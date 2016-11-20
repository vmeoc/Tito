#!/bin/bash
#This script install all the packages needed for the Tito Front End (Apache, git)
#It also configure the necessary files
#it download the necessary sources from  Git
#and it start the service

#variables#######################
HTMLPATH=/var/www/html
GITREPO=https://github.com/vmeoc/Tito/
HTTPDCONF=/etc/httpd/conf/httpd.conf
#################################
echo 
echo -e "Open Firewall port 80\n"

firewall-cmd --zone=public --add-port=80/tcp --permanent
firewall-cmd --reload


echo
echo -e "Install Apache & PHP\n"

yum update -y
yum install httpd -y
service httpd start
yum install php -y
yum install php-mysql -y
/usr/sbin/chkconfig httpd on

echo
echo -e "deactive selinux to reach remote db"
echo "SELINUXTYPE=disabled" > /etc/sysconfig/selinux

echo
echo -e "install Git\n"

yum install git -y

echo
echo -e "Install Tito sources \n"


cd $HTMLPATH
git clone $GITREPO .
git checkout Dev

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


#reboot to be done at the end by vRA