# php-freeradius-mysql
A web interface for FreeRADIUS with a MySQL backend.

Written in PHP7 using the Laravel framework for an installation of FreeRADIUS 3 with a MySQL backend. This app simplifies managing RADIUS users through a web-based GUI and includes some implementation of Simultaneous-Use checking if you want to limit the number of devices that a user is allowed to use. It can be served from the same machine acting as the RADIUS server.

# FreeRADIUS 3 Setup
In order to use this software, I assume that you already have a FreeRADIUS 3 server set up properly to interface with a MySQL database containing the default FreeRADIUS schema.

# Project History
I originally started this project as a way to automate and simplify network user management at Maxwell Adventist Academy. I saw an interest in it because there was an opportunity to learn PHP/Laravel and configure FreeRADIUS at the same time. I saw this as a challenge because the FreeRADIUS documentation does not seem very clear to beginners to the technology like me.

One of the things I found lacking was a GUI to manage users. There are some open source solutions out there, but I wanted one that was customized to our specific needs. And so this project was born, after having gone a few iterations.
