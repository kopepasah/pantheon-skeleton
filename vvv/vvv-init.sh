#!/bin/bash

set -e

cd ..

printf "## -------------------------------------------------- ##"
printf "Setting up: %s\n" $(basename $(pwd))

# Export required PHP constants into Bash.
printf "Creating database, if we don't already have one."
eval $(php -r '
	require_once( "wp-config-local.php" );
	foreach( explode( " ", "DB_NAME DB_HOST DB_USER DB_PASSWORD DB_CHARSET" ) as $key ) {
		echo $key . "=" . constant( $key ) . PHP_EOL;
	}
')
mysql -u root --password=root -e "CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET $DB_CHARSET"
mysql -u root --password=root -e "GRANT ALL PRIVILEGES ON $DB_NAME.* TO $DB_USER@localhost IDENTIFIED BY '$DB_PASSWORD';"

printf "Syncing wp-config-local.php..."
cp wp-config-local.php wp/wp-config-local.php

printf "Syncing wp-config.php (if exists)..."
if [ -e wp-config.php ]; then
	cp wp-config.php wp/wp-config.php
fi

printf "Finished setting up: %s\n" $(basename $(pwd))
printf "## -------------------------------------------------- ##"
