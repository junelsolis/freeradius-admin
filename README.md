![FreeRADIUS Admin](scr.png)

A web interface for FreeRADIUS with a MySQL backend.


# FreeRADIUS Admin
Need a **FreeRADIUS + MySQL + web GUI** installation right away? This application simplifies managing RADIUS users and groups through a web-based GUI. It is built around Docker containers in order to help take the complexity of installing and configuring FreeRADIUS, MySQL, and Apache at the same time. Place it all on one machine, turn the key and it's up.

# Try the Demo Site
[http://freeradiusadmin-demo.junelsolis.com](http://freeradiusadmin-demo.junelsolis.com)
# Install with Docker
The simplest way to install this app is using Docker.

1. Clone this repository
2. Use the **docker-compose.yml** file to build and run the containers.
3. Run this command in your container host: 
```docker container exec apache2-server chown -R www-data:www-data /var/www/html```
3. Using your browser go to [http://localhost:80](http://localhost:80). The login credentials are **testadmin** and **password**.
4. *phpmyadmin* is included as a service for testing and evaluation. It is accessible at [http://localhost:8080](http://localhost:8080).

**Notes about docker configuration:**

The docker-compose file will create four services: **rad-server**, **mysql-server**, **apache2-server** and **phpmyadmin**. All four containers have network connectivity with each other through static ip's on their own bridge network. Ports are forwarded or exposed as needed.

**mysql**

The **mysql-server** is configured with a generic username and password. This should be changed in the [docker-compose.yml](docker-compose.yml) file for production setups. The file [radius.sql](./mysql/srv/initdb.d/radius.sql) is a modified version of the radius MySQL schema included with [freeRADIUS](https://github.com/FreeRADIUS/freeradius-server) distributions. It is loaded by the container on startup if the database and tables do not already exist.

Furthermore, it is set to port-forward 3306 in case you need direct network access to the MySQL service. If this sort of access is not needed, it should be disabled in production setups by changing the 'port' declaration to 'expose'.

**freeradius 3**

The FreeRADIUS 3 server is the service around which the rest of the services in this app are built. You will need some knowledge about configuring it in order to make it work according to your requirements. The configuration files are located in the folder *./freeradius/src*. As is, these files are ready to be deployed and will instantiate one virtual server called **server01** listening on the default auth and acct ports 1812 and 1813. Depending on your use case, you may wish to edit the *Simultaneous-Use* section of the [queries.conf](./freeradius/src/mods-config/sql/main/mysql/queries.conf) file.

**laravel**

For a production setup, modify the **.env** file located in *./web/src* and make sure **you change the app key**. You can do so by going to a terminal, navigating to the *./web/src* directory, and running ```php artisan key:generate```.

# Manual Installation
In order to use this software, I assume that you already have a FreeRADIUS 3 server set up properly to interface with a MySQL database containing the default FreeRADIUS schema. This project was constructed with the default MySQL schema that comes with FreeRADIUS in mind. If you wish to use this project with a different schema, you will have to change the tables the source code points to.

# How to Contribute
Contributors are welcome. Fork the project and create a pull request. Please have a look at [CONTRIBUTING.md](CONTRIBUTING.md) for some guidelines.

# Project History
I originally started this project as a way to automate and simplify network user management at <a href="http://www.maxwellsda.org">Maxwell Adventist Academy</a>, a secondary school outside Nairobi, Kenya where I worked both as a physician and network administrator. I saw an interest in it because there was an opportunity to learn PHP/Laravel and configure FreeRADIUS at the same time. This was a challenge because the FreeRADIUS documentation does not seem very clear to beginners to the technology like me.

One of the things I found lacking was a GUI to manage users. There are some open source solutions out there, but I wanted one that was customized to our specific needs. And so this project was born, after having gone through a few iterations. With this repository, I am attempting to rewrite the application using Docker to help simplify development and deployment.
