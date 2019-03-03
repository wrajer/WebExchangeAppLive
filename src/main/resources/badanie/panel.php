<?php
session_start(); //start sesji, dołacznie do istniejacej sesji 

//sprawdzenie czy zalogowany
if(!isset($_SESSION['zalogowany']))
	{
		header('Location:index.php'); 
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
	
	<div class="containerPanel">
		
		<br> 		 
		<table align="center">
		  <tr>
			<td align="center"><a href="formularz.php"><button class="btn success">Dodaj dane pacjenta</button></a></td>
			<td align="center"><a href="logout.php"><button class="btn warning" >Wyloguj się</button></a></td>
		  </tr>
		  <?php		  
		  if($_SESSION['admin']) //dzięki temu admin widzi więcej 
					{echo '
		  <tr>
			<td align="center"><a href="uzytkownicydb.php"><button class="btn info">Lista użytkowników</button></a></td>
			<td align="center"><a href="exportdb.php"><button class="btn danger">Baza danych</button></a></td>
		  </tr>';}
		  ?>
		</table>
			
		<?php
			if (isset($_SESSION['info']))
			{
				echo '
				<table align="center">
				  <tr>
					<td align="center"><br><br><br><div class="error">'.$_SESSION['info'].'</div></td>	
				  </tr>		
				</table>
				';
				unset($_SESSION['info']);
			}
		?>
		
		
	</div>	
	</body>
</html>


