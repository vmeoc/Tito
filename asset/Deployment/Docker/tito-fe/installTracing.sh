
# Install:  Python 3.6, pip and SDK for wavefront tracing
#
# Alexandre hugla
# 4 mars 2019
#
# -----------------------------------------------------------


# INSTALL PYTHON  (TRES LONG)
#---------------
cd /tmp

apt-get update && sudo apt-get upgrade

apt-get install -y do build-essential libssl-dev zlib1g-dev
apt-get install -y libbz2-dev libreadline-dev libsqlite3-dev wget curl llvm
apt-get install -y libncurses5-dev libncursesw5-dev xz-utils tk-dev

curl -O https://www.python.org/ftp/python/3.6.4/Python-3.6.4.tgz

tar xvf Python-3.6.4.tgz

#prepare the build
cd Python-3.6.4
#./configure --enable-optimizations     # LENT:  The configure option --enable-optimizations enables running test suites to generate data for profiling Python. The resulting python binary has better performance in executing python code. 
./configure                             # PLUS RAPIDE


#build Python
make -j8      # dure 30 min avec --enable-optimizations

#install Python
make altinstall

python3.6 -V



# INSTALL PYTHON-PIP
#-------------------
apt-get install -y python3-pip
pip3 --version


# INSTALL WAVEFRONT SDK 
#----------------------
pip3 install wavefront-opentracing-sdk-python --no-cache-dir