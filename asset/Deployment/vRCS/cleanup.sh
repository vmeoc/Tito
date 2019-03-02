#!/bin/bash

#Created by Vince on the 19/12/17
#cleanup.sh
#
#


#########initial setting
TITO_RC_NEXT="tito-fe-rc-next.yml"
TITO_TEMP_DIR="/tmp/"
TITO_TEMP_DIR+=$1
TITO_PROD_DIR="/home/vince/Demo/Prod/Tito/asset/Deployment/K8/Ingress"
TITO_RC="tito-fe-rc.yml"
K8_CLUSTER="k8s-02"

echo "lancement du script clean up"
echo -n "TITO_TEMP_DIR="
echo $TITO_TEMP_DIR
echo -n "TITO_PROD_DIR="
echo $TITO_PROD_DIR
echo -n "TITO_RC="
echo $TITO_RC

cd $TITO_PROD_DIR

#use the right K8 cluster
kubectl config use-context $K8_CLUSTER

#suppression fichiers et répertoires
rm -rf $TITO_TEMP_DIR
rm -f $TITO_RC_NEXT

#destroy dev-demo K8
kubectl --namespace=dev delete pods,services,rc,ing -l app=tito -l stage=dev

#Set Tito prod tp V1
sed -i "0,/name:.*/s//name: tito-fe-current/" $TITO_RC
kubectl -n=prod rolling-update titofe -f $TITO_RC
sed -i "0,/name:.*/s//name: tito-fe/" $TITO_RC
