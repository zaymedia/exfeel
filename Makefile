init: init-ci
init-ci: docker-down-clear \
	app-clear \
	docker-pull docker-build docker-up \
	app-init

up: docker-up
down: docker-down
restart: down up

#linter and code-style
lint: app-lint
analyze: app-analyze
validate-schema: app-db-validate-schema
cs-fix: app-cs-fix
test: app-test

update-deps: app-composer-update

#check all
check: lint analyze validate-schema test

#Docker
docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build --pull

app-clear:
	docker run --rm -v ${PWD}/:/app -w /app alpine sh -c 'rm -rf var/cache/* var/log/* var/test/*'


#Composer
app-init: app-permissions app-composer-install #app-db-migrations #app-wait-db app-db-migrations #app-db-fixtures

app-permissions:
	docker run --rm -v ${PWD}/:/app -w /app alpine chmod 777 var/cache var/log var/test

app-composer-install:
	docker-compose run --rm php-cli composer install

app-composer-update:
	docker-compose run --rm php-cli composer update

app-composer-autoload: #refresh autoloader
	docker-compose run --rm php-cli composer dump-autoload

app-composer-outdated: #get not updated
	docker-compose run --rm php-cli composer outdated

app-wait-db:
	docker-compose run --rm php-cli wait-for-it db:3306 -t 30


#DB
app-db-validate-schema:
	docker-compose run --rm php-cli composer app orm:validate-schema

app-db-migrations-diff:
	docker-compose run --rm php-cli composer app migrations:diff

app-db-migrations:
	docker-compose run --rm php-cli composer app migrations:migrate -- --no-interaction

app-db-fixtures:
	docker-compose run --rm php-cli composer app fixtures:load


#Lint and analyze
app-lint:
	docker-compose run --rm php-cli composer lint
	docker-compose run --rm php-cli composer php-cs-fixer fix -- --dry-run --diff

app-cs-fix:
	docker-compose run --rm php-cli composer php-cs-fixer fix

app-analyze:
	docker-compose run --rm php-cli composer psalm


#Tests
app-test:
	docker-compose run --rm php-cli composer test

app-test-coverage:
	docker-compose run --rm php-cli composer test-coverage

app-test-unit:
	docker-compose run --rm php-cli composer test -- --testsuite=unit

app-test-unit-coverage:
	docker-compose run --rm php-cli composer test-coverage -- --testsuite=unit

app-test-functional:
	docker-compose run --rm php-cli composer test -- --testsuite=functional

app-test-functional-coverage:
	docker-compose run --rm php-cli composer test-coverage -- --testsuite=functional

#Console
console:
	docker-compose run --rm php-cli composer app

console-dev-token:
	docker-compose run --rm php-cli composer app oauth:e2e-token

#Build
build:
	docker --log-level=debug build --pull --file=./docker/production/nginx/Dockerfile --tag=${REGISTRY}/exfeel-nginx:${IMAGE_TAG} .
	docker --log-level=debug build --pull --file=./docker/production/php-fpm/Dockerfile --tag=${REGISTRY}/exfeel-php-fpm:${IMAGE_TAG} .
	docker --log-level=debug build --pull --file=./docker/production/php-cli/Dockerfile --tag=${REGISTRY}/exfeel-php-cli:${IMAGE_TAG} .

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build

push:
	docker push ${REGISTRY}/exfeel-nginx:${IMAGE_TAG}
	docker push ${REGISTRY}/exfeel-php-fpm:${IMAGE_TAG}
	docker push ${REGISTRY}/exfeel-php-cli:${IMAGE_TAG}

deploy:
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'docker network create --driver=overlay traefik-public || true'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'docker login -u=${DOCKERHUB_USER} -p=${DOCKERHUB_PASSWORD} ${REGISTRY}'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'rm -rf /home/exfeel/v_${BUILD_NUMBER}'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'mkdir -p /home/exfeel/v_${BUILD_NUMBER}'
	scp -o StrictHostKeyChecking=no -P ${PORT} docker-compose-production.yml ${HOST}:/home/exfeel/v_${BUILD_NUMBER}/docker-compose.yml
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "COMPOSE_PROJECT_NAME=exfeel" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "REGISTRY=${REGISTRY}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "IMAGE_TAG=${IMAGE_TAG}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "APP_ENV=${APP_ENV}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "APP_DEBUG=${APP_DEBUG}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "SENTRY_DSN=${SENTRY_DSN}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "DOMAIN=${DOMAIN}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "DOMAIN_REDIRECT=${DOMAIN_REDIRECT}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "DB_HOST=${DB_HOST}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "DB_USER=${DB_USER}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "DB_PASSWORD=${DB_PASSWORD}" >> .env'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && echo "DB_NAME=${DB_NAME}" >> .env'

	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'mkdir -p /home/exfeel/v_${BUILD_NUMBER}/secrets'
	scp -o StrictHostKeyChecking=no -P ${PORT} ${JWT_ENCRYPTION_KEY_FILE} ${HOST}:/home/exfeel/v_${BUILD_NUMBER}/secrets/jwt_encryption_key
	scp -o StrictHostKeyChecking=no -P ${PORT} ${JWT_PUBLIC_KEY} ${HOST}:/home/exfeel/v_${BUILD_NUMBER}/secrets/jwt_public_key
	scp -o StrictHostKeyChecking=no -P ${PORT} ${JWT_PRIVATE_KEY} ${HOST}:/home/exfeel/v_${BUILD_NUMBER}/secrets/jwt_private_key

	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && docker-compose pull'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd /home/exfeel/v_${BUILD_NUMBER} && docker-compose up --build --remove-orphans -d'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'rm -f /home/exfeel/exfeel'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'ln -sr /home/exfeel/v_${BUILD_NUMBER} /home/exfeel/exfeel'
rollback:
	ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker-compose pull'
	ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker-compose up --build --remove-orphans -d'
	ssh ${HOST} -p ${PORT} 'rm -f site'
	ssh ${HOST} -p ${PORT} 'ln -sr site_${BUILD_NUMBER} site'

