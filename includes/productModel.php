<?php

class Product extends DBConnection {
	function getAll(){
		$sql = "SELECT * FROM products";
		$result = $this->conn->query($sql);
		while($row = $result->fetch_object())
				$data[$row->product_id] = $row;
		return $data;
	}

	function get($pid){
		$sql = "SELECT * FROM products WHERE product_id = $pid";
		$result = $this->conn->query($sql);
		return $result->fetch_object();
	}

	function add($data){
		$sql = "INSERT INTO products (product_name, product_quantity, product_price, product_description, product_code, product_model, product_brand) VALUES (\"".$data['name']."\", ".$data['quantity'].", ".$data['price'].", \"".$data['description']."\", \"".$data['code']."\", \"".$data['model']."\", \"".$data['brand']."\")";
		$this->conn->query($sql);
	}

	function set($data){
		$sql = "UPDATE products SET product_name = \"".$data['name']."\", product_description = \"".$data['description']."\", product_model = \"".$data['model']."\", product_code = \"".$data['code']."\", product_brand = \"".$data['brand']."\", product_quantity = ".$data['quantity'].", product_price = ".$data['price']." WHERE product_id = ".$data['id'];
		$this->conn->query($sql);
	}

	function delete($pid){
		$sql = "DELETE FROM products WHERE product_id = $pid";
		if(!$this->conn->query($sql)) return;
		return 1;
	}

	function setsub($data){
		$data = (object) $data;
		$sql = "SELECT * FROM subproduct WHERE parent_id = $data->child";
		if($this->conn->query($sql)->num_rows > 0)
			return error("CHILDISPARENT", "Cannot set parent as child");
		$sql = "SELECT * FROM subproduct WHERE parent_id = $data->parent AND child_id = $data->child";
		if($this->conn->query($sql)->num_rows > 0)
			return error("SUBEXISTS", "Set sub already exists");
		$sql = "
			INSERT INTO subproduct (parent_id, child_id) VALUES
			($data->parent, $data->child)
		";
		$this->conn->query($sql);
		return 1;
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

	function unsub($data){
		$data = (object) $data;
		$sql = "DELETE FROM subproduct WHERE parent_id = $data->from AND child_id = $data->unlink";
		$this->conn->query($sql);
	}
}
