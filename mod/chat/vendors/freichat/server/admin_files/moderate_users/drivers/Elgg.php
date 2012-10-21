<?php

require 'base.php';

class Elgg extends Moderation {

    public function get_users() {
        $query = 'SELECT u.username as username,u.guid as id, COUNT( f.from ) AS no_of_messages,b.user_id as user_id 
                    FROM ' . $this->db_prefix . 'users_entity AS u
                    LEFT JOIN frei_chat AS f ON f.from = u.guid
                    LEFT JOIN frei_banned_users AS b ON u.guid = b.user_id
                    GROUP BY u.guid';


        $query = $this->db->query($query);
        $result = $query->fetchAll();
        return $result;
    }

}

?>