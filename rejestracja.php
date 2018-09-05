<!DOCTYPE html>
<?php
	include("funkcje.php");
	$conn = connect();
	if($conn->connect_error){
		echo "<script>alert(\"Brak połączenia z bazą danych.\");</script>";
	}
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<div id="calosc">
			<div id="kontener">
				<?php naglowek($conn); ?>
			</div>
			<div id="kontener" style="margin-top:40px;border:1px solid #003454;background-color:#A1DBFF;padding:10px">
				<h4>Zarejestruj się</h4>
				<?php
				if(isset($_GET["blad"])){
					if($_GET["blad"]=="puste")
						echo "<span style=\"color:red\">Pola nie mogą być puste!</span>";
					else if($_GET["blad"]=="haslo")
						echo "<span style=\"color:red\">Powtórz hasło jeszcze raz.</span>";
					else if($_GET["blad"]=="loginistnieje")
						echo "<span style=\"color:red\">Użytkownik o takim loginie istnieje!</span>";
					else if($_GET["blad"]=="blad")
						echo "<span style=\"color:red\">Nieprawidłowy login lub hasło.</span>";
					else if($_GET["blad"]=="sukces")
						echo "<span style=\"color:green\">Sukces! Przejdź do sekcji \"zaloguj\".</span>";
				}
				?>
				<form action="rejestruj.php" method="get">
					<p>Login:<input name="login" /></p>
					<p>Hasło:<input type="password" name="haslo" /></p>
					<p>Powtórz Hasło:<input type="password" name="powtorz" /></p>
					<p><input value="Zarejestruj" type="submit"></p>
					Uwaga! Hasło nie jest w żaden sposób szyfrowane. 
				</form>
			</div>
			<div id="kontener">
				<?php echo file_get_contents("stopka.txt"); ?>
			</div>
		</div>
	</body>
</html>