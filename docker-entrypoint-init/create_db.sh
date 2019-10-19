#!/usr/bin/env bash
echo "Creating DB.. "

mysql -u "${DB_USER}" "-p${MYSQL_ROOT_PASSWORD}" -e "CREATE DATABASE IF NOT EXISTS ${DB_NAME};"

echo "Creating DB Done. "
