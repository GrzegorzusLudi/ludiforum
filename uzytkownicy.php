<!DOCTYPE html>
<?php
	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
	}
						$strona = 1;
						$stronn = $conn->query("select uzyt_stron();");
						$row = $stronn->fetch_assoc();
						$stron = $row['uzyt_stron()'];
						if(isset($_GET["page"]) && $_GET["page"]>0 && $_GET["page"]<=$stron)
							$strona = $_GET["page"];
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="calosc">
			<div id="kontener">
				<?php naglowek($conn);
	$conn = connect();
					$upraw = uprawnienia($conn);
	$conn = connect(); ?>
			</div>
			<div id="kontener" style="margin-top:40px">
				Strona <?php echo $strona ?>
				<table>
					<tr id="tytul">
						<td style="width:500px">Użytkownik</td>
						<td style="width:100px">Postów</td>
						<td style="width:100px">Dołączył</td>
						<td style="width:100px">Ostatnia wizyta</td>
					</tr>
					
						<?php
						if($strona>0 && $strona<=$stron){
							$conn->begin_transaction(MYSQLI_TRANS_START_READ_ONLY);
							$result = $conn->query("call uzytkownicy($strona);");
							$conn->commit();
							
							while($row = $result->fetch_assoc()) {
								$ee = "";
								$zab = "";
								$mod = "";
								if($row["Uprawnienia"]!="Normalny")
									$ee = "<b>[".$row["Uprawnienia"]."]</b>";
								if(($upraw=="Administrator" || $upraw=="Moderator") && $row["Uprawnienia"]!="Administrator" && $row["Uprawnienia"]!="Moderator"){
									if($row["Uprawnienia"]!="Zablokowany"){
										$zab = "<i><a href=\"zablokujuzyt.php?id=".$row["ID"]."\">[ZABLOKUJ]</a></i>";
									} else {
										$zab = "<i><a href=\"zablokujuzyt.php?id=".$row["ID"]."\">[ODBLOKUJ]</a></i>";
									}
								}
								if($upraw=="Administrator" && $row["Uprawnienia"]!="Zablokowany"){
									if($row["Uprawnienia"]=="Normalny"){
										$mod = "<i><a href=\"modek.php?id=".$row["ID"]."\">[USTAW MODERATORA]</a></i>";
									} else if($row["Uprawnienia"]=="Moderator") {
										$mod = "<i><a href=\"modek.php?id=".$row["ID"]."\">[ODBIERZ MODERATORA]</a></i>";
									}
								}
								echo "<tr> 
								<td style=\"width:500px\">".$row["Nazwa"]." $ee $zab $mod</td>
								<td style=\"width:100px\">".$row["wiad"]."</td>
								<td style=\"width:100px\">".$row["DataDolaczenia"]."</td>
								<td style=\"width:100px\">".$row["OstatniaWizyta"]."</td>
								</tr>";
							}
						}
						?>
				</table>
				Strony: 
				<?php
							$i = 1;
							while($i<=$stron){
								echo "<a href=\"uzytkownicy.php?page=$i\">".$i."</a> ";
								$i++;
							}
					
				?>
			</div>
			<div id="kontener">
				<?php echo file_get_contents("stopka.txt"); ?>
			</div>
		</div>
	</body>
</html>