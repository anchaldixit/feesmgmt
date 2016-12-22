<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\ModuleBundle\Lib;

use Intelligent\SettingBundle\Lib\Settings;

class Module {

    var $db;
    protected $table;
    protected $module;
    public $module_settings;
    private $last_insert_id; //initilized after new field created
    private $last_sql_withoutlimit; //sql will be store in case total number of count need to be fetched
    private $last_sql_withoutlimit_params; //store the parameters for $last_sql_withoutlimit variable sql

    function __construct($conn) {

        $this->db = $conn;

        $this->module_settings = new Settings($conn);

        $this->initModuleSettings();
    }

    function initModuleSettings() {
        
    }

    /*
     * 
     * param1: $fields = array(fieldname1)
     * param2: $nd_condition = array('field-name' => 'value')
     * param3: $join = array('tablename' => array('id' => 'join_id'))
     * param4: $sort = array('field-name' => 'ASC')
     * param5: $limit = '1000'
     */
    function fetch($fields = array(), $nd_condition = array(), $join = array(), $sort = array(), $limit = '1000') {

        $extended_where = '';
        $order_by = '';
        $join_condition='';
        $params = array();
        $select_fields= '*';
         if (is_array($fields) and count($fields)) {
            //Parameter is not default, create the where clause

            $select_fields = implode(' , ', $fields);
        }       
        if (!isset($nd_condition['field-name']) and is_array($nd_condition) and count($nd_condition)) {
            //prepare where clause based on condition

            $arr_where = array();
            foreach ($nd_condition as $column => $value) {
                if (is_array($value) and isset($value['like'])) {
                    //$arr_where[]= " $column like '{$value['like']}'";
                    $arr_where[] = " $column like ?";
                    $params[] = "%{$value['like']}%";
                } else {
                    $arr_where[] = " {$this->table}.$column=?";
                    $params[] = $value;
                }
            }
            var_dump($params);
            $extended_where = 'where ' . implode(' and ', $arr_where);
        }
        if (!isset($sort['field-name']) and is_array($sort) and count($sort)) {

            $arr_orderby = array();
            foreach ($sort as $column => $type) {
                $arr_orderby[] = " $column $type";
            }
            $order_by = 'ORDER BY ' . implode(' , ', $arr_orderby);
        }
        
        if (!isset($join['tablename']) and is_array($join) and count($join)) {
            $arr_join_part =array();
            foreach ($join as $tablename => $value) {
                
                $arr_join_part[] = "LEFT JOIN $tablename ON ({$this->table}.{$value['id']} = $tablename.id)";
                
            }
            $join_condition = implode(' ', $arr_join_part);
            
        }


        $sql = "SELECT $select_fields FROM {$this->table} $join_condition $extended_where $order_by limit $limit";
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



        if (!empty($error)) {
            throw new \Exception(implode('<br>', $error), '001');
        }
        return $data;
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

    function getRow($id) {

        $this->table;
        $join = array();
        $schema = array('id'=>'id');



        $module_field_set = $this->getFormFields();

        foreach ($module_field_set as $key => $row) {

            $schema[$row['module_field_name']] = $row;

            if ($row['module_field_datatype'] == 'relationship') {
                //relationship datatype need to handle is separately.
                
                //append module name before field name
                $name = "{$row['relationship_module']}.{$row['module_field_name']}";
                $fieldset[] = $name;
                
                $join[$row['relationship_module']] = array('id'=>  $this->module_settings->prepareforeignKeyName($row['relationship_module']));
                
            } else {
                $fieldset[] = $row['module_field_name'];
            }
        }
        
        $result = $this->fetch($fieldset, array('id'=>$id), $join);
        
        return array('schema'=>$module_field_set,'row'=>$result);
        
        

        //Need list of all fields
        //how many left join
        //Fetch the data
        
    }

    function getDisplayGridFields() {


        $results = $this->module_settings->fetch(
                array('module' => $this->module, 'show_in_grid' => 'Y'), array('display_position' => 'ASC'));

        $fieldset = array();

        foreach ($results as $value) {
            
        }
    }

    function getFormFields() {

        $results = $this->module_settings->fetch(
                array('module' => $this->module), array('display_position' => 'ASC'));


        //@todo: give 
        //$fieldset=array();

        return $results;
    }

}
