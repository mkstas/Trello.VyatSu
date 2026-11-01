#!/bin/sh
set -e

set -a
. /etc/trello-cron.env
set +a

cd /var/www/html
exec /usr/local/bin/php bin/cron.php
