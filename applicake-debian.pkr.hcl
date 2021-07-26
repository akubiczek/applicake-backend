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
            "apt-get update && apt-get install -y apt-utils apt-transport-https ca-certificates lsb-release",
            "apt-get install -y curl wget git-core sudo apache2 unzip",
            "sudo wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg",
            "echo \"deb https://packages.sury.org/php/ $(lsb_release -sc) main\" | sudo tee /etc/apt/sources.list.d/php.list",
            "apt-get update",
            "apt-get install -y php7.4",
            "apt-get install -y php7.4-mysql php7.4-curl php7.4-imagick php7.4-simplexml php7.4-mbstring php7.4-dom php7.4-zip",
            #configure apache
            #install composer
            "php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\"",
            "php composer-setup.php",
            "php -r \"unlink('composer-setup.php');\"",
            "sudo mv composer.phar /usr/local/bin/composer",
            #install app
            "mkdir /var/www/api.applicake.to",
            "git clone -b feature/terraform https://akubiczek:${var.git_password}@github.com/akubiczek/miss-piggy-api.git /var/www/api.applicake.to/web",
            "cd /var/www/api.applicake.to/web",
            "composer update && composer install",
            "cp .env.example .env",
            #"php artisan migrate",
            #"php artisan key:generate",
            #"php artisan passport:keys",
            #"php artisan passport:client --password"
        ]
    }
}
