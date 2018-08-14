#!/bin/bash
docker run -it --rm --name certbot \
              -v "/etc/letsencrypt:/etc/letsencrypt" \
              -v "/var/lib/letsencrypt:/var/lib/letsencrypt" \
	            -p 80:80 \
              certbot/certbot certonly
