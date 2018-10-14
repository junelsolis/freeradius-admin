#!/bin/bash

service radiusd start
tail -f /var/log/lastlog
