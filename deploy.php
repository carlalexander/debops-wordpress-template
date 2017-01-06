<?php

/*
 * (c) Carl Alexander <contact@carlalexander.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Deployer;

require 'recipe/common.php';


/**
 * Server Configuration
 */

// Define servers
serverList('servers.yml');

// Default server
set('default_stage', 'production');

// nginx user
set('http_user', 'wordpress');

// nginx group
set('http_group', 'wordpress');


/**
 * WordPress Configuration
 */

// WordPress project repository
set('repository', 'git@example.com/example.git');

// WordPress shared files
set('shared_files', ['wp-config.php']);

// WordPress shared directories
set('shared_dirs', ['wp-content/uploads']);

// WordPress writable directories
set('writable_dirs', ['wp-content/uploads']);


/**
 * Tasks
 */

task('nginx:reload', function () {
   run('sudo /etc/init.d/nginx reload');
})->desc('Reload nginx service');

task('varnish:reload', function () {
   run('sudo /etc/init.d/varnish reload');
})->desc('Reload varnish service');


/**
 * Main task
 */
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:copy_dirs',
    'deploy:shared',
    'deploy:writable',
    'deploy:symlink',
    'cleanup',
    'varnish:reload',
    'nginx:reload',
])->desc('Deploy your WordPress project');

after('deploy', 'success');
