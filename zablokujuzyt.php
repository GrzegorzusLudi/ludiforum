<?php

	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
		header('Location: index.php?blad=polaczenie');
		die();
	} else {
		if($_GET["id"]==""){
			die();
		}
		$u = uprawnienia($conn);
	$conn = connect();
		if($u=="Administrator" || $u=="Moderator"){
			$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
			$res1 = $conn->query("select * from uzytkownik where ID=" . $_GET["id"] . ";");
			if($res1 && $res1->num_rows>0){
				$id = $res1->fetch_assoc();
				if($id["Uprawnienia"]=="Normalny"){
					$result = $conn->query("update uzytkownik set Uprawnienia='Zablokowany' where ID=" . $_GET["id"] . ";");
				} else if($id["Uprawnienia"]=="Zablokowany"){
					$result = $conn->query("update uzytkownik set Uprawnienia='Normalny' where ID=" . $_GET["id"] . ";");
				}
			}
			try {
				$conn->commit();
				header('Location: index.php?blad=sukces');
			} catch (Exception $e) {
				$conn->rollback();
				header('Location: index.php?blad=nazwa');
			}	
		} else {
			header('Location: index.php?blad=nieadminiemod');
		}
			
	}

?>