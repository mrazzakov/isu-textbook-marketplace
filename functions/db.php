<?php 

$con = mysqli_connect('localhost', 'root', '', 'ISU_TB_MP');

function row_count($result){


	return mysqli_num_rows($result);
}

function escape($string){
	global $con;

	return mysqli_real_escape_string($con, $string);

}

function query($query) {

	global $con;

	$result = mysqli_query($con, $query);

	confirm($result);

	return $result;


}

function confirm($result) {
	global $con;

	if(!$result){
		die("Query Failed".mysqli_error($con));


	}


}

function fetch_array($result){
	global $con;

	return mysqli_fetch_array($result);


}

function fetch_assoc($result){
	global $con;

	return mysqli_fetch_assoc($result);


}

function get_id() {
	global $con;

	return mysqli_insert_id($con);
}

?>
