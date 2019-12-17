#!/bin/sh

# build and publishes the docker images flightvision/selenium-node-$variant-with-mkcert:$baseImageTag

# base image tag:
# https://hub.docker.com/r/selenium/node-chrome/tags
# https://hub.docker.com/r/selenium/node-firefox/tags
baseImageTag=3.141.59-xenon

dir="$(dirname "$0")"

echo 'Authenticate for docker hub repository ‹flightvision› (https://hub.docker.com/repository/docker/flightvision/)'
docker login --username=flightvision

for variant in chrome firefox; do
    baseImage=selenium/node-$variant
    image=flightvision/selenium-node-$variant-with-mkcert

    echo
    echo "Building $image, based on $baseImage:$baseImageTag..."
    docker build \
        --no-cache \
        --build-arg=BASE_IMAGE=$baseImage:$baseImageTag \
        --tag $image:$baseImageTag \
        "$dir"

    echo
    echo "Pushing $image:$baseImageTag to docker hub..."
    docker push $image:$baseImageTag
done
