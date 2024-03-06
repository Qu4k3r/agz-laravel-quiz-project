resource "aws_ecr_repository" "this" {
  name                 = "${local.env}-${local.name}"
  image_tag_mutability = "IMMUTABLE"
  tags                 = local.tags

  image_scanning_configuration {
    scan_on_push = true
  }
}