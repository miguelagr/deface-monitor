#!/bin/bash

echo "instalando base de datos"

apt-get install postgresql -y

apt-get install python-pip -y

pip install psycopg2-binary commands requests urllib2 smtplib

echo "psql -f base.sql" | su postgres

#export PATH=$PATH:$(pwd)
