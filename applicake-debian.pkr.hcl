packer {
    required_plugins {
        docker = {
            version = ">= 0.0.7"
            source = "github.com/hashicorp/docker"
        }
    }
}

source "docker" "debian" {
    image = "debian:stable"
    commit = true
}

variable "git_password" {
    description = "Github password"
    type        = string
    sensitive   = true
}

build {
    sources = [
        "source.docker.debian"
    ]
    provisioner "shell" {
        inline = [
            "apt-get update && apt-get install -y dialog apt-utils apt-transport-https ca-certificates",
            "apt-get install -y curl git-core sudo apache2 unzip",
            "apt-get install -y php libapache2-mod-php php-mysql php-imagick php-simplexml php-mbstring php-dom php-zip",
            #configure apache
            #install composer
            "php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\"",
            "php composer-setup.php",
            "php -r \"unlink('composer-setup.php');\"",
            "sudo mv composer.phar /usr/local/bin/composer",
            "composer self-update --1",
            #install app
            "mkdir /var/www/api.applicake.to",
            "git clone https://akubiczek:${var.git_password}@github.com/akubiczek/miss-piggy-api.git /var/www/api.applicake.to/web",
            "cd /var/www/api.applicake.to/web",
            "composer install",
            "cp .env.example .env",
            "php artisan migrate",
            "php artisan key:generate",
            "php artisan passport:keys",
            "php artisan passport:client --password"
        ]
    }
}
