#!/bin/bash
cd ../../..

#filePaths=( "asset/Deployment/CloudAssembly/titodb/mysql.sh")

echo "Set database password: " && read password

read -p "Would you like to provide a Google API Key? (y/n) " useCustomKey
if [[ "$useCustomKey" =~ ^[Yy]$ ]]; then
    read -p "Enter Key: " customKey
    sed -i '' "s/.*GOOGLE_API_KEY.*/GOOGLE_API_KEY = $customKey/" "config.ini.php" 
fi

encpass=$(echo -n "${password}" | base64)

sed -i '' "s/.*password.*/password = \"$password\"/" "config.ini.php"

sed -i '' "s/master_password.*/master_password: $password/" "asset/Deployment/CloudAssembly/Tito FE and RDS DB.yml"

sed -i '' "s/DB_ROOT_PASSWORD=.*/DB_ROOT_PASSWORD=$password/" "asset/Deployment/CloudAssembly/titodb/mysql.sh"

sed -i '' "s/db_password=.*/db_password=$password/" "asset/Deployment/CloudAssembly/titodb/tito_db.sh"

sed -i '' "s/password=.*/password=$password --database=TitoDB -e 'select count(*) from TitoTable'\"/" "asset/Deployment/Docker/docker-compose.yml"

sed -i '' "s/ROOT_PASSWORD:.*/ROOT_PASSWORD: $password/g" "asset/Deployment/Docker/docker-compose.yml"

sed -i '' "s/password:.*/password: \"$password\",/" "asset/Deployment/FaaS/AWS/book/db-connector.js"

sed -i '' "s/password:.*/password: \"$password\",/" "asset/Deployment/FaaS/AWS/read/db-connector.js"

sed -i '' "s/password:.*/password: \"$password\",/" "asset/Deployment/FaaS/AWS/reset/db-connector.js"

sed -i '' "s/password:.*/password: \"$password\",/" "asset/Deployment/FaaS/Openfaas/book/db-connector"

sed -i '' "s/password:.*/password: \"$password\",/" "asset/Deployment/FaaS/Openfaas/read/db-connector"

sed -i '' "s/password:.*/password: \"$password\",/" "asset/Deployment/FaaS/Openfaas/reset/db-connector"

#Note: The sed command may not work properly in future changes to the file if any more value tags are added
sed -i '' "s/value:.*/value: $password/" "asset/Deployment/K8/Ingress/pks/tito-sql-pod.yml"

#  idk what to do for Titocopy.yaml

sed -i '' "s/password:.*/password: $encpass/" "asset/Deployment/K8/Ingress/PKSCloud/tito-full-ing-dev.yml"

sed -i '' "s/password:.*/password: $encpass/" "asset/Deployment/K8/Ingress/PKSCloud/tito-full-ing-prod.yml"

sed -i '' "s/password:.*/password: $encpass/" "asset/Deployment/K8/LB/tito-full-lb.yml"

line=$(sed -n '/DB_ROOT_PASSWORD:/=' 'asset/Deployment/vRA Blueprint/VM based/old/composite-blueprint/Titocopy.yaml')

line=$((line + 1))

sed -i '' "${line} s/default:.*/default: $password/" "asset/Deployment/vRA Blueprint/VM based/old/composite-blueprint/Titocopy.yaml"

sed -i '' "s/DB_PASSWORD:.*/DB_PASSWORD: $password/" "asset/Deployment/vRA Blueprint/VM based/old/composite-blueprint/Titocopy.yaml"

line=$(sed -n '/type: "secureString"/=' 'asset/Deployment/vRA Blueprint/VM based/old/software-component/Software.TitoDBconf.yaml')

l_one=$(echo $line | cut -d " " -f 1)
l_one=$((l_one + 1))
l_two=$(echo $line | cut -d " " -f 2)
l_two=$((l_two + 1))

sed -i '' "${l_one} s/value:.*/value: \"$password\"/" "asset/Deployment/vRA Blueprint/VM based/old/software-component/Software.TitoDBconf.yaml"
sed -i '' "${l_two} s/value:.*/value: \"$password\"/" "asset/Deployment/vRA Blueprint/VM based/old/software-component/Software.TitoDBconf.yaml"