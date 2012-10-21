<?php

require 'base.php';

class WordPress extends Moderation {

    public function get_users() {
        $query = 'SELECT u.user_login as username,u.ID as id, COUNT( f.from ) AS no_of_messages,b.user_id as user_id 
                    FROM ' . $this->db_prefix . 'users AS u
                    LEFT JOIN frei_chat AS f ON f.from = u.ID
                    LEFT JOIN frei_banned_users AS b ON u.ID = b.user_id
                    GROUP BY u.ID';


        $query = $this->db->query($query);
        $result = $query->fetchAll();
        return $result;
    }

}

?>