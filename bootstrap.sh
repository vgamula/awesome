#!/usr/bin/env bash

apt-get update
apt-get install -y python-software-properties curl git
add-apt-repository ppa:ondrej/php5
apt-get update

###
### custom:
###

# install mysql
echo mysql-server mysql-server/root_password password root | debconf-set-selections
echo mysql-server mysql-server/root_password_again password root | debconf-set-selections
apt-get -y install mysql-server mysql-client libmysqlclient-dev
mysql -e 'create database awesome;' --user=root --password=root

#install php with apache
apt-get -y install php5 libapache2-mod-php5 php5-mysql sendmail

#install composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
composer global require "fxp/composer-asset-plugin:1.0.0"

#install dependencies
cd /www/awesome && composer install --prefer-dist
cd /www/awesome && cp .env.example .env

# setup apache2 configuration
cp /www/awesome/apache.conf /etc/apache2/sites-available/000-default.conf
a2enmod rewrite
/etc/init.d/apache2 restart

# load data
cd /www/awesome && \
    php yii migrate --interactive=0 #&& \
#    php yii fixture/load User Project Topic --interactive=0
