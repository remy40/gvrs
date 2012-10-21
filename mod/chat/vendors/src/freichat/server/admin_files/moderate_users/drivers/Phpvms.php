<?php

require 'base.php';

class Phpvms extends Moderation {

    public function get_users() {
        $query = 'SELECT u.firstname as username,u.pilotid as id, COUNT( f.from ) AS no_of_messages,b.user_id as user_id  
                    FROM ' . $this->db_prefix . 'users AS u
                    LEFT JOIN frei_chat AS f ON f.from = u.pilotid
                    LEFT JOIN frei_banned_users AS b ON u.pilotid = b.user_id
                    GROUP BY u.pilotid';


        $query = $this->db->query($query);
        $result = $query->fetchAll();
        return $result;
    }

}

?>