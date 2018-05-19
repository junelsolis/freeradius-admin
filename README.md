# web-freeradius-mysql
A web interface for FreeRADIUS with a MySQL backend.

Written in PHP7 using the Laravel framework for an installation of FreeRADIUS 3 with a MySQL backend. This app simplifies managing RADIUS users through a web-based GUI and includes some implementation of Simultaneous-Use checking if you want to limit the number of devices that a user is allowed to use. It can be served from the same machine acting as the RADIUS server.

# Install with Docker
The simplest way to install this app is using Docker.

1. Clone this repository
2. Use the **docker-compose.yml file** to build and run the containers.

The docker-compose file will create three services: **rad-server**, **mysql-server**, and **apache2-server**. The three containers have network connectivity with each other through static ip's on their own bridge network. Ports are forwarded or exposed as needed.

**Important** The docker-compose file is set to port-forward 3306 in case you need direct network access to the MySQL service. If this sort of access is not needed, it should be disabled in production setups by changing the 'port' declaration to 'expose'.

# FreeRADIUS 3 Setup
In order to use this software, I assume that you already have a FreeRADIUS 3 server set up properly to interface with a MySQL database containing the default FreeRADIUS schema. This project was constructed with the default MySQL schema that comes with FreeRADIUS in mind. If you wish to use this project with a different schema, you will have to change the tables the source code points to.

# Project History
I originally started this project as a way to automate and simplify network user management at <a href="http://www.maxwellsda.org">Maxwell Adventist Academy</a>, a secondary school outside Nairobi, Kenya where I worked both as a physician and network administrator. I saw an interest in it because there was an opportunity to learn PHP/Laravel and configure FreeRADIUS at the same time. This was a challenge because the FreeRADIUS documentation does not seem very clear to beginners to the technology like me.

One of the things I found lacking was a GUI to manage users. There are some open source solutions out there, but I wanted one that was customized to our specific needs. And so this project was born, after having gone through a few iterations. With this repository, I am attempting to rewrite the application using Docker to help simplify development and deployment.
