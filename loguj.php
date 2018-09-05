<?php

	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
		header('Location: login.php?blad=polaczenie');
		die();
	} else {
		if($_GET["login"]=="" || $_GET["haslo"]==""){
			header('Location: login.php?blad=puste');
			die();
		}
		
		$conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
		$que = "select login('" . $_GET["login"] . "','" . $_GET["haslo"] . "');";
		$qu = "login('" . $_GET["login"] . "','" . $_GET["haslo"] . "')";
		try {
			$result = $conn->query($que);
			$conn->commit();
			
			$row = $result->fetch_assoc();
			$stron = $row[$qu];
			if($stron==1){
				setCookie("user_login",$_GET["login"], time() + 86400, "/");
				setCookie("user_haslo",$_GET["haslo"], time() + 86400, "/");
				header('Location: index.php');
			} else {
				header('Location: login.php?blad=nazwa');
			}
		} catch (Exception $e) {
			$conn->rollback();
			header('Location: login.php?blad=nazwa');
		}	
			
	}

?>