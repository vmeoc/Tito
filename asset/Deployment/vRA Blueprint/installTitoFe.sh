#!/bin/bash
#This script install all the packages needed for the Tito Front End (Apache, git)
#It also configure the necessary files
#it download the ncessary sources from  Git
#and it start the service

#variables
HTMLPATH=/var/www/html
GITREPO=https://github.com/vmeoc/Tito/
HTTPDCONF=/etc/httpd/conf/httpd.conf

echo 
echo -e "Arrêt du Firewall car utilisation NSX\n"

sudo service firewalld stop

echo
echo -e "Install Apache & PHP\n"

sudo yum update -y
sudo yum install httpd -y
sudo service httpd start
sudo yum install php -y
sudo chkconfig httpd on

echo
echo -e "install Git\n"

sudo yum install git -y

echo
echo -e "Install Tito sources \n"


cd $HTMLPATH
git clone $GITREPO .
git checkout tags/V1

echo
echo -e "conf httpd.conf pour prise en compte de PHP et paramètrage du serveur SQL\n"


echo "LoadModule php5_module modules/libphp5.so" >> $HTTPDCONF
cat <<EOF >> $HTTPDCONF
<IfModule env_module>
    SetEnv TITO-SQL "$SQLSERVER"
</IfModule>
EOF

echo -e "conf php.ini pour Timezone \n"

echo "date.timezone = \"Europe/Paris\"" >> /etc/php.ini


echo -e "démarrage Apache \n"

sudo service httpd restart


echo "Fin du script"
