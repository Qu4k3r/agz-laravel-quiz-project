# module "ec2_application" {
#   source  = "terraform-aws-modules/ec2-instance/aws"
#   version = "5.5.0"

#   ami                         = "ami-0f403e3180720dd7e"
#   associate_public_ip_address = true
#   availability_zone           = element(module.vpc.azs, 0)
#   enable_volume_tags          = false
#   instance_type               = "t2.micro"
#   key_name                    = "${local.env}-${local.name}"
#   monitoring                  = true
#   name                        = "${local.env}-${local.name}"
#   subnet_id                   = element(module.vpc.public_subnets, 0)
#   user_data_base64            = base64encode(data.template_file.user_data_application.rendered)
#   user_data_replace_on_change = true
#   vpc_security_group_ids      = [module.sg_application.security_group_id]

#   root_block_device = [
#     {
#       encrypted   = true
#       volume_type = "gp3"
#       throughput  = 200
#       volume_size = 30
#       tags = {
#         Name = "${local.env}-${local.name}"
#       }
#     },
#   ]

#   tags = merge(local.tags, {
#     Name = "${local.env}-${local.name}"
#   })
# }

# ##############################################
# ##################### SG #####################
# ##############################################
# module "sg_application" {
#   source  = "terraform-aws-modules/security-group/aws"
#   version = "~> 4.0"

#   name        = "${local.env}-${local.name}"
#   description = "Politicas de seg p instancia appserver de ${local.env}/${local.name}"
#   vpc_id      = module.vpc.vpc_id

#   ingress_with_cidr_blocks = [
#     {
#       from_port   = 35222
#       to_port     = 35222
#       protocol    = "tcp"
#       description = "Acesso SSH da rede externa para o appserver"
#       cidr_blocks = "0.0.0.0/0"
#     },
#     {
#       from_port   = 8080
#       to_port     = 8080
#       protocol    = "tcp"
#       description = "Acesso HTTP da rede externa para o appserver"
#       cidr_blocks = "0.0.0.0/0"
#     }
#   ]

#   egress_with_cidr_blocks = [
#     {
#       from_port   = 0
#       to_port     = 0
#       protocol    = -1
#       description = "Libera saida para todos os destinos"
#       cidr_blocks = "0.0.0.0/0"
#     }
#   ]

#   tags = merge(local.tags, {
#     Name = "${local.env}-${local.name}"
#   })
# }