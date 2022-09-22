pipeline{
    agent any
    stages{

        stage("SCM Checkout"){
            steps{
                checkout([$class: 'GitSCM', branches: [[name: '*/main']], doGenerateSubmoduleConfigurations: false, extensions: [[$class: 'CleanBeforeCheckout', deleteUntrackedNestedRepositories: true]], submoduleCfg: [], userRemoteConfigs: [[credentialsId: 'trivy-pipeline', url: 'https://github.com/pancaperkasa/trivyPipelineCompose.git']]])
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
        
        
        stage("Root File System Scanner"){
            steps{
                sh '''
                docker exec -it phpapache-container /bin/bash
                cd /
                curl -sfL https://raw.githubusercontent.com/aquasecurity/trivy/main/contrib/install.sh | sh -s -- -b /usr/local/bin
                trivy --format template --template "@templates/html.tpl" -o /reportphpcontainer.html --severity HIGH,CRITICAL rootfs /
                exit
                mkdir /var/www/html/trivy/pipeline${BUILD_NUMBER}/
                docker cp phpapache-container:/reportphpcontainer.html /var/www/html/trivy/pipeline${BUILD_NUMBER}/
                '''
            }
        }


    }
}