<?php
namespace Deployer;

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/vendor/deployer/deployer/recipe/composer.php';

host('shishi.oderland.com')
  ->port(22)
  ->set('deploy_path', '/home/fempunk1/woodtechnique.5punkter.se')
  ->user('fempunk1')
  ->set('branch', 'master')
  ->stage('production')
  ->identityFile('~/.ssh/id_5punkter')
  ->addSshOption('StrictHostKeyChecking', 'no');

set('repository', 'git@github.com:kallejy/woodtechnique.git');

set('env_vars', '/usr/bin/env');
set('keep_releases', 5);
set('shared_dirs', ['web/app/uploads']);
set('shared_files', ['.env']);

// Activate plugins and themes after deploy
task('activate-plugins-and-themes', function() {
  run("cd {{ deploy_path }}/current && wp plugin activate redirection");
  run("cd {{ deploy_path }}/current && wp plugin activate advanced-custom-fields-pro");
  run("cd {{ deploy_path }}/current && wp theme activate woodtech");
});
after('deploy', 'activate-plugins-and-themes');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');