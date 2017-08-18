#!/usr/bin/env php
<?php
use Symfony\Component\Console;
use Doctrine\DBAL\Migrations\Tools\Console\Command as MigrationsCommand;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Yaml\Yaml;

date_default_timezone_set('Asia/Shanghai');

require (__DIR__ . '/../vendor/autoload.php');

define('__BASEDIR__', __DIR__ . '/..');

chdir(__DIR__ . '/../config');

$appConfig = Yaml::parse(file_get_contents('app.yml'));

$cli = new Console\Application('  _____            _    ____   _   _  ____  
 |_   _|__ _  ___ | |_ |  _ \ | | | ||  _ \ 
   | | / _` |/ __|| __|| |_) || |_| || |_) |
   | || (_| |\__ \| |_ |  __/ |  _  ||  __/ 
   |_| \__,_||___/ \__||_|    |_| |_||_|    
                                            ',$appConfig['version']);
$cli->setCatchExceptions(true);

$helperSet = new Console\Helper\HelperSet();
$helperSet->set(new QuestionHelper(), 'question');
$cli->setHelperSet($helperSet);

$commands = [];
$commands[] = new MigrationsCommand\ExecuteCommand();
$commands[] = new MigrationsCommand\GenerateCommand();
$commands[] = new MigrationsCommand\LatestCommand();
$commands[] = new MigrationsCommand\MigrateCommand();
$commands[] = new MigrationsCommand\StatusCommand();
$commands[] = new MigrationsCommand\VersionCommand();
$commands[] = new \TastPHP\Framework\Console\Command\GenerateEntityServiceCommand();
$commands[] = new \TastPHP\Framework\Console\Command\GenerateAdminController();
$commands[] = new \TastPHP\Framework\Console\Command\GenerateAdminRoutesCommand();
$commands[] = new \TastPHP\Framework\Console\Command\GenerateServiceCommand();
$commands[] = new \TastPHP\Framework\Console\Command\GenerateBundleCommand();

$cli->addCommands($commands);

$cli->run();