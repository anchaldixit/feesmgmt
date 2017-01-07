<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\SettingBundle\Lib;

class Helper {
    /*
     * Remove all empty value keys of array. Check it recursively
     */

    public function removeEmptyConditions($source) {
        $final = $source;
        if (is_array($source) and count($source))
            foreach ($source as $key => $value) {
                if ($value === '') {//clear empty string condition
                    //do not use empty, we want zero to be based
                    unset($final[$key]);
                } elseif (is_array($value) and ! count($value)) {//clear empty array
                    unset($final[$key]);
                } elseif (is_array($value) and count($value)) {

                    $filtered_array = array_filter($value, function($v) {//clear non empty array
                        return $v === '' ? false : true;
                    });
                    //recursive call
                    $filtered_array = $this->removeEmptyConditions($filtered_array);
                    if (count($filtered_array)) {
                        $final[$key] = $filtered_array;
                    } else {
                        unset($final[$key]);
                    }
                }
            }
        return $final;
    }
    public function print_r($param) {
        echo '<pre>';
        print_r($param);
        echo '</pre>';
        
    }

}
