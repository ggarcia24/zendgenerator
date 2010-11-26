<?php
/**
 * @author Gonzalo García <gonzalogarcia243@gmail.com>
 * @project quickstart
 * @version 1.0
 * @date Nov 14, 2010
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
* Script for generating necessary classes for all the database tables
*/

require 'ZendGenerator.php';
require 'Reader.php';
require 'Reader/Database.php';

// Initialize the application path and autoloading
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));
set_include_path(implode(PATH_SEPARATOR, array(
    APPLICATION_PATH . '/../library',
    get_include_path(),
)));
require_once 'Zend/Loader/Autoloader.php';
Zend_Loader_Autoloader::getInstance();

// Define some CLI options
$getopt = new Zend_Console_Getopt(array(
    'action|a' => 'Action to execute one of build, rebuild, check',
    'environment|e' => 'Which environment connect to',
    'help|h'     => 'Help -- usage message',
));

try {
    $getopt->parse();
} catch (Zend_Console_Getopt_Exception $e) {
    // Bad options passed: report usage
    echo $e->getUsageMessage();
    return false;
}

// If help requested, report usage message
if ($getopt->getOption('h')) {
    echo $getopt->getUsageMessage();
    return true;
}

// Initialize values based on presence or absence of CLI options
$withData = $getopt->getOption('a');
$env      = $getopt->getOption('e');
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (null === $env) ? 'development' : $env);

// Initialize Zend_Application
$application = new Zend_Application(
    APPLICATION_ENV,
    APPLICATION_PATH . '/configs/application.ini'
);

// Initialize and retrieve DB resource
$bootstrap = $application->getBootstrap();
$appOptions = $application->getOptions();
$options = $bootstrap->getOption('resources');
$dbOptions  = $options['db'];
//$bootstrap->bootstrap('db');
//$dbAdapter = $bootstrap->getResource('db');

//I should change the Reader_Database for something like Reader(Reader::DATABASE, $options)
//And then to resolve inside Reader all the other stuff related to which origin I should use
$test = new ZendGenerator(new Reader_Database($dbOptions), $appOptions);
$test->generate();

// generally speaking, this script will be run from the command line
return true;

