<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backup extends CI_Controller {

    private $backup_path = 'db_backups/'; // Path to store backups

    public function __construct() {
        parent::__construct();
        $this->load->database();
		$this->load->helper(array('form', 'url', 'string'));
        $this->load->library('form_validation');
        $this->load->library('session');
    }

    // Function to create database backup
    public function daily_backup() {
        $db_name = $this->db->database;
        $db_user = $this->db->username;
        $db_pass = $this->db->password;
        $db_host = $this->db->hostname;
        $backup_file = $this->backup_path . 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        if (!is_dir($this->backup_path)) {
            mkdir($this->backup_path, 0777, true);
        }
		if ($db_host === 'localhost' || $db_host === '127.0.0.1') {
            $command = "mysqldump --user={$db_user} --host={$db_host} {$db_name} > {$backup_file}";
        } else {
            $command = "mysqldump --user={$db_user} --password={$db_pass} --host={$db_host} {$db_name} > {$backup_file}";
        }
        system($command, $output);
        if (file_exists($backup_file)) {
            $file_size = round(filesize($backup_file) / 1024, 2) . ' KB';
            $this->log_backup($backup_file, $file_size); 
			$this->session->set_flashdata('successmessage', "Backup successful: {$backup_file}\n");
        } else {
            $this->session->set_flashdata('warningmessage', 'Backup failed! Check permissions and MySQL credentials.');
        }
        $this->delete_old_backups();
		redirect('backup');
    }

    // Function to list backups
    public function index() {
        $query = $this->db->get('backup_logs');
        $data['backups'] = $query->result_array();
		$this->template->template_render('backup_list', $data);
    }

	private function delete_old_backups() {
		$files = glob($this->backup_path . 'backup_*.sql');
		$five_days_ago = date('Y-m-d H:i:s', strtotime('-5 days'));
		foreach ($files as $file) {
			if (filemtime($file) < time() - (5 * 24 * 60 * 60)) { 
				unlink($file);
			}
		}
		$this->db->where('backup_date <', $five_days_ago);
		$this->db->delete('backup_logs');
	}
	

    private function log_backup($file_name, $file_size) {
        $data = [
            'file_name' => $file_name,
            'file_size' => $file_size,
            'backup_date' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('backup_logs', $data);
    }
}
