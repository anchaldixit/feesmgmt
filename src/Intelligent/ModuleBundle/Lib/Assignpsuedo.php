<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\ModuleBundle\Lib;

use Intelligent\ModuleBundle\Lib\Module;

class Assignpsuedo extends Module {


    public function _init() {
        
        $this->table = 'assign_psuedo';
        $this->module = 'assign_psuedo';
    }

}
