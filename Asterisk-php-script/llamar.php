<html><head></head><body><form method="post">
<input type='text' name='num' /><input type='submit' value="LLAMAR" name='sub' /></form></body><html>

<?php

$fp=fopen("/var/www/html/tels.txt","r");
$x=0;
while (($line=fgets($fp)) != false){
$tels[$x]=$line;
$x++;
}
fclose($fp);
if (isset($_GET['p'])){
$p=$_GET['p'];
}else{
$p=0;
}
for ($i=$p;$i<$p+1;$i++){
echo "Llamando a $tels[$i] $i" . "<br />";
$fp=fopen("/var/tmp/llamar$p.call","w");
fwrite($fp,"Channel: SIP/netelip/$tels[$i]\n");
fwrite($fp,"MaxRetries: 5\n");
fwrite($fp,"RetryTime: 300\n");
fwrite($fp,"WaitTime: 45\n");
fwrite($fp,"Context: outboundmsg1\n");
fwrite($fp,"Extension: s\n");
fwrite($fp,"Priority: 1\n");
fwrite($fp,"Set: numtel= $tels[$i]\n");
system("mv /var/tmp/llamar$p.call /var/spool/asterisk/outgoing");
system("chmod 777 /var/spool/asterisk/outgoing/llamar$p.call");
echo "Listo el llamado a $tels[$i]";
}
fclose($fp);
$p=$p+1;
	
echo '<META HTTP-EQUIV="refresh" CONTENT="5; URL=llamar.php?p=' . $p . '">';








//if (isset($_POST['sub'])){
//$num=$_POST['num'];
/* $fp=fopen("/var/tmp/llamar.call","w");
fwrite($fp,"Channel: SIP/netelip/$num\n");
fwrite($fp,"MaxRetries: 5\n");
fwrite($fp,"RetryTime: 300\n");
fwrite($fp,"WaitTime: 45\n");
fwrite($fp,"Context: outboundmsg1\n");
fwrite($fp,"Extension: s\n");
fwrite($fp,"Priority: 1\n");
fclose($fp); 
 system("mv /var/tmp/llamar.call /var/spool/asterisk/outgoing"); 
echo "Listo el llamado a $num";
} */


 ?>
