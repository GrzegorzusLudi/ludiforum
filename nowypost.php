<?php

	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
		header("Location: temat.php?id=$i&strona=$k&blad=polaczenie");
		die();
	} else {
		if($_GET["opis"]=="" || $_GET["tematID"]==""){
			header("Location: temat.php?id=$i&strona=$k&blad=puste");
			die();
		}
		$u = uprawnienia($conn);
		$i = $_GET["tematID"];
		$k = $_GET["strona"];
	$conn = connect();
		if($u=="Administrator" || $u=="Moderator" || $u=="Normalny"){
			$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
			$res1 = $conn->query("select Zablokowany from temat where ID=$i;");
			if($res1)
				$rw = $res1->fetch_assoc();
			if($rw["Zablokowany"]==0){
				$res2 = $conn->query("select login('" . $_COOKIE["user_login"] . "','". $_COOKIE["user_haslo"] ."') as dd;");
				if($res2)
				$row = $res2->fetch_assoc();
				if($_GET["post"]==""){
					$odp = 0;
				} else {
					$odp = $_GET["post"]-1;
				}
			if($row["dd"]>0)
			try {
				$ist = $conn->query("select count(ID) from wiadomosc where IndeksWTemacie=$odp and TematID=$i;");
				$ei = "sukces";
				$row = $ist->fetch_assoc();
				if($row["count(ID)"]>0){
					$conn->query("call odpowiedz(" . $_GET["tematID"] . ",'" .$_COOKIE["user_login"]  . "','" . htmlspecialchars($_GET["opis"]) . "'," . $odp . ");");
				} else {
					$ei = "zlaodpowiedz";
				}
				$conn->commit();
				header("Location: temat.php?id=$i&strona=$k&blad=$ei");
			} catch (Exception $e) {
				$conn->rollback();
				header("Location: temat.php?id=$i&strona=$k&blad=$ei");
			}	
			} else {
				header("Location: temat.php?id=$i&strona=$k&blad=zablokowany");
				die();
				
			}
		} else {
			header("Location: temat.php?id=$i&strona=$k&blad=niezarejestrowany");
		}
			
	}

?>