<?php
session_start(); //start sesji, dołacznie do istniejacej sesji 

//sprawdzenie czy zalogowany
if(!isset($_SESSION['zalogowany']))
	{
		header('Location:index.php'); 
		exit(); //to wazne bo inaczej cała reszta kody była by wykonywana a tak to odrazu do gry o ile jest sesja otwarta
	}
	
if($_SESSION['admin']==false)	{	
	header('Location:panel.php'); 		
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
 
 $stmt=$polaczenie->prepare('select * from pacjenci');
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
      <h3>Obecny stan bazy danych pacjentów</h3>
      <div class="panel-body">
        <table border="1" class="table table-bordered table-striped">
    				<tr>
    					<th>ID</th>
    					<th width="120">Imię</th>
    					<th>Nazwisko</th>
						<th>PESEL</th>
						<td>Komórka</td>
						<td>WagaP</td>
						<td>WagaA</td>
						<td>Wzrost</td>
						<td>Ciaza</td>
						<td>Tydz</td>
						<td>WiekZ</td>
						<td>Poj?</td>
						<td>NadciIn</td>
						<td>NadciPC</td>
						<td>CukC</td>
						<td>CukPC</td>
						<td>InneChoroby</td>
						<td>TSH</td>
						<td>Cis</td>
						<td>HR</td>
						<td>ABPM</td>
						<td>leki</td>
						<td>Lek ID</td>
    				</tr>
    			<?php
 
    			while($row=$stmt->FETCH(PDO::FETCH_ASSOC)){
    				echo '
    				<tr>
    					<td>'.$row["id"].'</td>
    					<td>'.$row["imie"].'</td>
						<td>'.$row["nazwisko"].'</td>
    					<td>'.$row["pesel"].'</td>
						<td>'.$row["komorka"].'</td>
						<td>'.$row["wagaPrzedCiaza"].'</td>
						<td>'.$row["wagaAktualna"].'</td>
						<td>'.$row["wzrost"].'</td>
						<td>'.$row["ciaza"].'</td>
						<td>'.$row["tydzienCiazy"].'</td>
						<td>'.$row["wiekZajscia"].'</td>
						
						<td>'.$row["ciazaPojedyncza"].'</td>
						<td>'.$row["nadcisIndukowane"].'</td>
						<td>'.$row["nadcisPrzedCiaza"].'</td>				
						<td>'.$row["cukrzycaCiazowa"].'</td>
						<td>'.$row["cukrzycaPrzedciaza"].'</td>
						<td>'.$row["inneChoroby"].'</td>
						<td>'.$row["TSH"].'</td>
						<td>'.$row["cisnienie"].'</td>
						<td>'.$row["HR"].'</td>
						<td>'.$row["ABPM"].'</td>
						<td>'.$row["leki"].'</td>
						<td>'.$row["user_id"].'</td>
    				</tr>
    				';
    			}
		
    			?>
		
	
				
    		</table>
    		<a href="exportdb-excel.php">Export To Excel</a>
			
			
		<table align="center" width="368">
		  <tr >
			<td align="center" height="55"><a href="formularz.php"><button class="btn success">Dodaj dane pacjenta</button></a></td>
			<td align="center"><a href="logout.php"><button class="btn warning" >Wyloguj się</button></a></td>
		  </tr >
		  <tr>
			<td align="center"><a href="uzytkownicydb.php"><button class="btn info">Lista użytkowników</button></a></td>
			<td align="center"><a href="exportdb.php"><button class="btn danger">Baza danych</button></a></td>
		  </tr>
		</table>
 
      </div>
 
    </div>
 
  </div>
 
</div>
 
 
 
</body>
</html>



