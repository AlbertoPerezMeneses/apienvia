<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of metadata
 *
 * @author drkidb
 */
include_once APPPATH . 'libraries/REST_Controller.php';

class Metadata extends REST_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * @api {get} metadata/databases/ Databases
     * @apiName GetDatabases
     * @apiGroup METADATA
     *     
     *
     * @apiSuccess {String} las bases de datos.    
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {"bd":["jm1","test"]}
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "error": "UserNotFound"
     *     }
     */
    public function databases_get() {
        $this->load->model("meta_data");
        $items = $this->meta_data->get_databases();

        foreach ($items as $value) {
            switch ($value["Database"]) {
                case "information_schema":
                    break;

                case "mysql":
                    break;

                case "performance_schema":
                    break;

                default:
                    $data["bd"][] = $value["Database"];
                    break;
            }
        }
        $this->response($data, 200);
    }
    /**
     * @api {get} metadata/tables/ Tables
     * @apiName GetTables
     * @apiGroup METADATA
     * @apiParam {schema} la base de datos.
     *     
     *
     * @apiSuccess {String} la lista de tablas en la base de datos.    
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {"tables":["table1","table2"]}
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "response": "no existe la base de datos"
     *     }
     */
    public function tables_get() {

        $database = $this->get("schema", TRUE);
        $this->load->model("meta_data");

        
        $this->is_schema($database);
        $items = $this->meta_data->get_tables($database);

        foreach ($items as $key => $value) {
            $data["tables"][] = $value["Tables_in_" . $database];
        }
        $this->response($data, 200);
    }

    
    /**
     * @api {get} metadata/column/ Columns
     * @apiName GetColumn
     * @apiGroup METADATA
     *
     * @apiParam {schema} la base de datos
     * @apiParam {table} la tabla de la base de datos     
     *
     * @apiSuccess {String} firstname Firstname of the User.     
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {"columns":["columns1","columns2"]}
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "response": "no existe la base de datos"
     *     }
     */
    
    public function column_get() {
        $database = $this->get("schema", TRUE);
        $table = $this->get("table", TRUE);
        $this->load->model("meta_data");
        
        $this->is_schema($database);
        $this->is_table($database, $table);
                
        $items = $this->meta_data->get_columns($database, $table);
        foreach ($items as $key => $value) {
            $data["columns"][] = $value["Field"];
        }
        $this->response($data, 200);
    }
    
    /**
     * @api {get} metadata/select/ Select
     * @apiName GetSelect
     * @apiGroup QUERY
     *
     * @apiParam {schema} la base de datos
     * @apiParam {table} la tabla de la base de datos
     * @apiParam {where} parametros de busqueda , se tomaran como parametros de busqueda todos los demas parametros de busqueda
     * @apiParam {limit} el limite maximo de resultados de una busqueda
     
     *
     * @apiSuccess {String} firstname Firstname of the User.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "firstname": "John",
     *       "lastname": "Doe"
     *     }
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {"result":[{"data":"value"}]}
     */
    //http://localhost/MiningEnvia/index.php/metadata/select/schema/jmmodulo4/table/usuario/limit/2
    public function select_get() {
        $database = $this->get("schema", TRUE);
        $table = $this->get("table", TRUE);
        $limit = $this->get("limit", TRUE);
        $where = $this->get("where", TRUE);
        $this->load->model("meta_data");

        $this->is_schema($database);
        $this->is_table($database, $table);
        
        $params = $this->get();
        $extras["where"] = $this->filter_where($params);
        if ($limit != false) {
            $data["result"] = $this->meta_data->make_select($database, $table, $extras, $limit);
        } else {
            $data["result"] = $this->meta_data->make_select($database, $table, $extras);
        }
        $this->response($data, 200);
    }

    
    
    /**
     * @api {get} metadata/count/ Count
     * @apiName GetCount
     * @apiGroup QUERY
     *
     * @apiParam {schema} la base de datos
     * @apiParam {table} la tabla de la base de datos
     * @apiParam {where} parametros de busqueda , se tomaran como parametros de busqueda todos los demas parametros de busqueda
     * @apiParam {limit} el limite maximo de resultados de una busqueda
     * 
     * @apiSuccess {String} firstname Firstname of the User.
     *
     * @apiSuccessExample Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "firstname": "John",
     *       "lastname": "Doe"
     *     }
     *
     * @apiError UserNotFound The id of the User was not found.
     *
     * @apiErrorExample Error-Response:
     *     HTTP/1.1 404 Not Found
     *     {
     *       "response": "no existe la base de datos"
     *     }
     */
    //http://localhost/MiningEnvia/index.php/metadata/select/schema/jmmodulo4/table/usuario/limit/2
    public function count_get() {
        $database = $this->get("schema", TRUE);
        $table = $this->get("table", TRUE);
        $limit = $this->get("limit", TRUE);
        $where = $this->get("where", TRUE);
        $this->load->model("meta_data");

        $this->is_schema($database);
        $this->is_table($database, $table);
        $params = $this->get();
        $extras["where"] = $this->filter_where($params);
        if ($limit != false) {
            $data["result"] = $this->meta_data->make_count($database, $table, $extras, $limit);
        } else {
            $data["result"] = $this->meta_data->make_count($database, $table, $extras);
        }
        $this->response($data, 200);
    }
    
    private function is_table($database,$table){
        $this->load->model("meta_data");
        if($this->meta_data->table_exist($database.".".$table)){
            $this->response(array("response" => "no existe la tabla"), 404);
        }
    }
    
    private function is_schema($schema) {
        $this->load->model("meta_data");
        
        if($schema=="information_schema" OR $schema=="performance_schema" OR $schema=="mysql" ){
            $this->response(array("response" => "no existe la base de datos"), 404);
        }
        if (!$this->meta_data->db_exist($schema)) {
            $this->response(array("response" => "no existe la base de datos"), 404);
        }
    }

    private function filter_where($params) {
        foreach ($params as $key => $value) {
            $where = false;
            switch ($key) {

                case "schema":
                    break;
                case "table":
                    break;
                case "limit":
                    break;
                default:
                    $where[$key] = $value;
                    break;
            }
        }
        return $where;
    }

}
