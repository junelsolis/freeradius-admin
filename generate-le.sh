#!/bin/bash

docker run -it --rm \
  -v $(pwd)/le:/etc/letsencrypt \
  ekho/certbot \
  certonly --manual --preferred-challenges dns \
  --agree-tos
