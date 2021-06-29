<?php
# global variables
$template_file = "delFORM.tpl";
$page_content = "";
$action = "none";
$error = "";
$errors = array (
	'template' => "template reading error !",
	'db_connect' => "db connect error !",
	'db_read_data' => "buyer's email does not exist !",
	'db_read_data_visitor' => "unknown buyer !",
	'empty_cnumber' => "invalid buyer's number !",
	'no_cnumber' => "wrong buyer number !",
	);

# =======================
# main
read_template();
if(!empty($_POST)) {
	if (isset($_POST['search_acq'])) {
		$action = "search";
	}

	if (isset($_POST['delete_acq'])) {
		$action = "delete";	
		delete_db_data();
	}
	
	if (isset($_POST['cancel_acq'])) {
		$action = "none";
	}
}
set_vars();
show_page();
# =======================
# function read template
function read_template() {
	global $template_file, $page_content, $action, $error, $errors;
	$page_content = file_get_contents($template_file);
	if (!$page_content)
		$error = $errors['template'];
}
# =======================
# function read clients
function read_db_client($cnumber) {
	global $error, $errors;
	$dbh = pg_connect("host=localhost port=5432 dbname=ovya_recrutement user=postgres password=makasy81");
	if(!$dbh) {
		$error = $errors['db_connect'];
		return($error);
	} 
	$sql = "select * from acq where email = '$cnumber'";
	$res = pg_query($dbh, $sql);
	$row = pg_fetch_assoc($res);
	if(!$row) {
		$error = $errors['db_read_data'];
		return($error);
	} 
	pg_close($dbh);
	return($row);
}
# =======================
# function show_page
function show_page() {
	global $page_content;
	echo $page_content;
	exit(1);
}
# =======================
# function check_data
function check_data(){
	global $error, $errors;
	if (empty($_POST['vEmail_select'])){
		$error = $errors['empty_cnumber']; return($error);
	}
}
# =======================
# function delete_db_data
function delete_db_data(){
	global $error, $errors;
	$dbh = pg_connect("host=localhost port=5432 dbname=ovya_recrutement user=postgres password=makasy81");
	if(!$dbh) {
		$error = $errors['db_connect'];
		return($error);
	} 
	$buyer = $_POST['vEmail_select'];
	
	$sql1 = "select id from acq where  email = '$buyer'";
	$res1 = pg_query($dbh,$sql1); 
	$row_acq = pg_fetch_assoc($res1);
	if(!$row_acq) {
		$error = $errors['db_read_data_visitor'];
		return($error);
		exit();
	}
	$acq_id = $row_acq['id'];
	
	$sql1 = "DELETE FROM visite WHERE acq_id = $acq_id";
	$sql2 = "DELETE FROM acq WHERE id = $acq_id";
	
	$res1 = pg_query($dbh,$sql1);
	$res2 = pg_query($dbh,$sql2);
	
	$message = 'buyer deleted :  ' . $buyer . '   with id: ' . $acq_id ;
	set_var('error',$message);
	
return;

}
# =======================
# function set variables
function set_vars() {
	global $error, $action;
	check_data();
	if (!empty($error)) {
			set_var('error',$error);
			return;
	}
	
	$client_id = $_POST['vEmail_select'];
	$client_data = read_db_client($client_id);
	set_var('visitor', $client_id);
	switch($action) {
		case 'none';
		case 'search';
		    if (!empty($error)) {
				set_var('error',$error);
				break;
			} else set_var('error',"done");
			set_var('vEmail',$client_id);
			set_var('vname', $client_data['nom']);
			set_var('vid', $client_data['id']);
		case 'delete';
		    if (!empty($error)) {
				set_var('error',$error);
				break;
			} else set_var('error',"done");
			set_var('vEmail',$client_id);
			set_var('vname', $client_data['nom']);
			set_var('vid', $client_data['id']);
	}
}
# =======================
# function set variable
function set_var($name, $value) {
	global $page_content;
	$search = "[%".$name."%]";
	$page_content = str_replace($search, $value, $page_content);
}
?>

	

