output "address" {
  value = "http://${aws_instance.web.public_ip}/index.php"
}
