locals {
  tags = {
    CostCenter  = "Engineer"
    Environment = local.env
    ManagedBy   = "Terraform"
  }
}