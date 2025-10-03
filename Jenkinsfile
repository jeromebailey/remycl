// Jenkinsfile
pipeline {
    agent any
    
    parameters {
        choice(
            name: 'ENVIRONMENT',
            choices: ['DEV-AWS', 'PROD'],
            description: 'Select deployment environment'
        )
        string(
            name: 'BRANCH',
            defaultValue: 'main',
            description: 'Git branch to build'
        )
    }
    
    environment {
        DOCKER_HUB_CREDENTIALS = credentials('dockerhub-credentials')
        DOCKER_IMAGE_NAME = 'jeromebailey/remycl'
        DOCKER_IMAGE_TAG = "${env.BUILD_NUMBER}"
        
        // SSH credentials for deployment servers
        TEST_SERVER_CREDENTIALS = credentials('test-server-ssh')
        PROD_SERVER_CREDENTIALS = credentials('prod-server-ssh')
        
        // Server details
        // TEST_SERVER_HOST = '18.132.154.138'
        // TEST_SERVER_USER = 'ubuntu'
        // TEST_APP_PATH = '/home/ubuntu/acms'
        
        // PROD_SERVER_HOST = '192.168.1.200'
        // PROD_SERVER_USER = 'deploy'
        // PROD_APP_PATH = '/var/www/laravel-production'

        SERVER = getServerURL()
        PROJECT_PATH = getFullServerProjectPath()
        FOLDER_NAME = getServerFolderName(PROJECT_PATH)
        USERNAME = getServerUsername()
    }
    
    stages {
        stage('Checkout') {
            steps {
                script {
                    echo "Building branch: ${params.BRANCH}"
                    echo "Target environment: ${params.ENVIRONMENT}"
                    echo "Server: ${SERVER}"
                    echo "Project Path: ${PROJECT_PATH}"
                    echo "Username: ${USERNAME}"
                }
                
                // For GitHub
                git branch: "${params.BRANCH}",
                    credentialsId: 'github-credentials',
                    url: 'https://github.com/jeromebailey/remycl.git'
                
                // For GitLab, use this instead:
                // git branch: "${params.BRANCH}",
                //     credentialsId: 'gitlab-credentials',
                //     url: 'https://gitlab.com/your-username/your-laravel-repo.git'
            }
        }
        
        // stage('Prepare Environment') {
        //     steps {
        //         script {
        //             // Create .env file for the build
        //             sh '''
        //                 if [ ! -f .env ]; then
        //                     cp .env.example .env
        //                 fi
        //             '''
        //         }
        //     }
        // }
        
        stage('Build Docker Image') {
            steps {
                script {
                    echo "Building Docker image: ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}"
                    sh """
                        docker build -t ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} .
                        docker tag ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} ${DOCKER_IMAGE_NAME}:latest
                    """
                }
            }
        }
        
        stage('Run Tests') {
            steps {
                script {
                    echo "Running application tests..."
                    sh """
                        docker run --rm ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} php artisan test
                    """
                }
            }
        }
        
        stage('Push to Docker Hub') {
            steps {
                script {
                    echo "Logging in to Docker Hub..."
                    sh """
                        echo \$DOCKER_HUB_CREDENTIALS_PSW | docker login -u \$DOCKER_HUB_CREDENTIALS_USR --password-stdin
                        docker push ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}
                        docker push ${DOCKER_IMAGE_NAME}:latest
                        docker logout
                    """
                }
            }
        }
        
        stage('Deploy') {
            steps {
                script {
                    // def serverHost = params.ENVIRONMENT == 'production' ? env.PROD_SERVER_HOST : env.TEST_SERVER_HOST
                    // def serverUser = params.ENVIRONMENT == 'production' ? env.PROD_SERVER_USER : env.TEST_SERVER_USER
                    // def appPath = params.ENVIRONMENT == 'production' ? env.PROD_APP_PATH : env.TEST_APP_PATH
                    // def sshCredentials = params.ENVIRONMENT == 'production' ? env.PROD_SERVER_CREDENTIALS : env.TEST_SERVER_CREDENTIALS
                    
                    echo "Deploying to ${params.ENVIRONMENT} environment..."
                    echo "Server: ${SERVER}"
                    echo "Path: ${PROJECT_PATH}"

                    def sshCredentialsId = params.ENVIRONMENT == 'PROD' ? 'prod-server-ssh' : 'test-server-ssh'
                    
                    // Deploy using SSH
                    sshagent(credentials: [sshCredentialsId]) {
                        sh """
                            ssh -o StrictHostKeyChecking=no ${USERNAME}@${SERVER} '
                                cd ${PROJECT_PATH} &&
                                
                                # Update docker-compose.yml with new image tag
                                sed -i "s|image: ${DOCKER_IMAGE_NAME}:.*|image: ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG}|g" docker-compose.yml &&
                                
                                # Pull the latest image
                                docker-compose pull &&
                                
                                # Stop and remove old containers
                                docker-compose down &&
                                
                                # Start the application
                                docker-compose up -d &&
                                
                                # Run migrations
                                docker-compose exec -T app php artisan migrate --force &&
                                
                                # Clear cache
                                docker-compose exec -T app php artisan cache:clear &&
                                docker-compose exec -T app php artisan config:clear &&
                                docker-compose exec -T app php artisan route:clear &&
                                docker-compose exec -T app php artisan view:clear &&
                                
                                # Optimize for production
                                docker-compose exec -T app php artisan config:cache &&
                                docker-compose exec -T app php artisan route:cache &&
                                docker-compose exec -T app php artisan view:cache &&
                                
                                echo "Deployment completed successfully!"
                            '
                        """
                    }
                }
            }
        }
        
        stage('Health Check') {
            steps {
                script {
                    //def serverHost = params.ENVIRONMENT == 'production' ? env.PROD_SERVER_HOST : env.TEST_SERVER_HOST
                    
                    echo "Running health check on ${params.ENVIRONMENT}..."
                    
                    sleep(time: 10, unit: 'SECONDS')
                    
                    sh """
                        curl -f http://${SERVER}:8000/health || exit 1
                    """
                    
                    echo "Health check passed!"
                }
            }
        }
    }
    
    post {
        success {
            echo "Pipeline completed successfully!"
            echo "Deployed ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} to ${params.ENVIRONMENT}"
            echo "Server: ${SERVER}"
        }
        
        failure {
            echo "Pipeline failed!"
        }
        
        always {
            // Clean up Docker images on Jenkins server
            sh """
                docker rmi ${DOCKER_IMAGE_NAME}:${DOCKER_IMAGE_TAG} || true
                docker system prune -f
            """
        }
    }
}

// Helper functions for server configuration
def getServerURL() {
    def servers = ['DEV-AWS': '18.132.154.138', 'PROD': 'prod-idr.egov.ky']
    return servers["${params.ENVIRONMENT}"]
}

def getFullServerProjectPath() {
    def servers = ['DEV-AWS': '/home/ubuntu/remycl', 'PROD': '/opt/Docker/idr']
    return servers["${params.ENVIRONMENT}"]
}

def getServerFolderName(projectpath) {
    def sections = projectpath.split('/')
    return sections.last()
}

def getServerUsername() {
    def servers = ['DEV-AWS': 'ubuntu', 'PROD': 'ubuntu']
    return servers["${params.ENVIRONMENT}"]
}