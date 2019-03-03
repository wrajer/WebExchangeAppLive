<?php
session_start(); //start sesji, dołacznie do istniejacej sesji 

//sprawdzenie czy zalogowany
if(!isset($_SESSION['zalogowany']))
	{
		header('Location:index.php'); 
		exit(); //to wazne bo inaczej cała reszta kody była by wykonywana a tak to odrazu do gry o ile jest sesja otwarta
	}
if($_SESSION['admin']==false)	
	{	
		header('Location:panel.php'); 		
		exit(); 
	}
	

if (isset($_POST['Limie'])) //spradzamy tylko jedno wartośc, można to rozbudować np za pomocą && ale powinno byc ok
{
	$Limie=$_POST['Limie'];
	$Lnazwisko=$_POST['Lnazwisko'];
	$Llogin=$_POST ['Llogin'];
	$Lhaslo=$_POST ['Lhaslo'];
	$Lemail=$_POST['Lemail'];
	$Ladmin=$_POST ['Ladmin'];
	
	
	require_once"connect.php"; //lacznie sie z serwerem 
	mysqli_report(MYSQLI_REPORT_STRICT);//sposób raportowania błedów
	
	try 
	{
		$polacznie= new mysqli($host,$db_user,$db_password,$db_name);
		if($polacznie ->connect_errno!=0) //zabezpiecznie jesli bedzie erroer
		{
			throw new Exception(mysqli_connect_errno()); //rzuć nowy wyjątek
		}
		else 
		{
				//jesli wszsytko wpisane prawidłowo
			
				$rezultat = $polacznie ->query("SELECT id FROM uzytkownicy WHERE user='$Llogin'"); //zapytanie 
				if (!$rezultat) {throw new Exception($polaczenie->error); }
				$ile_takich_maili = $rezultat -> num_rows;
				if($ile_takich_maili>0)
				{
					
					$_SESSION['e_login']="Istnieje juz konto przypisane pod tym loginem. Login musi być unikatowy!";
				}
				else {
			
					if($polacznie -> query("INSERT INTO uzytkownicy VALUES (NULL, '$Limie','$Lnazwisko','$Llogin','$Lhaslo','$Lemail',$Ladmin,CURRENT_TIMESTAMP)"))
					{
						//$_SESSION['udanarejestracja'] = true; 
						//mail("wrajer@gmail.com", "krzysztof Barański kurs", "test php barański", "no headers");
						$_SESSION['info']="Nowy użytkownik został poprawnie dodany do bazy danych!";
						
						
						
						
						
						
						
						header('Location: uzytkownicydb.php');
					}
					else //trzeba rzucic wyjatek
					{
						throw new Exception(mysqli_connect_errno());
					}
				}
			$polacznie ->close(); //zawsze zamykac polaczenie
		}
	}
	
	catch (Exception $e) //to wyłapuje nam błędy 
	{
		echo 'Bład serwera, spróbuj później lub skontaktuj sie z administratorem';
		echo '<br/>Info developerskie'.$e;
	}
	
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
	
		<div class="containerUzytkownicyAdd"> <br>
		<br> 
		<span style = "color:white;  font-family: Arial, Helvetica, sans-serif;	 font-size: 34px; padding:60px;  "> Wpisz dane użytkownika</span>
		<div class="padding150">
		<br> 
		
			<form method="post" >
				
				
				<div class="font-input"><tytul>Imię<br> </tytul>
					<input type="text" name="Limie" placeholder="Imię"  pattern="[a-zA-ZąćęłńóśźżĄĘŁŃÓŚŹŻ]*" style="text-transform:capitalize;" >
				</div>
				<div class="font-input"><tytul>Nazwisko<br> </tytul>
					<input type="text" name="Lnazwisko" placeholder="Nazwisko" pattern="[a-zA-ZąćęłńóśźżĄĘŁŃÓŚŹŻ]*"style="text-transform:capitalize;" >
				</div>	
				<div class="font-input"><tytul>Login<br> </tytul>
					<input type="text" name="Llogin" placeholder="login" required>
				</div>				
				<div class="font-input"><tytul>Hasło<br> </tytul>
					<input type="text" name="Lhaslo" placeholder="haslo" required>
				</div>					
				<div class="font-input"><tytul>E-mail<br> </tytul>
					<input type="email" name="Lemail" placeholder="email">
				</div>
				<br>
				<div class="font-input"><tytul>Administrator</tytul><br>
				  <input type="radio" name="Ladmin" value="1"> Tak
				  <input type="radio" name="Ladmin" value="0" checked> Nie<br><br>
				</div>
								
			</div>	

				<p style=" padding-left: 200px;">
				<input type="submit" name="submit" value="Dodaj" class="btn-login" ><br> <br> <br>  
				<?php
					 if(isset($_SESSION['e_login'])) //jesli jest juz ustawiona to ustawiamy ja echem
					 {
						 echo '<div class="error" style="color:orange; font-size:20px;">'.$_SESSION['e_login'].'</div>';
						 unset ($_SESSION['e_login']);
					 }?>
			</form>
		</p>
		<p style=" padding-left: 160px;">
				<a href="uzytkownicydb.php"><button class="btn warning" >Powrót</button></a>
				</p>

		</div>

	</body>
</html>


