<?php

class DBConnection {
    protected $conn;
    
    function DBConnection(){
        $this->conn = new mysqli('localhost', 'root', '', 'rassi_pos');
    }
    
    function close(){
        $this->conn->close();
    }
    
    function isConnected(){
        return $this->conn;
    }
    
    function verify($data){
        $sql = "SELECT user_id, passcode FROM users WHERE user_id = ".$data['userid']." AND passcode = '".$data['passcode']."'";
        $result = $this->conn->query($sql);
        if(!$result) return;
        if($result->num_rows != 1) return;
        return $result->fetch_object();
    }
}

?>
