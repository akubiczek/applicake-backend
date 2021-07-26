terraform {
    required_providers {
        aws = {
            source  = "hashicorp/aws"
            version = "~> 3.27"
        }
    }

    required_version = ">= 0.14.9"
}

#https://dev.to/rolfstreefkerk/how-to-setup-a-basic-vpc-with-ec2-and-rds-using-terraform-3jij

locals {
    name   = "applicake"
    region = "eu-west-1"
    tags = {
        Owner       = "user"
        Environment = "dev"
    }
}

provider "aws" {
    profile = "default"
    region  = local.region
}

resource "aws_instance" "app_server" {
    ami           = "ami-830c94e3"
    instance_type = "t2.nano"

    tags = {
        Name = "ApplicakeAppServerInstance"
    }
}

################################################################################
# Supporting Resources
################################################################################

module "vpc" {
    source  = "terraform-aws-modules/vpc/aws"
    version = "~> 2"

    name                 = local.name
    cidr                 = "10.99.0.0/18"
    azs                  = ["${local.region}a", "${local.region}b", "${local.region}c"]
    database_subnets     = ["10.99.7.0/24", "10.99.8.0/24", "10.99.9.0/24"]

    create_database_subnet_group = true
}

module "security_group" {
    source  = "terraform-aws-modules/security-group/aws"
    version = "~> 4"

    name        = local.name
    description = "Complete MySQL security group"
    vpc_id      = module.vpc.vpc_id

    # ingress
    ingress_with_cidr_blocks = [
        {
            from_port   = 3306
            to_port     = 3306
            protocol    = "tcp"
            description = "MySQL access from within VPC"
            cidr_blocks = module.vpc.vpc_cidr_block
        },
    ]
}

################################################################################
# RDS Module
################################################################################

resource "aws_db_instance" "example" {
    identifier = local.name

    # All available versions: http://docs.aws.amazon.com/AmazonRDS/latest/UserGuide/CHAP_MySQL.html#MySQL.Concepts.VersionMgmt
    engine               = "mysql"
    engine_version       = "8.0.23"
    instance_class       = "db.t2.micro"

    allocated_storage     = 20
    max_allocated_storage = 100
    storage_encrypted     = false

    name     = "completeMysql"
    username = "complete_mysql"
    password = "YourPwdShouldBeLongAndSecure!"
    port     = 3306

    multi_az               = false
    vpc_security_group_ids = [module.security_group.security_group_id]

    maintenance_window              = "Mon:00:00-Mon:03:00"
    backup_window                   = "03:00-06:00"
    enabled_cloudwatch_logs_exports = ["general"]

    backup_retention_period = 0
    skip_final_snapshot     = true
    deletion_protection     = false

    performance_insights_enabled          = true
    performance_insights_retention_period = 7
}
