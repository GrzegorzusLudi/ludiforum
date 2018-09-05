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
					$result = $conn->query("select * from temat where ID=" . $_GET["id"] . ";");
					$z = $result->fetch_assoc();
					$dzialid = $z['DzialID'];
					$zabi = $z['Zablokowany'];
					$nazwa = $z['Tytul'];
					$res1 = $conn->query("select COUNT(ID) as odp from wiadomosc where TematID=" . $_GET["id"] . " GROUP BY TematID;");
					$y = $res1->fetch_assoc();
					$stron = (int)(($y['odp']-1)/20)+1;
					$res2 = $conn->query("select * from dzial where ID=" . $dzialid . ";");
					$x = $res2->fetch_assoc();
					$nazwad = $x["Nazwa"];
					$nazwai = $x["ID"];
					$za2 = $x['Zablokowany'];
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
			<h2><?php echo "<a href=\"dzial.php?id=$nazwai\">$nazwad</a> > $nazwa"; ?></h2>
				<table>
					<tr id="tytul">
						<td style="width:200px">Autor</td>
						<td style="width:800px">Post</td>
					</tr>
					<?php
						
							$conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
							$result = $conn->query("call wiadomosci(" . $_GET["id"] . "," . $_GET["strona"] .");");
							
							
							if($result)
							try {
							$conn->commit();
							
							while($row = $result->fetch_assoc()) {
								$ee = "";
								$nei = "";
								$usun = "";
								$zab = "";
								$mod = "";
								if($row["upr"]!="Normalny"){
									$ee = "<b>".$row["upr"]."</b>";
								}
								if($upraw=="Administrator" || $upraw=="Moderator" || (isset($_COOKIE["user_login"]) && $row["Nazwa"]==$_COOKIE["user_login"])){
									if($row["IndeksWtemacie"]!=0)
										$usun="<a href=\"usunpost.php?postid=".$row["ID"]."&tematid=".$_GET["id"]."\"><i>[USUŃ]</i></a>";
									else
										$usun="<a href=\"usuntemat.php?tematid=".$_GET["id"]."&dzialid=$nazwai\"><i>[USUŃ TEMAT]</i></a>";
								}
								
								if($row["upr"]!="Normalny")
									$ee = "<b>[".$row["upr"]."]</b>";
								if(($upraw=="Administrator" || $upraw=="Moderator") && $row["upr"]!="Administrator" && $row["upr"]!="Moderator"){
									if($row["upr"]!="Zablokowany"){
										$zab = "<i><a href=\"zablokujuzyt.php?id=".$row["userid"]."\">[ZABLOKUJ UŻYTKOWNIKA]</a></i>";
									} else {
										$zab = "<i><a href=\"zablokujuzyt.php?id=".$row["userid"]."\">[ODBLOKUJ UŻYTKOWNIKA]</a></i>";
									}
								}
								if($upraw=="Administrator" && $row["upr"]!="Zablokowany"){
									if($row["upr"]=="Normalny"){
										$mod = "<i><a href=\"modek.php?id=".$row["userid"]."\">[USTAW MODERATORA]</a></i>";
									} else if($row["upr"]=="Moderator") {
										$mod = "<i><a href=\"modek.php?id=".$row["userid"]."\">[ODBIERZ MODERATORA]</a></i>";
									}
								}
								if($row["OdpowiedzDo"]!=0)
									$nei = "<div style=\"background-color:#8888ff\">W odpowiedzi na post #". ($row["OdpowiedzDo"]+1) ."</div>";
								echo "<tr> 
								<td style=\"width:200px\"><div>Post #".($row["IndeksWtemacie"]+1)." $usun<br/>Wysłano: ".$row["DataWyslania"]."<br/><br/><b>Autor: </b>".$row["Nazwa"]." $ee $zab $mod<br/>Dołączył: ".$row["DataDolaczenia"]." </div>"
								. "</td> 
								<td style=\"width:600px\"> $nei". $row["Tresc"] ."</td>
								</tr>";
							}
							} catch(Exception $e){
								$conn->rollback();
							}
					?>
				</table>
					<?php
					echo "<div>Strony: ";
					for($i=1;$i<=$stron;$i++){
						if($i==$_GET["strona"]){
							echo $i . " ";
						} else {
							echo "<a href=\"temat.php?id=". $_GET["id"] ."&strona=$i\">" . $i . "</a> ";
						}
					}
					echo "</div>";
					
					if($upraw=="Administrator" || $upraw=="Moderator" || ($upraw=="Normalny" && $zabi==0 && $za2==0)){
							$lab = "";
					if(isset($_GET["blad"])){
						if($_GET["blad"]=="puste")
							$lab="<span style=\"color:red\">Pola nie mogą być puste!</span>";
						else if($_GET["blad"]=="nazwa")
							$lab="<span style=\"color:red\">Nieprawidłowe dane.</span>";
						else if($_GET["blad"]=="zlaodpowiedz")
							$lab="<span style=\"color:red\">Nie ma posta o takim numerze.</span>";
						else if($_GET["blad"]=="sukces")
							$lab="<span style=\"color:green\">Wysłano poprawnie!</span>";
					}
						echo
						"<div id=\"kontener\" style=\"margin-top:40px;border:1px solid #003454;background-color:#A1DBFF;padding:10px\">
						<h4>Odpowiedz</h4>
						$lab
						<form action=\"nowypost.php\" method=\"get\" id=\"u1\">
						Odpowiedz na post nr: <input name=\"post\" /><br/>
						<input name=\"tematID\" type=\"hidden\" value=\"". $_GET["id"] ."\" />
						<input name=\"strona\" type=\"hidden\" value=\"". $stron ."\" />
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