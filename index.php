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
					<tr id="tytul">
						<td style="width:600px">Dział</td>
						<td style="width:100px">Tematów</td>
						<td style="width:100px">Odpowiedzi</td>
					</tr>
					<?php
						
							$conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
							$result = $conn->query("call dzialy();");
							if($result)
							try {
							$conn->commit();
							
							while($row = $result->fetch_assoc()) {
								$ee = "";
								$ei = "";
								$nei = "";
								$zamk = "";
								if($row["Zablokowany"]!=0){
									$ee = "<b>[Zablokowany]</b>";
									if($upraw=="Administrator")
										$ei = "<a href=\"zablokuj.php?id=". $row["ID"] ."\"><i>[Odblokuj]</i></a>";
								} else {
									if($upraw=="Administrator")
										$ei = "<a href=\"zablokuj.php?id=". $row["ID"] ."\"><i>[Zablokuj]</i></a>";
								}
								if($upraw=="Administrator")
									$nei = "<a href=\"usun.php?id=". $row["ID"] ."\"><i>[Usuń]</i></a>";
								echo "<tr> 
								<td style=\"width:600px\"><div><a href=\"dzial.php?id=". $row["ID"] ."\">".$row["Nazwa"]."</a> $ee $ei $nei"
								. "</div><div style=\"font-size:10pt\">".$row["Opis"]."</div></td>
								<td style=\"width:100px\">". $row["tematy"] ."</td>
								<td style=\"width:100px\">". ($row["wiadomosci"]-$row["tematy"]) ."</td>
								</tr>";
							}
							} catch(Exception $e){
								$conn->rollback();
							}
					?>
				</table>
					<?php
					if($upraw=="Administrator"){
					$lab = "";
					if(isset($_GET["blad"])){
						if($_GET["blad"]=="puste")
							$lab="<span style=\"color:red\">Pola nie mogą być puste!</span>";
						else if($_GET["blad"]=="nazwa")
							$lab="<span style=\"color:red\">Nieprawidłowe dane.</span>";
						else if($_GET["blad"]=="sukces")
							$lab="<span style=\"color:green\">Wysłano poprawnie!</span>";
					}
						echo
						"<div id=\"kontener\" style=\"margin-top:40px;border:1px solid #003454;background-color:#A1DBFF;padding:10px\">
						<h4>Nowy dział (dla Administratorów)</h4>
						$lab
						<form action=\"nowydzial.php\" method=\"get\" id=\"u1\">
						Nazwa działu: <input name=\"nazwa\" /><br/>
						Opis działu:<br/><textarea name=\"opis\" rows=\"5\" cols=\"20\"></textarea>
						<input type=\"submit\">
						</form>
						</div>";
					}
					?>
			</div>
			<div id="kontener">
				<?php echo file_get_contents("stopka.txt"); ?>
			</div>
		</div>
	</body>
</html>