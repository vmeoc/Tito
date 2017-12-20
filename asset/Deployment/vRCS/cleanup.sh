#!/bin/bash

#Created by Vince on the 19/12/17
#cleanup.sh
#
#


#########initial setting
TITO_TEMP_DIR="/tmp/"
TITO_TEMP_DIR+=$1
TITO_PROD_DIR="/home/vmware/Demo-do-not-touch/Tito/asset/Deployment/K8"
TITO_RC="tito-fe-rc.ymltito-fe-rc.yml"

echo "lancement du script clean up"
echo -n "TITO_TEMP_DIR="
echo $TITO_TEMP_DIR
echo -n "TITO_PROD_DIR"
echo $TITO_PROD_DIR
echo -n "TITO_RC"
echo $TITO_RC

#suppression fichiers et répertoires
rm -rf $TITO_TEMP_DIR

#Set Tito prod tp V1
kubectl -n=dev rolling-update titofe-next -f $TITO_RC
