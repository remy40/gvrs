<?php

require 'base.php';

class Custom extends Moderation {

    public function get_users() {
        $query = 'SELECT u.'.$this->row_username.' as username,u.'.$this->row_userid.' as id, COUNT( f.from ) AS no_of_messages,b.user_id as user_id 
                    FROM ' . $this->db_prefix . $this->usertable.' AS u
                    LEFT JOIN frei_chat AS f ON f.from = u.'.$this->row_userid.'
                    LEFT JOIN frei_banned_users AS b ON u.'.$this->row_userid.' = b.user_id
                    GROUP BY u.'.$this->row_userid;


        $query = $this->db->query($query);
        $result = $query->fetchAll();
        return $result;
    }

}

?>
