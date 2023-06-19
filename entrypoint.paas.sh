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

chown -R www-data:www-data /var/www/html/storage && \
chmod -R 777 /var/www/html/storage


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

    const DB_HOST       = '"$(get_env_value "DB_HOST" "easyappointments-database")"';
    const DB_NAME       = '"$(get_env_value "DB_NAME" "easyappointments")"';
    const DB_USERNAME   = '"$(get_env_value "DB_USERNAME" "root")"';
    const DB_PASSWORD   = '"$(get_env_value "DB_PASSWORD" "root")"';

    // ------------------------------------------------------------------------
    // GOOGLE CALENDAR SYNC
    // ------------------------------------------------------------------------

    const GOOGLE_SYNC_FEATURE   = $(get_env_value "GOOGLE_SYNC_FEATURE" "FALSE");
    const GOOGLE_PRODUCT_NAME   = '"$(get_env_value "GOOGLE_PRODUCT_NAME" "")"';
    const GOOGLE_CLIENT_ID      = '"$(get_env_value "GOOGLE_CLIENT_ID" "")"';
    const GOOGLE_CLIENT_SECRET  = '"$(get_env_value "GOOGLE_CLIENT_SECRET" "")"';
    const GOOGLE_API_KEY        = '"$(get_env_value "GOOGLE_API_KEY" "")"';
}

/* End of file config.php */
/* Location: ./config.php */" > /var/www/html/config.php 

# Configure ssmtp with environment variables
echo "mailhub=${SMTP_SERVER}:${SMTP_PORT}\n\
UseTLS=${SMTP_USE_TLS}\n\
UseSTARTTLS=${SMTP_USE_STARTTLS}\n\
FromLineOverride=YES\n\
AuthUser=${SMTP_USERNAME}\n\
AuthPass=${SMTP_PASSWORD}" > /etc/ssmtp/ssmtp.conf


# Start Apache web server
apache2-foreground
