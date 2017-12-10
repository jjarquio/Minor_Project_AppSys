<?php
//Edit
class Receipt extends DBConnection {
	function get(){
		$sql = "
			SELECT * FROM sale WHERE sale_id = ".$_GET['id']
		;
		$result = $this->conn->query($sql);
		if($result->num_rows != 1) return;
		$data = $result->fetch_object();
		$sql = "
			SELECT user_name FROM users WHERE user_id = $data->sale_cashier"
		;
		$result = $this->conn->query($sql);
		$result = $result->fetch_object();
		$data->sale_time = date("Y-m-d H:i", strtotime($data->sale_time));
		$data->name = $result->user_name;
		return $data;
	}

	function getname(){
		$sql = "SELECT product_id AS id, product_name AS name FROM products";
		$result = $this->conn->query($sql);
		while($row = $result->fetch_object())
			$data[$row->id] = $row->name;
		return $data;
	}

	function getsub(){
		$sql = "SELECT * FROM subproduct";
		$result = $this->conn->query($sql);
		$data = array();
		while($row = $result->fetch_object()){
			if(isset($data[$row->parent_id]))
				array_push($data[$row->parent_id], $row->child_id);
			else $data[$row->parent_id] = array($row->child_id);
		}
		return $data;
	}

	function items(){
		$id = $_GET['id'];
		$sql = "
            SELECT
            	id,
            	prod_qty AS qty,
            	product_name AS name,
            	prod_price AS price,
            	prod_qty * prod_price AS subtotal
            FROM (
                SELECT product_id AS id, product_name
                FROM products
                ) AS prod 
            JOIN (
                SELECT prod_id, prod_qty, prod_price
                FROM sale_item WHERE sale_id = $id
                ) AS citem
            ON id = prod_id
		";
		$result = $this->conn->query($sql);

		for($x = 0; $row = $result->fetch_object(); ++$x)
			$data[$x] = $row;

		return $data;
	}
}
