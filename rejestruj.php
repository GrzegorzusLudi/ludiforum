<?php

	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
		header('Location: rejestracja.php?blad=polaczenie');
		die();
	} else {
		if($_GET["login"]=="" || $_GET["haslo"]=="" || $_GET["powtorz"]==""){
			header('Location: rejestracja.php?blad=puste');
			die();
		}
		
		$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
		$res = $conn->query("select COUNT(ID) from uzytkownik where Nazwa='".$_GET["login"]."';");
		$row = $res->fetch_assoc();
		$r = $row['COUNT(ID)'];
		if($r==1){
			header('Location: rejestracja.php?blad=loginistnieje');
			die();
		} else if($_GET["haslo"]!=$_GET["powtorz"]){
			header('Location: rejestracja.php?blad=haslo');
			die();
		} else {
			$result = $conn->query("call rejestruj('" . $_GET["login"] . "','" . $_GET["haslo"] . "');");
		}
		try {
			$conn->commit();
			header('Location: rejestracja.php?blad=sukces');
		} catch (Exception $e) {
			$conn->rollback();
			header('Location: rejestracja.php?blad=blad');
		}	
			
	}

?>