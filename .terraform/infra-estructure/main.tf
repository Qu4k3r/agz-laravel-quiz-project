locals {
  env  = var.env
  name = "application"
  tags = {
    CostCenter  = "Engineer"
    Environment = local.env
    ManagedBy   = "Terraform"
  }
}