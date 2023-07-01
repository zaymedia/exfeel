pipeline {
    agent any
    options {
        timestamps()
    }
    environment {
        CI = 'true'
        REGISTRY = credentials("REGISTRY")
        IMAGE_TAG = sh(
            returnStdout: true,
            script: "echo '${env.BUILD_TAG}' | sed 's/%2F/-/g'"
        ).trim()
        APP_ENV = credentials("APP_ENV")
        APP_DEBUG = credentials("APP_DEBUG")
        SENTRY_DSN = credentials("SENTRY_DSN")
        DOMAIN = credentials("DOMAIN")
        DOMAIN_REDIRECT = credentials("DOMAIN_REDIRECT")
        DB_HOST = credentials("DB_HOST")
        DB_USER = credentials("DB_USER")
        DB_PASSWORD = credentials("DB_PASSWORD")
        DB_NAME = credentials("DB_NAME")
        TELEGRAM_API_KEY = credentials("TELEGRAM_API_KEY")
    }
    stages {
        stage('Init') {
            steps {
                sh 'make init'
            }
        }
        stage('Lint') {
            steps {
                sh 'make lint'
            }
        }
        stage('Analyze') {
            steps {
                sh 'make analyze'
            }
        }
        stage('Down') {
            steps {
                sh 'make docker-down-clear'
            }
        }
        stage('Build') {
            steps {
                sh 'make build'
            }
        }
        stage('Push') {
            when {
                branch 'main'
            }
            steps {
                withCredentials([
                    usernamePassword(
                        credentialsId: 'REGISTRY_AUTH',
                        usernameVariable: 'USER',
                        passwordVariable: 'PASSWORD'
                    )
                ]) {
                    sh 'echo ${PASSWORD} | docker login -u ${USER} --password-stdin $REGISTRY'
                }
                sh 'make push'
            }
        }
        stage ('Deploy') {
            when {
                branch 'main'
            }
            steps {
                withCredentials([
                    string(credentialsId: 'PRODUCTION_HOST', variable: 'HOST'),
                    string(credentialsId: 'PRODUCTION_PORT', variable: 'PORT'),
                    string(credentialsId: 'APP_ENV', variable: 'APP_ENV'),
                    string(credentialsId: 'APP_DEBUG', variable: 'APP_DEBUG'),
                    string(credentialsId: 'SENTRY_DSN', variable: 'SENTRY_DSN'),
                    string(credentialsId: 'DOMAIN', variable: 'DOMAIN'),
                    string(credentialsId: 'DOMAIN_REDIRECT', variable: 'DOMAIN_REDIRECT'),
                    string(credentialsId: 'DB_HOST', variable: 'DB_HOST'),
                    string(credentialsId: 'DB_USER', variable: 'DB_USER'),
                    string(credentialsId: 'DB_PASSWORD', variable: 'DB_PASSWORD'),
                    string(credentialsId: 'DB_NAME', variable: 'DB_NAME'),
                    string(credentialsId: 'TELEGRAM_API_KEY', variable: 'TELEGRAM_API_KEY'),
                    file(credentialsId: 'JWT_ENCRYPTION_KEY_FILE', variable: 'JWT_ENCRYPTION_KEY_FILE'),
                    file(credentialsId: 'JWT_PUBLIC_KEY', variable: 'JWT_PUBLIC_KEY'),
                    file(credentialsId: 'JWT_PRIVATE_KEY', variable: 'JWT_PRIVATE_KEY'),
                    usernamePassword(
                        credentialsId: 'REGISTRY_AUTH',
                        usernameVariable: 'DOCKERHUB_USER',
                        passwordVariable: 'DOCKERHUB_PASSWORD'
                    )
                ]) {
                    sshagent (credentials: ['PRODUCTION_AUTH']) {
                        sh 'make deploy'
                    }
                }
            }
        }
    }
    post {
        always {
            script {
                if (getContext(hudson.FilePath)) {
                    sh 'make docker-down-clear || true'
                }
            }
        }
    }
}
