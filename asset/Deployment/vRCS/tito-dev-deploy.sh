#!/bin/bash

#Created by Vince on the 19/12/17
#
#
#


#########initial setting
TMP_DIR="/tmp/"
TMP_DIR+=$2
TITO_GITHUB="https://github.com/vmeoc/Tito"
VERSION=$1
STAGE="dev"

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

cd $TMP_DIR
git clone $TITO_GITHUB

#Flag Tito files as Dev stage
sed -i "/stage:/c\    stage: ${STAGE}" Tito/asset/Deployment/K8-PKS/*


#Set Tito to the correct version
sed -i "/value:/c\            value: ${VERSION}" Tito/asset/Deployment/K8-PKS/tito-fe-rc.yml

#Start Tito 
kubectl --namespace=dev create -f Tito/asset/Deployment/K8-PKS/.

#Resultat
sleep 3
echo "Connect to: "
kubectl get services titofe-service --namespace=dev --output=json | jq '.status.loadBalancer.ingress[0].ip'
