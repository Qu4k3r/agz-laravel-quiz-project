locals {
  env = var.env
  tags = {
    CostCenter  = "Engineer"
    Environment = local.env
    ManagedBy   = "Terraform"
  }
}