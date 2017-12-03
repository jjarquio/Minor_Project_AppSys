<?php

class Users extends DBConnection {
    function getUsers(){
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        for($x = 0; $row = $result->fetch_object(); $x++)
            $data[$x] = $row;
        return $data;
    }
    function getUser($uid){
        $sql = "SELECT user_name, user_type FROM users WHERE user_id = $uid";
        $result = $this->conn->query($sql);
        return $result->fetch_object();
    }

    function setUser($data){
        $sql = "UPDATE users SET ";
        $x = 0;
        if(isset($data['name'])){
            if($x == 0) ++$x;
            $sql .= "user_name = \"".$data['name']."\"";
        }
        if(isset($data['passcode'])){
            if($x) $sql .= ',';
            if($x == 0) ++$x;
            $sql .= "passcode = \"".$data['passcode']."\"";
        }
        if(isset($data['type'])){
            if($x) $sql .= ',';
            if($x == 0) ++$x;
            $sql .= "user_type = ".$data['type'];
        }
        $sql .= " WHERE user_id = ".$data['id'];
        $this->conn->query($sql);
    }

    function add($data){
        $sql = "INSERT INTO users 
        (user_name, passcode, user_type) values
        (\"".$data['name']."\", \"".$data['passcode']."\", ".$data['type'].")";
        $this->conn->query($sql);
    }

    function delete($uid){
        $sql = "DELETE FROM users WHERE user_id = $uid";
        $this->conn->query($sql);
    }
}

?>

