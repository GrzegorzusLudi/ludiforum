<?php

	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
		header("Location: dzial.php?id=".$_GET["dzialid"]."&blad=polaczenie");
		die();
	} else {
		if($_GET["id"]==""){
			die();
		}
		$u = uprawnienia($conn);
	$conn = connect();
		if($u=="Administrator"){
			$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
			$res1 = $conn->query("select * from temat where ID=" . $_GET["id"] . ";");
			if($res1 && $res1->num_rows>0){
				$id = $res1->fetch_assoc();
				if($id["Zablokowany"]==0){
					$result = $conn->query("update temat set Zablokowany=1 where ID=" . $_GET["id"] . ";");
				} else {
					$result = $conn->query("update temat set Zablokowany=0 where ID=" . $_GET["id"] . ";");
				}
			}
			try {
				$conn->commit();
				header("Location: dzial.php?id=".$_GET["dzialid"]."&blad=sukces");
			} catch (Exception $e) {
				$conn->rollback();
				header("Location: dzial.php?id=".$_GET["dzialid"]."&blad=nazwa");
			}	
		} else {
			header("Location: dzial.php?id=".$_GET["dzialid"]."&blad=nieadmin");
		}
			
	}

?>