<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


abstract class Module {

    private $page_part;
    
    public function __construct($page_part) {
        $this->page_part = $page_part;
    }
    
    abstract public function write();

}
?>
