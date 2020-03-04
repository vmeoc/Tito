# Created by Vincent Meoc
# Create the Tito Front End container
# docker run -d -P -e "TITO_VERSION=V2.3" -e "PROXY_NAME=wavefrontProxyFQDN" -e "PROXY_PORT=2878"   TITO:TAG

FROM php:7.3.6-apache-stretch

COPY apache2-foreground /usr/local/bin/apache2-foreground
RUN chmod +x /usr/local/bin/apache2-foreground; \
    apt-get update; \
    # for troubleshooting, can add vim and iputils-ping the following command line
    apt-get install -y libmcrypt-dev git curl vim nano; \
    docker-php-ext-install mysqli pdo_mysql sockets; \
    echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf; a2enconf servername; \
    apt-get clean && rm -rf /var/cache/apt/archives; \
    cd /tmp; \
    curl -O https://raw.githubusercontent.com/ahugla/test-bidouille-docker/master/Debian9/installTracing.sh; \
    chmod 755 installTracing.sh; \
    ./installTracing.sh;


ENTRYPOINT ["/usr/local/bin/apache2-foreground"]
