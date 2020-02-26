#!/usr/bin/env bash

docker-compose -f docker/docker-compose.yml up -d
docker exec -it epolka-app /bin/bash
