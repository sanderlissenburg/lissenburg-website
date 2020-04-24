echo "$DOCKER_PASSWORD" | docker login -u "$DOCKER_ID" --password-stdin

docker build -t lissenburg/lissenburg-client -f ./client/docker/Dockerfile ./client

docker push lissenburg/lissenburg-client
