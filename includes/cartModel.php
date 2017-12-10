<?php

class Cart extends DBConnection {
    function pay($data){
        $id = $_COOKIE['datas'];
        $time = date("Y-m-d H:i:s");
        $sql = "
            INSERT INTO sale (sale_cashier, sale_cash, sale_time) VALUES
            ($id, $data->cash, '$time');
        ";
        $this->conn->query($sql);
        $last_id = $this->conn->insert_id;
        $sql = "
            SELECT id, name, qty, price, code, model, brand
            FROM (
                SELECT product_id AS id, product_name AS name, product_price AS price, product_code AS code, product_model AS model, product_brand AS brand
                FROM products)
                AS p
            JOIN (
                SELECT cprod_id AS cid, cprod_qty AS qty
                FROM cart)
                AS c
            ON id = cid
        ";
        $result = $this->conn->query($sql);
        $data = array();
        for($x = 0; $row = $result->fetch_object(); ++$x) $data[$x] = $row;
        $sql = "INSERT INTO sale_item (sale_id, prod_id, prod_qty, prod_price) VALUES";

        $x = 0;
        foreach($data as $row){
            if($x) $sql .= ",\n";
            else ++$x;
            $sql .= "($last_id, $row->id, $row->qty, $row->price, $row->code, $row->model, $row->brand)";

            // Automated reduction of items sold in the products
            $sql2 = "UPDATE products SET product_quantity = product_quantity - $row->qty WHERE product_id = $row->id";
            $this->conn->query($sql2);
        }
        $this->conn->query($sql);
        $sql = "DELETE FROM cart";
        $this->conn->query($sql);
        return $last_id;
    }

    function total(){
        return $this->conn->query("
            SELECT SUM(subtotal) AS total
            FROM (
                SELECT price * qty AS subtotal
                FROM (
                    SELECT product_id AS id, product_name, product_price AS price, product_code AS code, product_model AS model, product_brand AS brand
                    FROM products)
                    AS prod 
                JOIN (
                    SELECT cprod_id AS cid, cprod_qty AS qty
                    FROM cart)
                    AS c
                ON id = cid) AS s
            GROUP BY NULL
        ")->fetch_object()->total;
    }

    function get(){
        $sql = "
            SELECT id, name, price, qty, price * qty AS subtotal
            FROM (
                SELECT product_id AS pid, product_name AS name, product_price AS price, product_code AS code, product_model AS model, product_brand AS brand
                FROM products) AS p
            JOIN (
                SELECT cprod_id AS id, cprod_qty AS qty FROM cart) AS c
            ON pid = id
        ";
        $result = $this->conn->query($sql);
        $data = array();
        for($x = 0; $row = $result->fetch_object(); ++$x)
            $data[$x] = $row;
        return $data;
    }

    function add($data){
        $sql = "SELECT * FROM cart WHERE cprod_id = $data->id";
        $result = $this->conn->query($sql);
        if($result->num_rows == 0){
            $sql = "
                INSERT INTO cart
                (cprod_id, cprod_qty)
                VALUES
                ($data->id, $data->quantity)
            ";
            $this->conn->query($sql);
        }else{
            $result = $result->fetch_object()->cprod_qty;
            if($result + $data->quantity > $data->stockqty) return;
            $sql = "
                UPDATE cart
                SET cprod_qty = cprod_qty + $data->quantity
                WHERE cprod_id = $data->id
            ";
            $this->conn->query($sql);
        }
        return 1;
    }

    function isManager($user){
        $sql = "SELECT user_type FROM users WHERE user_id = $user";
        $result = $this->conn->query($sql);
        if($result->num_rows != 1) return;
        $result = $result->fetch_object();
        if($result->user_type != 0) return;
        return 1;
    }

    function isInputtedManager($data){
        if(!isset($data['id']) || !isset($data['passcode'])) return;
        if($data['id'] == '' || $data['passcode'] == '') return;
        $data = (object) $data;
        $sql = "SELECT user_type FROM users WHERE user_id = $data->id AND passcode = '$data->passcode'";
        $result = $this->conn->query($sql);
        if($result->num_rows != 1) return;
        $result = $result->fetch_object();
        if($result->user_type != 0) return;
        return 1;
    }

    function void($data){
        $data = (object) $data;
        $sql = "DELETE FROM cart WHERE cprod_id IN ($data->item)";
        $this->conn->query($sql);
    }
}
