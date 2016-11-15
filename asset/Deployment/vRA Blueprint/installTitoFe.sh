#!/bin/bash

#variables
HTMLPATH=/var/www/html
GITREPO=https://github.com/vmeoc/Tito/

echo
echo "Arrêt du Firewall car utilisation NSX"
echo
sudo service firewalld stop

echo
echo "Install Apache & PHP"
echo
sudo yum update -y
sudo yum install httpd -y
sudo service httpd start
sudo yum install php -y
sudo chkconfig httpd on

echo
echo "install Git"
echo
sudo yum install git -y

echo
echo "Install Tito sources"
echo

cd $HTMLPATH
git clone $GITREPO .
git checkout tags/V1

echo
echo "conf httpd.conf pour prise en compte de PHP"
echo

echo "LoadModule php5_module modules/libphp5.so" >> /etc/httpd/conf/httpd.conf

echo
echo "conf php.ini pour Timezone"
echo
echo "date.timezone = \"Europe/Paris\"" >> /etc/php.ini

echo
echo "démarrage Apache"
echo
sudo service httpd restart

echo
echo "Fin du script"
echo