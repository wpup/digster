#!/usr/bin/env bash

DB_USER=root
DB_PASS=root

mysql --user="$DB_USER" --password="$DB_PASS" -e"DROP DATABASE IF EXISTS wordpress_test"
/tmp/wordpress/wp-content/plugins/digster/bin/install-wp-tests.sh wordpress_test $DB_USER $DB_PASS localhost "4.1"

cd /tmp/wordpress/wp-content/plugins/digster/
mkdir /tmp/wordpress/wp-content/uploads
mkdir -p /tmp/wordpress/wp-content/plugins/digster/tmp
mkdir -p /tmp/wordpress/wp-content/themes/twentyfifteen/views

# Set start path
echo cd \/tmp\/wordpress\/wp-content\/plugins\/digster/ > /home/vagrant/.bashrc
rm -rf /etc/motd
