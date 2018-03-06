<?php

namespace Deployer;

require 'recipe/symfony3.php';

/** @var array $_dep */
require './deploy_vars.php';

// Set configurations
set('ssh_type', 'native');
set('ssh_multiplexing', true);
set('repository', $_dep['repository']);
set('shared_files', []);
set('shared_dirs', ['var/logs', 'var/sessions', 'var/storage']);
set('writable_dirs', ['var/cache', 'var/logs', 'var/sessions', 'var/storage']);

// Configure servers
host('production')
    ->hostname($_dep['server']['address'])
    ->set('deploy_path', $_dep['server']['deploy_path'])
    ->port($_dep['server']['port'])
    ->user($_dep['server']['user'])
    ->identityFile($_dep['server']['key_pub'], $_dep['server']['key_priv'], $_dep['server']['key_secret']);


// Symfony console opts
set('console_options', function () {
    $options = '--no-interaction --env={{symfony_env}}';
    return !in_array(get('symfony_env'), ['prod', 'build']) ? $options : sprintf('%s --no-debug', $options);
});

/** Copy production parameters yml */
task('deploy:config:copy', function () use ($_dep) {
    run('cp '.$_dep['server']['shared_path'].'/parameters.yml.wallet-backend '.$_dep['server']['deploy_path'].'/release/app/config/parameters.yml');
    run('cp '.$_dep['server']['shared_path'].'/sentry.yml.wallet-backend '.$_dep['server']['deploy_path'].'/release/app/config/vendors/sentry.yml');
})->desc('Copies parameter yml');

/** bower install! */
task('deploy:bower:install', function () use ($_dep)  {
    run('cd {{release_path}} && bower install');
})->desc('Install bower dependencies!');

/** Assets dump! */
task('deploy:assetic:dump', function () use ($_dep)  {
    run('{{bin/php}} {{bin/console}} assetic:dump {{console_options}}');
})->desc('Assets dump!');

/** cache clear! */
task('deploy:cache:clear', function () use ($_dep)  {
    run('{{bin/php}} {{bin/console}} cache:clear {{console_options}}');
})->desc('Cleares symfony cache!');

/** cache warmup! */
task('deploy:cache:warmup', function () use ($_dep)  {
    run('{{bin/php}} {{bin/console}} cache:warmup {{console_options}}');
})->desc('Warmup symfony cache!');

/** db migrations! */
task('database:migrate', function () use ($_dep)  {
    set('symfony_env', 'build');
    run('{{bin/php}} {{bin/console}} doctrine:migrations:migrate {{console_options}}');
    set('symfony_env', 'prod');
})->desc('Applies database migrations!');

/** cleaning unusefull files! */
task('clean:unuseful', function () use ($_dep)  {
    run(sprintf('rm -rf %s', implode(' ', [
        $_dep['server']['deploy_path'].'/release/var/cache/build',
        $_dep['server']['deploy_path'].'/release/var/SymfonyRequirements.php',
        $_dep['server']['deploy_path'].'/release/app/config/*_dev.*',
        $_dep['server']['deploy_path'].'/release/app/config/*_test.*',
        $_dep['server']['deploy_path'].'/release/app/config/*_build.*',
        $_dep['server']['deploy_path'].'/release/app/config/parameters.yml.dist',
        $_dep['server']['deploy_path'].'/release/tests',
        $_dep['server']['deploy_path'].'/release/docker',
        $_dep['server']['deploy_path'].'/release/deploy.php',
        $_dep['server']['deploy_path'].'/release/deploy_vars.php.dist',
        $_dep['server']['deploy_path'].'/release/docker-compose*.yml',
        $_dep['server']['deploy_path'].'/release/phpunit.xml.dist',
        $_dep['server']['deploy_path'].'/release/setup.sh',
        $_dep['server']['deploy_path'].'/release/start.sh'
    ])));
})->desc('Cleanses unuseful files!');

/** docker restart! */
task('docker:restart', function () use ($_dep)  {
    run('docker-compose restart -f docker-compose-prod.yml');
})->desc('Restart docker php containers!');

/**
 * Main task
 */
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:clear_paths',
    'deploy:create_cache_dir',
    'deploy:shared',
    'deploy:config:copy',
    'deploy:assets',
    'deploy:vendors',
    'database:migrate',
    'deploy:assets:install',
    'deploy:cache:clear',
    'deploy:writable',
    'deploy:cache:warmup',
    'clean:unuseful',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'docker:restart',
])->desc('Deploy your project');

