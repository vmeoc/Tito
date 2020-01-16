You have several blueprints here:

Tito FE is just the Front end

Tito FE and RDS is the front end running in a cloud agnostic machine and the DB running in RDS

Tito monolith FE and DB multi cloud is quite interesting since it's a fully agnostic blueprint which you can run in any clouds Very useful to show infra as a code, intelligent placement, etc...

tito with micro services is the most advanced on using the agnostic objects for the monolith part of Tito and AWS services for the micro service part (Lambda serverless + API GW + IAM + RDS). You'll need a bit of setup on the AWS VPC, Sec group, subnets, etc... to make this working though.


The different blueprints need a cloud landing zone properly setup, connectd to vRA and properly tags for the intelligent placement.
Each Network profile need to have cloud:<aws/azure/vsphere> for example
