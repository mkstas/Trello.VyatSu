#!/bin/sh
set -e

: "${APP_ENV:=dev}"
[ -n "${APP_KEY:-}" ] || { echo "APP_KEY is required" >&2; exit 1; }

umask 027
{
    printf "APP_ENV='%s'\n" "$APP_ENV"
    printf "APP_KEY='%s'\n" "$APP_KEY"
} > /etc/trello-cron.env

chown root:www-data /etc/trello-cron.env
chmod 0640 /etc/trello-cron.env

exec cron -f
