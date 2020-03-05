
# Install:  Python 3.6, pip and SDK for wavefront tracing
#
# Alexandre hugla
# 5 mars 2019
#
# -----------------------------------------------------------


# INSTALL PYTHON3 
#----------------
echo "deb http://ftp.de.debian.org/debian testing main" >> /etc/apt/sources.list
echo 'APT::Default-Release "stable";' | tee -a /etc/apt/apt.conf.d/00local
apt-get update
apt-get -t testing install -y python3


# INSTALL PYTHON3-PIP 
#----------------------
rm -f /etc/apt/apt.conf.d/00local
apt-get update
apt-get install -y python3-pip


# INSTALL WAVEFRONT SDK 
#----------------------
pip3 install wavefront-opentracing-sdk-python --no-cache-dir
