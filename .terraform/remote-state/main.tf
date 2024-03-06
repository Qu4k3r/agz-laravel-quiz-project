terraform {
  required_version = ">= 0.15"

  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = ">= 4.0.0"
    }
  }
}

provider "aws" {
  region = var.region
}

module "remote-state-s3-backend" {
  enable_replication      = true
  override_s3_bucket_name = true
  s3_bucket_name          = "agz-laravel-quiz-project-tf-remote-state"
  s3_bucket_name_replica  = "agz-laravel-quiz-project-tf-replica-remote-state"
  source                  = "nozaq/remote-state-s3-backend/aws"
  version                 = "1.6.0"

  providers = {
    aws = aws
    aws.replica = aws
  }
}