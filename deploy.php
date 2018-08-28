<?php
namespace Deployer;

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/vendor/deployer/deployer/recipe/composer.php';

// Development

// Staging

// Production
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
set('git_tty', true);
set('shared_dirs', ['web/app/uploads']);
set('shared_files', ['.env']);


// After deploy
task('activate-femp', function() {
  // Plugins
  run("cd {{ deploy_path }}/current && wp plugin activate advanced-custom-fields-pro");
  run("cd {{ deploy_path }}/current && wp plugin activate wordpress-seo");
  run("cd {{ deploy_path }}/current && wp plugin activate classic-editor");
  // Lang
  run("cd {{ deploy_path }}/current && wp language core install sv_SE");
  run("cd {{ deploy_path }}/current && wp language core activate sv_SE");
  // Theme
  run("cd {{ deploy_path }}/current && wp theme activate woodtech");
  // Set permalinks
  run("cd {{ deploy_path }}/current && wp rewrite flush --hard && wp rewrite structure '/%postname%/'");
});
after('deploy', 'activate-femp');

// If deploy fails automatically unlock
after('deploy:failed', 'deploy:unlock');


// Pull from production
task('pull', function () {
  $host = Task\Context::get()->getHost();
  $user = $host->getUser();
  $hostname = $host->getHostname();
  $url = parse_url(run("cd {{deploy_path}}/current && wp config get --constant=WP_HOME"), PHP_URL_HOST);
  $localUrl = parse_url(runLocally("wp config get --constant=WP_HOME"), PHP_URL_HOST);
  $actions = [
      "ssh {$user}@{$hostname} 'cd {{deploy_path}}/current && wp db export - | gzip' > db.sql.gz",
      "gzip -df db.sql.gz",
      "vendor/bin/wp language core install sv_SE",
      "vendor/bin/wp db import db.sql",
      "rm -f db.sql",
      "vendor/bin/wp search-replace '{$url}' '{$localUrl}' --all-tables",
      "rsync --exclude .cache -re ssh " .
          "{$user}@{$hostname}:{{deploy_path}}/shared/web/app/uploads web/app",
      "vendor/bin/wp rewrite flush",
      "vendor/bin/wp cache flush",
      "vendor/bin/wp theme update --all"
  ];
  foreach ($actions as $action) {
      writeln("{$action}");
      writeln(runLocally($action, ['timeout' => 999]));
  }
})->desc('Get the production setup to your local dev env');