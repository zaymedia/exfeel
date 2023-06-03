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
        DB_HOST = credentials("DB_HOST")
        DB_USER = credentials("DB_USER")
        DB_PASSWORD = credentials("DB_PASSWORD")
        DB_NAME = credentials("DB_NAME")
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
                branch 'master'
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
                    string(credentialsId: 'DB_HOST', variable: 'DB_HOST'),
                    string(credentialsId: 'DB_USER', variable: 'DB_USER'),
                    string(credentialsId: 'DB_PASSWORD', variable: 'DB_PASSWORD'),
                    string(credentialsId: 'DB_NAME', variable: 'DB_NAME'),
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
