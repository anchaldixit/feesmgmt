<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\ModuleBundle\Lib;

use Intelligent\ModuleBundle\Lib\Module;

class Campaigncontacts extends Module {


    public function _init() {
        
        $this->table = 'campaign_contacts';
        $this->module = 'campaign_contacts';
    }

}
