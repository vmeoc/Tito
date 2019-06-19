# Created by Vincent Meoc
# Create the Tito Front End container

FROM php:7.3.6-apache-stretch

COPY apache2-foreground /usr/local/bin/apache2-foreground
RUN chmod +x /usr/local/bin/apache2-foreground; \
    apt-get update; \
    # for troubleshooting, can add vim and iputils-ping the following command line
    apt-get install -y libmcrypt-dev git curl; \
    docker-php-ext-install mysqli pdo_mysql sockets; \
    echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf; a2enconf servername; \
    apt-get clean && rm -rf /var/cache/apt/archives;

ENTRYPOINT ["/usr/local/bin/apache2-foreground"]
