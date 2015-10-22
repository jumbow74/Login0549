<?PHP
	session_start();
	// Create connection to Oracle
	$conn = oci_connect("system", "570323Nuch", "//localhost/XE");
	if (!$conn) {
		$m = oci_error();
		echo $m['message'], "\n";
		exit;
	} 
?>
Login form
<hr>

<?PHP
	if(isset($_POST['submit'])){
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$Confirm_code = trim($_POST['confirm_code']);
		if($Confirm_code == '456789'){
			$query = "SELECT * FROM AA_LOGIN WHERE username='$username' and password='$password'";
			$parseRequest = oci_parse($conn, $query);
			oci_execute($parseRequest);
			// Fetch each row in an associative array
			$row = oci_fetch_array($parseRequest, OCI_RETURN_NULLS+OCI_ASSOC);
			if($row){
				$_SESSION['ID'] = $row['ID'];
				$_SESSION['NAME'] = $row['NAME'];
				$_SESSION['SURNAME'] = $row['SURNAME'];
				echo '<script>window.location = "MemberPage.php";</script>';
			}else{
				echo "Login fail.";
			}
		}
		else{
				echo "Login fail.";
		}
	};
	oci_close($conn);
?>

<form action='login.php' method='post'>
	Username <br>
	<input name='username' type='input'><br>
	Password<br>
	<input name='password' type='password'><br>
	Confirm code <br>
	456789<br>
	<input name='confirm_code' type='input'><br><br>
	<input name='submit' type='submit' value='Login'>
</form>
