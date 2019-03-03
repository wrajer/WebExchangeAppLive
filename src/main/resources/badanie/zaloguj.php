<?php
session_start();
	//sprawdzenie czy juży czy zalogowany, jeśli nie to zakaz dostępu
	if(!isset($_POST['login'])|| !isset($_POST['haslo'])) 
	{
		header('Location:index.php'); 
		exit(); 
	}
	//pobieramy informacje o db z innego pliku, pobieramy stamtąd dane
	require_once"connect.php";  

	//polacznie otwarte
	$polaczenie= @new mysqli($host,$db_user,$db_password,$db_name); 
	

	if($polaczenie ->connect_errno!=0) //zabezpiecznie jesli bedzie erroer
	{
		echo"Error:".$polaczenie->connect_errno;
	}

	else  //w innym wypadku sprawdzamy czy dane logowania sa w systemie
	{
		$login=$_POST['login']; 
		$haslo=$_POST['haslo'];

		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
		
		//jeśli uda się połączyć z tymi danymi
		if ($rezultat=@$polaczenie->query(
			sprintf("SELECT * FROM uzytkownicy WHERE user='%s' AND pass='%s'",
			mysqli_real_escape_string($polaczenie,$login),
			mysqli_real_escape_string($polaczenie,$haslo))))
			{ 
				$ilu_userow = $rezultat->num_rows; //zapytanie ile userow jest o tych danych w bazie
				
				
				if($ilu_userow>0) 
				{	
					
					$_SESSION['zalogowany'] = true; //to jest zmianne sprawdzajaa zy jesteśmy zalogowani 
						
					$wiersz = $rezultat->fetch_assoc(); //funkcja zabiera wszystkie dane z danego pobranego rzedu, po nazwach kolumn z db
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['imie'] = $wiersz['imie'];
					$_SESSION['nazwisko'] = $wiersz['nazwisko'];
					$_SESSION['user'] = $wiersz['user'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['admin'] = $wiersz['admin'];
						
					unset($_SESSION['blad']);
					$rezultat->free_result();
					
					header('Location: panel.php'); //przekierowanie do innego pliku po zalogowaniu
					
				}			 
				else //jesli wpisał złe dane logowania
				{
					$_SESSION['blad'] = '<span style = "color:red"> Nieprawidłowy login lub hasło</span>';
					header('Location: index.php'); 
					
				}
			}

			$polaczenie->close();
	}
?>
