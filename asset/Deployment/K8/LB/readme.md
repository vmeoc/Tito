# Overview

This folder consists of a number of different files. An overview is provided below.

## Component YAMLs

- **tito-fe-rc.yml** : Front end Replication Controller. This defines how many front-end hosts to deploy, what image to use, what port to expose, and what host to connect to for the database
- **tito-fe-service.yml** : LoadBalancer Service file details what port the service should listen on and which app (defined in replication controller) the service should direct requests to
- **tito-sql-pod.yml** : Specifies the DB for the application, what image to use, root password for db, and what port to listen on
- **tito-sql-service.yml** : Provides a service to expose the sql database to other pods and what port to expose.

## Merged YAMLs

- **ahugla-merg-rc-svc-fe.yaml** : Provides a merged YAML of the tito-fe-rc.yml and tito-fe-service.yml . This can be handy if you are providing step-by-step guidance on building out the Tito app and want the Front-End (LB Service + ReplicationController) to be deployed as a single YAML.
- **tito-full-lb.yml** : Provides a SINGLE YAML to stand up a Load Balanced copy of Tito in Kubernetes. Create a namespace named "tito" in your cluster, then use Sample deployment line: ```kubectl create -f tito-full-lb.yml```