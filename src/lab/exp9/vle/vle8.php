<?php
session_start(); 

$usr_val = $_POST["percent1"];
//echo $usr_val ;
include_once("config.inc.php");

# Inherit database connection information from variables defined in config.inc.php
 global $db, $db_host, $db_user, $db_password;
$eid = $_SESSION['eid'];
 # Connect to the database and report any errors on connect.
 $cid = mysql_connect($db_host,$db_user,$db_password);

/*
 if (!$cid) {
  die("ERROR: " . mysql_error() . "\n");
 } 
$_POST['a'] ="";

$i = $_POST["i"];

if($_POST['a']!="")
{
$checked = $_POST['a'];
foreach($checked as $item) {

mysql_select_db ("$db");
 $result = mysql_query("UPDATE vle_data
SET flag='1' 
WHERE Srno='$item'") or die("MySQL Login Error: ".mysql_error()); 


#echo "Item $item was checked<br />";
# Check for errors.
 if (!$result) {

  die("ERROR: " . mysql_error() . "\n");

 } 



} 


}

*/
mysql_select_db ("$db");
$stuff = mysql_query("SELECT * FROM `vle_data` where eid='$eid' and flag='0'") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) { 

$row=mysql_num_rows($stuff);
$mes_val ="";
while($row = mysql_fetch_array($stuff))
  {

  $vle_t=$row['t'];
    $vle_rix=$row['rix'];
       $vle_riy=$row['riy'];
      $Srno=$row['Srno'];

$mes_val= $mes_val.$vle_t." ".$vle_rix." ".$vle_riy."%";


$P=1;
   $A1=14.3916;
   $B1=2795.82;
   $C1=-43.15;
   $A2=13.8594;
   $B2=2773.78;
   $C2=-53.08;
   $m=1;


$T=$vle_t+273;
   $P_sat1=exp($A1-$B1/($T+$C1))/101.325;
   $P_sat2=exp($A2-$B2/($T+$C2))/101.325;
   $x=(1.4943-$vle_rix)/0.1359;
   $y=(1.4943-$vle_riy)/0.1359;

   if($x<=0.01||($x-0.99)>=0) //To remove divide by zero case...
       continue;
  

   $G1= $P*$y/($P_sat1*$x);
   $G2=$P*(1-$y)/($P_sat2*(1-$x));
   $ge=($x*log($G1)+(1-$x)*log($G2))/($x*(1-$x)); //Ge/RTx1x2
   $g1log=log($G1);
   $g2log=log($G2);

  // $Y(m,1:5)=[x, y, log(G1),log(G2),GE];

$x = round($x,4);
$y = round($y,4);
$g1log = round($g1log,4);
$g2log = round($g2log,4);
$ge = round($ge,4);
$gy= $g1log - $g2log;

mysql_select_db ("$db");
 $result = mysql_query("UPDATE vle_data
SET x='".$x."',y='".$y."',g1log='".$g1log."',g2log='".$g2log."', ge='".$ge."', gy='".$gy."'
WHERE Srno='".$Srno."'") or die("MySQL Login Error: ".mysql_error()); 


#echo "Item $item was checked<br />";
# Check for errors.
 if (!$result) {

  die("ERROR: " . mysql_error() . "\n");

 } 

 


}

//echo $mes_val;

}



mysql_select_db ("$db");
$stuff = mysql_query("SELECT x , gy FROM vle_data WHERE eid='".$eid."' AND gy <= 0 ORDER BY x ASC") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) { 

$row=mysql_num_rows($stuff);
$mes_val ="";
while($row = mysql_fetch_array($stuff))
  {

  $x=$row['x'];
    $gy=$row['gy'];
   
$x1[] = $x;
   
$gy1[] = $gy;

//echo $x." 2222222222222222222222222222222222222".$gy;


}


}



mysql_select_db ("$db");
$stuff = mysql_query("SELECT x , gy FROM vle_data WHERE eid='".$eid."' AND gy > 0 ORDER BY x ASC") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) { 

$row=mysql_num_rows($stuff);
$mes_val ="";
while($row = mysql_fetch_array($stuff))
  {

  $x=$row['x'];
    $gy=$row['gy'];


   
$x2[] = $x;
   
$gy2[] = $gy;


//echo $x." ".$gy;


}


}



mysql_select_db ("$db");
$stuff = mysql_query("SELECT count(x) FROM vle_data WHERE eid='".$eid."' AND gy <= 0 ORDER BY x ASC") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) { 

$row=mysql_num_rows($stuff);
$mes_val ="";
while($row = mysql_fetch_array($stuff))
  {

  $count_x1=$row['count(x)'];

//echo "<br>";

//echo $x."count <= ";


}


}

mysql_select_db ("$db");
$stuff = mysql_query("SELECT count(x) , gy FROM vle_data WHERE eid='".$eid."' AND gy > 0 ORDER BY x ASC") or die("MySQL Login Error: ".mysql_error()); 

if (mysql_num_rows($stuff) > 0) { 

$row=mysql_num_rows($stuff);
$mes_val ="";
while($row = mysql_fetch_array($stuff))
  {

  $count_x2=$row['count(x)'];


//echo $x."count > ";


}


}








$array = array(1, 2, 3, 4, 5);
//print_r($array);



// Append an item (note that the new key is 5, instead of 0).
$array[] = 6;
echo "x1";
//print_r($x1);
echo "x2";
//print_r($x2);
echo "gy1";
//print_r($gy1);
echo "gy2";
//print_r($gy2);


for($i=0;$i<=299; $i++){
			$a[$i]= $i;
		
		}			
$t = $a;
//print_r($t);
	$p1 = $_POST["percent1"];
	//$p2 = $_POST["percent2"];
	//$message = $p1." ".$p2;

//echo "x1###################################################"."<br>";

$a1 = 0;
for($i=0;$i<=$count_x1 - 2; $i++){

$a1 = $a1 + 0.5 * ($x1[$i+1]-$x1[$i])*($gy1[$i+1]+$gy1[$i]);

}




$a2 = 0;
for($i=0;$i<=$count_x2 - 2; $i++){

$a2 = $a2 + 0.5 * ($x2[$i+1]-$x2[$i])*($gy2[$i+1]+$gy2[$i]);

}
$p = abs($a1/$a2);
//echo $p;



	$sys = $_SESSION['sys'];
	if($usr_val<0.8*$p && $usr_val>1.2*$p )
	{
	echo "<center><h1>Error in Calculations ; do it again.</h1>";
	echo "<a href=vle7.php><img border=0 src=next.jpg></a></center>";
	}
	elseif($usr_val>=0.8*$p && $usr_val<=1.2*$p)
	{

	echo "<center><h1>Calculations are correct and data consistency error is within bounds.</h1>";
	echo "<a href=vle9.php?mod=$sys><img border=0 src=next.jpg></a></center>";
	}
	else
	{
        echo "<center><h1>The error entered exceeds the suggested limits , do the runs again.</h1>";
	echo "<a href=vle2.php?sys=$sys><img border=0 src=next.jpg></a></center>";
	}



?>
	

