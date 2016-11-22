FROM php:rc-apache
COPY . /var/www/html/

RUN apt-get update
RUN apt-get install php5-mysql vim libmcrypt-dev -y
RUN docker-php-ext-install mysqli pdo pdo_mysql mcrypt
RUN cp /usr/share/php5/php.ini-production /usr/local/etc/php/php.ini

RUN cat <<EOF >> /etc/apache2/mods-enabled/env.conf
<IfModule env_module>
    SetEnv TITO-SQL "tito-sql"
</IfModule>
EOF
