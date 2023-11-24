<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file(base_app.$path)){
			if(unlink(base_app.$path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_manufacturer(){
		try {
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				if($k !== 'manufacturerID' && $k !== 'manufacturerID'){
					if(!empty($data)) $data .=",";
					$v = htmlspecialchars($this->conn->real_escape_string($v));
					$data .= " `{$k}`='{$v}' ";
				}
			}
			$check = $this->conn->query("SELECT * FROM `manufacturers` where `manufacturerName` = '{$manufacturerName}' and manufacturerID != '{$manufacturerID}' and delete_flag = 0")->num_rows;
			if($this->capture_err())
				return $this->capture_err();
			if($check > 0){
				$resp['status'] = 'failed';
				$resp['msg'] = "Manufacturer already exists.";
				return json_encode($resp);
				exit;
			}
			if(empty($manufacturerID)){
				$sql = "INSERT INTO `manufacturers` set {$data} ";
			}else{
				$sql = "UPDATE `manufacturers` set {$data} where manufacturerID = '{$manufacturerID}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$cid = !empty($manufacturerID) ? $manufacturerID : $this->conn->insert_id;
				$resp['cid'] = $cid;
				$resp['status'] = 'success';
				if(empty($manufacturerID))
					$resp['msg'] = "New Manufacturer successfully saved.";
				else
					$resp['msg'] = " Manufacturer successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
			return json_encode($resp);
		} catch (Exception $e) {
			$resp['status'] = 'failed';
			$resp['err'] = $e->getMessage();
			return json_encode($resp);
		}
	}
	function delete_manufacturer(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `manufacturers` set `delete_flag` = 1 where manufacturerID = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Manufacturer successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_type(){
		try {
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				if($k !== 'carTypeID' && $k !== 'carTypeID'){
					if(!empty($data)) $data .=",";
					$v = htmlspecialchars($this->conn->real_escape_string($v));
					$data .= " `{$k}`='{$v}' ";
				}
			}
			$check = $this->conn->query("SELECT * FROM `carType` where `carTypeName` = '{$carTypeName}' and delete_flag = 0 ".(!empty($carTypeID) ? " and carTypeID != {$carTypeID} " : "")." ")->num_rows;
			if($this->capture_err())
				return $this->capture_err();
			if($check > 0){
				$resp['status'] = 'failed';
				$resp['msg'] = "Car Type already exists.";
				return json_encode($resp);
				exit;
			}
			if(empty($carTypeID)){
				$sql = "INSERT INTO `carType` set {$data} ";
			}else{
				$sql = "UPDATE `carType` set {$data} where carTypeID = '{$carTypeID}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$fid = !empty($carTypeID) ? $carTypeID : $this->conn->insert_id;
				$resp['fid'] = $fid;
				$resp['status'] = 'success';
				if(empty($id))
					$resp['msg'] = "New Car Type successfully saved.";
				else
					$resp['msg'] = " Car Type successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
			return json_encode($resp);
		} catch (Exception $e) {
			$resp['status'] = 'failed';
			$resp['err'] = $e->getMessage();
			return json_encode($resp);
		}
	}
	function delete_type(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `carType` set `delete_flag` = 1 where carTypeID = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Car Type successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_model(){
		try {
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				if($k !== 'modelID' && $k !== 'modelID'){
					if(!empty($data)) $data .=",";
					$v = htmlspecialchars($this->conn->real_escape_string($v));
					$data .= " `{$k}`='{$v}' ";
				}
			}
			$model = htmlspecialchars($this->conn->real_escape_string($model));
			$check = $this->conn->query("SELECT * FROM `carModel` where `model` = '{$model}' and manufacturerID = '{$manufacturerID}' and carTypeID = '{$carTypeID}' and delete_flag = 0 ".(!empty($modelID) ? " and modelID != {$modelID} " : "")." ")->num_rows;
			if($this->capture_err())
				return $this->capture_err();
			if($check > 0){
				$resp['status'] = 'failed';
				$resp['msg'] = "Model already exists.";
				return json_encode($resp);
				exit;
			}
			if(empty($modelID)){
				$sql = "INSERT INTO `carModel` set {$data} ";
			}else{
				$sql = "UPDATE `carModel` set {$data} where modelID = '{$modelID}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$pid = !empty($modelID) ? $modelID : $this->conn->insert_id;
				$resp['pid'] = $pid;
				$resp['status'] = 'success';
				if(empty($modelID))
					$resp['msg'] = "New Model successfully saved.";
				else
					$resp['msg'] = " Model successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
			if($resp['status'] == 'success')
				$this->settings->set_flashdata('success',$resp['msg']);
				return json_encode($resp);
		} catch (Exception $e) {
			$resp['status'] = 'failed';
			$resp['err'] = $e->getMessage();
			return json_encode($resp);
		}
	}
	function delete_model(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `carModel` set `delete_flag` = 1 where modelID = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Model successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function save_vehicle(){
		try {
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				if($k !== 'inventoryID' && $k !== 'inventoryID'){
					if(!empty($data)) $data .=",";
					$v = htmlspecialchars($this->conn->real_escape_string($v));
					$data .= " `{$k}`='{$v}' ";
				}
			}
	
			if(empty($inventoryID)){
				$sql = "INSERT INTO `inventory` set {$data} ";
			}else{
				$sql = "UPDATE `inventory` set {$data} where inventoryID = '{$inventoryID}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$vid = !empty($inventoryID) ? $inventoryID : $this->conn->insert_id;
				$resp['vid'] = $vid;
				$resp['status'] = 'success';
				if(empty($inventoryID))
					$resp['msg'] = "New Vehicle successfully saved.";
				else
					$resp['msg'] = " Vehicle successfully updated.";
			}else{
				$resp['status'] = 'failed';
				$resp['msg'] = $this->conn->error;
				$resp['sql'] = $sql;
			}
	
			return json_encode($resp);
		} catch (Exception $e) {
			$resp['status'] = 'failed';
			$resp['err'] = $e->getMessage();
			return json_encode($resp);
		}
	}
	function delete_vehicle(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `inventory` where inventoryID = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Vehicle successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_transaction(){
		try {
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				if(!in_array($k, array('id'))){
					if(!empty($data)) $data .=",";
					$v = htmlspecialchars($this->conn->real_escape_string($v));
					$data .= " `{$k}`='{$v}' ";
				}
			}
			if(empty($id)){
				$sql = "INSERT INTO `transaction_list` set {$data} ";
			}else{
				$sql = "UPDATE `transaction_list` set {$data} where id = '{$id}' ";
			}
			$save = $this->conn->query($sql);
			if($save){
				$tid = !empty($id) ? $id : $this->conn->insert_id;
				$resp['tid'] = $tid;
				$resp['status'] = 'success';
				if(empty($id))
					$this->settings->set_flashdata('success'," Transaction has been saved successfully.");
				else
					$this->settings->set_flashdata('success'," Transaction successfully updated");
				$this->conn->query("UPDATE `inventory` set `status` = 1 where inventoryID = '{$vehicle_id}'");
				
			}else{
				$resp['status'] = 'failed';
				$resp['err'] = $this->conn->error."[{$sql}]";
			}
			return json_encode($resp);
		} catch (Exception $e) {
			$resp['status'] = 'failed';
			$resp['err'] = $e->getMessage();
			return json_encode($resp);
		}
	}
	function delete_transaction(){
		extract($_POST);
		$get = $this->conn->query("SELECT vehicle_id FROM `transaction_list` where id = '{$id}' ");
		$del = $this->conn->query("DELETE FROM `transaction_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Transaction has been deleted successfully.");
			if($get->num_rows > 0){
				$vehicle_id = $get->fetch_array()[0];
				$this->conn->query("UPDATE `inventory` set `status` = 0 where inventoryID = '{$vehicle_id}'");
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_manufacturer':
		echo $Master->save_manufacturer();
	break;
	case 'delete_manufacturer':
		echo $Master->delete_manufacturer();
	break;
	case 'save_type':
		echo $Master->save_type();
	break;
	case 'delete_type':
		echo $Master->delete_type();
	break;
	case 'save_model':
		echo $Master->save_model();
	break;
	case 'delete_model':
		echo $Master->delete_model();
	break;
	case 'save_vehicle':
		echo $Master->save_vehicle();
	break;
	case 'delete_vehicle':
		echo $Master->delete_vehicle();
	break;
	case 'save_transaction':
		echo $Master->save_transaction();
	break;
	case 'delete_transaction':
		echo $Master->delete_transaction();
	break;
	default:
		// echo $sysset->index();
		break;
}