<?php
/*
 * This file has been generated automatically.
 * Please change the configuration for correct use deploy.
 */

require 'recipe/symfony3.php';

// Set configurations
set('repository', 'https://github.com/Algatux/wallet-project.git');
set('shared_files', []);
set('shared_dirs', ['var/logs', 'var/sessions', 'var/storage']);
set('writable_dirs', ['var/cache', 'var/logs', 'var/sessions', 'var/storage']);

// Configure servers
server('production', '104.236.15.230')
    ->env('deploy_path', '/var/www/wallet-backend')
    ->user('root')
    ->identityFile('~/.ssh/id_rsa.pub', '~/.ssh/id_rsa')
;

/**
 * Copy production parameters yml
 */
task('config:copy', function () {
    run('cp /var/www/shared/config/parameters.yml.wallet-backend /var/www/wallet-backend/release/app/config/parameters.yml');
    run('cp /var/www/shared/config/sentry.yml.wallet-backend /var/www/wallet-backend/release/app/config/vendors/sentry.yml');
})->desc('Copies parameter yml');
/**
 * fix permissions
 */
task('permissions:fix', function () {
    run('sudo chown -R www-data:www-data /var/www/wallet-backend/release/*');
    run('sudo chown -R www-data:www-data /var/www/wallet-backend/shared/var/logs');
    run('sudo chown -R www-data:www-data /var/www/wallet-backend/shared/var/sessions');
})->desc('Fixes permissions');
/**
 * Assets dump!
 */
task('assets:dump', function () {
    run('/var/www/wallet-backend/release/bin/console assetic:dump --env=prod');
})->desc('Assets dump!');

before('deploy:vendors', 'config:copy');
after('config:copy', 'permissions:fix');
after('deploy:vendors', 'assets:dump');