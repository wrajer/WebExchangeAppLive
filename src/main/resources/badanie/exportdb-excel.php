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

 //to ponizej esortuje excela i wg mnie powino to być w TRY ale mogę sie mylić:

$stmt=$polaczenie->prepare('select * from pacjenci');
$stmt->execute();

$columnHeader ='';
$columnHeader = "id"."\t"."Imie"."\t"."Nazwisko"."\t"."PESEL"."\t"."Komorka"."\t"."WagaP"."\t"."WagaA"."\t"."Wzrost"."\t"."KtoraC"."\t"."TydzC"."\t"."WiekZ"."\t"."Poj?"."\t"."NadciIn"."\t"."NadciPC"."\t"."CukC"."\t"."CukPC"."\t"."InneChoroby"."\t"."TSH"."\t"."Cis"."\t"."HR"."\t"."ABPM"."\t"."leki"."\t"."Dodano"."\t"."Lek ID"."\t";

$setData='';

while($rec =$stmt->FETCH(PDO::FETCH_ASSOC))
{
  $rowData = '';
  foreach($rec as $value)
  {
    $value = '"' . $value . '"' . "\t";
    $rowData .= $value;
  }
  $setData .= trim($rowData)."\n";
}


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=Dane_pacjentow.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader)."\n".$setData."\n";


?>
