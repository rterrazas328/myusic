#!/bin/bash

set -e

# Inject secrets into .env
if [[ -v RAILWAY_SERVICE_ID ]]; then
    echo "Railway Detected!"
else
  if [ -e /run/secrets/app_key ]; then
    export APP_KEY=$(cat /run/secrets/app_key)
  fi
  if [ -e /run/secrets/app_name ]; then
    export APP_NAME=$(cat /run/secrets/app_name)
  fi
  if [ -e /run/secrets/db_connection ]; then
    export DB_CONNECTION=$(cat /run/secrets/db_connection)
  fi
  if [ -e /run/secrets/db_port ]; then
    export DB_PORT=$(cat /run/secrets/db_port)
  fi
  if [ -e /run/secrets/db_database ]; then
    export DB_DATABASE=$(cat /run/secrets/db_database)
  fi
  if [ -e /run/secrets/db_username ]; then
    export DB_USERNAME=$(cat /run/secrets/db_username)
  fi
  if [ -e /run/secrets/db_password ]; then
    export DB_PASSWORD=$(cat /run/secrets/db_password)
  fi
  if [ -e /run/secrets/email_domain ]; then
    export MAILGUN_DOMAIN=$(cat /run/secrets/email_domain)
  fi
  if [ -e /run/secrets/email_host ]; then
    export MAIL_HOST=$(cat /run/secrets/email_host)
  fi
  if [ -e /run/secrets/email_port ]; then
    export MAIL_PORT=$(cat /run/secrets/email_port)
  fi
  if [ -e /run/secrets/email_from_address ]; then
    export MAIL_FROM_ADDRESS=$(cat /run/secrets/email_from_address)
  fi
  if [ -e /run/secrets/email_from_name ]; then
    export MAIL_FROM_NAME=$(cat /run/secrets/email_from_name)
  fi
  if [ -e /run/secrets/email_key ]; then
    export MAILGUN_SECRET=$(cat /run/secrets/email_key)
  fi
  if [ -e /run/secrets/email_username ]; then
    export MAIL_USERNAME=$(cat /run/secrets/email_username)
  fi
  if [ -e /run/secrets/email_password ]; then
    export MAIL_PASSWORD=$(cat /run/secrets/email_password)
  fi
  if [ -e /run/secrets/vite_app_name ]; then
    export VITE_APP_NAME=$(cat /run/secrets/vite_app_name)
  fi
fi


php artisan config:clear


echo "MySQL is up - running migrations..."

php artisan migrate

npm install


exec apache2-foreground

