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
		if(is_file($path)){
			if(unlink($path)){
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
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `category_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `category_list` set {$data} ";
		}else{
			$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['cid'] = $cid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Category successfully saved.";
			else
				$resp['msg'] = " Category successfully updated.";
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `category_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Category successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_class(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `class_list` where `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Class already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `class_list` set {$data} ";
		}else{
			$sql = "UPDATE `class_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$sid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['sid'] = $sid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Class successfully saved.";
			else
				$resp['msg'] = " Class successfully updated.";

				if(!empty($_FILES['img']['tmp_name'])){
					$img_path = "uploads/classs/";
					if(!is_dir(base_app.$img_path)){
						mkdir(base_app.$img_path);
					}
					$accept = array('image/jpeg','image/png');
					if(!in_array($_FILES['img']['type'],$accept)){
						$resp['msg'] += " Image file type is invalid";
					}else{
						if($_FILES['img']['type'] == 'image/jpeg')
							$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
						elseif($_FILES['img']['type'] == 'image/png')
							$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
						if(!$uploadfile){
							$resp['msg'] +=  " Image is invalid";
						}else{
							list($width, $height) =getimagesize($_FILES['img']['tmp_name']);
							if($width > 640 || $height > 480){
								if($width > $height){
									$perc = ($width - 640) / $width;
									$width = 640;
									$height = $height - ($height * $perc);
								}else{
									$perc = ($height - 480) / $height;
									$height = 480;
									$width = $width - ($width * $perc);
								}
							}
							$temp = imagescale($uploadfile,$width,$height);
							$spath = $img_path.'/'.$_FILES['img']['name'];
							$i = 1;
							while(true){
								if(is_file(base_app.$spath)){
									$spath = $img_path.'/'.($i++).'_'.$_FILES['img']['name'];
								}else{
									break;
								}
							}
							if($_FILES['img']['type'] == 'image/jpeg')
							$upload = imagejpeg($temp,base_app.$spath,60);
							elseif($_FILES['img']['type'] == 'image/png')
							$upload = imagepng($temp,base_app.$spath,6);
							if($upload){
								$this->conn->query("UPDATE class_list set image_path = CONCAT('{$spath}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$sid}' ");
							}
	
							imagedestroy($temp);
						}
					}
				}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_class(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `class_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Class successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_product(){
		if(isset($_POST['descrption']))
		$_POST['descrption'] = addslashes(htmlspecialchars($_POST['descrption']));

		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `product_list` where `brand` = '{$brand}' and `name` = '{$name}' and delete_flag = 0 ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Product already exists.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `product_list` set {$data} ";
		}else{
			$sql = "UPDATE `product_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$pid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['pid'] = $pid;
			$resp['status'] = 'success';
			if(empty($id)){
				$resp['msg'] = 'Product has been addedd successfully';
			}else{
				$resp['msg'] = " Product has been updated successfully.";
			}

			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success' && isset($resp['msg']))
		$this->settings->set_flashdata('success', $resp['msg']);
		return json_encode($resp);
	}
	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `product_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_registration(){
		if(empty($_POST['id'])){
			$prefix = date('Ymd');
			$code = sprintf("%'.05d", 1);
			while(true){
				$check = $this->conn->query("SELECT * FROM `registration_list` where code = '{$prefix}{$code}'")->num_rows;
				if($check > 0){
					$code = sprintf("%'.05d",abs($code) + 1);
				}else{
					$_POST['code'] = $prefix.$code;
					break;
				}
			}
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k])){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `registration_list` set {$data} ";
		}else{
			$sql = "UPDATE `registration_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$qid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			$data ="";
			if(empty($id)){
				if(!is_null($this->settings->userdata("id")))
					$resp['msg'] = "Your Registration Request has been sent successfully. We will reach you back for the confirmation of your class registration as soon as we sees your request. Thank you!";
				else
					$resp['msg'] = "Registration Request has been added successfully.";

			}else{
				$resp['msg'] = "Registration Request has been updated successfully.";
			}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success' && isset($resp['msg'])){
			if(!is_null($this->settings->userdata("id")))
				$this->settings->set_flashdata('success_public', $resp['msg']);
			else
				$this->settings->set_flashdata('success', $resp['msg']);
		}

		return json_encode($resp);
	}
	function delete_registration(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `registration_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," registration Request has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_inquiry(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `inquiry_list` set {$data} ";
		}else{
			$sql = "UPDATE `inquiry_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$cid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success'," Your Inquiry has been sent successfully. Thank you!");
			else
				$this->settings->set_flashdata('success'," Inquiry successfully updated");
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_inquiry(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `inquiry_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Inquiry has been deleted successfully.");
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
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_class':
		echo $Master->save_class();
	break;
	case 'delete_class':
		echo $Master->delete_class();
	break;
	case 'save_product':
		echo $Master->save_product();
	break;
	case 'delete_product':
		echo $Master->delete_product();
	break;
	case 'save_registration':
		echo $Master->save_registration();
	break;
	case 'delete_registration':
		echo $Master->delete_registration();
	break;
	case 'save_inquiry':
		echo $Master->save_inquiry();
	break;
	case 'delete_inquiry':
		echo $Master->delete_inquiry();
	break;
	default:
		// echo $sysset->index();
		break;
}