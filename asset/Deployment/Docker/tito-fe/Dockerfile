#Created by Vincent Meoc
# Create the Tito Front End container
#Env (optional): TITOSQL=<FQDN/IP of MYSQL

FROM php:rc-apache
COPY . /var/www/html/
COPY asset/Deployment/Docker/tito-fe/apache2-foreground /usr/local/bin/apache2-foreground
RUN chmod +x /usr/local/bin/apache2-foreground

RUN apt-get update
RUN apt-get install php5-mysql vim libmcrypt-dev -y
RUN docker-php-ext-install mysqli pdo pdo_mysql mcrypt
RUN cp /usr/share/php5/php.ini-production /usr/local/etc/php/php.ini
 
RUN echo "<IfModule env_module>" >> /etc/apache2/mods-enabled/env.conf
RUN echo "     SetEnv TITO-SQL \"tito-sql\"" >> /etc/apache2/mods-enabled/env.conf
RUN echo "</IfModule>" >> /etc/apache2/mods-enabled/env.conf
