<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Intelligent\ModuleBundle\Lib;

use Intelligent\SettingBundle\Lib\Settings;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\DependencyInjection\ContainerAware;

abstract class Module extends ContainerAware {

    var $db;
    protected $table;
    protected $module;
    public $module_settings;
    private $last_insert_id; //initilized after new field created
    private $last_sql_withoutlimit; //sql will be store in case total number of count need to be fetched
    private $last_sql_withoutlimit_params; //store the parameters for $last_sql_withoutlimit variable sql
    private $db_manager;
    protected $row_filter_enabled = true;

    /*
     * Leave the construct blank, dont remove
     */

    function __construct() {
        
    }

    /*
     * Function will be called thru service
     */

    function init() {

        $this->db = $this->container->get('database_connection');
        $this->module_settings = $this->container->get('intelligent.setting.module');

        $this->_init();
    }

    abstract function _init();





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
        $join_condition = '';
        $params = array();
        $select_fields = '*';

        if (!isset($nd_condition['field-name']) and is_array($nd_condition) and count($nd_condition)) {
            //prepare where clause based on condition

            $arr_where = array();
            foreach ($nd_condition as $column => $value) {
                if (is_array($value) and isset($value['like'])) {
                    //$arr_where[]= " $column like '{$value['like']}'";
                    $arr_where[] = " $column like ?";
                    $params[] = "%{$value['like']}%";
                } elseif (is_array($value) and ( isset($value['min']) or isset($value['min']) )) {
                    //range bound condtion
                    if (isset($value['min']) and ! empty($value['min'])) {
                        $arr_where[] = " $column >= ?";
                        $params[] = strstr($value['min'], '/') === false ? $value['min'] : date('Y-m-d', strtotime($value['min']));
                    }
                    if (isset($value['max']) and ! empty($value['max'])) {
                        $arr_where[] = " $column <= ?";
                        $params[] = strstr($value['max'], '/') === false ? $value['max'] : date('Y-m-d', strtotime($value['max']));
                    }
                } else {
                    $arr_where[] = "$column=?";
                    $params[] = $value;
                }
            }
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
            $arr_join_part = array();
            foreach ($join as $tablename => $value) {

                foreach ($value as $left_conditon => $right_condition) {
                    $arr_join_part[] = "LEFT JOIN $tablename ON ($left_conditon = $right_condition)";
                    $fields[] = $right_condition;
                }
            }
            $join_condition = implode(' ', $arr_join_part);
        }
        if (is_array($fields) and count($fields)) {
            //Parameter is not default, create the where clause

            $select_fields = implode(' , ', $fields);
        }

        $sql = "SELECT $select_fields FROM {$this->table} $join_condition $extended_where $order_by limit $limit";
        $this->last_sql_withoutlimit = "SELECT count(*) FROM {$this->table} $join_condition $extended_where ";
        $this->last_sql_withoutlimit_params = $params;
        $result = $this->db->fetchAll($sql, $params);
        return $result;
    }

    public function save($post_data) {

        $data = $this->validateAndSet($post_data, 'save');

        $data['modified_datetime'] = date("Y-m-d H:i:s");

        if ($this->row_filter_enabled) {
            $data = $this->addViewAccessCondition($data);
        }

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
        $fields_config = $this->getFormFields();

        //validate each field based on its configurations & data type
        foreach ($fields_config as $key => $field_schema) {

            //Check if is already configured
            if (isset($post_data[$field_schema['module_field_name']])) {

                $field_name = $field_schema['module_field_name'];
                $field_value = $post_data[$field_name];
                $field_display_name = $field_schema['module_field_display_name'];
                $field_datatype = $field_schema['module_field_datatype'];


                if ($field_schema['required_field'] == 'Y' and empty($field_value)) {

                    $error[] = "$field_display_name cannot be empty.";
                } else {

                    switch ($field_datatype) {
                        case 'varchar':

                            if (strlen($field_value) > $field_schema['varchar_limit']) {
                                $error[] = "$field_display_name crossed the character limit of {$field_schema['varchar_limit']}.";
                            }
                            break;
                        case 'percentage':
                        case 'currency':

                            if (!empty($field_value) and ! is_numeric($field_value)) {
                                $error[] = "$field_display_name should be a number.";
                            } else {
                                $field_value = round($field_value, 2);
                            }
                            break;
                        case 'text':


                            break;
                        case 'decimal':
                        case 'number':

                            if (!empty($field_value) and ! is_numeric($field_value)) {
                                $error[] = "$field_display_name should be a number.";
                            }
                            break;
                        case 'enum':
                            break;
                        case 'link':

                            if (filter_var($field_value, FILTER_VALIDATE_URL) === false) {
                                $error[] = "$field_display_name should be a URL.";
                            }
                            break;
                        case 'user':


                            break;
                        case 'date':
                            $field_value = date('Y-m-d', strtotime($field_value));


                            break;
                        case 'datetime':


                            break;
                        case 'relationship':

                            if ($field_schema['required_field'] == 'Y' and empty($post_data[$field_name])) {
                                $error[] = "{$field_schema['relationship_module']} Relationship field cannot be empty";
                            } else {
                                $field_value = $post_data[$field_name];
                            }
                            break;

                        default:
                            break;
                    }

                    $data[$field_name] = $field_value;
                }
            } elseif ($field_schema['module_field_datatype'] == 'relationship') {
                //relationship field need to handled separately

                if (isset($field_schema['relationship_field_name'])) {
                    $field_name = $field_schema['relationship_field_name'];

                    if ($field_schema['required_field'] == 'Y' and empty($post_data[$field_name])) {
                        $error[] = "{$field_schema['relationship_module']} Relationship field cannot be empty";
                    } else {
                        $field_value = $post_data[$field_name];
                        $data[$field_name] = $field_value;
                    }
                }
            }
        }

        ;


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
        $fieldset = array();
        $where = array("{$this->module}.id" => $id);

        $module_field_set = $this->getFormFields();

        foreach ($module_field_set as $key => $row) {

            $schema[$row['module_field_name']] = $row;

            if ($row['module_field_datatype'] == 'relationship') {
                //relationship datatype need to handle is separately.
                //append module name before field name
                $this->prepareSQLParams($row, $join, $fieldset, $where);
                
            }elseif($row['module_field_datatype'] == 'formulafield'){
                $fieldset[] = "{$row['formulafield']} as {$row['module_field_name']}";
            } else {
                $fieldset[] = "{$row['module']}.{$row['module_field_name']}";
            }
        }

        $filters = $this->addViewAccessCondition($where);

        $result = $this->fetch($fieldset, $filters, $join);

        return array('schema' => $module_field_set, 'row' => $result);



        //Need list of all fields
        //how many left join
        //Fetch the data
    }

    function getRows($where, $order_by, $limit) {

        $join = array();
        $fieldset = array("{$this->table}.id");

        $module_field_set = $this->getDisplayGridFields();

        foreach ($module_field_set as $key => $row) {

            $schema[$row['module_field_name']] = $row;

            if ($row['module_field_datatype'] == 'relationship') {
                //relationship datatype need to handle is separately.
                //append module name before field name
                $this->prepareSQLParams($row, $join, $fieldset, $where);
            } elseif($row['module_field_datatype'] == 'formulafield'){
                $fieldset[] = "{$row['formulafield']} as {$row['module_field_name']}";
            }else {
                $fieldset[] = "{$row['module']}.{$row['module_field_name']}";
                if (isset($where[$row['module_field_name']])) {
                    $temp = $where[$row['module_field_name']];
                    $where["{$row['module']}.{$row['module_field_name']}"] = $temp;
                    unset($where[$row['module_field_name']]);
                }
            }
        }
        $fieldset[] = "{$this->table}.modified_datetime";

        $where = $this->addViewAccessCondition($where);
        
        $result = $this->fetch($fieldset, $where, $join, $order_by, $limit);

        return array('schema' => $module_field_set, 'row' => $result);
    }

    /*
     * Function is expected to be used for view page, it will fetch all the settings required to show fields & filters
     */

    function getDisplayGridFields() {


        $results = $this->module_settings->fetch(
                array('module' => $this->module, 'show_in_grid' => 'Y'), array('display_position' => 'ASC'));

        $fieldset = array();

        foreach ($results as $value) {

            # If datatype is relationship then extract the field setting of relationship field and include into relationship table
            if ($value['module_field_datatype'] == 'relationship') {
                //relationship field also required setting for relationship module

                $result2 = $this->getFieldSettings($value['relationship_module'], $value['module_field_name']);
                $core_field_settings = $this->getCoreSettingsOfRelationshipField($result2);
                $value['core_field_settings'] = $core_field_settings;

                # Add field setting to $fieldset only for if relationship settings found for it
                if (count($result2)) {
                    $value['relationship_field_settings'] = $result2;
                    $this->filterSettings($value);
                    $fieldset[$value['module_field_name']] = $value;
                }
            } else {//non relationship type field
                //May be some information/twigs need to be done for filters
                $this->filterSettings($value);
                $fieldset[$value['module_field_name']] = $value;
            }
        }

        return $fieldset;
    }

    /*
     * Get Field settings/configurition. function will fetch the setting recursively if field datatype is relationship
     * @param1: module name (string)
     * @param2: Field name (string)
     * Return: Array
     */

    function getFieldSettings($module, $field_name) {

        $result = $this->module_settings->fetch(
                array('module' => $module,
                    'module_field_name' => $field_name
                )
        );
        if (count($result)) {
            if ($result[0]['module_field_datatype'] == 'relationship') {
                //Recursive call
                $result2 = $this->getFieldSettings($result[0]['relationship_module'], $result[0]['module_field_name']);

                if (count($result2)) {
                    $result[0]['relationship_field_settings'] = $result2;
                }
            }
            return $result[0];
        }
    }

    /*
     * Prepare join condition. If field is relational then prepare join recursively till end
     * Parameter 1: field setting(array)
     * Parameter 2: join conitions(array call by reference)
     * Parameter : $select fields(array call by reference)
     */

    function prepareSQLParams($field_settings, &$join, &$select, &$where) {

        if (isset($field_settings['relationship_field_settings']) and $field_settings['relationship_field_settings']['module_field_datatype'] == 'relationship') {
            $join_table = $field_settings['relationship_field_settings']['relationship_module'];
            //one extra join required(nested)

            $join[$field_settings['relationship_module']] = array("{$field_settings['relationship_module']}.id" => "{$field_settings['module']}." . $this->module_settings->prepareforeignKeyName($field_settings['relationship_module']));

            $join[$join_table] = array("$join_table.id" => "{$field_settings['relationship_module']}." . $this->module_settings->prepareforeignKeyName($join_table));
            if (isset($where[$field_settings['module_field_name']])) {
                $temp = $where[$field_settings['module_field_name']];
                $where["$join_table.{$field_settings['module_field_name']}"] = $temp;
                unset($where[$field_settings['module_field_name']]);
            }
            $this->prepareSQLParams($field_settings['relationship_field_settings'], $join, $select, $where);
            //do not proceed further
            return;
        } else {
            $join_table = $field_settings['relationship_module'];

            $join[$join_table] = array("$join_table.id" => "{$field_settings['module']}." . $this->module_settings->prepareforeignKeyName($join_table));

            if (isset($where[$field_settings['module_field_name']])) {
                $temp = $where[$field_settings['module_field_name']];
                $where["$join_table.{$field_settings['module_field_name']}"] = $temp;
                unset($where[$field_settings['module_field_name']]);
            }
        }
        $field_name = "$join_table.{$field_settings['module_field_name']}";
        $select[] = $field_name;
    }

    function getEnableFilters() {

        $results = $this->module_settings->fetch(
                array('module' => $this->module, 'enable_fitler' => 'Y'), array('display_position' => 'ASC'));



        return $results;
    }

    function getFormFields() {

        $results = $this->module_settings->fetch(
                array('module' => $this->module), array('display_position' => 'ASC'));
        //@todo: give 
        $fieldset = array();
        $dependencies = array();

        foreach ($results as $key => $value) {

            if ($value['module_field_datatype'] !== 'relationship') {
                $fieldset[] = $value;
            } else {
                //In case there are multiple fields of same relationship table is there, do not send  all fields. Only send the one field.
                if (!isset($dependencies[$value['relationship_module']])) {

                    $value['relationship_foregin_key'] = 'set';
                    $dependencies[$value['relationship_module']] = 'set';
                    $value['relationship_field_name'] = $this->module_settings->prepareforeignKeyName($value['relationship_module']);
                    $value['relationship_module_display_name'] = $this->module_settings->getModule($value['relationship_module']);
                }
                $result2 = $this->getFieldSettings($value['relationship_module'], $value['module_field_name']);
                
                $core_field_settings = $this->getCoreSettingsOfRelationshipField($result2);
                $value['core_field_settings']=$result2['core_field_settings'] = $core_field_settings;
                if (count($result2)) {
                    $value['relationship_field_settings'] = $result2;
                }
                
                $fieldset[] = $value;
            }
            //$fieldset[]
        }

        return $fieldset;
    }

    function setDbManager($db_manager) {

        $this->db_manager = $db_manager;
    }

    function getUsers() {

        $query = $this->db_manager->createQueryBuilder();
        $query->select("u")
                ->from("IntelligentUserBundle:User", "u");
        $query->andWhere($query->expr()->in("u.status", 1));

        $dql = $query->getQuery();
        $results = $dql->getResult();
        $userlist = array();
        foreach ($results as $key => $user) {
            $userlist[$user->getId()] = $user->getName();
        }
        return $userlist;
    }

    function afterSave($data) {
        
    }

    /*
     * Function will add the row level condition to $parameters. Currently scope is restricted to customer level view.
     * @param: Array
     */

    function addViewAccessCondition($params) {

        //$session = new Session();
        //$val = $session->get('active_customer_filter');
        $user_permission = $this->container->get("user_permissions");
        $val = $user_permission->getCurrentViewCustomer()->getId();

        if ($this->module != 'customer' and ! empty($val)) {
            $params = array_merge($params, array("{$this->module}.linked_customer_id" => $val));
        } elseif ($this->module == 'customer') {
            $params = array_merge($params, array("{$this->module}.id" => $val));
        }

        return $params;
    }

    /*
     * Fetch more information required for filters
     * Param 1: Array(call by reference)
     */

    function filterSettings(&$field_settings) {

        if ($field_settings['enable_filter'] == 'Y') {

            if ($field_settings['enable_filter_with_option'] == 'Y') {
                //change the datatype of field to enum
                //$field_settings['value']='';
                $this->convert2EnumDatatype4Filter($field_settings);
            }
        }
    }

    /*
     * This will fetch the column values and put that as enum value for filters
     * Param 1: Array(call by reference)
     */

    private function convert2EnumDatatype4Filter(&$field_settings) {

        if ($field_settings['module_field_datatype'] == 'relationship') {

            $this->convert2EnumDatatype4Filter($field_settings['relationship_field_settings']);
        } else {

            $module = $this->container->get("intelligent.{$field_settings['module']}.module");
            $filters = $module->addViewAccessCondition(array());

            $params = $condition = array();

            foreach ($filters as $key => $value) {
                $condition[] = "$key = ?";
                $params[] = $value;
            }
            $where = ' where ' . implode(' and ', $condition);


            $sql = "select GROUP_CONCAT(distinct {$field_settings['module_field_name']} SEPARATOR '|') as 'values' from  {$field_settings['module']} $where";

            $result = $this->db->fetchAll($sql, $params);
            if (count($result)) {
                //do setting only if results found
                $field_settings['module_field_datatype'] = 'enum';
                //enum parameter understands pipe as dilimiter
                $field_settings['value'] = $result[0]['values'];
            }
        }
    }

    /*
     * Fetch the core settings of relationsihp field. It may go to array nested level of 3 -4
     */

    function getCoreSettingsOfRelationshipField($field_settings) {

        if (isset($field_settings['relationship_field_settings']) and $field_settings['module_field_datatype'] == 'relationship' and count($field_settings['relationship_field_settings'])) {
            return $this->getCoreSettingsOfRelationshipField($field_settings['relationship_field_settings']);

        } else {
            return $field_settings;
        }
    }

}
