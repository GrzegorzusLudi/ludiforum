<?php

	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
		header("Location: temat.php?id=".$_GET["tematid"]."&blad=polaczenie");
		die();
	} else {
		if($_GET["tematid"]=="" || $_GET["dzialid"]==""){
			die();
		}
		$u = uprawnienia($conn);
	$conn = connect();
		if($u=="Administrator" || $u=="Moderator" || $u=="Normalny"){
			$conn->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
			$res2 = $conn->query("select login('" . $_COOKIE["user_login"] . "','". $_COOKIE["user_haslo"] ."') as dd;");
			$res1 = $conn->query("select * from temat where ID=" . $_GET["tematid"] . ";");
			if($res2)
				$row = $res2->fetch_assoc();
			if(($u=="Administrator" || $u=="Moderator" || ($u=="Normalny" && $res2 && $row["dd"]>0)) && $res1 && $res1->num_rows>0){
				$id = $res1->fetch_assoc();
				$result = $conn->query("delete from temat where ID=" . $_GET["tematid"] . ";");
			} else {
				header("Location: temat.php?id=".$_GET["tematid"]."&blad=zledane");
				die();
			}
			try {
				$conn->commit();
				header("Location: dzial.php?id=".$_GET["dzialid"]."&blad=sukces");
			} catch (Exception $e) {
				$conn->rollback();
				header("Location: temat.php?id=".$_GET["tematid"]."&blad=nazwa");
			}	
		} else {
			header("Location: temat.php?id=".$_GET["tematid"]."&blad=nieuzytkownik");
		}
			
	}

?>