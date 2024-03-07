locals {
  azs                   = slice(data.aws_availability_zones.available.names, 0, (var.env == "main" ? 6 : 3))
  cidr                  = var.cidrs[var.env]
  database_subnet_cidrs = [for k, v in local.azs : cidrsubnet(local.cidr, 8, k + (length(local.azs) * 2))]
  env                   = var.env
  key_name              = "${var.env}-${local.name}"
  key_pair              = var.key_pair
  name                  = "application"
  private_subnet_cidrs  = [for k, v in local.azs : cidrsubnet(local.cidr, 8, k)]
  public_subnet_cidrs   = [for k, v in local.azs : cidrsubnet(local.cidr, 8, k + length(local.azs))]
  region                = "us-east-1"
  tags = {
    CostCenter  = "Engineer"
    Environment = local.env
    ManagedBy   = "Terraform"
  }
}