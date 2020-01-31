#!/bin/bash

# INSTALL TITO SUR CentOS7.x:
#    - httpd
#    - Setup DB address
#    - Tito App
#	 - Wavefront metriques et Tracing
#    - Log Insight Agent
#---------------------------------------------------------------------------------------------------------------------------
# Original author: Alex
# Updated by Vince
# 30/01/2020
#
# V2.1
#
#---------------------------------------------------------------------------------------------------------------------------
# USAGE:
#
# Install_Tito_LIagent_WavefrontConfig_Tracing.sh  [WAVEFRONT PROXY FQDN]  [WAVEFRONT PORT] [TITO VERSION] [DB_address]
#
#     ex: ./Install_Tito_LIagent_WavefrontConfig_Tracing.sh   wvfp.cpod-vrealizesuite.az-demo.shwrfr.com  2878   V1.9.6 192.168.30.1
#
#---------------------------------------------------------------------------------------------------------------------------

# Get and display parameters
PROXY_NAME=$1
PROXY_PORT=$2
TITO_VERSION=$3
SQLSERVER=$4
HTTPDCONF=/etc/httpd/conf/httpd.conf
echo "PROXY_NAME=$PROXY_NAME"
echo "PROXY_PORT=$PROXY_PORT"
echo "TITO_VERSION=$TITO_VERSION"
echo "HTTPDCONF=$HTTPDCONF"


# Install web server 
#rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
#rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
#yum --enablerepo=remi,remi-php72 install -y httpd php php-common
yum install httpd -y
/usr/sbin/service httpd start
yum install php -y
yum install php-mysql -y
/usr/sbin/chkconfig httpd on

# Install Python3 and libraries
yum install -y python36 python-pip python36-setuptools gcc python3-devel
easy_install-3.6 pip
pip3 install wavefront-opentracing-sdk-python --no-cache-dir

#Se timezone
echo
echo -e "conf php.ini Timezone \n"

echo "date.timezone = \"Europe/Rome\"" >> /etc/php.ini

#Setup DBAddress
echo
echo -e "conf httpd.conf to include PHP and set MySQL server\n"

echo
echo -e "modify SQLSERVER variable to remove not needed characters"
SQLSERVER=$(tr -d []\' <<< $SQLSERVER)

echo
echo "LoadModule php5_module modules/libphp5.so" >> $HTTPDCONF
cat <<EOF >> $HTTPDCONF
<IfModule env_module>
    SetEnv TITO-SQL "$SQLSERVER"
</IfModule>
EOF

# TITO INSTALL
git clone https://github.com/vmeoc/Tito.git  /var/www/html
cd /var/www/html
git checkout $TITO_VERSION

  
# Rendre executable le script Python de Tracing
chmod 777 /var/www/html/sendTraces.py


# config httpd.conf pour autoriser le lancement de scripts
sed -i '/<Directory "\/var\/www\/html">/a AddHandler cgi-script .cgi .pl .py' /etc/httpd/conf/httpd.conf
sed -i '/<Directory "\/var\/www\/html">/a Options +ExecCGI' /etc/httpd/conf/httpd.conf


# WAVEFRONT CONFIG - set variable for apache in "/etc/sysconfig/httpd"
echo "PROXY_NAME=$PROXY_NAME" >> /etc/sysconfig/httpd
echo "PROXY_PORT=$PROXY_PORT" >> /etc/sysconfig/httpd


# Start Web Server
systemctl start httpd
systemctl enable httpd


# INSTALL LI AGENT
cd /tmp
git clone https://github.com/ahugla/LogInsight.git  /tmp/li
rpm -ivh "/tmp/li/latest/VMware*.rpm"
sed -i -e 's/;ssl=yes/ssl=no/g'  /var/lib/loginsight-agent/liagent.ini
systemctl restart liagentd
systemctl enable liagentd
rm -rf /tmp/li
  


