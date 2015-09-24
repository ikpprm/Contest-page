<?php     
function ReverseIPOctets($inputip){
			$ipoc = explode(".",$inputip);
			return $ipoc[3].".".$ipoc[2].".".$ipoc[1].".".$ipoc[0];
			}
/*
 * 
 * Test.php
 * 
 * 
 */
//print_r($_REQUEST);

//I replace these with the correct details    
define('DB_NAME', 'whackedo_Analytics');
define('DB_USER', 'whackedo_ramesh');
define('DB_PASSWORD', 'mango@123');
define('DB_HOST', 'localhost:3306');
$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);

if (!$link) {
    die('Could not connect: ' . myself_error());
}
$db_selected = mysql_select_db(DB_NAME, $link);
if (!$db_selected) {
    die('Can\'t use ' . DB_NAME . ': ' . mysql_error());
}

//$input = $_SERVER['HTTP_HOST'];

//$path = parse_url($input, PHP_URL_PATH); // gives "/pwsdedtech"
//$UserSurl = substr($path, 1); // gives "pwsdedtech"
$UserSurl =$_REQUEST['page'];
//echo $UserSurl;


if (isset($UserSurl) && !empty($UserSurl)) 
{
//$array = mysql_fetch_row(mysql_query("select url_short,url_hits,url_id from urls where url_short='$UserSurl'"));
$result = mysql_query("select url_short,Ref_hits,url_id,name from Fans where url_short='$UserSurl' order by url_date DESC Limit 1");
$array = mysql_fetch_array($result);
$clicks = $array['Ref_hits'] + 1;
$id = $array['url_id'];
$rname = $array['name'];

/*
*
*TOR
*/


	if (gethostbyname(ReverseIPOctets($_SERVER['REMOTE_ADDR']).".".$_SERVER['SERVER_PORT'].".".ReverseIPOctets($_SERVER['SERVER_ADDR']).".ip-port.exitlist.torproject.org")=="127.0.0.2") {
							
							$Tor = "True";
						} 
		else {
			
				$Tor = "False";
			} 

	




/*
*
*/

$rresultu = mysql_query("select ID,Referrer_url,Ref_Name,Url_short,Ref_id from Log where referrer_url='".$_REQUEST['page']."' order by Created_Timestamp DESC Limit 1;");
$arrrayu = mysql_fetch_array($rresultu);
$iddu = $arrrayu['ID'];
$iddur = $arrrayu['Url_short'];

if(empty($iddu) || !empty($iddur))
{
//echo "select url_short,url_hits,url_id from urls where url_short='$UserSurl'";
//echo "UPDATE urls SET url_hits='$clicks' where url_id='$id'";

mysql_query("UPDATE Fans SET Ref_hits='$clicks' where url_id='$id'");
//Log File
mysql_query("insert into Log (
IS_Tor,
Referrer_url,
Ref_Name,
Ref_id,
PHP_SELF,
argv,
argc,
GATEWAY_INTERFACE,
SERVER_ADDR,
SERVER_NAME,
SERVER_SOFTWARE,
SERVER_PROTOCOL,
REQUEST_METHOD,
REQUEST_TIME,
REQUEST_TIME_FLOAT,
QUERY_STRING,
DOCUMENT_ROOT,
HTTP_ACCEPT,
HTTP_ACCEPT_CHARSET,
HTTP_ACCEPT_ENCODING,
HTTP_ACCEPT_LANGUAGE,
HTTP_CONNECTION,
HTTP_HOST,
HTTP_REFERER,
HTTP_USER_AGENT,
HTTPS,
REMOTE_ADDR,
REMOTE_HOST,
REMOTE_PORT,
REMOTE_USER,
REDIRECT_REMOTE_USER,
SCRIPT_FILENAME,
SERVER_ADMIN,
SERVER_PORT,
SERVER_SIGNATURE,
PATH_TRANSLATED,
SCRIPT_NAME,
REQUEST_URI,
PHP_AUTH_DIGEST,
PHP_AUTH_USER,
PHP_AUTH_PW,
AUTH_TYPE,
PATH_INFO,
ORIG_PATH_INFO,
HTTP_CLIENT_IP,
HTTP_X_FORWARDED_FOR,
HTTP_X_FORWARDED,
HTTP_FORWARDED_FOR,
HTTP_FORWARDED) values ('".$Tor."','".$UserSurl."','".$rname."','".$id."','".$_SERVER['PHP_SELF']."','".$_SERVER['argv']."','".$_SERVER['argc']."','".$_SERVER['GATEWAY_INTERFACE']."','".$_SERVER['SERVER_ADDR']."','".$_SERVER['SERVER_NAME']."','".$_SERVER['SERVER_SOFTWARE']."','".$_SERVER['SERVER_PROTOCOL']."','".$_SERVER['REQUEST_METHOD']."','".$_SERVER['REQUEST_TIME']."','".$_SERVER['REQUEST_TIME_FLOAT']."','".$_SERVER['QUERY_STRING']."','".$_SERVER['DOCUMENT_ROOT']."','".$_SERVER['HTTP_ACCEPT']."','".$_SERVER['HTTP_ACCEPT_CHARSET']."','".$_SERVER['HTTP_ACCEPT_ENCODING']."','".$_SERVER['HTTP_ACCEPT_LANGUAGE']."','".$_SERVER['HTTP_CONNECTION']."','".$_SERVER['HTTP_HOST']."','".$_SERVER['HTTP_REFERER']."','".$_SERVER['HTTP_USER_AGENT']."','".$_SERVER['HTTPS']."','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['REMOTE_HOST']."','".$_SERVER['REMOTE_PORT']."','".$_SERVER['REMOTE_USER']."','".$_SERVER['REDIRECT_REMOTE_USER']."','".$_SERVER['SCRIPT_FILENAME']."','".$_SERVER['SERVER_ADMIN']."','".$_SERVER['SERVER_PORT']."','".$_SERVER['SERVER_SIGNATURE']."','".$_SERVER['PATH_TRANSLATED']."','".$_SERVER['SCRIPT_NAME']."','".$_SERVER['REQUEST_URI']."','".$_SERVER['PHP_AUTH_DIGEST']."','".$_SERVER['PHP_AUTH_USER']."','".$_SERVER['PHP_AUTH_PW']."','".$_SERVER['AUTH_TYPE']."','".$_SERVER['PATH_INFO']."','".$_SERVER['ORIG_PATH_INFO']."','".$_SERVER['HTTP_CLIENT_IP']."','".$_SERVER['HTTP_X_FORWARDED_FOR']."','".$_SERVER['HTTP_X_FORWARDED']."','".$_SERVER['HTTP_FORWARDED_FOR']."','".$_SERVER['HTTP_FORWARDED']."');");

}
//header('Location: http://localhost/RC/'); exit;



}
$resultc = mysql_query("select url_short,Ref_hits,Clicks,url_id,name from Fans where url_short='$UserSurl' order by url_date DESC Limit 1");
$arrayc = mysql_fetch_array($resultc);
$clickss = $arrayc['Clicks'] + 1;
$idds = $array['url_id'];
//echo $UserSurl."-".$clickss;
mysql_query("UPDATE Fans SET Clicks='$clickss' where url_id='$idds'");

 
/*
 * 
 * End of Test.php
 * 
 * 
 */


$server_name = "http://".$_SERVER['HTTP_HOST']."/";
$name = $_POST["Name"];
$email = $_POST["email1"];
 
$server_name = "http://".$_SERVER['HTTP_HOST']."/";


//create the urls table if it's not already there:
mysql_query("CREATE TABLE IF NOT EXISTS `Fans` (
  `url_id` int(11) NOT NULL auto_increment,
  `name` varchar(200) NOT NULL,
  `Email` varchar(255) default NULL,
  `url_short` varchar(20) default NULL,
  `url_date` Timestamp,
  `url_ip` varchar(255) default NULL,
  `Ref_hits` int(11) default '0',
  `Clicks` varchar(50),
  `IS_Tor` varchar(10),
  PRIMARY KEY  (`url_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;");

mysql_query("create table IF NOT EXISTS `Log`(ID int(11) NOT NULL auto_increment,
        Referrer_url varchar(20),
        Ref_Name varchar(100),
        Url_short varchar(10),
        Ref_id int(11),
	`IS_Tor` varchar(10),
       PHP_SELF varchar(100),
argv varchar(100),
argc varchar(100),
GATEWAY_INTERFACE varchar(100),
SERVER_ADDR varchar(100),
SERVER_NAME varchar(100),
SERVER_SOFTWARE varchar(100),
SERVER_PROTOCOL varchar(100),
REQUEST_METHOD varchar(100),
REQUEST_TIME varchar(100),
REQUEST_TIME_FLOAT varchar(100),
QUERY_STRING varchar(100),
DOCUMENT_ROOT varchar(100),
HTTP_ACCEPT varchar(100),
HTTP_ACCEPT_CHARSET varchar(100),
HTTP_ACCEPT_ENCODING varchar(100),
HTTP_ACCEPT_LANGUAGE varchar(100),
HTTP_CONNECTION varchar(100),
HTTP_HOST varchar(100),
HTTP_REFERER varchar(500),
HTTP_USER_AGENT varchar(500),
HTTPS varchar(100),
REMOTE_ADDR varchar(100),
REMOTE_HOST varchar(100),
REMOTE_PORT varchar(100),
REMOTE_USER varchar(100),
REDIRECT_REMOTE_USER varchar(100),
SCRIPT_FILENAME varchar(100),
SERVER_ADMIN varchar(100),
SERVER_PORT varchar(100),
SERVER_SIGNATURE varchar(100),
PATH_TRANSLATED varchar(100),
SCRIPT_NAME varchar(100),
REQUEST_URI varchar(100),
PHP_AUTH_DIGEST varchar(100),
PHP_AUTH_USER varchar(100),
PHP_AUTH_PW varchar(100),
AUTH_TYPE varchar(100),
PATH_INFO varchar(100),
ORIG_PATH_INFO varchar(100),
HTTP_CLIENT_IP varchar(100),
HTTP_X_FORWARDED_FOR varchar(100),
HTTP_X_FORWARDED varchar(100),
HTTP_FORWARDED_FOR varchar(100),
HTTP_FORWARDED varchar(100),
Created_Timestamp timestamp,
        PRIMARY KEY  (ID));");
//



//redirect to real link if URL is set
if (!empty($_GET['email1'])) {
	$redirect = mysql_fetch_assoc(mysql_query("SELECT Email FROM Fans WHERE url_short = '".addslashes($_GET['email1'])."'"));
	$redirect = "http://".str_replace("http://","",$redirect[url_link]);
	header('HTTP/1.1 301 Moved Permanently');  
	header("Location: ".$redirect);  
}
//

//insert new url
if (($_POST['email1']) && (ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$",$_POST['email1']))) {
/*
*
*TOR
*/

	if (gethostbyname(ReverseIPOctets($_SERVER['REMOTE_ADDR']).".".$_SERVER['SERVER_PORT'].".".ReverseIPOctets($_SERVER['SERVER_ADDR']).".ip-port.exitlist.torproject.org")=="127.0.0.2") {
							
							$Tor = "True";
						} 
		else {
			
				$Tor = "False";
			} 

	



/*
*
*/

//get random string for URL and add http:// if not already there
$short = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5);
date_default_timezone_set("Asia/Calcutta");
mysql_query("INSERT INTO Fans (name,Email, url_short, url_ip,IS_Tor,url_date) VALUES
	(
        '".$_POST["Name"]."',
	'".addslashes($_POST['email1'])."',
	'".$short."',
	'".$_SERVER['REMOTE_ADDR']."',
	'".$Tor."',
	'".date("Y-m-d H:i:s")."'
	)
");

$rresultux = mysql_query("select ID,Referrer_url,Ref_Name,Url_short,Ref_id from Log where referrer_url='".$_REQUEST['page']."' order by Created_Timestamp DESC Limit 1 ;");
$arrrayux = mysql_fetch_array($rresultux);
$iddurx = $arrrayux['Url_short'];

if(!empty($short) || empty($iddurx))
{

$rresult = mysql_query("select ID,Referrer_url,Ref_Name,Url_short,Ref_id from Log where referrer_url='".$_REQUEST['page']."'order by Created_Timestamp DESC Limit 1;");
$arrray = mysql_fetch_array($rresult);
$idd = $arrray['ID'];
mysql_query("update Log set Url_short='".$short."' where ID='".$idd."';");
  
}
$resultt = mysql_query("select url_short,Ref_hits,url_id,name from Fans where url_short='".$_REQUEST['page']."'order by url_date DESC Limit 1;");
$arrayy = mysql_fetch_array($resultt);
$iddd = $arrayy['url_id'];
if(empty($iddd)){mysql_query("insert into Log (
url_short,
IS_Tor,
PHP_SELF,
argv,
argc,
GATEWAY_INTERFACE,
SERVER_ADDR,
SERVER_NAME,
SERVER_SOFTWARE,
SERVER_PROTOCOL,
REQUEST_METHOD,
REQUEST_TIME,
REQUEST_TIME_FLOAT,
QUERY_STRING,
DOCUMENT_ROOT,
HTTP_ACCEPT,
HTTP_ACCEPT_CHARSET,
HTTP_ACCEPT_ENCODING,
HTTP_ACCEPT_LANGUAGE,
HTTP_CONNECTION,
HTTP_HOST,
HTTP_REFERER,
HTTP_USER_AGENT,
HTTPS,
REMOTE_ADDR,
REMOTE_HOST,
REMOTE_PORT,
REMOTE_USER,
REDIRECT_REMOTE_USER,
SCRIPT_FILENAME,
SERVER_ADMIN,
SERVER_PORT,
SERVER_SIGNATURE,
PATH_TRANSLATED,
SCRIPT_NAME,
REQUEST_URI,
PHP_AUTH_DIGEST,
PHP_AUTH_USER,
PHP_AUTH_PW,
AUTH_TYPE,
PATH_INFO,
ORIG_PATH_INFO,
HTTP_CLIENT_IP,
HTTP_X_FORWARDED_FOR,
HTTP_X_FORWARDED,
HTTP_FORWARDED_FOR,
HTTP_FORWARDED) values ('".$short."','".$Tor."','".$_SERVER['PHP_SELF']."','".$_SERVER['argv']."','".$_SERVER['argc']."','".$_SERVER['GATEWAY_INTERFACE']."','".$_SERVER['SERVER_ADDR']."','".$_SERVER['SERVER_NAME']."','".$_SERVER['SERVER_SOFTWARE']."','".$_SERVER['SERVER_PROTOCOL']."','".$_SERVER['REQUEST_METHOD']."','".$_SERVER['REQUEST_TIME']."','".$_SERVER['REQUEST_TIME_FLOAT']."','".$_SERVER['QUERY_STRING']."','".$_SERVER['DOCUMENT_ROOT']."','".$_SERVER['HTTP_ACCEPT']."','".$_SERVER['HTTP_ACCEPT_CHARSET']."','".$_SERVER['HTTP_ACCEPT_ENCODING']."','".$_SERVER['HTTP_ACCEPT_LANGUAGE']."','".$_SERVER['HTTP_CONNECTION']."','".$_SERVER['HTTP_HOST']."','".$_SERVER['HTTP_REFERER']."','".$_SERVER['HTTP_USER_AGENT']."','".$_SERVER['HTTPS']."','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['REMOTE_HOST']."','".$_SERVER['REMOTE_PORT']."','".$_SERVER['REMOTE_USER']."','".$_SERVER['REDIRECT_REMOTE_USER']."','".$_SERVER['SCRIPT_FILENAME']."','".$_SERVER['SERVER_ADMIN']."','".$_SERVER['SERVER_PORT']."','".$_SERVER['SERVER_SIGNATURE']."','".$_SERVER['PATH_TRANSLATED']."','".$_SERVER['SCRIPT_NAME']."','".$_SERVER['REQUEST_URI']."','".$_SERVER['PHP_AUTH_DIGEST']."','".$_SERVER['PHP_AUTH_USER']."','".$_SERVER['PHP_AUTH_PW']."','".$_SERVER['AUTH_TYPE']."','".$_SERVER['PATH_INFO']."','".$_SERVER['ORIG_PATH_INFO']."','".$_SERVER['HTTP_CLIENT_IP']."','".$_SERVER['HTTP_X_FORWARDED_FOR']."','".$_SERVER['HTTP_X_FORWARDED']."','".$_SERVER['HTTP_FORWARDED_FOR']."','".$_SERVER['HTTP_FORWARDED']."');");
}
$redirect = "?s=$short";
header('Location: '.$redirect); die;

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Whacked Out</title>
<style type="text/css">
<!--
body {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 25px;
	text-align: center;
}
input {
	font-size: 20px;
	padding: 10px;
}
h2 {
	font-size: 16px;
	margin: 0px;
	padding: 0px;
}
h1 {
	margin: 0px;
	padding: 0px;
	font-size: 35px;
	color: #009999;
}
form {
	margin: 0px;
	padding: 0px;
}
h3 {
	font-size: 13px;
	color: #666666;
	font-weight: normal;
}
h3 a {
	color: #006699;
	text-decoration: none;
}
table {
	font-size: 13px;
	background-color: #EBEBEB;
	border: 1px solid #CCCCCC;
}


input[type="email1"] {
  border: 1px solid #ddd;
  padding: 4px 8px;
}

input[type="email1"]:focus {
  border: 1px solid #000;
}

input[type="submit"] {
  font-weight: bold;
  padding: 10px 80px;
  border:1px solid #000;
  background: #3b5998;
  color:#fff;
}

form {
  width: 50%;
  margin: 0 auto;
}

.p {
  padding-top: 30px;
}
-->
</style>
</head>

<body>


<h1> Ram Charan BruceLee!!!!!</h1>
<h4>Please Enter Fields and Get a Chance to Meet Ramcharan</h4>
<form id="form1" name="form1" method="post" action="">
<p>Name: <input name="Name" type="text" id="Name" placeholder="Enter Name" />
<p>Email:<input name="email1" type="text" id="email1" value="" placeholder="Enter Email ID" required />
    <br></br>
<input type="submit" name="Submit" value="Go" />
</form>
<!--if form was just posted-->
<?php if (!empty($_GET['s'])) { ?>
<br />
<h2>Share this URL & Get a Chance to meet Ramcharan: <a href="<?php echo $server_name; ?><?php echo "rameshi/RC/".$_GET['s']; ?>" target="_blank"><?php echo $server_name; ?><?php echo "rameshi/RC/".$_GET['s']; ?></a></h2>
<?php
} 
?>
</body>
</html>
