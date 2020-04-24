@servers(['dev' => '192.168.1.14', 'prod' => '-i ~/.ssh/piggylykeys.pem bitnami@api.applicake.to'])

@setup
    if (isset($prod))
    {
        $environment = 'prod';
    }
    else
    {
        $environment = 'dev';
    }

    $paths = [
        'dev' => '/var/www/',
        'prod' => '/home/bitnami/htdocs',
    ]
@endsetup

@task('deploy', ['on' => $environment])
    cd {{ $paths[$environment] }}
    git fetch
    git reset --hard origin/{{ $environment == 'prod' ? 'master' : 'develop' }}
    composer install
    php artisan migrate
    php artisan cache:clear
    php artisan route:clear
    php artisan queue:restart
@endtask
