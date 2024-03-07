data "aws_availability_zones" "available" {}

data "template_file" "user_data_application" {
  template = file("./user_data/application.sh")
  vars = {
    SSH_PRIVATE_KEY = local.key_pair
  }
}