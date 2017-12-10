<?php

class Sales extends DBConnection {
    function report(){
        $between = (object) $_GET;
        $sql = "
            SELECT
                s.sale_id AS id,
                sale_time AS time,
                user_name AS name,
                sale
            FROM (
                SELECT *
                FROM sale
                ) AS s
            JOIN (
                SELECT user_id, user_name
                FROM users
                ) AS u
            ON s.sale_cashier = u.user_id
            JOIN (
                SELECT 
                    sale_id,
                    SUM(prod_qty * prod_price) AS sale
                FROM sale_item
                GROUP BY sale_id
                ) AS si
            ON s.sale_id = si.sale_id
            WHERE sale_time BETWEEN '$between->from' AND '$between->to'
            ORDER BY sale_time
        ";
        $result = $this->conn->query($sql);
        for($x = 0; $row = $result->fetch_object(); $x++)
            $data[$x] = $row;
        return $data;
    }

    function get($orderby){
        $sql = "
            SELECT
                s.sale_id AS id,
                sale_time AS time,
                user_name AS name,
                sale
            FROM (
                SELECT *
                FROM sale
                ) AS s
            JOIN (
                SELECT user_id, user_name
                FROM users
                ) AS u
            ON s.sale_cashier = u.user_id
            JOIN (
                SELECT 
                    sale_id,
                    SUM(prod_qty * prod_price) AS sale
                FROM sale_item
                GROUP BY sale_id
                ) AS si
            ON s.sale_id = si.sale_id
            ORDER BY $orderby
        ";
        $result = $this->conn->query($sql);
        echo $this->conn->error;
        for($x = 0; $row = $result->fetch_object(); $x++)
            $data[$x] = $row;
        return $data;
    }
}
