pipeline{
    agent any
    stages{

        stage("SCM Checkout"){
            steps{
                checkout([$class: 'GitSCM', branches: [[name: '*/main']], doGenerateSubmoduleConfigurations: false, extensions: [[$class: 'CleanBeforeCheckout', deleteUntrackedNestedRepositories: true]], submoduleCfg: [], userRemoteConfigs: [[credentialsId: 'trivy-pipeline', url: 'https://github.com/pancaperkasa/trivyPipeline.git']]])
            }
        }

        stage("Misconfig Scanner"){
            steps{
                sh '''
                trivy config .
                '''
            }
        }

        stage("Compose"){
            steps{
                sh '''
                docker-compose up -d
                '''
            }
        }
        
        
        stage("Vulnerability and Secret Scanner"){
            steps{
                sh '''
                mkdir /var/www/html/trivy/pipeline${BUILD_NUMBER}/
                touch /var/www/html/trivy/pipeline${BUILD_NUMBER}/trivypipeline.html
                trivy image --format template --template "@templates/html.tpl" -o /var/www/html/trivy/pipeline${BUILD_NUMBER}/trivypipeline.html --exit-code 1 --severity HIGH,CRITICAL pingapp:v1.1
                '''
            }
        }


    }
}