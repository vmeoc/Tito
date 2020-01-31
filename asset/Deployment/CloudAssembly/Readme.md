You have several blueprints here:

Tito FE is just the Front end

Tito FE and RDS is the front end running in a cloud agnostic machine and the DB running in RDS

Tito monolith FE and DB multi cloud is quite interesting since it's a fully agnostic blueprint which you can run in any clouds Very useful to show infra as a code, intelligent placement, etc...

tito with micro services is the most advanced on using the agnostic objects for the monolith part of Tito and AWS services for the micro service part (Lambda serverless + API GW + IAM + RDS). You'll need a bit of setup on the AWS VPC, Sec group, subnets, etc... to make this working though.


The different blueprints need a cloud landing zone properly setup, connectd to vRA and properly tags for the intelligent placement.
Each Network profile need to have cloud:<aws/azure/vsphere> for example

Tracing with Tito

The tito monolith FE and DB multi cloud blueprint now sends traces to Wavefront (via proxy) with tags for home_address and work_address. 
This is based on a Python script 'sendTraces.py' which sequentially reports the spans and which is launched by GetTrafficData.php.
As this is for demo purpose, all spans are fake but 'Google API calls' which is based on the real duration of the call.

Prerequisites (see below for the install and configuration script)
Wavefront Proxy
Python3
"sendTraces.py" must be executable
'PROXY_NAME' and 'PROXY_PORT' must be configured in /etc/sysconfig/httpd
Enable scripts execution in /etc/httpd/conf/httpd.conf for <Directory "/var/www/html">
Wavefront Proxy
docker run -d \
-e WAVEFRONT_URL=https://vmware.wavefront.com/api/ \
-e WAVEFRONT_TOKEN=7xxxxxxxxxxxxxxxxxxxxxxxxxxxx5 \
-e JAVA_HEAP_USAGE=512m \
-e WAVEFRONT_PROXY_ARGS="--traceListenerPorts 30000 --histogramDistListenerPorts 40000" \
-p 2878:2878 \
-p 30000:30000 \
-p 40000:40000 \
-p 4242:4242 \
wavefronthq/proxy:latest
