<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Database_comparison {
    protected $CI;

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }
    public function compare_dbs() {
        $sql_file = 'system/libraries/tblstrucutre.sql'; // Make sure file exists here
        if (!file_exists($sql_file)) {
            echo "SQL file not found: $sql_file";
            return;
        }
        // Optional: Increase time limits
        ini_set('max_execution_time', 300); // 5 minutes
        ini_set('memory_limit', '512M');

        $sql_data = file_get_contents($sql_file);

        // Normalize line endings
        $sql_data = str_replace(["\r\n", "\r"], "\n", $sql_data);

        // Remove comments
        $sql_data = preg_replace('/--.*\n/', '', $sql_data);
        $sql_data = preg_replace('/\/\*.*?\*\//s', '', $sql_data); // multiline comments

        // Split queries by semicolon and newline
        $queries = preg_split('/;\s*\n/', $sql_data);

        $success = 0;
        $fail = 0;

        foreach ($queries as $query) {
            $query = trim($query);
            if (empty($query)) continue;

            try {
                $this->CI->db->query($query);
                $success++;
            } catch (Exception $e) {
                $fail++;
                log_message('error', 'SQL Error: ' . $e->getMessage() . ' in query: ' . $query);
            }
        }
        //echo "SQL import complete. Success: $success, Failed: $fail";
    }
}
