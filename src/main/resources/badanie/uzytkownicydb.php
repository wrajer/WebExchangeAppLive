<?php
session_start(); //start sesji, dołacznie do istniejacej sesji 

//sprawdzenie czy zalogowany
if(!isset($_SESSION['zalogowany']))
	{
		header('Location:index.php'); 
		exit(); //to wazne bo inaczej cała reszta kody była by wykonywana a tak to odrazu do gry o ile jest sesja otwarta
	}
	
if($_SESSION['admin']==false)	{	
	header('Location:index.php'); 		
	exit(); 
	}
require_once"connect.php"; //lacznie sie z serwerem 
	
 try
 {
     $polaczenie = new PDO("mysql:host={$host};dbname={$db_name}",$db_user,$db_password);
     $polaczenie->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 }
 catch(PDOException $e)
 {
	 echo 'Bład serwera, spróbuj później lub skontaktuj sie z administratorem';
	 echo '<br/>Info developerskie';
     echo "ERROR : ".$e->getMessage();
 }
 
 $stmt=$polaczenie->prepare('select * from uzytkownicy');
 $stmt->execute();
 
 //href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
?>

<!DOCTYPE html>
<html lang="pl"> 
<head>
<title>Obecny stan bazy danych pacjentów</title>
<link rel="stylesheet"  href="bootstrap.min.css"  type="text/css" >
</head>
<body >
<div class="container">
  <div class="panel">
    <div class="panel-heading">
       <h3>Zestawienie użytkowników serwisu</h3>
      <div class="panel-body">
        <table border="1" class="table table-bordered table-striped">
    				<tr>
    					<td>ID</td>
    					<td>Imię</td>
    					<td>Nazwisko</td>
						<th>Login</th>
						<th>Hasło</th>
						<td>E-mail</td>
						<td>Admin ?</td>
						<td>Stworzony</td>		
    				</tr>
    			<?php
 
    			while($row=$stmt->FETCH(PDO::FETCH_ASSOC)){
    				echo '
    				<tr>
    					<td>'.$row["id"].'</td>
    					<td>'.$row["imie"].'</td>
						<td>'.$row["nazwisko"].'</td>
    					<td>'.$row["user"].'</td>
						<td>'.$row["pass"].'</td>
						<td>'.$row["email"].'</td>
						<td>'.$row["admin"].'</td>
						<td>'.$row["timestamp"].'</td>						
    				</tr>
    				';
    			}
    			?>		
    		</table>
    				
			
		<table align="center" width="368">
		  <tr >
			<td align="center" height="55"><a href="formularz.php"><button class="btn success">Dodaj dane pacjenta</button></a></td>
			<td align="center"><a href="logout.php"><button class="btn warning" >Wyloguj się</button></a></td>
		  </tr>
		  <tr>
			<td align="center"><a href="uzytkownicyadd.php"><button class="btn info">Dodaj użtkownika</button></a></td>
			<td align="center"><a href="exportdb.php"><button class="btn danger">Baza danych</button></a></td>
		  </tr>
		</table>
		
		<?php
			if (isset($_SESSION['info']))
			{
				echo '
				<table align="center">
				  <tr>
					<td align="center"><br><div class="error">'.$_SESSION['info'].'</div></td>	
				  </tr>		
				</table>
				';
				unset($_SESSION['info']);
			}
		?>
		
 
      </div>
 
    </div>
 
  </div>
 
</div>
 
 
 
</body>
</html>



