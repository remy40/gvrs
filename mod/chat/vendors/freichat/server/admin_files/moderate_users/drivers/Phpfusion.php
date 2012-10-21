<?php

require 'base.php';

class Phpfusion extends Moderation {

    public function get_users() {
        $query = 'SELECT u.user_name as username,u.user_id as id, COUNT( f.from ) AS no_of_messages,b.user_id as user_id 
                    FROM ' . $this->db_prefix . 'users AS u
                    LEFT JOIN frei_chat AS f ON f.from = u.user_id
                    LEFT JOIN frei_banned_users AS b ON u.user_id = b.user_id
                    GROUP BY u.user_id';


        $query = $this->db->query($query);
        $result = $query->fetchAll();
        return $result;
    }

}

?>