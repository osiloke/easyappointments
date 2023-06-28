#!/bin/bash

# Function to get the value of an environment variable or use the default value
get_env_value() {
  local env_var_value=$(printenv "$1")
  if [[ -n "$env_var_value" ]]; then
    echo "$env_var_value"
  else
    echo "$2"
  fi
}

# IF SKIP_UNZIP is not defined
if [[ -z "$SKIP_UNZIP" ]]; then
  unzip /tmp/html.zip -d /var/www/html
fi

chown -R www-data:www-data /var/www/html/storage && \
chmod -R 777 /var/www/html/storage

# Database Configuration
if [[ -n "$DATABASE_URL" ]]; then
    # Extract the database configuration from the DATABASE_URL environment variable
    DB_URL="$DATABASE_URL"
    DB_HOST=$(echo $DB_URL | awk -F[@//] '{print $4}')
    DB_PORT=$(echo $DB_URL | awk -F[@//] '{print $3}' | awk -F[:] '{print $2}')
    DB_USERNAME=$(echo $DB_URL | awk -F[@//] '{print $3}' | awk -F[:] '{print $1}')
    DB_PASSWORD=$(echo $DB_URL | awk -F[@//] '{print $2}' | awk -F[:] '{print $2}')
    DB_NAME=$(echo $DB_URL | awk -F[/] '{print $NF}')
else
    # Use the existing configuration
    DB_HOST=$(get_env_value "DB_HOST" "easyappointments-database")
    DB_NAME=$(get_env_value "DB_NAME" "easyappointments")
    DB_USERNAME=$(get_env_value "DB_USERNAME" "root")
    DB_PASSWORD=$(get_env_value "DB_PASSWORD" "root")
fi

# Create the configuration file
echo "<?php
/* ----------------------------------------------------------------------------
 * Easy!Appointments - Open Source Web Scheduler
 *
 * @package     EasyAppointments
 * @author      A.Tselegidis <alextselegidis@gmail.com>
 * @copyright   Copyright (c) 2013 - 2020, Alex Tselegidis
 * @license     http://opensource.org/licenses/GPL-3.0 - GPLv3
 * @link        http://easyappointments.org
 * @since       v1.0.0
 * ---------------------------------------------------------------------------- */

/**
 * Easy!Appointments Configuration File
 *
 * Set your installation BASE_URL * without the trailing slash * and the database
 * credentials in order to connect to the database. You can enable the DEBUG_MODE
 * while developing the application.
 *
 * Set the default language by changing the LANGUAGE constant. For a full list of
 * available languages look at the /application/config/config.php file.
 *
 * IMPORTANT:
 * If you are updating from version 1.0 you will have to create a new \"config.php\"
 * file because the old \"configuration.php\" is not used anymore.
 */
class Config {

    // ------------------------------------------------------------------------
    // GENERAL SETTINGS
    // ------------------------------------------------------------------------

    const BASE_URL      = '"$(get_env_value "BASE_URL" "http://localhost:8000")"';
    const LANGUAGE      = '"$(get_env_value "LANGUAGE" "english")"';
    const DEBUG_MODE    = $(get_env_value "DEBUG_MODE" "FALSE");

    // ------------------------------------------------------------------------
    // DATABASE SETTINGS
    // ------------------------------------------------------------------------

    const DB_HOST       = '$DB_HOST';
    const DB_NAME       = '$DB_NAME';
    const DB_USERNAME   = '$DB_USERNAME';
    const DB_PASSWORD   = '$DB_PASSWORD';

    // ------------------------------------------------------------------------
    // GOOGLE CALENDAR SYNC
    // ------------------------------------------------------------------------

    const GOOGLE_SYNC_FEATURE     = $(get_env_value "GOOGLE_SYNC_FEATURE" "FALSE");
    const GOOGLE_PRODUCT_NAME     = '"$(get_env_value "GOOGLE_PRODUCT_NAME" "")"';
    const GOOGLE_CLIENT_ID        = '"$(get_env_value "GOOGLE_CLIENT_ID" "")"';
    const GOOGLE_CLIENT_SECRET    = '"$(get_env_value "GOOGLE_CLIENT_SECRET" "")"';
    const GOOGLE_API_KEY          = '"$(get_env_value "GOOGLE_API_KEY" "")"';

    // ------------------------------------------------------------------------
    // STRIPE PAYMENT INTEGRATION
    // ------------------------------------------------------------------------

    const STRIPE_PAYMENT_FEATURE  = '"$(get_env_value "STRIPE_PAYMENT_FEATURE" "")"';
    const STRIPE_API_KEY  = '"$(get_env_value "STRIPE_API_KEY" "")"';
}

/* End of file config.php */
/* Location: ./config.php */" > /var/www/html/config.php

# Configure ssmtp with environment variables
echo "mailhub=${SMTP_SERVER}:${SMTP_PORT}" > /etc/ssmtp/ssmtp.conf
echo "UseTLS=${SMTP_USE_TLS}" >> /etc/ssmtp/ssmtp.conf
echo "UseSTARTTLS=${SMTP_USE_STARTTLS}" >> /etc/ssmtp/ssmtp.conf
echo "FromLineOverride=YES" >> /etc/ssmtp/ssmtp.conf
echo "AuthUser=${SMTP_USERNAME}" >> /etc/ssmtp/ssmtp.conf
echo "AuthPass=${SMTP_PASSWORD}" >> /etc/ssmtp/ssmtp.conf

echo "➜ Install Composer Dependencies"
composer install

echo "➜ Install NPM Dependencies"
npm install

echo "➜ Build Project Assets"
gulp build

echo "➜ Listen To Incoming Requests"
php-fpm