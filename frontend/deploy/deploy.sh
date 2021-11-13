## Login to docker hub
#echo "$DOCKER_PASSWORD" | docker login -u "$DOCKER_ID" --password-stdin
#
### Pull old images to fill cache
#docker pull lissenburg/website-front
#
### Build and push images to docker
#make build-prod
#docker push lissenburg/website-frontend-nginx

ssh $SSH_ENTRY_HOST

ls
