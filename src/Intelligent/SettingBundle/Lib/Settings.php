<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\SettingBundle\Lib;

class Settings {

    var $db;
    var $table = 'settings';
    /*
     * module is variable that holds all the logical modules which this applicaiton support.
     * KEY is exact name of db table & VALUE is display name
     */
    var $module = array(
        'customer' => 'Customer',
        'campaign' => 'Campanigns',
        'campaign_contacts' => 'Campanigns Contact',
        'marketing_initiatives' => 'Marketing Initiatives');
    var $module_datatypes = array(
        'varchar'=>'Limited Char',
        'text' => 'Long Text',
        'currency' => 'Currency',
        'decimal' => 'Decimal',
        'link' => 'Link',
        'user' => 'User',
        'date' => 'Date',
        'datetime' => 'Datetime'
    );

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

        $result = $this->db->fetchAll('SELECT * FROM settings limit 1');
        return $result;
    }

    public function fetch($nd_condition = array('field-name' => 'value')) {

        $extended_where = '';
        if (!isset($nd_condition['field-name']) and is_array($nd_condition)) {
            //Parameter is not default, create the where clause

            $arr_where = array();
            foreach ($nd_condition as $column => $value) {
                $arr_where[] = " $column='$value'";
            }
            $extended_where = 'where ' . implode(' and ', $arr_where);
        }

        $result = $this->db->fetchAll("SELECT * FROM settings $extended_where");
        return $result;
    }

    public function insert() {
        $data = array(
            'display_name' => 'Campaign End Date',
            'table_field_name' => 'campaign_end_date',
            'datatype' => 'datetime',
            'table_name' => 'campaign',
        );
        $result = $this->db->insert($this->table, $data);
    }

    public function save($post_data) {

        $data = $this->validateAndSet($post_data, 'save');

        $data['modified_datetime'] = date("Y-m-s H:i:s");

        $this->db->insert(
                $this->table, $data
        );
        if ($this->db->errorCode() != 0) {

            throw new \Exception($this->db->errorInfo(), '001');
        }
        
        $new_id = $this->db->lastInsertId();

        $this->afterSave($data);

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
            
            
            $data['modified_datetime'] = date("Y-m-s H:i:s");


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

        if (empty($post_data['enable_filter'])) {
            $error[] = "Enable filter field cannot be empty";
        } else {
            $data['enable_filter'] = $post_data['enable_filter'];
        }
        if ($type == 'save') {//Edit not allowed on this field, set it only for new row
            $data['relationship_module'] = $post_data['relationship_module'];
        }

        if (!empty($error)) {
            throw new \Exception(implode('<br>', $error), '001');
        }
        return $data;
    }

    public function afterSave($data) {

        $this->createModuleField($data['module'], $data['module_field_name'], $data['module_field_datatype'], $data['enable_filter'] == 'Y' ? true : false);
    }

    public function afterDelete() {
        
    }

    public function createModuleField($table, $field_name, $datatype, $is_indexed) {

        $index = '';
        if ($is_indexed) {
            $index = ", ADD INDEX `$field_name` (`$field_name` ASC)";
        }
        $type = '';
        if ($datatype == 'varchar') {
            $type = 'varchar(400)';
        } elseif ($datatype == 'text') {
            $type = 'text';
        }elseif ($datatype == 'link') {
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

}
