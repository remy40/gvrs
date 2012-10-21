<?php

require 'base.php';

class Drupal extends Moderation {

    public function get_users() {
        $query = 'SELECT u.name as username,u.uid as id, COUNT( f.from ) AS no_of_messages,b.user_id as user_id 
                    FROM ' . $this->db_prefix . 'users AS u
                    LEFT JOIN frei_chat AS f ON f.from = u.uid
                    LEFT JOIN frei_banned_users AS b ON u.uid = b.user_id
                    GROUP BY u.uid';


        $query = $this->db->query($query);
        $result = $query->fetchAll();
        return $result;
    }

}

?>