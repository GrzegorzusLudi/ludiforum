<?php
function connect(){
	
	//database preferences
	$servername = "localhost";
	$username = "root";
	$password = "zaq1@WSX";
	
	$conn = new mysqli($servername, $username, $password);
	$success = true;
	if ($conn->connect_error) {
		$success = false;
	} else {
		mysqli_select_db($conn,"forum2");
	}
	return $conn;
}
function naglowek($conn){
	
echo "<div style=\"border:1px solid #003454;background-color:#007ECC;color:white;font-size:30px;padding:30px\">FORUM</div>
				<div style=\"\">
					<div id=\"przycisk\"><a href=\"index.php\">strona główna</a></div>
					<div id=\"przycisk\"><a href=\"uzytkownicy.php\">użytkownicy</a></div>";
$sukc = false;
if(isset($_COOKIE["user_login"])){
	
		$conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
		$que = "select login('" . $_COOKIE["user_login"] . "','" . $_COOKIE["user_haslo"] . "');";
		$qu = "login('" . $_COOKIE["user_login"] . "','" . $_COOKIE["user_haslo"] . "')";
		try {
			$result = $conn->query($que);
			$conn->commit();
			
			$row = $result->fetch_assoc();
			$stron = $row[$qu];
			if($stron==1)
				$sukc = true;
		} catch(Exception $e){
			$conn->rollback();
		}
}
if($sukc==false){
	echo "<div id=\"przycisk\"><a href=\"login.php\">zaloguj</a></div>
		  <div id=\"przycisk2\"><a href=\"rejestracja.php\">rejestracja</a></div>";
		 
} else {
	echo "<div id=\"przycisk\"><a href=\"logout.php\">wyloguj [". $_COOKIE["user_login"] ."]</a></div>
	      <div id=\"przycisk\"><a href=\"pw.php\">prywatne wiadomości</a></div>";
}
	echo "</div> ";
		$conn->close();
}
function uprawnienia($conn){
	$upr = "Niezalogowany";
	if(isset($_COOKIE["user_login"])){
		$conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
	
		$que = "call uprawnienia('" . $_COOKIE["user_login"] . "','" . $_COOKIE["user_haslo"] . "');";
		try {
			$result = $conn->query($que);
			$conn->commit();
			
			if($result->num_rows>0){
				$row = $result->fetch_assoc();
				$upr = $row["Uprawnienia"];
			}
		} catch(Exception $e){
			$conn->rollback();
		}
	}
		$conn->close();
	return $upr;
}
?>