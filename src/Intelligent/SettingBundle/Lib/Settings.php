<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\SettingBundle\Lib;

class Settings {

    var $db;
    var $table = 'module_settings';
    /*
     * module is variable that holds all the logical modules which this applicaiton support.
     * KEY is exact name of db table & VALUE is display name
     */
    var $module = array(
        'customer' => 'Customer',
        'marketing_projects' => 'Marketing Projects',
        'campaign' => 'Campanigns',
        'campaign_contacts' => 'Campanigns Contact',
        'psuedo_email_accounts' => 'Psuedo Email Accounts',
        'assign_psuedo' => 'Assign Psuedo'
    );
    var $module_datatypes = array(
        'varchar' => 'Limited Character',
        'text' => 'Long Text',
        'currency' => 'Currency',
        'decimal' => 'Decimal',
        'enum' => 'Value Set',
        'link' => 'Link',
        'user' => 'User',
        'date' => 'Date',
//        'datetime' => 'Datetime',
        'relationship' => 'Relationship'
    );
    private $last_insert_id; //initilized after new field created
    private $last_sql_withoutlimit; //sql will be store in case total number of count need to be fetched
    private $last_sql_withoutlimit_params; //store the parameters for $last_sql_withoutlimit variable sql

    public function __construct($db) {

        $this->db = $db;
    }

    /*
     * Total number of tables supported in applications are pre-defined. Function will return the tables
     */

    public function getModule($key = '') {

        return empty($key) ? $this->module : $this->module[$key];
    }

    /*
     * get the Module datatypes allowed for text
     */

    public function getModuleDataTypes($key = '') {

        return empty($key) ? $this->module_datatypes : $this->module_datatypes[$key];
    }

    public function fetchAll() {

        $result = $this->db->fetchAll("SELECT * FROM {$this->table} limit 1");
        return $result;
    }

    public function fetch($nd_condition = array('field-name' => 'value'), $sort = array('field-name' => 'ASC'), $limit = '1000') {

        $extended_where = '';
        $order_by = '';
        $params = array();
        if (!isset($nd_condition['field-name']) and is_array($nd_condition) and count($nd_condition)) {
            //Parameter is not default, create the where clause

            $arr_where = array();
            foreach ($nd_condition as $column => $value) {
                if (is_array($value) and isset($value['like'])) {
                    //$arr_where[]= " $column like '{$value['like']}'";
                    $arr_where[] = " $column like ?";
                    $params[] = "%{$value['like']}%";
                } else {
                    $arr_where[] = " $column=?";
                    $params[] = $value;
                }
            }
            $extended_where = 'where ' . implode(' and ', $arr_where);
        }
        if (!isset($sort['field-name']) and is_array($sort)) {

            $arr_orderby = array();
            foreach ($sort as $column => $type) {
                $arr_orderby[] = " $column $type";
            }
            $order_by = 'ORDER BY ' . implode(' , ', $arr_orderby);
        }

        $sql = "SELECT * FROM {$this->table} $extended_where $order_by limit $limit";
        $this->last_sql_withoutlimit = "SELECT count(*) FROM {$this->table} $extended_where ";
        $this->last_sql_withoutlimit_params = $params;
        $result = $this->db->fetchAll($sql, $params);
        return $result;
    }

    public function save($post_data) {

        $data = $this->validateAndSet($post_data, 'save');

        $data['modified_datetime'] = date("Y-m-d H:i:s");

        $this->db->insert(
                $this->table, $data
        );
        if ($this->db->errorCode() != 0) {

            throw new \Exception($this->db->errorInfo(), '001');
        }

        $this->last_insert_id = $new_id = $this->db->lastInsertId();

        try {
            $this->afterSave($data);
        } catch (\Exception $ex) {
            //rollback the first insert of setting module
            $this->delete($new_id);
            throw $ex;
        }


        return $new_id;
    }

    /*
     * Description: Update wrt to id
     * Param1: array
     * Return: array
     */

    function update($post_data) {

        if (!empty($post_data['id'])) {
            $data = $this->validateAndSet($post_data, 'update');


            $data['modified_datetime'] = date("Y-m-d H:i:s");


            $this->db->update(
                    $this->table, $data, array('id' => $post_data['id'])
            );
            if ($this->db->errorCode() != 0) {

                throw new \Exception($this->db->errorInfo(), '002');
            }
        } else {
            throw new \Exception('Error Code: 234234, Unexpected Error', '001');
        }
    }

    /*
     * Description: Delete row based on id
     * Param1: integer
     * Return: array
     */

    function delete($delete_id) {
        $respid = $this->db->delete("{$this->table}", array('id' => $delete_id));
        return $respid;
    }

    public function validateAndSet($post_data, $type) {

        $data = array();
        $error = array();

        array_walk_recursive($post_data, function(&$val) {
            $val = trim($val);
            $val = stripslashes($val);
        });

        if ($type == 'save') {//Edit not allowed on this field, set it only for new row
            if (empty($post_data['module'])) {
                $error[] = "Module cannot be empty";
            } else {
                $data['module'] = $post_data['module'];
            }
        }


        if (empty($post_data['module_field_display_name'])) {
            $error[] = "Module field name cannot be empty";
        } else {
            $data['module_field_display_name'] = $post_data['module_field_display_name'];
        }
        if ($type == 'save') {//Edit not allowed on this field, set it only for new row
            if (empty($post_data['module_field_name'])) {
                $new = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($post_data['module_field_display_name']));
                $data['module_field_name'] = strlen($new) > 50 ? substr($new, -50) : $new;
            } else {
                $new = preg_replace('/[^a-zA-Z0-9_]/', '_', strtolower($post_data['module_field_name']));
                $data['module_field_name'] = strlen($new) > 50 ? substr($new, -50) : $new;
            }

            if ($post_data['module_field_datatype'] == 'relationship') {
                //If Type is set as relationship then need to validate extra for module_field_name also
                if (empty($post_data['relationship_module'])) {

                    $error[] = "Relationship Module cannot be empty for 'relationship' datatype";
                } elseif ($post_data['relationship_module'] == $post_data['module']) {

                    $error[] = "Relationship Module cannot be same as module name.";
                } elseif(empty($post_data['relationship_module_unique_field'])){
                    $error[] = "Relationship Module unique field cannot be empty.";
                    
                }else {
                    //check the field name exist in relationship module
                    $result1 = $this->fetch(
                            array(
                                'module' => $post_data['relationship_module'],
                                'module_field_name' => $data['module_field_name']));
                    
                    //check the field
                    $result2 = $this->fetch(
                            array(
                                'module' => $post_data['relationship_module'],
                                'module_field_name' => $data['relationship_module_unique_field']));

                    if (!count($result1)) {
                        //Field not found
                        $error[] = "{$data['module_field_name']} field not found for relationship module";
                    }elseif(!count($result2)){
                        
                        $error[] = "{$data['relationship_module_unique_field']} field not found for relationship module";
                    
                        
                    }else {
                    
                        $data['relationship_module'] = $post_data['relationship_module'];
                        $data['relationship_module_unique_field'] = $post_data['relationship_module_unique_field'];
                    }
                }
            }

            if (empty($post_data['module_field_datatype'])) {
                $error[] = "Module field's datatype cannot be empty";
            } else {
                $data['module_field_datatype'] = $post_data['module_field_datatype'];
            }
        }

        if ($post_data['module_field_datatype'] == 'link' and empty($post_data['link_text'])) {
            $error[] = "Display text of link cannot be empty";
        } else {
            $data['link_text'] = $post_data['link_text'];
        }

        if ($post_data['module_field_datatype'] == 'enum' and empty($post_data['value'])) {
            $error[] = "Value set can be empty for selected datatype";
        } elseif ($post_data['module_field_datatype'] != 'enum') {
            //value should be empty
            //do not set anything
            //$data['value'] ='';
        } else {
            $data['value'] = $post_data['value'];
        }

        if ($type == 'save') {//Edit not allowed on this field, set it only for new row
            if ($post_data['module_field_datatype'] == 'varchar' and empty($post_data['varchar_limit'])) {
                $error[] = "Limited Character field cannot be empty";
            } elseif ($post_data['module_field_datatype'] != 'varchar') {
                //value should be empty
                //Do not set the data
                //$data['varchar_limit'] =null';
            } else {
                $data['varchar_limit'] = $post_data['varchar_limit'];
            }
        }

        if (empty($post_data['enable_filter'])) {
            $error[] = "Enable filter field cannot be empty";
        } else {
            $data['enable_filter'] = $post_data['enable_filter'];
        }

        if (empty($post_data['show_in_grid'])) {
            $error[] = "Show in Grid field cannot be empty";
        } else {
            $data['show_in_grid'] = $post_data['show_in_grid'];
        }
        if ($type == 'save') {//Edit not allowed on this field, set it only for new row
            if (empty($post_data['unique_field'])) {
                $error[] = "Unique field cannot be empty";
            } else {
                $data['unique_field'] = $post_data['unique_field'];
            }
        }

        if (empty($post_data['required_field'])) {
            $error[] = "Required field cannot be empty";
        } else {
            $data['required_field'] = $post_data['required_field'];
        }

        if (empty($post_data['display_position'])) {
            $error[] = "Display position field cannot be empty";
        } elseif (!is_numeric($post_data['display_position'])) {
            $error[] = "Display position field should be number";
        } else {
            $data['display_position'] = floor($post_data['display_position']);
        }

//        if ($type == 'save') {//Edit not allowed on this field, set it only for new row
//            $data['relationship_module'] = $post_data['relationship_module'];
//        }

        if (!empty($error)) {
            throw new \Exception(implode('<br>', $error), '001');
        }
        return $data;
    }

    public function afterSave($data) {

        $other_details = '';
        if ($data['module_field_datatype'] == 'varchar') {
            $other_details = $data['varchar_limit'];
        } elseif ($data['module_field_datatype'] == 'relationship') {
            $this->createForeignKey($data['module'], $this->prepareforeignKeyName($data['relationship_module']));
            return;
        }
        if ($data['unique_field'] == 'Y') {
            $index_type = 'UNIQUE';
        } elseif ($data['enable_filter'] == 'Y') {
            $index_type = 'INDEX';
        } else {
            $index_type = '';
        }

        $this->createModuleField($data['module'], $data['module_field_name'], $data['module_field_datatype'], $index_type, $other_details);
    }

    public function afterDelete() {
        
    }
    
    public function prepareforeignKeyName($module){
        
        return "relationship_{$module}_id";
        
    }

    public function createModuleField($table, $field_name, $datatype, $index_type, $other_details) {

        $index = '';
        if (!empty($index_type)) {
            $index = ", ADD $index_type `$field_name` (`$field_name` ASC)";
        }
        $type = '';
        if (in_array($datatype, array('varchar'))) {
            $type = "varchar($other_details)";
        } elseif (in_array($datatype, array('enum'))) {
            $type = 'varchar(200)';
        } elseif ($datatype == 'text') {
            $type = 'text';
        } elseif ($datatype == 'link') {
            $type = 'varchar(400)';
        } else if (in_array($datatype, array('integer', 'user'))) {
            $type = 'int(11)';
        } else if (in_array($datatype, array('decimal'))) {
            $type = 'float(12,4)';
        } else if (in_array($datatype, array('currency'))) {
            $type = 'float(10,2)';
        } else if (in_array($datatype, array('date'))) {
            $type = 'date';
        } else if (in_array($datatype, array('datetime'))) {
            $type = 'datetime';
        }
        $alt_sql = "ALTER TABLE `$table` 
            ADD COLUMN `$field_name` $type NULL $index;";

        $this->db->executeQuery($alt_sql);

        if ($this->db->errorCode() != 0) {

            throw new \Exception($this->db->errorInfo(), '002');
        }
    }

    function totalCountOfLastFetch() {

        if (!empty($this->last_sql_withoutlimit)) {
            $result = $this->db->fetchAll($this->last_sql_withoutlimit, $this->last_sql_withoutlimit_params);
            if ($this->db->errorCode() != 0) {

                throw new \Exception($this->db->errorInfo(), '002');
            }
        } else {
            throw new \Exception('last_sql_withoutlimit is empty', '002');
        }

        return $result[0]['count(*)'];
    }

    function createForeignKey($module, $column) {

        $sql = "show columns FROM $module where field = '$column'";

        $result = $this->db->fetchAll($sql);

        if (count($result)) {
            //column already exist 
        } else {

            $alt_sql = "ALTER TABLE `$module` 
            ADD COLUMN `$column` int(11) NULL , ADD index `$column` (`$column` ASC);";
            $this->db->executeQuery($alt_sql);

            if ($this->db->errorCode() != 0) {

                throw new \Exception($this->db->errorInfo(), '002');
            }
        }
    }

}
