#!/bin/bash

cd /var/www/html
# Run scheduler
while [ true ]
do
  php handle_ads.php
  sleep 3600 #1 hour
done
