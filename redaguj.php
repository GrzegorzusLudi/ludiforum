<?php

	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
		header("Location: temat.php?id=$i&blad=polaczenie");
		die();
	} else {
		if($_GET["tresc"]=="" || $_GET["adresat"]==""){
			header("Location: pw.php?blad=puste");
			die();
		}
		if($_GET["adresat"]==$_COOKIE["user_login"]){
			header("Location: pw.php?blad=dosiebie");
			die();
		}
		$u = uprawnienia($conn);
		$i = $_GET["adresat"];
	$conn = connect();
		if($u=="Administrator" || $u=="Moderator" || $u=="Normalny"){
			$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
			$res2 = $conn->query("select login('" . $_COOKIE["user_login"] . "','". $_COOKIE["user_haslo"] ."') as dd;");
			if($res2)
				$row = $res2->fetch_assoc();
			if($row["dd"]>0)
			try {
				$ist = $conn->query("select count(ID) from uzytkownik where Nazwa='$i'");
				$ei = "";
				$row = $ist->fetch_assoc();
				if($row["count(ID)"]>0){
					$conn->query("call pwiadomosc('" . $_COOKIE["user_login"] . "','$i','" . $_GET["tresc"] . "');");
					$ei = "sukces";
				} else {
					$ei = "zlaodpowiedz";
				}
				$conn->commit();
				header("Location: pw.php?blad=$ei");
			} catch (Exception $e) {
				$ei = "blad";
				$conn->rollback();
				header("Location: pw.php?blad=$ei");
			}	
		} else {
			header("Location: pw.php?blad=niezarejestrowany");
		}
			
	}

?>