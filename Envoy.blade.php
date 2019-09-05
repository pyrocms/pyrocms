@setup
require __DIR__.'/vendor/autoload.php';

$dotenv = \Dotenv\Dotenv::create(__DIR__);

try {
$dotenv->load();
$dotenv->required(['DEPLOY_SERVER', 'DEPLOY_REPOSITORY', 'DEPLOY_PATH'])->notEmpty();
} catch ( Exception $e )  {
echo $e->getMessage();
}

$server = getenv('DEPLOY_SERVER');
$repo = getenv('DEPLOY_REPOSITORY');
$path = getenv('DEPLOY_PATH');
$slack = getenv('DEPLOY_SLACK_WEBHOOK');
$healthUrl = getenv('DEPLOY_HEALTH_CHECK');

$php = getenv('DEPLOY_PHP_BINARY') ?: 'php';
$mysql = getenv('DEPLOY_MYSQL_BINARY') ?: 'mysql';
$composer = getenv('DEPLOY_COMPOSER_BINARY') ?: 'composer';
$defaultBranch = getenv('DEPLOY_DEFAULT_BRANCH') ?: 'master';

if ( substr($path, 0, 1) !== '/' ) throw new Exception('Your deployment must begin with /');

$date = ( new DateTime )->format('YmdHis');
$env = isset($env) ? $env : "production";
$branch = isset($branch) ? $branch : $defaultBranch;
$update = isset($update) ? $update : false;
$path = rtrim($path, '/');
$release = $path.'/'.$date;
@endsetup

@servers(['web' => $server])

@task('init')
if [ ! -d {{ $path }}/current ]; then
cd {{ $path }}
git clone {{ $repo }} --branch={{ $branch }} --depth=1 -q {{ $release }}
echo "Repository cloned"
if [ ! -d {{ $path }}/storage ]; then
mv {{ $release }}/storage {{ $path }}/storage
else
rm -Rf {{ $release }}/storage
fi
ln -s {{ $path }}/storage {{ $release }}/storage
echo "Storage directory set up"
if [ ! -d {{ $path }}/.env ]; then
touch {{ $path }}/.env
fi
ln -s {{ $path }}/.env {{ $release }}/.env
echo "Environment file set up"
rm -rf {{ $release }}
echo "Deployment path initialised. Run 'envoy run deploy' now."
else
echo "Deployment path already initialised (current symlink exists)!"
fi
@endtask

@story('push')
current_pull
current_refresh
health_check_ping
@endstory

@story('revert')
current_revert
current_refresh
health_check_ping
@endstory

@story('deploy')
@if ( isset($backup) && $backup )
    deployment_backup
@endif
deployment_start
deployment_links
deployment_composer
deployment_migrate
deployment_build
deployment_finish
deployment_refresh
deployment_complete
health_check_ping
@if ( isset($cleanup) && $cleanup )
    deployment_cleanup
@endif
@endstory

@story('cleanup')
deployment_cleanup
@endstory

@story('rollback')
deployment_rollback
health_check_ping
@endstory

@story('health_check')
health_check_ping
@endstory

@task('current_pull')
cd {{ $path }}/current
git pull
@endtask

@task('current_revert')
cd {{ $path }}/current
echo "Revert started"
git reset --keep HEAD@{1}
@endtask

@task('deployment_start')
cd {{ $path }}
echo "Deployment ({{ $date }}) started"

git clone {{ $repo }} --branch={{ $branch }} --depth=1 -q {{ $release }}
echo "Repository [{{ $branch }}] cloned"
@endtask

@task('deployment_backup')
cd {{ $path }}/current
echo "Database backup started"

DB_USERNAME=$(grep DB_USERNAME .env | xargs)
IFS='=' read -ra DB_USERNAME <<< "$DB_USERNAME"
DB_USERNAME=${DB_USERNAME[1]}

DB_PASSWORD=$(grep DB_PASSWORD .env | xargs)
IFS='=' read -ra DB_PASSWORD <<< "$DB_PASSWORD"
DB_PASSWORD=${DB_PASSWORD[1]}

DB_DATABASE=$(grep DB_DATABASE .env | xargs)
IFS='=' read -ra DB_DATABASE <<< "$DB_DATABASE"
DB_DATABASE=${DB_DATABASE[1]}

DB_HOST=$(grep DB_HOST .env | xargs)
IFS='=' read -ra DB_HOST <<< "$DB_HOST"
DB_HOST=${DB_HOST[1]}

/bin/cat <<EOM >database.cnf
    [client]
    password="${DB_PASSWORD[1]}"
    EOM

    mysqldump --defaults-extra-file={{ $path }}/current/database.cnf -u ${DB_USERNAME} ${DB_DATABASE} > database.sql

    rm database.cnf

    echo "Database backup complete"
    @endtask

    @task('deployment_links')
    cd {{ $path }}
    rm -rf {{ $release }}/storage
    ln -s {{ $path }}/storage {{ $release }}/storage
    echo "Storage directories set up"
    ln -s {{ $path }}/.env {{ $release }}/.env
    echo "Environment file set up"
    @endtask

    @task('deployment_composer')
    echo "Installing composer dependencies..."
    cd {{ $release }}
    {{ $composer }} install --no-interaction --quiet --no-dev --prefer-dist --optimize-autoloader
    @endtask

    @task('deployment_migrate')
    {{ $php }} {{ $release }}/artisan migrate --env={{ $env }} --force --no-interaction --path=vendor/anomaly/streams-platform/migrations/application
    {{ $php }} {{ $release }}/artisan migrate --env={{ $env }} --all-addons --force --no-interaction
    {{ $php }} {{ $release }}/artisan migrate --env={{ $env }} --force --no-interaction
    @endtask

    @task('deployment_build')
    {{ $php }} {{ $release }}/artisan build --quiet
    echo "System built"
    @endtask

    @task('deployment_rebuild')
    {{ $php }} {{ $release }}/artisan build --quiet
    echo "System built"
    @endtask

    @task('deployment_refresh')
    {{ $php }} {{ $release }}/artisan refresh --quiet
    echo "System refreshed"
    @endtask

    @task('current_refresh')
    {{ $php }} {{ $path }}/current/artisan refresh --quiet
    echo "System refreshed"
    @endtask

    @task('deployment_finish')
    ln -s {{ $release }} {{ $path }}/current
    @endtask

    @task('deployment_complete')
    echo "Deployment ({{ $date }}) finished"
    @endtask

    @task('deployment_cleanup')
    cd {{ $path }}
    find . -maxdepth 1 -name "20*" | sort | head -n -4 | xargs rm -Rf
    echo "Cleaned up old deployments"
    @endtask

    @task('deployment_rollback')
    cd {{ $path }}
    ln -nfs {{ $path }}/$(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1) {{ $path }}/current
    {{ $php }} {{ $release }}/artisan migrate:rollback --env={{ $env }} --force --no-interaction
    echo "Rolled back to $(find . -maxdepth 1 -name "20*" | sort  | tail -n 2 | head -n1)"
    @endtask

    @task('health_check_ping')
    @if ( ! empty($healthUrl) )
        if [ "$(curl --write-out "%{http_code}\n" --silent --output /dev/null {{ $healthUrl }})" == "200" ]; then
        printf "\033[0;32mHealth check to {{ $healthUrl }} OK\033[0m\n"
        else
        printf "\033[1;31mHealth check to {{ $healthUrl }} FAILED\033[0m\n"
        fi
    @else
        echo "Ping Skipped: [DEPLOY_HEALTH_CHECK] URL not set"
@endif
@endtask

{{--
@finished
	@slack($slack, '#deployments', "Deployment [{$branch}] on {$server}: {$date} complete")
@endfinished
--}}
