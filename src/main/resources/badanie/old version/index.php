<?php
session_start();
//sprawdzenie czy już zalogowany, tylko tyle
if(isset($_SESSION['zalogowany'])&&($_SESSION['zalogowany']==true ) )
{
	header('Location: panel.php'); //zmienic póxniej na formularz lub
	exit(); //to wazne bo inaczej cała reszta kody była by wykonywana a tak to odrazu do gry o ile jest sesja otwarta
}
?>





<!DOCTYPE html>
<html lang="pl">
	<head>
		<meta charset="utf-8"/>  <!-- polskie znaku -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/> 
		<title>Badanie "Nazwa badania oraz dodatkowy opis" </title>
		<link rel="stylesheet" type="text/css" href="style.css"></link> <!-- nakierownie na style CSS -->
	</head>

	<body>
	
		<div class="container">
			<img src="logo-tarcza-nazwa-en_samo_logo.png" />
			<form action = "zaloguj.php" method="post" >
			
				<div class="font-input">
					<input type="text" name="login" placeholder="Wprowadź login">
				</div>
				<div class="font-input">
					<input type="password" name="haslo" placeholder="Wprowadź hasło">
				</div>
				<input type="submit" name="submit" value="Zaloguj się" class="btn-login"><br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
						
		
			</form>
			
		</div>
		<?php
		 if (isset($_SESSION['blad'])) //sprawdza czy taka zmienna istnieje, podobnie moze byc z guzikiem wstecz
		 {
			 echo '
				<table align="center">
				  <tr>
					<td align="center"><br><div class="error">'.$_SESSION['blad'].'</div></td>	
				  </tr>		
				</table>
				';
			 unset($_SESSION['blad']);
		 }
		?>
		
		
		
	</body>
</html>


