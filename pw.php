<!DOCTYPE html>
<?php
	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
	} else {
	}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<script src="skrypt.js">
		
	</script>
	<body>
		<div id="calosc">
			<div id="kontener">
				<?php /*echo file_get_contents("naglowek.txt");*/naglowek($conn); 
	$conn = connect();
					$upraw = uprawnienia($conn);
	$conn = connect();

					?>
			</div>
			<div id="kontener" style="margin-top:40px">
				<table>
				<h2>Skrzynka odbiorcza</h2>
					<tr id="tytul">
						<td style="width:700px">Tresc</td>
						<td style="width:100px">Nadawca</td>
					</tr>
					<?php
						
							$conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
			$res2 = $conn->query("select login('" . $_COOKIE["user_login"] . "','". $_COOKIE["user_haslo"] ."') as dd;");
			if($res2)
				$roww = $res2->fetch_assoc();
							
							if($roww["dd"]>0){
								$result = $conn->query("call pwiadomosci('".$_COOKIE["user_login"]."');");
							}
							
							try {
							$conn->commit();
							
							while($row = $result->fetch_assoc()) {
								$ee = "";
								$ei = "";
								$nei = "";
								$zamk = "";
								echo "<tr> 
								<td style=\"width:600px\"><div>".$row["Tresc"].
								 "</div><div style\"font-align:right\"><a href=\"usunpw.php?pwid=".$row["ID"]."\"><i>[USUŃ]</i></a></div></td>
								<td style=\"width:100px\">". $row["nad"] ."<br/>".$row["DataWyslania"]."</td>
								</tr>";
							}
							} catch(Exception $e){
								$conn->rollback();
							}
					?>
				</table>
					<?php
					echo
						"<div id=\"kontener\" style=\"margin-top:40px;border:1px solid #003454;background-color:#A1DBFF;padding:10px\">";
						if(isset($_GET["blad"])){
							if($_GET["blad"]=="sukces")
								echo "<span style=\"color:green\">Wysłano poprawnie!</span>";
							else if($_GET["blad"]=="puste")
								echo "<span style=\"color:red\">Pola nie mogą być puste.</span>";
							else if($_GET["blad"]=="dosiebie")
								echo "<span style=\"color:red\">Nie można wysłać wiadomości do siebie.</span>";
							else if($_GET["blad"]=="zlaodpowiedz")
								echo "<span style=\"color:red\">Nie ma takiego użytkownika.</span>";
						}
						echo "
						<h4>Redaguj</h4>
						<form action=\"redaguj.php\" method=\"get\" id=\"u1\">
						Adresat: <input name=\"adresat\" /><br/>
						Tresc:<br/><textarea name=\"tresc\" rows=\"5\" cols=\"20\"></textarea>
						<input type=\"submit\">
						</form>
						</div>";
					?>
			</div>
			<div id="kontener">
				<?php echo file_get_contents("stopka.txt"); ?>
			</div>
		</div>
	</body>
</html>