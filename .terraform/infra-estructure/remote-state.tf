terraform {
  required_version = ">= 0.15"

  required_providers {
    aws = {
      source  = "hashicorp/aws"
      version = ">= 4.0.0"
    }
  }

  backend "s3" {
    bucket         = "agz-laravel-quiz-project-tf-remote-state"
    key            = "infra-estructure.tfstate"
    region         = "us-east-1"
    dynamodb_table = "tf-remote-state-lock"
  }
}