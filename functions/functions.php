<?php  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require './vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require './vendor/PHPMailer/PHPMailer/src/SMTP.php';
require './vendor/PHPMailer/PHPMailer/src/Exception.php';

//Load Composer's autoloader






//************Reusable functions*******************//
function clean($string){

	return htmlentities($string);


}


function redirect(){

	return header("Location : {$location}");
}


function set_message($message){

	if(!empty($message)){

		$_SESSION['message'] = $message;


	}else{

		$message = "";
	}


}

function display_message(){


	if(isset($_SESSION['message'])){

		echo $_SESSION['message'];


		unset($_SESSION['message']);
	}
}



function token_generator(){

	$token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));

	return $token;
}

function validation_errors($error_message){
$error_message = <<<DELIMITER


<div class="alert alert-danger alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	<strong>Warning!</strong> $error_message
</div>
DELIMITER;

return $error_message;

}

function email_exists($email){

	$sql = "SELECT userid FROM users WHERE email = '$email'";

	$result = query($sql);

	if(row_count($result) == 1){
		return true;
	}else{
		return false;
	}
}

function username_exists($username){

	$sql = "SELECT userid FROM users WHERE username = '$username'";

	$result = query($sql);

	if(row_count($result) == 1){
		return true;
	}else{
		return false;
	}
}

function send_email($email, $subject, $msg, $headers){


	// $mail = new PHPMailer();

	// $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    // $mail->isSMTP();                                      // Set mailer to use SMTP
    // $mail->Host = 'smtp.gmail.com';                      // Specify main and backup SMTP servers
    // $mail->Username = 'textbooisu@gmail.com';                 // SMTP username
    // $mail->Password = 'Test-123';                           // SMTP password
    // $mail->Port = 587; 
    // $mail->Mailer = 'smtp';
    // $mail->SMTPAuth = true;                               // Enable SMTP authentication  
    // $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    // $mail->SMTPOptions = array(
    //     'ssl' => array(
    //         'verify_peer' => false,
    //         'verify_peer_name' => false,
    //         'allow_self_signed' => true
    //     )
    // );


    // $mail->setFrom('textbooisu@gmail.com', 'ISU Textbook Marketplace');
    // $mail->isHTML(true);
    // $mail->addAddress($email); 

    // $mail->Subject = 'Here is the subject';
    // $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

 
   
    // if(!$mail->send()){

    // 	echo 'Message could not be sent. ';
    //     echo 'Mailer Error: ' . $mail->ErrorInfo;
		   
	// 	} else {
	// 	     echo 'Message has been sent';
	// 	}




	return mail($email, $subject, $msg, $headers);



	}




/*****************Validation Register User Functions **********************************/


function validate_user_registration(){

	$min = 3;
	$max = 20;
	$email_domain = '@ilstu.edu';
	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$first_name           = clean($_POST['first_name']);
		$last_name            = clean($_POST['last_name']);
		$username             = clean($_POST['username']);
		$email                = clean($_POST['email']);
		$password             = clean($_POST['password']);
		$confirm_password     = clean($_POST['confirm_password']);
	
	    if(strlen($first_name) < $min){

	    	$errors[] = "Your first name is too short, it must be at least {$min} characters";
	    }

 		if(strlen($last_name) < $min){

	    	$errors[] = "Your last name is too short, it must be at least {$min} characters";
	    }

	    if(strlen($username) < $min){

	    	$errors[] = "Your username is too short, it must be at least {$min} characters";
	    }

	    if(strlen($first_name) > $max){

	    	$errors[] = "Your first name is too long, it must be at least {$max} characters";
	    }

	    if(strlen($username) > $max){

	    	$errors[] = "Your username is too long, it must be at least {$max} characters";
	    }

 		if(strlen($last_name) >  $max){

	    	$errors[] = "Your last name is too long, it must be at least {$max} characters";
	    }

	    if(empty($first_name)){

	    	$errors[] = "Your first name cannot be empty";
	    }
	    if (strpos($email, '@ilstu.edu') == false) {
   			 $errors[] = "Sorry, You must be a current ISU student with a vaild email address.";
		}

		if ($password !== $confirm_password) {
   			 $errors[] = "Your passwords did not match.";
		}

		if(email_exists($email)){

			$errors[] = "Sorry, that email is already registered.";
		}

		if(username_exists($username)){

			$errors[] = "Sorry, that username is already registered.";
		}

	    if(!empty($errors)){

	    	foreach ($errors as $error) {
	    	echo validation_errors($error);

	    	}

	    }else{

        	if(register_user($first_name, $last_name, $username, $email, $password)){

  				set_message("<p class='bg-success text-center'>Check your email for activation link.</p>");
        		header("Location: index.php");
        		
				
        	}
        }


	}//post


}


/******************Register  User Functions**************************************************/
function register_user($first_name, $last_name, $username, $email, $password){
    /*******Escape Data**********/

    $first_name = escape($first_name);
    $last_name  = escape($last_name);
    $username   = escape($username);
    $email      = escape($email);
    $password   = escape($password);




		if(email_exists($email)){
			return false;
		} else if (username_exists($username)){
			return false;
		}else {

			$password = md5($password);

			$validation_code = md5($username . microtime());

			$sql = "INSERT INTO users(first_name, last_name, username, email, password, validation_code, active)";
			$sql.= "VALUES('$first_name','$last_name','$username','$email','$password','$validation_code', 0)";

			$result = query($sql);
			

			$subject = "Activate Account";

			$msg = " Click link below to activate Account

			http://localhost/isu_tb_mp/activate.php?email=$email&code=$validation_code

			";
  
  			$headers = "From: nonrepy@ISU_Textbook_Marketplace.com";
			send_email($email, $subject, $msg, $headers);

			return true;
			
			
		}
}


/************************Activate User Functions ************************************/


function activate_user(){


	if($_SERVER['REQUEST_METHOD'] == "GET"){


		if(isset($_GET['email'])){

		   $email = clean($_GET['email']);
		   $validation_code = clean($_GET['code']);

      $sql = "SELECT userid FROM users WHERE email = '".escape($_GET['email'])."' AND validation_code = '".escape($_GET['code'])."' ";
		   $result = query($sql);

		   

		   if(row_count($result) == 1){

        $sql2 = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '".escape($email)."'  AND validation_code = '".escape($validation_code)."'";
		   	 $result2 = query($sql2);
		   	 confirm($result2);

		     set_message("<p class='bg-success'>Account is activated. You can now login.</p>");

		     header("Location: login.php");
			}else{
				set_message("<p class='bg-danger text-center'>Sorry, your account could not be activated.</p>");

		        header("Location: login.php");

			}
		}
	}
}//END ACTIVATE USER


/************************Validate User Login Functions ************************************/
function validate_user_login(){
    $errors = [];
	$min = 3;
	$max = 20;
	$email_domain = '@ilstu.edu';

	

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		

		$email                = clean($_POST['email']);
		$password             = clean($_POST['password']);
		$remember			  = isset($_POST['remember']);



		if(empty($email)){
		$errors[] = "Email field is empty.";
		}


		if(empty($password)){
			$errors[] = "Password field is empty.";
		}

		if(!empty($errors)){

		    	foreach ($errors as $error) {
		    	echo validation_errors($error);

		    	}

		    }else{

		    	if(login_user($email, $password, $remember)){

		    		header("Location: create.php");
		    	}else{
		    		echo validation_errors("Your Login is not correct. Please contact an Admin to see if you have been banned, or reset password");
		    	}


	    }
		

     }
	
		    	

}//Function

/************************Login User Functions ************************************/

	function login_user($email, $password, $remember){

		$sql = "SELECT password, userid FROM users WHERE email = '".escape($email)."' AND active = 1 AND strike < 3" ;

		$result = query($sql);

		

		if(row_count($result) == 1){

			$row = fetch_array($result);

			$db_password = $row['password'];

			if(md5($password) === $db_password){

				if($remember == "on"){

					setcookie('email', $email, time() + 86400);
				}

				$_SESSION['email'] = $email;

				return true;

			}else{

				return false;
			}
				




				return true;
			}else{

				return false;
			}


			


	}


function logged_in(){

	if(isset($_SESSION['email']) || isset($_COOKIE['email'])){

		return true;

	}else{
		return false;
	}
}

function is_admin() {
	$email = "";

	if(isset($_SESSION['email'])) {
		$email = $_SESSION['email'];
	} 
	else if(isset($_COOKIE['email'])){
		$email = $_COOKIE['email'];
	}

	$sql = "SELECT admin FROM users WHERE email='$email'";
	$result = query($sql);
	$row = fetch_array($result);
	$admin = $row['admin'];

	return $admin;
}


/************************Forgot Password Functions ************************************/
function forgot_password(){

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		if(isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']){

			$email =  clean($_POST['email']);

			if(email_exists($email)){

				$validation_code = md5($email . microtime());

				setcookie('temp_code', $validation_code, time() + 900);

				$sql = "UPDATE users SET validation_code = '".escape($validation_code)."' WHERE email = '".escape($email)."'";

				$result = query($sql);
			

				$subject = "Password Reset.";
				$message = "Your reset code is : {$validation_code} 

				Click here to reset password http://localhost/ISU_TB_MP/code.php?email=$email&code=$validation_code";

				$headers = "From: noreply@ISU_Textbook_Marketplace.com";



				send_email($email, $subject, $message, $headers);




				set_message("<p class = 'bg-success text-center'>Please check email for pasword reset code.</p>");
				header("Location: index.php");
						

				} else {

							echo validation_errors("Not a valid email.");
				}


		}else {

				header("Location: index.php");
			
		}


		//token checks
		if(isset($_POST['cancel_submit'])){
			header("Location: login.php");
		}

				
	}//post
		
}//fuctions

/************************Forgot Password Code Validation Functions ************************************/

function validate_code(){


	if(isset($_COOKIE['temp_code'])){

		if(!isset($_GET['email']) && !isset($_GET['code'])){

			header("Location: index.php");

		}else if (empty($_GET['email']) || empty($_GET['code'])){
			header("Location: index.php");



		}else{

			if(isset($_POST['code'])){

					$email = clean($_GET['email']);
					$validation_code = clean($_POST['code']);

					$sql = "SELECT userid FROM users WHERE validation_code = '".escape($validation_code)."' AND email = '".escape($email)."' ";

					$result = query($sql);

					if(row_count($result)==1){

						setcookie('temp_code', $validation_code, time() + 900);

						header("Location: reset.php?email=$email&code=$validation_code");
					}else{


						echo validation_errors("Wrong validation code.");
					}




				}


		}	

	}else{

		set_message("<p class = 'bg-danger text-center'>Sorry, your validation time has expired, please try again..</p>");

		header("Location: recover.php");

	}
}


//***************Reset Function*************************//

function password_reset(){

	if(isset($_COOKIE['temp_code'])){

   		if(isset($_GET['email']) && isset($_GET['code'])){

   			

			if(isset($_SESSION['token']) && isset($_POST['token'])){



				if($_POST['token'] === $_SESSION['token']){


					if($_POST['password'] === $_POST['confirm_password']){

					   $update_password = md5($_POST['password']);

					   $sql = "UPDATE users SET password = '".escape($update_password)."', validation_code = 0 WHERE email = '".escape($_GET['email'])."' ";

					   query($sql);

					   set_message("<p class = 'bg-success text-center'>Your password is rest and now you can login.</p>");

					   header("Location: login.php");
						
				    }else{
				    	echo validation_errors("Passwords don't match, Please try again.");
				    }

				}


 			 }

      	}

  	}else{

  	set_message("<p class = 'bg-danger text-center'>Sorry your time expired.</p>");

  	header("Location: recover.php");

        }
}


//***************Validate Listing Function*************************//
function validate_listing(){

	if($_SERVER['REQUEST_METHOD'] == "POST"){

		$bk_price		= clean($_POST['bk_price']);
		$isbn			= clean($_POST['isbn']);
		$bk_title		= clean($_POST['bk_title']);
		$bk_author		= clean($_POST['bk_author']);
		$bk_desc		= clean($_POST['bk_desc']);
		$class_num		= clean($_POST['class_num']);
		$add 			= clean($_POST['add']);

		if($add == "Update Listing") {
			$old_image 	= clean($_POST['old_image']);
			$id			= clean($_POST['id']);
		}
	
	    if(floatval($bk_price) == 0){
	    	$errors[] = "You must enter a price for the listing";
		}
		
		if(!(strlen($isbn) == 13 || strlen($isbn) == 11)) {
			$errors[] = "ISBN must be 11 or 13 digits long";
		}

		if($_FILES['bk_image']['size'] == 0 && $_FILES['bk_image']['error'] != 4){
			$errors[] = "image size is bigger than 2MB";
		}

	    if(!empty($errors)){
	    	foreach ($errors as $error) {
	    	echo validation_errors($error);
	    	}

	    }else{

			if($add == "Add Listing") {
				if(create_listing($isbn, $bk_price, $bk_title, $bk_author, $bk_desc, $class_num)){

					if($_FILES['bk_image']['error'] != 4){ //if a file was uploaded
						$ext		= pathinfo($_FILES['bk_image']['name'])['extension'];
						$image_name	= "uploads/".get_id().".".$ext;
						add_image($image_name, get_id());
						move_uploaded_file($_FILES['bk_image']['tmp_name'],$image_name);
					}
					email_subscription($class_num, get_id());

					set_message("<p class='bg-success text-center'>Successfully Created New Listing!</p>");
				}
			}
			else{
				if(update_listing($id, $isbn, $bk_price, $bk_title, $bk_author, $bk_desc, $class_num)){

					if($_FILES['bk_image']['error'] != 4){ //if a file was uploaded
						unlink($old_image);
						$ext		= pathinfo($_FILES['bk_image']['name'])['extension'];
						$image_name	= "uploads/".$id.".".$ext;
						add_image($image_name, $id);
						move_uploaded_file($_FILES['bk_image']['tmp_name'],$image_name);
					}
					
					header("Location: create.php");
				}
			}
        }
	}
}

/******************Create Listing**************************************************/
function create_listing($isbn, $bk_price, $bk_title, $bk_author, $bk_desc, $class_num){
	/*******Escape Data**********/
	
    $bk_title	= escape($bk_title);
    $bk_author	= escape($bk_author);
    $bk_desc	= escape($bk_desc);
	$class_num	= escape($class_num);
	$userid		= get_userid();

		$sql = "INSERT INTO listings(isbn, bk_price, bk_title, bk_author, bk_desc, class_num, userid)";
		$sql.= "VALUES('$isbn','$bk_price','$bk_title','$bk_author','$bk_desc','$class_num', '$userid')";

		$result = query($sql);

		return true;		
}

function add_image($bk_image, $id){

	$sql = "UPDATE listings SET bk_image = '$bk_image' WHERE id = $id;";

	query($sql);

	return true;
}

function get_userid(){

	$sql = "SELECT userid FROM users WHERE email = '{$_SESSION['email']}' AND active = 1" ;

	$result = query($sql);
	$row = fetch_array($result);
	$userid = $row['userid'];

	return $userid;
}

function get_user_listings(){

	$userid = get_userid();
	$sql = "SELECT * FROM listings WHERE userid = $userid" ;
	$result = query($sql);

	return $result;
}

function strike_user($userid){
	$sql = "UPDATE users SET strike = strike + 1 WHERE userid = $userid";
	$result = query($sql);
}

function delete_user($userid){
	$sql = "DELETE FROM listings WHERE userid = $userid";
	$result = query($sql);

	$sql = "DELETE FROM notification WHERE userid = $userid";
	$result = query($sql);

	$sql = "DELETE FROM users WHERE userid = $userid";
	$result = query($sql);
}

function admin_user($userid, $isAdmin) {
	if($isAdmin==1){
		$isAdmin = 0;
	} else {
		$isAdmin = 1;
	}
	
	$sql = "UPDATE users SET admin = $isAdmin WHERE userid = $userid";
	$result = query($sql);
}


function get_all_users(){

	$sql = "SELECT first_name, last_name, username, email, active, strike, admin, userid FROM users WHERE email!= '{$_SESSION['email']}'";
	$result = query($sql);

	return $result;
}

function get_all_listings($query){

	if(isset($query['advanced'])){
		$advance = $query['advanced'];
	}
	else {
		$advanced	= 0;
	}

	$sort		= $query['sort'];
	$search		= $query['search'];

	unset($query['advanced'], $query['sort'],$query['search']);
	
	$sql = "SELECT * FROM listings l JOIN users u ON l.userid=u.userid";
	$columns=array('l.isbn', 'l.bk_price', 'l.bk_title', 'l.bk_author', 'l.bk_desc', 'l.class_num', 'u.email');

	//when advance search
	if($advance==true) {
		$adv_array = "";

		foreach ($query as $key => $value) {
			if($value != null) {
				$adv_array = $adv_array . " " . $key . " LIKE '%" . $value . "%' AND";
			}
		}
		$adv_array = substr($adv_array, 0, strlen($adv_array)-4);

		if(!empty($adv_array)){
			$sql = $sql . " WHERE " . $adv_array; 
		}
	}

	//search all columns
	if($search!=null && $advance==false) {
		$sql = $sql . " WHERE $columns[0] LIKE '%$search%'";
		for($x = 1; $x <= 6; $x++) {
			$sql = $sql . " OR $columns[$x] LIKE '%$search%'";
		}
	}

	//order of the data
	if($sort!=null){
		$sql = $sql . " ORDER BY $sort";
	}

	//print($sql);

	$result = query($sql);

	return $result;
}

function update_listing($id, $isbn, $bk_price, $bk_title, $bk_author, $bk_desc, $class_num) {
	/*******Escape Data**********/
	
	$bk_title	= escape($bk_title);
	$bk_author	= escape($bk_author);
	$bk_desc	= escape($bk_desc);
	$class_num	= escape($class_num);

	
		$sql = "UPDATE listings SET isbn = $isbn, bk_price = $bk_price, bk_title = '$bk_title',bk_author = '$bk_author', bk_desc = '$bk_desc', class_num = '$class_num' WHERE id = $id";

		$result = query($sql);

		return true;
}


function delete_listing($id) {

	//delete the image file
	$sql = "SELECT bk_image FROM listings WHERE id = $id";
	$result = query($sql);
	$row = fetch_array($result);
	$img_path = $row['bk_image'];
	unlink($img_path);

	//delete the row
	$sql = "DELETE FROM listings WHERE id = $id";
	$result = query($sql);

	set_message("<p class='bg-danger text-center'>Successfully Deleted a Listing!</p>");
	header("Location: create.php");
}

function delete_listing_report($id) {

	//delete the image file
	$sql = "SELECT bk_image FROM listings WHERE id = $id";
	$result = query($sql);
	$row = fetch_array($result);
	$img_path = $row['bk_image'];
	unlink($img_path);

	//delete the row
	$sql = "DELETE FROM listings WHERE id = $id";
	$result = query($sql);

	header("Location: browse.php?search=&sort=&advanced=0&bk_title=&isbn=&bk_price=&class_num=&bk_desc=&bk_author=");
}

function get_listing($id) {

	$sql = "SELECT * FROM listings WHERE id = $id";
	$result = query($sql);
	$row = fetch_array($result);

	return $row;

}

function get_user_details($userid, $column) {
	$sql = "SELECT $column FROM users WHERE userid = $userid";
	$result = query($sql);
	$row = fetch_array($result);
	$data = $row[$column];

	return $data;
}

function get_listing_details($listingid, $column) {
	$sql = "SELECT $column FROM listings WHERE id = $listingid";
	$result = query($sql);
	$row = fetch_array($result);
	$data = $row[$column];

	return $data;
}

function strike_user_listing($listingId, $userId){
	strike_user($userId);
	delete_listing_report($listingId);
}

function report_listing($listingId) {
	$email_array = array();
	$email = $_SESSION['email'];

	$subject = "Reported Listing";
	$msg = " The following listing has been reported by $email: 
	http://localhost/isu_tb_mp/details.php?id=$listingId ";
	$headers = "From: nonrepy@ISU_Textbook_Marketplace.com";
	

	$sql = "SELECT email FROM users WHERE admin=1";
	$results = query($sql);
	while(null !== ($row = fetch_assoc($results))){
		send_email($row['email'], $subject, $msg, $headers);
	}
}

function email_subscription($class_num, $listingId) {
	$email_array = array();

	$subject = "New Listing Posted";
	$msg = " A new Listing has been posted for class $class_num: 
	http://localhost/isu_tb_mp/details.php?id=$listingId ";
	$headers = "From: nonrepy@ISU_Textbook_Marketplace.com";
	

	$sql = "SELECT u.email FROM users u JOIN notification n ON u.userid=n.userid WHERE n.class_num='$class_num'";
	$result = query($sql);

	while($row = fetch_assoc($result)){
		send_email($row['email'], $subject, $msg, $headers);
	}
}

function add_class($class_num) {
	$userid = get_userid();
	$sql = "SELECT class_num FROM notification WHERE userid = $userid AND class_num = '$class_num'";
	$results = query($sql);

	if(fetch_assoc($results) == null){
		$sql = "INSERT INTO notification (userid, class_num) VALUES ($userid, '$class_num')";
		$results = query($sql);
	
		set_message("<p class='bg-success text-center'>Class Added!</p>");
		header("Location: subscriptions.php");

	} else {
		$sql = "DELETE FROM notification WHERE userid=$userid AND class_num='$class_num'";
		$results = query($sql);
	}
}

function get_all_user_notifications(){
	$userid = get_userid();
	$sql = "SELECT class_num FROM notification WHERE userid = $userid";
	$result = query($sql);

	return $result;
}

function get_all_unique_notifications(){
	$userid = get_userid();
	$res_array = array();
	$res_user_array = array();

	$sql = "SELECT class_num FROM notification UNION SELECT class_num FROM listings";
	$result = query($sql);
	while($row = fetch_assoc($result)){
		 array_push($res_array, $row['class_num']);
	}


	$sql = "SELECT class_num FROM notification WHERE userid = $userid";
	$result2 = query($sql);
	while($row = fetch_assoc($result2)){
		array_push($res_user_array, $row['class_num']);
	}

	foreach($res_user_array as $value){
		$indx = array_search($value, $res_array);
		unset($res_array[$indx]);
	}

	return $res_array;
}

function get_newest_listing(){
	$sql = "SELECT MAX(create_date) create_date FROM listings";
	$result = query($sql);
	$row = fetch_assoc($result);
	$date = $row['create_date'];

	$sql = "SELECT * FROM listings WHERE create_date = '$date'";
	$result = query($sql);

	return $result;
}

?>