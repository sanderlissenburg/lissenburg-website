if [ -f .env ]
then
. .env
fi

## Login to docker hub
echo "$DOCKER_PASSWORD" | docker login -u "$DOCKER_ID" --password-stdin

## Pull old images to fill cache
docker pull lissenburg/website-php-fpm
docker pull lissenburg/website-nginx

## Build and push images to docker
make build-prod
docker push lissenburg/website-php-fpm
docker push lissenburg/website-nginx

echo touch ./deploy/vps/.env
echo "DB_HOST=$DB_HOST" >> ./deploy/vps/.env
echo "DB_USERNAME=$DB_USERNAME" >> ./deploy/vps/.env
echo "DB_PASSWORD=$DB_PASSWORD" >> ./deploy/vps/.env
echo "DB_DATABASE=$DB_DATABASE" >> ./deploy/vps/.env

## Deploy to vps
echo "$SSH_PRIVATE_KEY" > "$HOME/.ssh/id_rsa"
ssh $SSH_USER@$SSH_HOST 'mkdir -p ~/www/lissenburg/'
scp -r ./deploy/vps/* $SSH_USER@$SSH_HOST:~/www/lissenburg/
scp ./deploy/vps/.env $SSH_USER@$SSH_HOST:~/www/lissenburg/.env
ssh $SSH_USER@$SSH_HOST 'cd ~/www/lissenburg/ && touch acme.json && chmod 600 acme.json'

#  -c <(docker-compose config) instead of  -c docker-compose.yaml, otherwise .env vars will not be applied
ssh $SSH_USER@$SSH_HOST 'cd ~/www/lissenburg/ && docker-compose pull && docker stack deploy -c <(docker-compose config) lissenburg'
ssh $SSH_USER@$SSH_HOST 'cd ~/www/lissenburg/ && docker-compose run --rm -e DB_DATABASE="" website_php-fpm vendor/bin/doctrine-module dbal:run-sql "CREATE DATABASE IF NOT EXISTS '$DB_DATABASE'"'
ssh $SSH_USER@$SSH_HOST 'cd ~/www/lissenburg/ && docker-compose run --rm website_php-fpm vendor/bin/doctrine-module migrations:migrate -n'

rm ./deploy/vps/.env
