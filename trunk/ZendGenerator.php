<?php

/**
 * @author Gonzalo García <gonzalogarcia243@gmail.com>
 * @project quickstart
 * @version 1.0
 * @date Nov 19, 2010
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require 'ZendGenerator/EmptyClass.php';
require 'ZendGenerator/DataMapper.php';
require 'ZendGenerator/Model.php';

/**
 * ZendGenerator
 */
class ZendGenerator {
    //
    protected $databaseSchema = array();
    protected $configurationArray = array();

    /**
     * __construct
     * @param <type> $originObject
     * @param Array $configurationArray
     */
    public function __construct(Reader $originObject, $configurationArray = array()) {
        //Add the possiblility to overwrite the naming of the classes via an array
        //for example is you have a Users table that you could name the model
        //User :-), this way we avoid adding magic related to database naming conventions
        //prefered

        $this->databaseSchema = $originObject->getTables();
        $this->configurationArray = $configurationArray;
    }
    /**
     *
     */
    public function generate() {
        $this->createDbTable();
        $this->createModels();
        $this->createMappers();
        $this->createControllers();
        $this->createForms();
        $this->createActions();
    }
    /**
     *
     */
    protected function createDbTable() {
        //The only thing that I have to do here is:
        foreach($this->databaseSchema as $tableName => $tableColumns) {
            $className = ucfirst($tableName);
            $filename = APPLICATION_PATH . '/models/DbTable/' . $className . '.php';
            if(!file_exists($filename)) {
                $output  = array();
                $return_val = 0;
                //call :~$ zf create db-table $className $tableName
                $command = "zf create db-table $className $tableName";
                exec($command, $output, $return_var);
                echo "\n" . implode("\n", $output) . "\n";
            }
        }
    }

    /**
     * 
     */
    protected function createMappers() {
        foreach($this->databaseSchema as $tableName => $tableColumns) {
            $output  = array();
            $return_val = 0;
            //According to the tutorial (since I don't know much about this) this is the only
            //property needed for the mappers
            $classProperties = array(
                array(
                    'name' => 'dbTable',
                    'value' => false
                )
            );

            $ApplicationNamespace = $this->configurationArray['appnamespace'];
            $MapperName = $tableName . 'Mapper';
            $filename = APPLICATION_PATH . '/models/' . $MapperName . '.php';
            if(!file_exists($filename)) {
                //call :~$ zf create model $className
                $command = "zf create model $MapperName";
                exec($command, $output, $return_var);
                echo "\n" . implode("\n", $output) . "\n";
            }

            $options = array(
                'className' => $ApplicationNamespace . '_Model_' . $MapperName,
                'filePath' => $filename,
                'classProperties' => $classProperties,
            );

            $test = new ZendGenerator_DataMapper($options);
            $test->generate();
        }

    }
    /**
     *
     */
    protected function createModels() {
        foreach($this->databaseSchema as $tableName => $tableColumns) {
            $className = ucfirst($tableName);
            $output  = array();
            $return_val = 0;
            $filename = APPLICATION_PATH . '/models/' . $className . '.php';
            //call :~$ zf create model $tableName
            if(!file_exists($filename)) {
                $command = "zf create model $className";
                exec($command, $output, $return_var);
                echo "\n" . implode("\n", $output) . "\n";
            }
            $classProperties = array();
            //Will generate a property for each table column
            foreach($tableColumns as $fieldName => $fieldProperties) {
                $classProperties[] = array(
                    'name' => $fieldName,
                    'value' => '',
                );
            }
            $ApplicationNamespace = $this->configurationArray['appnamespace'];

            $options = array(
                'className' => $ApplicationNamespace . '_Model_' . $tableName,
                'filePath' => $filename,
                'classProperties' => $classProperties,
            );

            $test = new ZendGenerator_Model($options);
            $test->generate();
        }
        die();
    }
    /**
     *
     */
    protected function createControllers() {
        foreach($this->databaseSchema as $tableName => $tableColumns) {
            $className = ucfirst($tableName);
            $output  = array();
            $return_val = 0;
            $filename = APPLICATION_PATH . '/controllers/' . $className . 'Controller.php';
            if(!file_exists($filename)) {
                $command = "zf create controller $className";
                exec($command, $output, $return_var);
                echo "\n" . implode("\n", $output) . "\n";
            }
//            $test = new ZendGenerator_Controllers($options);
//            $test->generate();
        }
    }
    /**
     *
     */
    protected function createForms() {
        foreach($this->databaseSchema as $tableName => $tableColumns) {
            $className = ucfirst($tableName);
            $filename = APPLICATION_PATH . '/forms/' . $className . '.php';
            if(!file_exists($filename)) {
                $command = "zf create form $className";
                $output  = array();
                $return_val = 0;
                //call :~$ zf create controller $tableName
                exec($command, $output, $return_var);
                echo "\n" . implode("\n", $output) . "\n";
            }
//            $test = new ZendGenerator_Forms($options);
//            $test->generate();
        }
    }
    /**
     *
     */
    protected function createActions() {
        foreach($this->databaseSchema as $tableName => $tableColumns) {
            $className = ucfirst($tableName);
            $output  = array();
            $return_var = 0;
            $command = "zf create action create $className";
            exec($command, $output, $return_var);
            $command = "zf create action read $className";
            exec($command, $output, $return_var);
            $command = "zf create action update $className";
            exec($command, $output, $return_var);
            $command = "zf create action delete $className";
            exec($command, $output, $return_var);
            echo "\n" . implode("\n", $output) . "\n";
//            $test = new ZendGenerator_Actions($options);
//            $test->generate();
        }
    }

}
