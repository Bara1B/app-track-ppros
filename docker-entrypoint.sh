#!/bin/bash

# Tunggu sampe MySQL bener-bener siap
echo "Waiting for mysql to be ready..."
until nc -z -v -w30 mysql 3306
do
  echo "Waiting for database connection..."
  # tunggu 5 detik sebelum nyoba lagi
  sleep 5
done
echo "MySQL is ready!"

# Jalanin perintah asli dari Sail
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf