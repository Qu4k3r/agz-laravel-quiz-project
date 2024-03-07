variable "cidrs" {
  type        = map(string)
  description = "Bloco de endereços IP do projeto"
  default = {
    develop      = "172.20.0.0/16"
    homologation = "172.22.0.0/16"
    main         = "172.16.0.0/16"
  }
}

variable "env" {
  description = "The environment in which resources are set up"
  type        = string
}

variable "region" {
  description = "The AWS region in which resources are set up."
  type        = string
  default     = "us-east-1"
}