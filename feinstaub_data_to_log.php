<html>
<head>
   <title>feinstaub_data_to_log.php</title>
   <?php 
   // Speichert die via >file_get_contents('php://input')< erhaltenen
   // Daten in YYYYmmdd.log Dateien im JSON-Format ab.
   ?>
   <?php 
   ini_set('display_errors', 'On');
   error_reporting(E_ALL | E_STRICT); 
   ?>
   
</head>
<body>
	<?php echo '<p>feinstaub_data.php</p>'; ?>
	
	<?php
	$logURL="./feinstaub.log";
	$logToOrdner="feinstaublog/".date('Ymd').".log";
	$itime= time();//timestamp Januar 1 1970 00:00:00 GMT
	$datum= date('Y-m-d');
	$zeit=  date('G:i:s');
	$daten = file_get_contents('php://input');

	//aktuelles Messwert
	echo '<p>'.$logURL.'</p>';
	echo '<p>'.$logToOrdner.'</p>';
	$handle=fopen($logURL,'w') or die('Can not open: '.$logURL);//Datei überschreiben
	echo '<p>'.$handle.'</p>';
	fwrite ($handle, "{" );
	fwrite ($handle, '"time":'.$itime.',');
	fwrite ($handle, '"datum":"'.$datum.'",');
	fwrite ($handle, '"zeit":"'.$zeit.'",');
	fwrite ($handle, '"daten":'.$daten  );
	fwrite ($handle, "}".chr(10) );
	fclose ($handle);

	//als Datensätze in Ordner, 
	$add=file_exists($logToOrdner);
	$handle=fopen($logToOrdner,'a');//Daten anhängen
	$ip = $_SERVER['REMOTE_ADDR'];
	$domain = gethostbyaddr($ip);

	if($add)fwrite ($handle, "," );
	fwrite ($handle, "{" );
	fwrite ($handle, '"ip":"'.$_SERVER['REMOTE_ADDR'].'",');
	fwrite ($handle, '"domain":"'.$domain.'",');
//	fwrite ($handle, '"ip":'.$_SERVER['REMOTE_ADDR'].',');
	fwrite ($handle, '"time":'.$itime.',');
	fwrite ($handle, '"datum":"'.$datum.'",');
	fwrite ($handle, '"zeit":"'.$zeit.'",');
	fwrite ($handle, '"daten":'.$daten  );
	fwrite ($handle, "}".chr(10) );
	fclose ($handle);
	?>
</body>
</html>
