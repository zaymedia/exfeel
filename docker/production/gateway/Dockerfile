FROM nginx:1.21-alpine

COPY ./docker/common/nginx/snippets /etc/nginx/snippets
COPY ./docker/production/gateway/conf.d /etc/nginx/conf.d

WORKDIR /app