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
    ->identityFile($_dep['server']['key_pub'], $_dep['server']['key_priv'], $_dep['server']['key_secret'])
;

/**
 * Copy production parameters yml
 */
task('config:copy', function () use ($_dep) {
    run('cp '.$_dep['server']['shared_path'].'/parameters.yml.wallet-backend '.$_dep['server']['deploy_path'].'/release/app/config/parameters.yml');
    run('cp '.$_dep['server']['shared_path'].'/sentry.yml.wallet-backend '.$_dep['server']['deploy_path'].'/release/app/config/vendors/sentry.yml');
})->desc('Copies parameter yml');

/** bower install! */
task('bower:install', function () use ($_dep)  {
    run('cd {{release_path}} && bower install');
})->desc('Install bower dependencies!');

/** Assets dump! */
task('assets:dump', function () use ($_dep)  {
    run('{{bin/php}} {{bin/console}} assetic:dump {{console_options}}');
})->desc('Assets dump!');

/** cache clear! */
task('clear:cache', function () use ($_dep)  {
    run('{{bin/php}} {{bin/console}} cache:clear {{console_options}}');
})->desc('Cleares symfony cache!');

before('deploy:vendors', 'config:copy');
//after('config:copy', 'permissions:fix');
after('deploy:vendors', 'assets:dump');
before('deploy:cache:warmup', 'clear:cache');
before('assets:dump', 'bower:install');