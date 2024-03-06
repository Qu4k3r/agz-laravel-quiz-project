locals {
  env  = var.env
  name = "application"
  tags = {
    CostCenter  = "Engineer"
    Environment = local.env
    Name        = local.name
    ManagedBy   = "Terraform"
  }
}