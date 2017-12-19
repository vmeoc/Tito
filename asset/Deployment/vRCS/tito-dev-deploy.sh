#!/bin/bash

#Created by Vince on the 19/12/17
#
#
#


#########initial setting
TMP_DIR="/tmp/"
TMP_DIR+=$(cat /dev/urandom | tr -dc '0-9' | fold -w 16 | head -n 1)
TITO_GITHUB="https://github.com/vmeoc/Tito"
VERSION=$1
STAGE="dev"
INGRESS_NAME="tito-dev-"
INGRESS_NAME+=$(cat /dev/urandom | tr -dc '0-9' | fold -w 4 | head -n 1)

echo "lancement script deploiement Tito"
echo -n "TMP_DIR= "
echo $TMP_DIR
echo -n "TITO_GITHUB= "
echo $TITO_GITHUB
echo -n "VERSION= "
echo $VERSION
echo -n "STAGE= "
echo $STAGE
echo -n "INGRESS_NAME= "
echo $INGRESS_NAME

#cleanup
echo "cleanup..."
kubectl --namespace=dev delete pods,services,rc,ing -l app=tito -l stage=dev

mkdir $TMP_DIR
cd $TMP_DIR
git clone $TITO_GITHUB

#Flag Tito files as Dev stage
sed -i "/stage:/c\    stage: ${STAGE}" Tito/asset/Deployment/K8/*

#Set Ingress as Dev
sed -i "/- path:/c\      - path: /${INGRESS_NAME}" Tito/asset/Deployment/K8/tito-fe-ing.yml

#Set Tito to the correct version
sed -i "/value:/c\            value: ${VERSION}" Tito/asset/Deployment/K8/tito-fe-rc.yml

#Start Tito 
kubectl --namespace=dev create -f Tito/asset/Deployment/K8/.

#Resultat
echo "Connect to: "
echo http://ingress.k8s/$INGRESS_NAME/index.php

#cleanup
echo "cleanup TODO"

