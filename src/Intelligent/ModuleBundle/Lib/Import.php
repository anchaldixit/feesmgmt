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
        'savelist_of_display_name' => array(),
        'keylist_of_display_name' => array()
    ); //tracker of header
    var $test_only_header = false;
    var $delete_before_insert = false;
    var $module_has_nested_relationship_inkey = true;
    var $usernotfound = array();
    var $users_list = array();
    var $quickbase_keyname;
    public $console_customer_id;

    function init($module) {

        if (empty($this->console_customer_id)) {
            //Also validate Import is used as logged in feature. If yes then dont thru exception
            $user_permission = $this->container->get("user_permissions");
            $active_customer_filter = $user_permission->getCurrentViewCustomer()->getId();
            if (empty($active_customer_filter)) {
                throw new \Exception('011', 'Console customer cannot be empty');
            }
        }
        $this->module_name = $module;
        $this->module = $this->container->get("intelligent.{$this->module_name}.module");
        $this->field_set = $this->module->getFormFields();
        //$this->logger = $this->container->get('monolog.logger.import_logger');
        $this->helper = new Helper();
    }

    function setConsoleCustomer($v) {
        $this->console_customer_id = $v;
        $this->container->get('session')->set('console_cusotmer_id', $this->console_customer_id);
    }

    function setTestOnlyHeader($v) {
        $this->test_only_header = $v;
    }

    function setDeleteBeforeInsert($v) {
        $this->delete_before_insert = $v;
    }

    function setForeignKey($v) {
        $this->quickbase_keyname = $v;
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

                if ($this->console_customer_id) {
                    $this->helper->print_r($this->t);
                }
                if ($this->test_only_header) {
                    $this->setDisplayMessages();
                    //$this->get('session')->getFlashBag()->add('success', 'Header details ');
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
                    if ($data[$field_name] === null) {
                        unset($data[$field_name]);
                    }
                }

                if ($this->console_customer_id) {

                    $this->helper->print_r($data);
                }
                if (!empty($data['id'])) {
                    //var_dump($data);
                    $this->module->update($data);
                } else {
                    $this->module->save($data);
                }
            }
        }
        //extract data
        //$path, get first row
        //prepare field found and to be inserted
        //prepare foriegn key and get it
        //insert it 
        //next row
    }

    private function setDisplayMessages() {

        //Show the list of all matched columns
        if (!count($this->t['savelist_of_display_name'])) {
            $this->container->get('session')->getFlashBag()->add('errors', 'None of the column name match with module attribute\'s name');
        } else {
            $this->container->get('session')->getFlashBag()->add('success', 'Matched columns: ' . implode(', ', $this->t['savelist_of_display_name']));
        }

        //Show the list of all columns matched with key(forgien key)
        if (!count($this->t['keylist_of_display_name'])) {
            //Dont send any msg
            //$this->get('session')->getFlashBag()->add('success', 'No Key found');
        } else {
            $keylist = '';
            foreach ($this->t['keylist_of_display_name'] as $k_module => $list) {
                $keylist = "[$k_module: " . implode(', ', $list) . "] ";
            }
            $this->container->get('session')->getFlashBag()->add('success', "Colums identified as key: $keylist");
        }

        if (!count($this->t['csv_field_notfoundlist'])) {
            //Dont send msg best condition
        } else {
            $this->container->get('session')->getFlashBag()->add('success', 'CSV columns not found in Module: ' . implode(', ', $this->t['csv_field_notfoundlist']));
        }

        if (!count($this->t['db_field_notfoundlist'])) {
            //Dont send msg best condition
        } else {
            $this->container->get('session')->getFlashBag()->add('success', 'Extra columns in CSV: ' . implode(', ', $this->t['db_field_notfoundlist']));
        }


        //$this->get('session')->getFlashBag()->add('success', 'Header details ');
    }

    private function formate($value, $fieldname) {

        $fieldtype = isset($this->field_set[$fieldname]) ? $this->field_set[$fieldname]['module_field_datatype'] : '';
        $return = $value;

        switch ($fieldtype) {
            case 'percentage':

                $return = str_replace('%', '', $value);
                $return = str_replace(',', '', $return);


                break;
            case 'number':

                $return = str_replace(',', '', $value);


                break;
            case 'date':

                if (!empty($value)) {
                    $dilmiter = strpos($value, '-') !== false ? '-' : '/';
                    if ($dilmiter == '/') {
                        $d = explode($dilmiter, $value);
                        $return = date('Y-m-d', mktime(0, 0, 0, $d[0], $d[1], $d[2]));
                    }else{
                        //Dont do anything for 
                    }
                } else {
                    $return = null;
                }

                break;
            case 'user':

                $user_id = $this->extractAizanId($value);

                if (empty($user_id)) {

                    $this->usernotfound[] = $value;
                    $return = '';
                } else {
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
                    if ($this->module_has_nested_relationship_inkey) {
                        $select = array("$r_module.id");
                        $nd_condition = array();
                        foreach ($set as $key => $field) {
                            //$nd_condition = array("{$r_module}.$field" => $row[$key]);
                            $nd_condition["$field"] = $row[$key];
                            // $nd_condition = array()
                        }
                        $row_result = $m->getRows($nd_condition, array(), 10);
                        $results = $row_result['row'];
                    } else {

                        $select = array("$r_module.id");
                        $nd_condition = array();
                        foreach ($set as $key => $field) {
                            $nd_condition = array("{$r_module}.$field" => $row[$key]);
                            //$nd_condition["$field"] = $row[$key];
                            // $nd_condition = array()
                        }
                        $results = $m->fetch($select, $nd_condition);
                    }

                    //var_dump($row);exit;
                    //$row = $m->fetch($select, $nd_condition);

                    if (count($results) == 1) {
                        $foreign_key_id = $this->module->module_settings->prepareforeignKeyName($r_module);
                        $data[$foreign_key_id] = $results[0]['id'];
                    } elseif (count($results) > 1) {
                        if ($this->console_customer_id) {
                            $this->helper->print_r($results);
                        }
                        throw new \Exception('Multiple foreign key ids found', '111');
                    } else {
                        //below condition not required, there are few data where mapping is optional like in CMN/marketing_projects
                        //throw new \Exception('Foreign Key Not found', '111');
                    }
                }
            }
        }

        return $data;
    }

    function prepareHeader($csv_header) {


        // $this->helper->print_r($this->field_set);
        if ($this->console_customer_id) {
            $this->helper->print_r($csv_header);
        }

        $this->t['csv_field_notfoundlist'] = $csv_header;


        foreach ($this->field_set as $field_name => $field) {
            $match_key = array_search($field['module_field_display_name'], $csv_header);

            $this->prepareExpectedKeyList($field);

            if ($match_key !== FALSE) {

                if ($field['module_field_datatype'] == 'relationship') {
                    //check foregin key
                    if (empty($this->quickbase_keyname)) {

                        if (!isset($this->t['keylist'][$field['relationship_module']])) {
                            $this->t['keylist'][$field['relationship_module']] = array();
                            $this->t['keylist_of_display_name'][$field['relationship_module']] = array();
                        }

                        $this->t['keylist'][$field['relationship_module']][$match_key] = $field['module_field_name'];
                        $this->t['keylist_of_display_name'][$field['relationship_module']][$match_key] = $field['module_field_display_name'];
                    }
                } elseif (!in_array($field['module_field_datatype'], array('formulafield', 'relationship-aggregator'))) {

                    $this->t['savelist'][$match_key] = $field['module_field_name'];
                    $this->t['savelist_of_display_name'][$match_key] = $field['module_field_display_name'];
                } else {

                    //unexpected
                }
                unset($this->t['csv_field_notfoundlist'][$match_key]);
            } else {
                $this->t['db_field_notfoundlist'][] = $field['module_field_display_name'];
            }
        }
        if (preg_match('/ID#$/', $csv_header[0])) {

            $this->t['savelist']['0'] = 'quickbase_id';
            unset($this->t['csv_field_notfoundlist'][0]);
        }
        if ($csv_header[0] == 'Id') {
            $this->t['savelist']['0'] = 'id';
            unset($this->t['csv_field_notfoundlist'][0]);
        }
        if (!empty($this->quickbase_keyname)) {
            foreach ($this->quickbase_keyname as $module => $head_col) {
                //only for one time
                $match_key = array_search($head_col, $csv_header);
                if ($match_key !== FALSE) {
                    if (!isset($this->t['keylist'][$module])) {
                        $this->t['keylist'][$module] = array();
                    }
                    $this->t['keylist'][$module][$match_key] = "$module.quickbase_id";
                } else {
                    throw new \Exception('Foriegn key name match not found. LINENO:' . __LINE__);
                }
            }
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
        preg_match_all("/([^<]*)<(.*)>/", $quickbase_user, $match);

        //var_dump($match);

        if (!empty($match[2])) {
            //quickbase key id match found
            $u_id = trim($match[2][0]);

            if (!empty($users[$u_id])) {
                //user match found

                $return = $users[$u_id][0]['id'];
            }
        }
        return $return;
    }

    function getAllUsers() {

        if (empty($this->users_list)) {

            $db = $this->container->get('database_connection');
            $sql = "select * from user where quickbase_id != '' ";
            $data = $db->fetchAll($sql);
            $data = $this->helper->groupByField($data, 'quickbase_id');
            $this->users_list = $data;
        }

        return $this->users_list;
    }

}
