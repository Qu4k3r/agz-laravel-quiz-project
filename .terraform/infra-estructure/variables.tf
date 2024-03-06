variable "env" {
  description = "The environment in which resources are set up"
  type        = string
}

variable "region" {
  description = "The AWS region in which resources are set up."
  type        = string
  default     = "us-east-1"
}