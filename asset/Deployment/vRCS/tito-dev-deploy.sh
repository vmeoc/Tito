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
TITO_CONF="Tito/asset/Deployment/K8/Ingress/"
K8_CLUSTER="gv-prod"

echo "lancement script deploiement Tito"
echo -n "TMP_DIR= "
echo $TMP_DIR
echo -n "TITO_GITHUB= "
echo $TITO_GITHUB
echo -n "VERSION= "
echo $VERSION
echo -n "STAGE= "
echo $STAGE

#switch to the right cluster
kubectl config use-context $K8_CLUSTER

#cleanup
echo "cleanup..."
kubectl --namespace=dev delete pods,services,rc,ing -l app=tito -l stage=dev

cd $TMP_DIR
git clone $TITO_GITHUB

#Flag Tito files as Dev stage
sed -i "/stage:/c\    stage: ${STAGE}" $TITO_CONF/*


#Set Tito to the correct version
sed -i "/value:/c\            value: ${VERSION}" $TITO_CONF/tito-fe-rc.yml

#Start Tito 
kubectl --namespace=dev create -f $TITO_CONF/.

#Resultat
sleep 3
echo "Connect to: "
VAR=$(kubectl get ing tito-dev --namespace=dev --output=json | jq '.spec.rules[0].host')
echo "http://${VAR//\"}/tito/"
