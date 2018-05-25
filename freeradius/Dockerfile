FROM ubuntu

RUN apt-get update && apt-get upgrade -y && apt-get install freeradius freeradius-common freeradius-dhcp freeradius-mysql freeradius-utils -y

ADD ./rad_service_start.sh /rad_service_start.sh
RUN ["chmod", "+x", "/rad_service_start.sh"]
