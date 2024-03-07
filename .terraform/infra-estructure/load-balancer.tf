resource "aws_lb" "this" {
  name               = substr("${local.env}-${local.name}", 0, 32)
  internal           = false
  load_balancer_type = "application"
  security_groups    = [module.sg_svc_loadbalancer.security_group_id]
  subnets            = module.vpc.public_subnets
  idle_timeout       = local.alb_idle_timeout
  enable_http2       = local.alb_enable_http2

  access_logs {
    bucket  = module.alb_log_bucket[0].s3_bucket_id
    enabled = true
    prefix  = null
  }

  tags = merge(local.tags, {
    Name = "${local.env}-${local.name}"
  })
}


##############################################
################# Listeners ##################
##############################################
resource "aws_lb_listener" "redirect" {
  load_balancer_arn = aws_lb.this.id
  port              = 80
  protocol          = "HTTP"

  default_action {
    type = "redirect"
    redirect {
      port        = "443"
      protocol    = "HTTPS"
      status_code = "HTTP_301"
    }
  }
}

resource "aws_lb_listener" "https" {
  load_balancer_arn = aws_lb.this.id
  port              = 443
  protocol          = "HTTPS"
  ssl_policy        = "ELBSecurityPolicy-2016-08"

  default_action {
    type = "fixed-response"

    fixed_response {
      content_type = "text/plain"
      message_body = "not found"
      status_code  = "404"
    }
  }
}

##############################################
##################### SG #####################
##############################################
module "sg_svc_loadbalancer" {
  source  = "terraform-aws-modules/security-group/aws"
  version = "~> 4.0"

  name        = "${local.env}-${local.name}-loadbalancer"
  description = "Politicas de seg do Load Balancer para ${local.env}/${local.name}"
  vpc_id      = module.vpc.vpc_id

  ingress_with_cidr_blocks = [
    {
      from_port   = 80
      to_port     = 80
      protocol    = "tcp"
      description = "Libera acesso a porta HTTP do Load Balancer"
      cidr_blocks = "0.0.0.0/0"
    },
    {
      from_port   = 443
      to_port     = 443
      protocol    = "tcp"
      description = "Libera acesso a porta HTTPS do Load Balancer"
      cidr_blocks = "0.0.0.0/0"
    }
  ]

  egress_with_cidr_blocks = [
    {
      from_port   = 8080
      to_port     = 8080
      protocol    = "tcp"
      description = "Libera saida da porta HTTP para o Application server"
      cidr_blocks = "${module.ec2_application.private_ip}/32"
    }
  ]

  tags = merge(local.tags, {
    Name = "${local.env}-${local.name}-loadbalancer"
  })
}

##############################################
#################### Logs ####################
##############################################
module "alb_log_bucket" {
  source  = "terraform-aws-modules/s3-bucket/aws"
  version = "~> 3.0"

  bucket = "${local.env}-${local.name}-alb-logs-bucket"
  acl    = "log-delivery-write"

  force_destroy = true

  control_object_ownership = true
  object_ownership         = "ObjectWriter"

  attach_elb_log_delivery_policy = true
  attach_lb_log_delivery_policy  = true

  attach_deny_insecure_transport_policy = true
  attach_require_latest_tls_policy      = true

  tags = merge(local.tags, {
    Name = "${local.env}-${local.name}-alb-logs-bucket"
  })
}

##############################################
################ Target Group ################
##############################################
resource "aws_lb_target_group" "this" {
  name        = substr("${local.env}-${local.name}", 0, 32)
  port        = 8080
  protocol    = "HTTP"
  vpc_id      = module.vpc.vpc_id
  target_type = "instance"

  tags = merge(local.tags, {
    Name = "${local.env}-${local.name}"
  })

  health_check {
    interval          = 30
    matcher           = 200
    path              = "/"
    protocol          = "HTTP"
    healthy_threshold = 3
    timeout           = 5
  }
}

resource "aws_lb_listener_rule" "this" {
  listener_arn = aws_lb_listener.https.arn
  priority     = 1

  action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.this.arn
  }

  condition {
    path_pattern {
      values = ["/*"]
    }
  }
}

resource "aws_alb_target_group_attachment" "this" {
  target_group_arn = aws_lb_target_group.this.arn
  target_id        = module.ec2_application.id
  port             = 8080
}