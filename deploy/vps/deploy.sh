# Login to docker hub
echo "$DOCKER_PASSWORD" | docker login -u "$DOCKER_ID" --password-stdin

# Build and push images to docker
docker build -t lissenburg/lissenburg-client -f ./client/docker/Dockerfile ./client
docker push lissenburg/lissenburg-client

# Deploy to vps
ssh -i ./deploy/travis/travis_deploy_key $(SSH_USER)@$(SSH_HOST) 'mkdir -p ~/www/lissenburg/'
scp -r ./deploy/vps/* $(SSH_USER)@$(SSH_HOST):~/www/lissenburg/
ssh -i ./travis/travis_deploy_key $(SSH_USER)@$(SSH_HOST) 'cd ~/www/lissenburg/ && docker-compose pull && docker stack deploy -c <(docker-compose config) lissenburg'