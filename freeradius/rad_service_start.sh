#!/bin/bash

service freeradius start
tail -f /var/log/lastlog
