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
		if($u=="Administrator"){
			$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
			$conn->query("delete from dzial where ID=" . $_GET["id"] . ";");
			
			try {
				$conn->commit();
				header('Location: index.php?blad=sukces');
			} catch (Exception $e) {
				$conn->rollback();
				header('Location: index.php?blad=nazwa');
			}	
		} else {
			header('Location: index.php?blad=nieadmin');
		}
			
	}

?>