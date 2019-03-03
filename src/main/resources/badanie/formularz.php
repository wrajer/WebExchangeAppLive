<?php
session_start(); //start sesji, dołacznie do istniejacej sesji 

//sprawdzenie czy zalogowany
if(!isset($_SESSION['zalogowany']))
	{
		header('Location:index.php'); 
		exit(); //to wazne bo inaczej cała reszta kody była by wykonywana a tak to odrazu do gry o ile jest sesja otwarta
	}

if (isset($_POST['Pimie'])) //spradzamy tylko jedno wartośc, można to rozbudować np za pomocą && ale powinno byc ok
{
	$Pimie=$_POST['Pimie'];
	$Pnazwisko=$_POST['Pnazwisko'];
	$Ppesel=$_POST ['Ppesel'];
	$Pkomorka=$_POST ['Pkomorka'];
	$PwagaPrzedCiaza=$_POST['PwagaPrzedCiaza'];
	$PwagaAktualna=$_POST ['PwagaAktualna'];
	$Pwzrost=$_POST ['Pwzrost'];
	$Pciaza=$_POST['Pciaza'];
	$PtydzienCiazy=$_POST ['PtydzienCiazy'];
	$PwiekZajscia=$_POST ['PwiekZajscia'];
	$PciazaPojedyncza=$_POST['PciazaPojedyncza'];
	$PnadcisIndukowane=$_POST ['PnadcisIndukowane'];
	$PnadcisPrzedCiaza=$_POST ['PnadcisPrzedCiaza'];
	$PcukrzycaCiazowa=$_POST['PcukrzycaCiazowa'];
	$PcukrzycaPrzedciaza=$_POST ['PcukrzycaPrzedciaza'];	
	$PinneChoroby=$_POST ['PinneChoroby'];
	$PTSH=$_POST ['PTSH'];
	$Pcisnienie =$_POST ['Pcisnienie'];
	$PHR=$_POST ['PHR']; 
	$PABPM=$_POST ['PABPM']; 
	$Pleki=$_POST ['Pleki']; 
	$user_id=$_SESSION['id'];
	$user_login=$_SESSION['user'];
	
	//zmiana TSH na kropke
	if (isset($PTSH)){	$PTSH = str_replace(',', '.', $PTSH);}

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
				if($polacznie -> query("INSERT INTO `pacjenci` (`id`, `imie`, `nazwisko`, `pesel`, `komorka`, `wagaPrzedCiaza`, `wagaAktualna`, 
					`wzrost`, `ciaza`, `tydzienCiazy`, `wiekZajscia`, `ciazaPojedyncza`, `nadcisIndukowane`, `nadcisPrzedCiaza`, `cukrzycaCiazowa`, 
					`cukrzycaPrzedciaza`, `inneChoroby`, `TSH`, `cisnienie`, `HR`, `ABPM`, `leki`, `dodane`, `user_id`)

					VALUES (NULL, '$Pimie','$Pnazwisko',$Ppesel,$Pkomorka,$PwagaPrzedCiaza,$PwagaAktualna,$Pwzrost,$Pciaza,$PtydzienCiazy,
				$PwiekZajscia,'$PciazaPojedyncza','$PnadcisIndukowane',' $PnadcisPrzedCiaza','$PcukrzycaCiazowa','$PcukrzycaPrzedciaza','$PinneChoroby',
				$PTSH,'$Pcisnienie',$PHR,'$PABPM','$Pleki',CURRENT_TIMESTAMP,'$user_id')"))
				{
										
					//wyslanie maila do admina
						$to = 'wrajer@gmail.com';
						$subject = 'Badanie "Tytuł". Został dodany nowy pacjent!"';
						$message = 	$Pimie."/".$Pnazwisko."/".$Ppesel."/".$Pkomorka."/".$PwagaPrzedCiaza."/".$PwagaAktualna."/".$Pwzrost."/".$Pciaza."/".$PtydzienCiazy."/".$PwiekZajscia."/".$PciazaPojedyncza."/".$PnadcisIndukowane."/".$PnadcisPrzedCiaza."/".$PcukrzycaCiazowa."/".$PcukrzycaPrzedciaza."/".$PinneChoroby."/".$PTSH."/".$Pcisnienie."/".$PHR."/".$PABPM."/".$Pleki."/".$user_login;
						$from = "From: Administrator systemu<wrajer@gmail.com>";
						
						mail($to,$subject,$message,$from);
						
						
						$_SESSION['info']= "Dane zostały poprawnie dodane do bazy danych!";
						
					header('Location: panel.php');
				}
				else //trzeba rzucic wyjatek
				{
					throw new Exception(mysqli_connect_errno());
				}
			$polacznie ->close(); //zawsze zamykac polaczenie
		}
	}
	
	catch (Exception $e) //to wyłapuje nam błędy 
	{
		echo 'Bład serwera, spróbuj później lub skontaktuj sie z administratorem';
		echo '<br/>Info developerskie: '.$e;
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
	
		<div class="containerFor">
		<br> 
		<span style = "color:white;  font-family: Arial, Helvetica, sans-serif;	 font-size: 40px; padding:60px; padding-top:20px;"> Wpisz dane pacjenta</span>
		<div class="padding150">
		<br> 
			
		<br> 
			<form method="post" >
				
				
				<div class="font-input"><tytul>Imię<br> </tytul>
					<input type="text" name="Pimie" placeholder="Imię"  pattern="[a-zA-ZąćęłńóśźżĄĘŁŃÓŚŹŻ]*" style="text-transform:capitalize;" required>
				</div>
				<div class="font-input"><tytul>Nazwisko<br> </tytul>
					<input type="text" name="Pnazwisko" placeholder="Nazwisko" pattern="[a-zA-ZąćęłńóśźżĄĘŁŃÓŚŹŻ]*"style="text-transform:capitalize;" required>
				</div>			
				<div class="font-input"><tytul>PESEL<br> </tytul>
					<input type="number" name="Ppesel" placeholder="PESEL" min="10000000000" max="99999999999" >
				</div>
				<div class="font-input"><tytul>Nr komórkowy<br> </tytul>
					<input type="number" name="Pkomorka" placeholder="opcjonalny"  min="100000000" max="999999999" >
				</div>
				<div class="font-input"><tytul>Waga przed ciążą<br> </tytul>
					<input type="number" name="PwagaPrzedCiaza" placeholder="[kg]"  min="30" max="600" >
				</div>
				<div class="font-input"><tytul>Aktualna waga<br> </tytul>
					<input type="number" name="PwagaAktualna" placeholder="[kg]"  min="30" max="600" >
				</div>
				<div class="font-input"><tytul>Wzrost<br> </tytul>
					<input type="number" name="Pwzrost" placeholder="[cm]"  min="100" max="250" >
				</div>
				<div class="font-input"><tytul>Która ciąża?<br> </tytul>
					<input type="number" name="Pciaza" value="1"  min="1" max="25" >
				</div>
				<div class="font-input"><tytul>Który tydzien ciazy?<br> </tytul>
					<input type="number" name="PtydzienCiazy" min="1" max="50"  placeholder="[wpisać coś]" >
				</div>
				<div class="font-input"><tytul>Wiek zajścia w pierwszą ciąże?<br> </tytul>
					<input type="number" name="PwiekZajscia" min="5" max="99" placeholder="[wpisać coś]" >
				</div>
			</div>	
				
			<div class="padding50">	
				<div class="font-input"><tytul>Ciąża pojedyncza?</tytul><br>
				  <input type="radio" name="PciazaPojedyncza" value="tak" checked> Tak
				  <input type="radio" name="PciazaPojedyncza" value="nie"> Nie<br><br>
				</div>
				
				<div class="font-input"><tytul>Nadciśnienie indukowane ciążą?</tytul><br>
				  <input type="radio" name="PnadcisIndukowane" value="tak" > Tak
				  <input type="radio" name="PnadcisIndukowane" value="nie" checked> Nie<br><br>
				</div>
				
				<div class="font-input"><tytul>Nadciśnienie rozpoznane przed ciążą?</tytul><br>
				  <input type="radio" name="PnadcisPrzedCiaza" value="tak" > Tak
				  <input type="radio" name="PnadcisPrzedCiaza" value="nie" checked> Nie<br><br>
				</div>
				
				<div class="font-input"><tytul>Cukrzyca ciążowa?</tytul><br>
				  <input type="radio" name="PcukrzycaCiazowa" value="tak" > Tak
				  <input type="radio" name="PcukrzycaCiazowa" value="nie" checked> Nie<br><br>
				</div>
				
				<div class="font-input"><tytul>Cukrzyca rozpoznana przed ciążą?</tytul><br>
				  <input type="radio" name="PcukrzycaPrzedciaza" value="tak" > Tak
				  <input type="radio" name="PcukrzycaPrzedciaza" value="nie" checked> Nie<br><br>
				</div>
				
				<div class="font-input"><tytul>Czy wykonywano kiedyś ABPM?</tytul><br>
				  <input type="radio" name="PABPM" value="tak" > Tak
				  <input type="radio" name="PABPM" value="nie" checked> Nie<br><br>
				</div>
			</div>
				
			<div class="padding50">	
				<div class="font-input"><tytul>Inne rozpoznane choroby<br> </tytul>
					<textarea type="text" name="PinneChoroby" placeholder="[proszę wpisać wszystkie z dawkami, w tym suplementy]"  cols="38" rows="3">
					</textarea>
				</div>
			</div>
			
			<div class="padding150">
				
				<div class="font-input"><tytul>Stężenie TSH<br> </tytul>
					<input type="number" name="PTSH" placeholder="[np mh/l]"  min="0" max="250"  pattern = "[0-9]*" min="0" value="0" step="0.01"  required>
				</div>
				
				<div class="font-input"><tytul>Ciśnienie krwi<br> </tytul>
					<input type="text" name="Pcisnienie" placeholder="[np. 120/80]" pattern = "[0-9/]*" required>
				</div>
				
				<div class="font-input"><tytul>Puls <br> </tytul>
					<input type="number" name="PHR" placeholder="[HR b-min]"  min="0" max="250" required>
				</div>
			</div>	
				
			<div class="padding50">	
				<div class="font-input"><tytul>Obecnie przyjmowane leki<br> </tytul>
					<textarea type="text" name="Pleki" placeholder="[proszę wpisać wszystkie z dawkami, w tym suplementy]"  cols="38" rows="5">
					</textarea>
				</div>
			</div>	
				
				<p style=" padding-left: 200px;">
				<input type="submit" name="submit" value="Wyślij" class="btn-login" ><br> <br> <br>   
				</p>
				
			</form>
				<p style=" padding-left: 160px;">
				<a href="panel.php"><button class="btn warning" >Powrót do panelu</button></a>
				</p>
		</div>
	</body>
</html>


