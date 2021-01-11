This is the content to deploy the Tito monolith app from Cloud assembly with Salt taking care of the conf mgmt.
To use it, simply import the cloud assembly template and copy all salt files on your salt master.
You can also set your salt master to point to this repo to consume the files:
fileserver_backend:
  - git
gitfs_remotes:
   - git://github.com/vmeoc/Tito.git:
     - root: asset/Deployment/Salt
