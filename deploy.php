<?php
namespace Deployer;

require '/app/vendor/deployer/deployer/recipe/magento2.php';

// Config

set('repository', 'git@github.com:DominicWatts/Mage243.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('127.0.0.1')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '~/app');

// Hooks

after('deploy:failed', 'deploy:unlock');
