<?PHP
session_start();
	if(empty($_SESSION['ID']) || empty($_SESSION['NAME']) || empty($_SESSION['SURNAME'])){
		echo '<script>window.location = "Login.php";</script>';
	}
?>

Change Password
<hr>
<?PHP
	$connect = oci_connect("system", "570323Nuch", "//localhost/XE");
	if (!$connect) {
	echo "connect changePass fail";
	}
		if(isset($_POST['confirmTochange'])){
			$username = trim($_POST['username']);
			$Old_password = trim($_POST['Old_password']);
			$new_pssword = trim($_POST['new_pssword']);
			
			$query = "SELECT * FROM AA_LOGIN WHERE username='$username' and password='$Old_password' and id='".$_SESSION['ID']."'";
			$parseRequest = oci_parse($connect, $query);
			oci_execute($parseRequest);
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			if($row){
				$_SESSION['ID'] = $row['ID'];
				$_SESSION['NAME'] = $row['NAME'];
				$_SESSION['SURNAME'] = $row['SURNAME'];
				
				$query1 = "UPDATE AA_LOGIN SET password='$new_pssword' WHERE username='$username' and password='$Old_password' ";
				$parseRequest1 = oci_parse($connect, $query1);
				oci_execute($parseRequest1);
				echo "changePass yes.";
			}else{
				echo "changePass fail.";
			}

		}
		
			
		
		
	
	;

?>
			
<form action='changePass.php' method='post'>
	Username <br>
	<input name='username' type='input'><br>
	Old Password<br>
	<input name='Old_password' type='password'><br>
	New Password <br>
	<input name='new_pssword' type='password'><br><br>
	<input name='confirmTochange' type='submit' value='changePass'>
</form>