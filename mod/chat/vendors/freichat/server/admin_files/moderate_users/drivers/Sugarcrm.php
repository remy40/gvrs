<?php

require 'base.php';

class Sugarcrm extends Moderation {

    public function get_users() {
        $query = 'SELECT u.user_name as username,u.id as id, COUNT( f.from ) AS no_of_messages,b.user_id as user_id 
                    FROM ' . $this->db_prefix . 'users AS u
                    LEFT JOIN frei_chat AS f ON f.from = u.id
                    LEFT JOIN frei_banned_users AS b ON u.id = b.user_id
                    GROUP BY u.id';


        $query = $this->db->query($query);
        $result = $query->fetchAll();
        return $result;
    }

}

?>