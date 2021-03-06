<?php
//Original Author: Saurabh Sood (his maximum code is either commented or deleted)
//Modification Done by: Karan Dwivedi (maximum code running or exists as comments)
error_reporting(E_ALL);
$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = '';
$password = '';

// Initial connection to the inbox
$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

// Grabs any e-mail that is not read
$emails = imap_search($inbox,'SUBJECT "MakeMyTrip E-Ticket & Invoice for Booking" SINCE "1 January 2014"');

//values to be parsed from email
$message_date=null;
$arrivalsArray=null;
$departuresArray=null;
$arrivalTimes = null;
$departureTimes = null;

if($emails){

//declare limit variable... this will limit the # of email to show. 
$limit = count($emails);

//loop each email retrieve.
foreach($emails as $email_number){

 //if limit is true. Break the loop and exit. 
 if($limit == 0)
 break;

 $limit--;

 //fetch the email over view... if you want to see the overview of the email.(OPTIONAL)
 $overview = imap_fetch_overview($inbox,$email_number,0);
 
 $message_date =  $overview[0]->date;
 
 //fetch the email content body... This will show only the email content. 
 $message = imap_fetchbody($inbox, $email_number,"1");
 
 //strip existing HTML tags to display text content only.(JUST COMMENT IT IF YOU WANT TO DISPLAY IT IN AN HTML FORMAT)
 $message = strip_tags($message);

 //echo $message;

 //fetch arrivals
 $arrivalsArray = array();

 $arrivalOffset = 0;

 $arrival = strpos($message, "hrsArrival", $arrivalOffset);

 while($arrival){
 
 //echo "\n";
 
 $arrivalOffset = $arrival + 1;
 
 $equalTo = strpos($message, "=", $arrivalOffset);
 
 $arrivalString = substr($message, $arrival + 10, $equalTo - ($arrival + 10));
 
 trim($arrivalString, " \t\n\r\0\x0B\x20");
 
 //echo $arrivalString; 
 
 $arrivalsArray[] = $arrivalString;
 
 $commaPos = strpos($message, ",", $equalTo);
 
 $commaPos = $commaPos + 2;
 
 $hrsPos = strpos($message, "hrs", $commaPos);
 
 $arrivalTimes[] = trim(substr($message, $commaPos, $hrsPos - $commaPos));
 
 //echo $equalTo."\n";
 
 $arrival = strpos($message, "hrsArrival", $arrivalOffset);
 
 }

 //fetch departures
 $departuresArray = array();
 $departureTimes = array();
 
 $departureOffset = 0;

 $departure = strpos($message, "Departure", $departureOffset);

 while($departure){
 
 $departureOffset = $departure + 1;
 
 $equalTo = strpos($message, "=", $departureOffset);
 
 $departureString = substr($message, $departure + 9, $equalTo - ($departure + 9));
 
 trim ($departureString, " \t\n\r\0\x0B\x20");
 
 $departuresArray[] = $departureString;
 
 $commaPos = strpos($message, ",", $equalTo);
 
 $commaPos = $commaPos + 2;
 
 $hrsPos = strpos($message, "hrs", $commaPos);
 
 $departureTimes[] = trim(substr($message, $commaPos, $hrsPos - $commaPos));
 
 $departure = strpos($message, "Departure", $departureOffset);
 
 //echo "\n";
 
 }
 
 } //for loop close
 
 for($i=0; $i<count($departureTimes); $i++){
 
 $equalToPos = strpos($departureTimes[$i], "=", 0);
 
 if($equalToPos){
 
 $departureTimes[$i] = substr($departureTimes[$i],0,$equalToPos-1).substr($departureTimes[$i],$equalToPos+1,strlen($departureTimes[$i])-1);
 
 }
 
 str_replace("\n","",$departureTimes[$i]);
 
 }
 
 /*
 for($i=0; $i<count($arrivalsArray); $i++)
 {
   echo $departuresArray[$i]." ".$departureTimes[$i]."->".$arrivalsArray[$i]." ".$arrivalTimes[$i]."\n";
 }
 */
 
 
 }//if($emails close)

/*$json_string = "{";

$json_string = $json_string."\"flight_date\":[\"".$message_date."\"],";

$json_string = $json_string."\"departures\":[";

for($i=0; $i<count($departuresArray); $i++){

if($i != count($departuresArray) - 1){
$json_string = $json_string."\"".$departuresArray[$i]."\",";
continue;
   }
   
   $json_string = $json_string."\"".$departuresArray[$i]."\"],";

}

$json_string = $json_string."\"arrivals\":[";

for($i=0; $i<count($arrivalsArray); $i++){

if($i != count($arrivalsArray) - 1){
$json_string = $json_string."\"".$arrivalsArray[$i]."\",";
continue;
   }
   
   $json_string = $json_string."\"".$arrivalsArray[$i]."\"],";

}


$json_string = $json_string."\"departure_time\":[";

for($i=0; $i<count($departureTimes); $i++){

if($i != count($departureTimes) - 1){
$json_string = $json_string."\"".$departureTimes[$i]."\",";
continue;
   }
   
   $json_string = $json_string."\"".$departureTimes[$i]."\"],";

}

$json_string = $json_string."\"arrival_time\":[";

for($i=0; $i<count($arrivalTimes); $i++){

if($i != count($arrivalTimes) - 1){
$json_string = $json_string."\"".$arrivalTimes[$i]."\",";
continue;
   }
   
   $json_string = $json_string."\"".$arrivalTimes[$i]."\"]";

}

$json_string = $json_string."}";

//echo $json_string;

//$jsonss = json_decode($json_string);
$jss = json_encode($json_string);*/

$json_ob = array("flight_date" => $message_date, "arrival_time" => $arrivalTimes, "departure_times" => $departureTimes, "departures" => $departuresArray, "arrivals" => $arrivalsArray);
//print_r($json_ob);

header('Content-Type: application/json');
//echo $jss;
echo json_encode($json_ob);
//close the imap connection
imap_close($inbox);

?>
