<?php

	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
		header("Location: pw.php?blad=polaczenie");
		die();
	} else {
		if($_GET["pwid"]==""){
			die();
		}
		$u = uprawnienia($conn);
	$conn = connect();
		if($u=="Administrator" || $u=="Moderator" || $u=="Normalny"){
			$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
			$res2 = $conn->query("select login('" . $_COOKIE["user_login"] . "','". $_COOKIE["user_haslo"] ."') as dd;");
			$res1 = $conn->query("select * from prywatnawiadomosc where ID=" . $_GET["pwid"] . ";");
			if($res2)
				$row = $res2->fetch_assoc();
			if(($res2 && $row["dd"]>0) && $res1 && $res1->num_rows>0){
				$id = $res1->fetch_assoc();
				$result = $conn->query("delete from prywatnawiadomosc where ID=" . $_GET["pwid"] . ";");
			} else {
				header("Location: pw.php?blad=zledane");
				die();
			}
			try {
				$conn->commit();
				header("Location: pw.php?blad=sukceswusuwaniu");
			} catch (Exception $e) {
				$conn->rollback();
				header("Location: pw.php?blad=nazwa");
			}	
		} else {
			header("Location: pw.php?blad=nieuzytkownik");
		}
			
	}

?>