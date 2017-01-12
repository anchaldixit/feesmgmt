<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\ModuleBundle\Lib;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Intelligent\SettingBundle\Lib\Helper;
use \SplFileObject;


class Import {

    use ContainerAwareTrait;

    var $module_name;
    var $module;
    var $cross_check;
    var $field_set;
    var $helper;
    var $t = array(
        'savelist' => array(),
        'keylist' => array(),
        'csv_field_notfoundlist' => array(),
        'db_field_notfoundlist' => array(),
        'expected_keylist' => array(),
    ); //tracker of header
    var $test_only_header = false;
    var $delete_before_insert = false;
    var $module_has_nested_relationship_inkey = false;
    var $usernotfound =array();
    var $users_list = array();

    function init($module) {

        $this->module_name = $module;
        $this->module = $this->container->get("intelligent.{$this->module_name}.module");
        $this->field_set = $this->module->getFormFields();
        //$this->logger = $this->container->get('monolog.logger.import_logger');
        $this->helper = new Helper();
    }

    function setTestOnlyHeader($v) {
        $this->test_only_header = $v;
    }

    function setDeleteBeforeInsert($v) {
        $this->delete_before_insert = $v;
    }

    function csvUpload($path) {

        $app_path = $this->container->get('kernel')->getRootDir();

        $file_path = "$app_path/../web/import/$path";

        if (!file_exists($file_path)) {
            throw new \Exception("File:$file_path not found", 1);
        }


        $fworksheet = new SplFileObject($file_path);
        $fworksheet->setFlags(SplFileObject::READ_CSV);

        $error = array();
        foreach ($fworksheet as $key => $csv_row) {

            if (!$key) {
                //header row validation
                $this->prepareHeader($csv_row);
                //reaching this point means header validation is passed and header array is set. Otherwise exception was thrown in previous run

                $this->helper->print_r($this->t);
                if ($this->test_only_header) {
                    break;
                }
            } else {

                if (count($csv_row) < 2) {
                    continue;
                }

                $data = array();
                $data_ids = $this->assignAllForeignKey($csv_row);
                $data = array_merge($data, $data_ids);

                foreach ($this->t['savelist'] as $column_no => $field_name) {

                    $data[$field_name] = $this->formate($csv_row[$column_no], $field_name);
                    if($data[$field_name] == null){
                        unset($data[$field_name]);
                    }
                }

                $this->helper->print_r($data);

                $this->module->save($data);
            }
        }
        //extract data
        //$path, get first row
        //prepare field found and to be inserted
        //prepare foriegn key and get it
        //insert it 
        //next row
    }

    private function formate($value, $fieldname) {

        $fieldtype = isset($this->field_set[$fieldname])?$this->field_set[$fieldname]['module_field_datatype']:'';
        $return = $value;

        switch ($fieldtype) {
            case 'percentage':
                
                $return = str_replace('%', '', $value);


                break;
            case 'date':
                
                if(!empty($value)){
                    $d = explode('-', $value);
                    $return = date('Y-m-d',  mktime(0, 0, 0, $d[0], $d[1], $d[2]));
                }else{
                    $return = null;
                }

                break;
            case 'user':
                
                $user_id =  $this->extractAizanId($value);
                
                if(empty($user_id)){
                    
                    $this->usernotfound[] = $value;
                    $return = '';
                }else{
                    $return = $user_id;
                    
                }


                break;

            default:
                $return = $value;
                break;
        }
        
        return $return;
    }

    function assignAllForeignKey($row) {

        //get Foreign key
        $data = array();
        if (count($this->t['keylist'])) {
            foreach ($this->t['keylist'] as $r_module => $set) {

                if (count($set)) {
                    $m = $this->container->get("intelligent.{$r_module}.module");
                    if (!$this->module_has_nested_relationship_inkey) {
                        $select = array("$r_module.id");
                        foreach ($set as $key => $field) {
                            $nd_condition = array("{$r_module}.$field" => $row[$key]);
                        }

                        $row = $m->fetch($select, $nd_condition);

                        if (count($row) == 1) {
                            $foreign_key_id = $this->module->module_settings->prepareforeignKeyName($r_module);
                            $data[$foreign_key_id] = $row[0]['id'];
                        } elseif (count($row) > 1) {
                            $this->helper->print_r($row);
                            throw new \Exception('Multiple foreign key ids found', '111');
                        } else {
                            //below condition not required, there are few data where mapping is optional like in CMN/marketing_projects
                            //throw new \Exception('Foreign Key Not found', '111');
                        }
                    }
                }
            }
        }

        return $data;
    }

    function prepareHeader($csv_header) {


        // $this->helper->print_r($this->field_set);

        $this->helper->print_r($csv_header);

        $this->t['csv_field_notfoundlist'] = $csv_header;


        foreach ($this->field_set as $field_name => $field) {
            $match_key = array_search($field['module_field_display_name'], $csv_header);

            $this->prepareExpectedKeyList($field);

            if ($match_key !== FALSE) {

                if ($field['module_field_datatype'] == 'relationship') {
                    //check foregin key
                    if (!isset($this->t['keylist'][$field['relationship_module']])) {
                        $this->t['keylist'][$field['relationship_module']] = array();
                    }

                    $this->t['keylist'][$field['relationship_module']][$match_key] = $field['module_field_name'];
                } elseif ($field['module_field_datatype'] != 'formulafield') {

                    $this->t['savelist'][$match_key] = $field['module_field_name'];
                } else {

                    //unexpected
                }
                unset($this->t['csv_field_notfoundlist'][$match_key]);
            } else {
                $this->t['db_field_notfoundlist'][$match_key] = $field['module_field_name'];
            }
        }
        if (preg_match('/ID#$/', $csv_header[0])) {

            $this->t['savelist']['0'] = 'quickbase_id';
            unset($this->t['csv_field_notfoundlist'][0]);
        }

        //@todo total number of keys to match
    }

    function prepareExpectedKeyList($field) {

        if ($field['module_field_datatype'] == 'relationship') {
            //collect all the relationship fields t
            if (!isset($keylist[$field['relationship_module']])) {

                $this->t['expected_keylist'][$field['relationship_module']] = array('all' => array());

                if (isset($field['relationship_foregin_key'])) {
                    //Only run one time
                    $this->t['expected_keylist'][$field['relationship_module']]['minimum'] = explode('|', $field['relationship_module_unique_field']);
                }
            }
            $this->t['expected_keylist'][$field['relationship_module']]['all'][] = $field['module_field_name'];
        }
    }
    
    function extractAizanId($quickbase_user) {
        
        $return = '';
        $users = $this->getAllUsers();
        //var_dump($users);
        preg_match_all("/([^<]*)<(.*)>/",$quickbase_user,$match);
        
        //var_dump($match);
        
        if(!empty($match[2])){
            //quickbase key id match found
            $u_id = trim($match[2][0]);
            
            if(!empty($users[$u_id])){
                //user match found
                
                $return = $users[$u_id][0]['id'];
            }
            
            
        }
        return $return;
        
        
    }
    
    function getAllUsers(){
        
        if(empty($this->users_list)){
            
            $db = $this->container->get('database_connection');
            $sql = "select * from user where quickbase_id != '' ";
            $data = $db->fetchAll($sql);
            $data = $this->helper->groupByField($data  , 'quickbase_id');
            $this->users_list = $data ;
            
        }
        
        return $this->users_list;
        
        
        
        
    }

}
