<?php

	include("funkcje.php");
	$conn = connect();
	$i = $_GET["dzialID"];
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
		header("Location: dzial.php?id=$i&blad=polaczenie");
		die();
	} else {
		if($_GET["nazwa"]=="" || $_GET["opis"]=="" || $_GET["dzialID"]==""){
			header("Location: dzial.php?id=$i&blad=puste");
			die();
		}
		$u = uprawnienia($conn);
	$conn = connect();
		if($u=="Administrator" || $u=="Moderator" || $u=="Normalny"){
			$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
			$res1 = $conn->query("select Zablokowany from dzial where ID=".$_GET["dzialID"].";");
			if($res1)
				$rw = $res1->fetch_assoc();
			if($rw["Zablokowany"]==0){
			$res2 = $conn->query("select login('" . $_COOKIE["user_login"] . "','". $_COOKIE["user_haslo"] ."') as dd;");
			if($res2)
				$row = $res2->fetch_assoc();
			if($res2 && $row["dd"]>0){
				$result = $conn->query("call nowytemat('" . $_COOKIE["user_login"] . "'," . $_GET["dzialID"] . ",'" . $_GET["nazwa"] . "','" . $_GET["opis"] . "');");
			} else {
				header("Location: dzial.php?id=$i&blad=zledane");
				die();
			}
			} else {
				header("Location: dzial.php?id=$i&blad=zablokowany");
				die();
				
			}
			try {
				$conn->commit();
				header("Location: dzial.php?id=$i&blad=sukces");
			} catch (Exception $e) {
				$conn->rollback();
				header("Location: dzial.php?id=$i&blad=nazwa");
			}	
		} else {
			header("Location: dzial.php?id=$i&blad=niezarejestrowany");
		}
			
	}

?>