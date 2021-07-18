# tito Front End in Terraform

This provides a template for running Tito on Amazon Web services.

This example will also create a new EC2 Key Pair in the specified AWS Region. 
The key name and path to the public key must be specified via the  
terraform command vars.
Also the private key used to install the software need to be in ~/.ssh/titan_priv

After you run `terraform apply` on this configuration, it will
automatically output the URL to connect to. 

To run, configure your AWS provider as described in 

https://www.terraform.io/docs/providers/aws/index.html
for example export your credentials as env variables with export AWS_ACCESS_KEY_ID

Run with a command like this:

```
terraform apply -var 'key_name={your_aws_key_name}' \
   -var 'public_key_path={location_of_your_key_in_your_local_machine}'
```

For example:

```
terraform apply -var 'key_name=terraform' -var 'public_key_path=/Users/jsmith/.ssh/terraform.pub' -var 'private_key_path=/Users/jsmith/.ssh/terraform.priv'
```

TODO Later on:
add SQL
Use more Variable
