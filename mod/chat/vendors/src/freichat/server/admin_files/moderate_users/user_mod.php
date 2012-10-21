<?php

require '../../../arg.php';

class user_mod extends FreiChat {

    public function __construct() {
        parent::__construct();
        $this->init_vars();
        require 'drivers/' . $this->driver . '.php';
        $this->mod = new $this->driver();
        $this->mod->db_prefix = $this->db_prefix;
        $this->mod->row_username = $this->row_username;
        $this->mod->row_userid = $this->row_userid;
        $this->mod->usertable = $this->usertable;
        $this->mod->db = $this->db;
        // $this->connect_db();
    }

    public function get_data() {
        $users = $this->mod->get_users();
        echo json_encode($users);
    }

    public function ban($id) {
        $query = 'INSERT INTO frei_banned_users (user_id) VALUES(' . $id . ')';
        $this->db->query($query);
    }

    public function unban($id) {
        $query = 'DELETE FROM frei_banned_users WHERE user_id=' . $id;
        $this->db->query($query);
    }

}

if (isset($_REQUEST['mode'])) {

    $mod = new user_mod();

    if ($_REQUEST['mode'] == 'ban') {
        $mod->ban($_POST['id']);
    } else if ($_REQUEST['mode'] == 'unban') {
        $mod->unban($_POST['id']);
    } else if ($_REQUEST['mode'] == 'get_data') {
        $mod->get_data();
    }
}