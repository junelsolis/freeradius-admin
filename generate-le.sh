#!/bin/bash

# This script will run a docker container
# that will allow you to acquire a letsencrypt
# certificate using the manual DNS method.
docker run -it --rm \
  -v $(pwd)/le:/etc/letsencrypt \
  ekho/certbot \
  certonly --manual --preferred-challenges dns \
  --agree-tos
