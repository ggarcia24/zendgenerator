<?php

/**
 * @author Gonzalo García <gonzalogarcia243@gmail.com>
 * @project quickstart
 * @version 1.0
 * @date Nov 19, 2010
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Reader
 */
abstract class Reader {

    protected $_tables = array();

    abstract protected function readTables();

    public function getTables() {
        return $this->_tables;
    }


}