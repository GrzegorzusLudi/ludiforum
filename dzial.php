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
					$conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
					$result = $conn->query("select * from dzial where ID=" . $_GET["id"] . ";");
					$z = $result->fetch_assoc();
					$zab = $z['Zablokowany'];
					$nazwa = $z['Nazwa'];
							try {
								$conn->commit();
							} catch(Exception $e){
								$conn->rollback();
							}
	$conn->close();
	$conn = connect();
					?>
			</div>
			<div id="kontener" style="margin-top:40px">
			<h2><?php echo $nazwa; ?></h2>
				<table>
					<tr id="tytul">
						<td style="width:500px">Temat</td>
						<td style="width:100px">Autor</td>
						<td style="width:100px">Odpowiedzi</td>
						<td style="width:100px">Ostatni post</td>
					</tr>
					<?php
						
							$conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
							$us = "";
							$hs = "";
							if(isset($_COOKIE["user_login"])){
								$us = $_COOKIE["user_login"];
								$hs = $_COOKIE["user_haslo"];
							}
							$result = $conn->query("call tematy(" . $_GET["id"] . ",'". $us ."','". $hs ."');");
							
							if($result)
							try {
							while($row = $result->fetch_assoc()) {
								$ee = "";
								$ei = "";
								$nei = "";
								$zamk = "";
								if($row["Zablokowany"]!=0){
									$ee = "<b>[Zablokowany]</b>";
									if($upraw=="Administrator" || $upraw=="Moderator")
										$ei = "<a href=\"zablokujt.php?dzialid=".$_GET["id"]."&id=". $row["ID"] ."\"><i>[Odblokuj]</i></a>";
								} else {
									if($upraw=="Administrator" || $upraw=="Moderator")
										$ei = "<a href=\"zablokujt.php?dzialid=".$_GET["id"]."&id=". $row["ID"] ."\"><i>[Zablokuj]</i></a>";
								}
								$str = "";
								if($row["odp"]>20){
									for($i=0;$i<$row["odp"];$i+=20){
										$str+="";
									}
								}
								if($upraw=="Administrator" || $upraw=="Moderator" || ($upraw=="Normalny" && $row["prawo"]!=0))
									$nei = "<a href=\"usuntemat.php?dzialid=".$_GET["id"]."&tematid=". $row["ID"] ."\"><i>[Usuń]</i></a>";
								echo "<tr> 
								<td style=\"width:600px\"><a href=\"temat.php?id=". $row["ID"] ."&strona=". 1 ."\">".$row["Tytul"]."</a> $ee $ei $nei"
								. "</td>
								<td style=\"width:100px\">". $row["uzyt"] ."</td>
								<td style=\"width:100px\">". $row["odp"] ."</td>
								<td style=\"width:100px\">". $row["DataWyslania"] ."</td>
								</tr>";
							}
							$conn->commit();
							} catch(Exception $e){
								$conn->rollback();
							}
					?>
				</table>
					<?php
					if($upraw=="Administrator" || $upraw=="Moderator" || ($upraw=="Normalny" && $zab==0)){
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
						<h4>Nowy temat</h4>
						$lab
						<form action=\"nowytemat.php\" method=\"get\" id=\"u1\">
						Tytuł: <input name=\"nazwa\" /><br/>
						<input name=\"dzialID\" type=\"hidden\" value=\"".$_GET["id"]."\" />
						Treść posta:<br/><textarea name=\"opis\" rows=\"10\" cols=\"40\"></textarea>
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