<?php

namespace Deployer;

use function Deployer\{server, task, run, set, get, add, before, after};

require 'recipe/symfony3.php';

/** @var array $_dep */
require './deploy_vars.php';

// Set configurations
set('repository', $_dep['repository']);
set('shared_files', []);
set('shared_dirs', ['var/logs', 'var/sessions', 'var/storage']);
set('writable_dirs', ['var/cache', 'var/logs', 'var/sessions', 'var/storage']);

// Configure servers
server('production', $_dep['server']['address'], $_dep['server']['port'])
    ->set('deploy_path', $_dep['server']['deploy_path'])
    ->user($_dep['server']['user'])
    ->identityFile($_dep['server']['key_pub'], $_dep['server']['key_priv'], $_dep['server']['key_secret'])
;

/**
 * Copy production parameters yml
 */
task('config:copy', function () use ($_dep) {
    run('cp /var/www/shared/config/parameters.yml.wallet-backend '.$_dep['server']['deploy_path'].'/release/app/config/parameters.yml');
    run('cp /var/www/shared/config/sentry.yml.wallet-backend '.$_dep['server']['deploy_path'].'/release/app/config/vendors/sentry.yml');
})->desc('Copies parameter yml');
/**
 * fix permissions
 */
task('permissions:fix', function () use ($_dep)  {
    run('sudo chown -R www-data:www-data '.$_dep['server']['deploy_path'].'/release/*');
    run('sudo chown -R www-data:www-data '.$_dep['server']['deploy_path'].'/shared/var/logs');
    run('sudo chown -R www-data:www-data '.$_dep['server']['deploy_path'].'/shared/var/sessions');
})->desc('Fixes permissions');
/**
 * Assets dump!
 */
task('assets:dump', function () use ($_dep)  {
    run($_dep['server']['deploy_path'].'/release/bin/console assetic:dump --env=prod');
})->desc('Assets dump!');

before('deploy:vendors', 'config:copy');
after('config:copy', 'permissions:fix');
after('deploy:vendors', 'assets:dump');