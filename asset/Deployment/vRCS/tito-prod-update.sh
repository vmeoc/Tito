#!/bin/bash

#Created by Vince on the 19/12/17
#Tito-Prod-update.sh
#
#


#########initial setting
TITO_RC_NEXT="tito-fe-rc-next.yml"
TITO_RC_CURRENT="tito-fe-rc.yml"
NEXT_LABEL="next"
NEXT_NAME="titofe-next"
TITO_VERSION=$1
TITO_PROD_DIR="/home/vmware/DemoTito/Prod/Tito/asset/Deployment/K8-PKS"

echo "lancement du script update Prod Tito"
echo -n "TITO_PROD_DIR="
echo $TITO_PROD_DIR
echo -n "TITO_RC_NEXT="
echo $TITO_RC_NEXT
echo -n "TITO_RC_CURRENT="
echo $TITO_RC_CURRENT
echo -n "NEXT LABEL="
echo $NEXT_LABEL
echo -n "NEXT_NAME="
echo $NEXT_NAME
echo -n "TITO_VERSION="
echo $TITO_VERSION

cd $TITO_PROD_DIR
cp $TITO_RC_CURRENT $TITO_RC_NEXT

#change metadata.name
sed -i "0,/name:.*/s//name: ${NEXT_NAME}/" $TITO_RC_NEXT

#change version label at the rc selector level and at the container template level
sed -i "/version:.*/s//version: ${NEXT_LABEL}/" $TITO_RC_NEXT

#change version at the container level via the env variable
sed -i "/value:.*/s//value: ${TITO_VERSION}/" $TITO_RC_NEXT

#start rolling update
kubectl -n=prod rolling-update titofe -f $TITO_RC_NEXT
