#!/bin/bash

cd /var/www/html
# Run scheduler
while [ true ]
do
  php handle_ads.php
  sleep 60 #1 hour
done
