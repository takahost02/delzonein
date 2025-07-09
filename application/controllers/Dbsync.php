<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dbsync extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
    }

    public function index() {
        $this->sync_database();
    }

    private function sync_database() {
        $sql_file_path = APPPATH . '../db.sql';  // Adjust path if necessary

        try {
            $sql_content = $this->read_sql_file($sql_file_path);
        } catch (Exception $e) {
            echo $e->getMessage();
            return;
        }

        // Parse SQL file to extract table and column information
        preg_match_all('/CREATE TABLE `(\w+)` \((.+?)\);/s', $sql_content, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $table_name = $match[1];
            $columns_sql = $match[2];

            // Get existing columns from the database
            $existing_columns = $this->get_existing_columns($table_name);
            $existing_columns_map = [];
            foreach ($existing_columns as $col) {
                $existing_columns_map[$col->name] = $col;
            }

            // Parse SQL columns
            preg_match_all('/`(\w+)` (\w+(\(\d+\))?)/', $columns_sql, $columns_matches, PREG_SET_ORDER);

            foreach ($columns_matches as $column_match) {
                $column_name = $column_match[1];
                $column_type = $column_match[2];

                if (!array_key_exists($column_name, $existing_columns_map)) {
                    // Column does not exist, add it
                    $this->dbforge->add_column($table_name, [
                        $column_name => [
                            'type' => $column_type
                        ]
                    ]);
                } else {
                    // Column exists, check if type matches
                    if (strtolower($existing_columns_map[$column_name]->type) !== strtolower($column_type)) {
                        // Column type does not match, modify it
                        $fields = [
                            $column_name => [
                                'name' => $column_name,
                                'type' => $column_type,
                            ],
                        ];
                        $this->dbforge->modify_column($table_name, $fields);
                    }
                }
            }
        }

        echo "Database sync completed.";
    }

    private function read_sql_file($file_path) {
        if (file_exists($file_path)) {
            return file_get_contents($file_path);
        } else {
            throw new Exception("SQL file not found.");
        }
    }

    private function get_existing_columns($table_name) {
        return $this->db->field_data($table_name);
    }
}
