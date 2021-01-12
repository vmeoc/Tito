This is the content to deploy the Tito monolith app from Cloud assembly with Salt taking care of the conf mgmt.
To use it, simply import the cloud assembly template and copy all salt files on your salt master.
You can also set your salt master to point to this repo to consume the files:
fileserver_backend:
  - git
  - roots
gitfs_remotes:
   - git://github.com/vmeoc/Tito.git:
     - root: asset/Deployment/Salt
Then restart the server.

To test the setup: salt '<servernameX>' state.apply titoFE.install.
<ServernameX> should answer on port 80 with the Tito Front end.
