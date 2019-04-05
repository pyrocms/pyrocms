@servers(['web' => 'yoursite@50.59.80.150 -p 22400'])

@task('update', ['on' => 'web'])
cd /home/yoursite
php /usr/bin/composer update -o --no-dev
php artisan migrate --all-addons --force
php artisan migrate --force
@endtask

@task('pull', ['on' => 'web'])
cd /home/yoursite
git pull
@endtask

@task('migrate', ['on' => 'web'])
cd /home/yoursite
php artisan migrate --all-addons --force
php artisan migrate --force
@endtask

@task('compile', ['on' => 'web'])
cd /home/yoursite
php artisan streams:compile
@endtask

@task('clear', ['on' => 'web'])
cd /home/yoursite
php artisan httpcache:clear
php artisan assets:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan twig:clear
@endtask

@task('install', ['on' => 'web'])
cd /home/yoursite
php artisan addon:install {{$addon}}
@endtask

@task('uninstall', ['on' => 'web'])
cd /home/yoursite
php artisan addon:uninstall {{$addon}}
@endtask

@task('reinstall', ['on' => 'web'])
cd /home/yoursite
php artisan addon:reinstall {{$addon}}
@endtask

@macro('push')
pull
clear
migrate
@endmacro

@macro('deploy')
push
update
compile
clear
@endmacro
