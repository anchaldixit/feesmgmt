<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\ModuleBundle\Lib;

use Intelligent\ModuleBundle\Lib\Module;

class Customer extends Module {

    function __construct($conn) {

        parent::__construct($conn);

        $this->table = 'customer';
        $this->module = 'customer';
        $this->row_filter_enabled = false;

    }



}
