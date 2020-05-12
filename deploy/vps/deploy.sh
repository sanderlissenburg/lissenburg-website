# Login to docker hub
echo "$DOCKER_PASSWORD" | docker login -u "$DOCKER_ID" --password-stdin

# Pull old images to fill cache
docker pull lissenburg/lissenburg-client

# Build and push images to docker
docker build -t lissenburg/lissenburg-client -f ./client/docker/nginx/Dockerfile ./client
docker push lissenburg/lissenburg-client

echo "APP_ENV=prod\nDATABASE_URL=" > ./admin/.env

docker build -f=admin/docker/php-fpm/Dockerfile -t lissenburg/admin-php-fpm --target php-fpm ./admin
docker build -f=admin/docker/php-fpm/Dockerfile -t lissenburg/admin-nginx --target nginx ./admin
docker push lissenburg/admin-php-fpm
docker push lissenburg/admin-nginx

# Deploy to vps
ssh $SSH_USER@$SSH_HOST 'mkdir -p ~/www/lissenburg/'
scp -r ./deploy/vps/* $SSH_USER@$SSH_HOST:~/www/lissenburg/
ssh $SSH_USER@$SSH_HOST 'cd ~/www/lissenburg/ && touch acme.json && chmod 600 acme.json'
ssh $SSH_USER@$SSH_HOST 'cd ~/www/lissenburg/ && docker-compose pull && docker stack deploy -c docker-compose.yaml lissenburg'
