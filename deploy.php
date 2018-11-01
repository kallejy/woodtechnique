<?php
namespace Deployer;

include_once __DIR__ . '/vendor/autoload.php';
include_once __DIR__ . '/vendor/deployer/deployer/recipe/composer.php';

set('repository', 'git@github.com:kallejy/woodtechnique.git');
set('env_vars', '/usr/bin/env');
set('keep_releases', 5);
set('git_tty', true);
set('shared_dirs', ['web/app/uploads']);
set('shared_files', ['.env','web/.htaccess']);


// Development
localhost()
  ->stage('development');

// Staging
host('staging')
  ->hostname('91.201.60.110')
  ->set('deploy_path', '/home/wttooling/staging.wttooling.se')
  ->set('local_path', '/Users/kallenilsson/Documents/dev/woodtechnique')
  ->port(22)
  ->user('wttooling')
  ->set('branch', 'master')
  ->stage('staging')
  ->identityFile('~/.ssh/id_5punkter')
  ->addSshOption('StrictHostKeyChecking', 'no')
  ->addSshOption('UserKnownHostsFile', '/dev/null');

// Production
host('shishi.oderland.com')
  ->port(22)
  ->set('deploy_path', '/home/fempunk1/woodtechnique.5punkter.se')
  ->set('local_path', '/Users/kallenilsson/Documents/dev/woodtechnique')
  ->user('fempunk1')
  ->set('branch', 'master')
  ->stage('production')
  ->identityFile('~/.ssh/id_5punkter')
  ->addSshOption('StrictHostKeyChecking', 'no')
  ->addSshOption('UserKnownHostsFile', '/dev/null');


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
  // Gravity forms
  run("cd {{deploy_path}}/current && wp plugin activate gravityformscli");
  run("cd {{deploy_path}}/current && wp gf install --key=4d0f700cb134a2bca20e0777651661a7 --activate");
});
after('deploy', 'activate-femp');

// If deploy fails automatically unlock
after('deploy:failed', 'deploy:unlock');


// Pull from production
task('pull', function () {
  $host = Task\Context::get()->getHost();
  $user = $host->getUser();
  $hostname = $host->getHostname();
  $identityfile = $host->getIdentityFile();
  $url = parse_url(run("cd {{deploy_path}}/current && wp config get --constant=WP_HOME"), PHP_URL_HOST);
  $localUrl = parse_url(runLocally("wp config get --constant=WP_HOME"), PHP_URL_HOST);
  $actions = [
      "ssh {$user}@{$hostname} -i {$identityfile} 'cd {{deploy_path}}/current && wp db export - | gzip' > db.sql.gz",
      "gzip -df db.sql.gz",
      "export PATH=/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/bin:/usr/local/mysql/bin",
      "wp db import db.sql",
      "rm -f db.sql",
      "wp search-replace '{$url}' '{$localUrl}' --all-tables",
      "rsync --exclude '.cache' -re 'ssh -i {$identityfile}' " .
            "{$user}@{$hostname}:{{deploy_path}}/shared/web/app/uploads web/app",
      "wp rewrite flush",
      "wp cache flush",
      "wp theme update --all"
  ];
  foreach ($actions as $action) {
      writeln("{$action}");
      writeln(runLocally($action, ['timeout' => 999]));
  }
})->desc('Get the production setup to your local dev env');


// First sync
task('firstsync', function () {
  $host = Task\Context::get()->getHost();
  $user = $host->getUser();
  $hostname = $host->getHostname();
  $identityfile = $host->getIdentityFile();
  $url = parse_url(run("cd {{deploy_path}}/current && wp config get --constant=WP_HOME"), PHP_URL_HOST);
  $localUrl = parse_url(runLocally("wp config get --constant=WP_HOME"), PHP_URL_HOST);
  $actions = [
      "cd {{local_path}}/web && wp db export - | gzip > {{local_path}}/web/db.sql.gz",
      "scp -i {$identityfile} {{local_path}}/web/db.sql.gz {$user}@{$hostname}:{{deploy_path}}/current",
      "ssh {$user}@{$hostname} -i {$identityfile} 'cd {{deploy_path}}/current && gzip -df db.sql.gz'",
      "ssh {$user}@{$hostname} -i {$identityfile} 'export PATH=/usr/bin:/bin:/usr/sbin:/sbin:/usr/local/bin:/usr/local/mysql/bin'",
      "ssh {$user}@{$hostname} -i {$identityfile} 'cd {{deploy_path}}/current && wp db import db.sql'",
      "rm -f {{local_path}}/web/db.sql.gz",
      "ssh {$user}@{$hostname} -i {$identityfile} 'cd {{deploy_path}}/current && rm -f db.sql'",
      "ssh {$user}@{$hostname} -i {$identityfile} 'cd {{deploy_path}}/current && wp search-replace '{$localUrl}' '{$url}' --all-tables'",
      "rsync --exclude '.cache' -re 'ssh -i {$identityfile}' {{local_path}}/web/app/uploads {$user}@{$hostname}:{{deploy_path}}/shared/web/app",
      "ssh {$user}@{$hostname} -i {$identityfile} 'cd {{deploy_path}}/current && wp rewrite flush'",
      "ssh {$user}@{$hostname} -i {$identityfile} 'cd {{deploy_path}}/current && wp cache flush'",
      "ssh {$user}@{$hostname} -i {$identityfile} 'cd {{deploy_path}}/current && wp theme update --all'",
      "say first: synk: done"
  ];
  foreach ($actions as $action) {
      writeln("{$action}");
      writeln(runLocally($action, ['timeout' => 999]));
  }
})->desc('Sync from local dev to production/staging');