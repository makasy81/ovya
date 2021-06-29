<?php
# global variables
$template_file = "vFORM.tpl";
$page_content = "";
$action = "none";
$error = "";
$errors = array (
	'template' => "template reading error !",
	'db_connect' => "db connect error !",
	'db_read_data' => "client number does not exist !",
	'db_read_data_visitor' => "unknown visitor !",
	'empty_cnumber' => "invalid client number !",
	'no_cnumber' => "wrong client number !",
	);

# =======================
# main
read_template();
if(!empty($_POST)) {
	if (isset($_POST['search'])) {
		$action = "search";
	}

	if (isset($_POST['createVisit'])) {
		$action = "insert";	
		$dossier = insert_db_data();
	}
	
	if (isset($_POST['cancelVisit'])) {
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
	$sql = "select * from ccial where id = $cnumber";
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
	if (empty($_POST['cnumber_select'])){
		$error = $errors['empty_cnumber']; return($error);
	}
}
# =======================
# function insert_db_data
function insert_db_data(){
	global $error, $errors;
	$dbh = pg_connect("host=localhost port=5432 dbname=ovya_recrutement user=postgres password=makasy81");
	if(!$dbh) {
		$error = $errors['db_connect'];
		return($error);
	} 
	$client = $_POST['cnumber_select'];
	
	$date = $_POST['date'];
	$timeStart = $_POST['start-time'];
	$timeEnd = $_POST['start-time'];
	$vmail = $_POST['visitorMail'];
	$sql3 = "select id from acq where  email = '$vmail'";
	$res3 = pg_query($dbh,$sql3); 
	$row_acq = pg_fetch_assoc($res3);
	if(!$row_acq) {
		$error = $errors['db_read_data_visitor'];
		return($error);
		exit();
	}
	$acq_id = $row_acq['id'];
	
	$startDate = $date . ' ' . $timeStart . ':00';
	$endDate = $date . ' ' . $timeEnd . ':00';
	
	
	$sql1 = "INSERT INTO dossier (date_insert, ccial_id) VALUES (NOW(), $client)";
	$sql2 = "select id from dossier where ccial_id = $client ORDER BY date_insert DESC limit 1";
    
	$res1 = pg_query($dbh,$sql1);
	$res2 = pg_query($dbh,$sql2);
	$row_dossier = pg_fetch_assoc($res2);
	$dossier_id = $row_dossier['id'];
	set_var('dossier',$dossier_id);
		
	$sql4 = "INSERT INTO visite (date_start, date_end, acq_id, ccial_id, dossier_id, canceled) VALUES ('$startDate', '$endDate', $acq_id, $client, $dossier_id, false)";
    $res4 = pg_query($sql4);	
	
	$message = 'visit created : from: ' . $startDate . ' to: ' . $endDate . ' visitor id: ' . $acq_id . ' client id: ' . $client . ' dossier id: ' . $dossier_id ;
	set_var('error',$message);
	
	pg_close($dbh);
	return;
}
# =======================
# function delete_db_data
function delete_db_data(){
	global $error, $errors;
	$dbh = "do_nothing";
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
	
	$client_id = $_POST['cnumber_select'];
	$client_data = read_db_client($client_id);
	set_var('cnumber', $client_id);
	switch($action) {
		case 'none';
		case 'search';
		    if (!empty($error)) {
				set_var('error',$error);
				break;
			} else set_var('error',"done");
			set_var('crow', $client_data['nom']);
			set_var('cname', $client_data['nom']);
			set_var('cmail', $client_data['email']);
		case 'insert';
		    if (!empty($error)) {
				set_var('error',$error);
				break;
			} else set_var('error',"done");
			set_var('crow', $client_data['nom']);
			set_var('cname', $client_data['nom']);
			set_var('cmail', $client_data['email']);
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

	

