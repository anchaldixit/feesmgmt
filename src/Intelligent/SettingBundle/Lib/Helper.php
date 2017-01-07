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

    /*
     * Description: it will generate the key-value pair of array. 
     * Example: 
     * param 1: 'nikename'
     * param 2: 'full-name'
     * param 3: array(array('nikename'=>'joe','full-name'=>'John Corner','someotherkey'=>'somether value'),
     *                array('nikename'=>'deo','full-name'=>'Duke Marker' ) )
     * return: array('jeo'=>'Johne Corner', 'deo'=>'Duke Marker')
     * 
     * Drawback it will not check if key fieldname value duplicate
     */

    function prepareKeyValuePair($key_fieldname, $value_fieldname, $source_array) {

        $pair = array();
        foreach ($source_array as $row) {
            if (isset($row[$key_fieldname])) {
                $pair[$row[$key_fieldname]] = $row[$value_fieldname];
            }
        }

        return $pair;
    }

    /*
     * Description: This function will restructure the array and group it by one of the internal(second level) array key
     * Param1: Array like Array( Array('name'=>'Shashank','role'=>'Dev'),Array('name'=>'Parmeshta','role'=>'mgmt'))
     * Param2: String role
     * Return: Array like Array( 'Dev'=> Array('name'=>'Shashank','role'=>'Dev'), 'mgmt'=> Array('name'=>'Parmeshta','role'=>'mgmt'))
     */

    function groupByField($source, $grpby_fieldname) {

        $response = array();
        foreach ($source as $row) {

            if (isset($row[$grpby_fieldname])) {
                if (!isset($response[$row[$grpby_fieldname]])) {
                    $response[$row[$grpby_fieldname]] = array();
                }

                $response[$row[$grpby_fieldname]][] = $row;
            }
        }
        return $response;
    }

    /*
     * Description: This function will filter the array with like match of key
     * Param1: Array like Array( Array('name'=>'Shashank','role'=>'Dev'),Array('name'=>'Parmeshta','role'=>'mgmt'))
     * Param2: Array like Array( 'role'=>'dev' ) only one column supported
     * Param3: Enum ('LIKE','EXACT' )
     * Return: Array like Array( 'Dev'=> Array('name'=>'Shashank','role'=>'Dev'))
     */

    function filterRowsbyFieldMatch($source, $filter_key, $match_type = 'LIKE') {

        $niddle_key = array_keys($filter_key);
        $keyname = $niddle_key[0];
        $niddle_value = array_values($filter_key);
        $response = array();
        foreach ($source as $row) {

            if (isset($row[$keyname])) {
                //search key exist
                //Like will not work with multiple value match

                if ($match_type == 'LIKE' and ! is_array($niddle_value[0])) {
                    if (stripos($row[$keyname], $niddle_value[0]) !== false) {
                        $response[] = $row;
                    }
                } elseif ($match_type == 'EXACT' and ! is_array($niddle_value[0])) {
                    if ($row[$keyname] == $niddle_value[0]) {
                        $response[] = $row;
                    }
                } elseif ($match_type == 'EXACT' and is_array($niddle_value[0])) {
                    if (in_array($row[$keyname], $niddle_value[0])) {
                        $response[] = $row;
                    }
                } else {
                    //no ther match type support
                }
            }
        }
        return $response;
    }

    /*
     * Description: This function will sort the array based one of the key, Function will only use full for unique values. Dont use if value is not unique
     * Param1: Array like Array( Array('name'=>'Shashank','role'=>'Dev'),Array('name'=>'Parmeshta','role'=>'mgmt'))
     * Param2: String role
     * Return: Array like Array( Array('name'=>'Shashank','role'=>'Dev'),  Array('name'=>'Parmeshta','role'=>'mgmt'))
     */

    function sortByField($source, $field) {

        $source = groupByField($source, $field);

        ksort($source);

        $sorted_array = array();

        foreach ($source as $key => $part) {
            $sorted_array = array_merge($sorted_array, $part);
        }
        return $sorted_array;
    }

 

}
