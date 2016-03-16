<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of meta_data
 *
 * @author drkidb
 */
class Meta_data extends CI_Model {

    public function __construct() {
        $this->load->database();
        parent::__construct();
    }

    public function get_databases() {
        $this->db->trans_start();
        $query = $this->db->query("SHOW DATABASES");
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_tables($database) {
        $this->db->trans_start();
        $query = $this->db->query("SHOW TABLES FROM " . $database);
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function get_columns($database, $table) {
        $this->db->trans_start();
        $query = $this->db->query("SHOW COLUMNS FROM " . $database . "." . $table);
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function make_select($database, $table, $extras, $limit = 1000) {
        $this->db->trans_start();
        $this->db->limit($limit);

        if ($extras["where"] != FALSE) {
            $this->db->where($extras["where"]);
        }

        $query = $this->db->get($database . "." . $table);
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    public function make_count($database, $table, $extras, $limit = 1000) {
        $this->db->trans_start();
        $this->db->limit($limit);

        if ($extras["where"] != FALSE) {
            $this->db->where($extras["where"]);
        }

        $query = $this->db->get($database . "." . $table);
        $this->db->trans_complete();
        if ($this->db->trans_status() === TRUE) {
            return $query->num_rows();
        } else {
            return false;
        }
    }

    public function db_exist($database) {
        $this->load->dbutil();
        return $this->dbutil->database_exists($database);
    }

    public function table_exist($table) {
        return $this->db->table_exists($table);
    }

}
