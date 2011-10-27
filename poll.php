<html>
<head>
<link href="pollstyle.css" type="text/css" rel="stylesheet"> 
<link rel="icon" type="image/jpg" href="http://www.thegoodwebguide.co.uk/favicon1.jpg"> 
<script type="text/javascript">
function validate_email(field,alerttxt)
{
with (field)
  {
  apos=value.indexOf("@");
  dotpos=value.lastIndexOf(".");
  if (apos<1||dotpos-apos<2)
    {alert(alerttxt);return false;}
  else {return true;}
  }
}

function validate_form(thisform)
{
with (thisform)
  {
  if (validate_email(email,"Not a valid e-mail address!")==false)
    {email.focus();return false;}
  }
}
</script>
</head>
<body>
<?php 

//error reporting TURN OFF LATER
error_reporting(E_ALL);

// Access details
include ('pollaccess.php');

$connection = mysql_connect ($host, $user, $pass) or die ("Error - Unable to Connect");

mysql_select_db($db) or die ("Error- Unable to find database");

//Getting User Choice
$websitechoice = $_GET["Website"];

//Getting date
$date = date("Y-m-d");

//Getting Ip Address
$ip = $_SERVER['REMOTE_ADDR'];

//Check ip against db shut script if already voted
$result = mysql_query("SELECT * FROM votes WHERE ip='$ip'");
while($row = mysql_fetch_array($result))
{
if ($row['ip'] ==$ip) exit("<h3><p align=center>Thanks for voting for the website of the year! <br> You can click <a href='JavaScript:window.close()'>here</a> to close this window.<br>
Please note that you can only vote once.<h3>");
} 
  
?>


<div id="confirm">


	<img src="http://www.thegoodwebguide.co.uk/images/goodwebguide_logo.jpg"</img><br><br>

	Thank you! You have chosen to vote for <b><?php echo ($websitechoice) ?></b>. Please complete these short steps to confirm your
	vote:

	<form method="post" onsubmit="return validate_form(this);" action=""><br>
	Please enter your email:<br>
	<input type="text" name="email"><br><br>
	<input type="checkbox" value="1" name="optin" checked/> Please uncheck if you do not wish to recieve our newsletter.<br><br>
	<input type="submit" value="Vote!"><br><br>
</div>
<?php
//check for form submission 
if($_SERVER['REQUEST_METHOD']=='POST') {
//form into variables
$email = $_POST ["email"];
$optin = $_POST ["optin"];

//write to db 'votes'
$query = "INSERT INTO votes (site, email, ip, date, newsletter) VALUES ('$websitechoice', '$email', '$ip', '$date', '$optin')"; 
$result = mysql_query($query) or die ("Error in query: $query. ".mysql_error()); 
}

//close connection
mysql_close($connection);	
//redirect to success page on pressing submit
if ($_SERVER ['REQUEST_METHOD']=='POST')
	
{    
   echo '<META HTTP-EQUIV="Refresh" Content="0; URL=success.php">';    
   exit;    
}    

?>  
</body>
</html>