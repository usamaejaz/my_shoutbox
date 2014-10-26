<?php
/*
* Usama Ejaz
* thedeveloper24.com
* osamaejaz1[at]gmail.com
*/

require_once("config.php");


$code_head=<<<EOF
<!-- include jQuery if not available -->
<script>window.jQuery || document.write('<script src="//code.jquery.com/jquery-1.10.2.min.js"><\/script>')</script>

<!-- script variables -->
<script>
var base_url="{$base_url}"; //base url
var chat_widget_full_url="{$base_url}"; //static chatbox page url
var chat_header_title="Shoutbox"; //window title
</script>

<!-- include js files -->
<script src="{$base_url}chat_full.js"></script>

<!-- inlcude css -->
<link href="{$base_url}chat.css" rel="stylesheet" type="text/css" />
<style>
.chat_wrapper {
position:relative !important;
border:none !important;
margin:0 !important;
width:100% !important;
right:0 !important;
}
.chat_window {
border:1px solid #FF7400;
margin-bottom:20px;
}
</style>
EOF;


$code_body=<<<EOF


<!-- inside <body> tag -->
<!-- include this div for loading shoutbox -->
<div class="chat_window">
<noscript><div style="text-algin:center;">It needs <b>JAVASCRIPT</b> to be enabled to access this page. Please <a target="_blank" href="http://enable-javascript.com/">enable javascript</a></div></noscript>
</div>
EOF;



if($_GET['get_code_full'] || $_GET['get_code_widget']){
	header("Content-Type:text/plain");
}

if($_GET['get_code_full']){ echo $code_head;if($_GET['body']){ echo $code_body; } die(); } elseif($_GET['get_code_widget']){ echo str_replace("chat_full.js","chat.js", preg_replace("/<style>([\s\S]*?)<\/style>/","",$code_head));die(); }





if($_POST['uname'] && $_POST['pwd']){
	if($_POST['uname']==$admin_username && $_POST['pwd']==$admin_password){
		$_SESSION['admin_shoutbox']=1;
	} else {
		$error="Invalid username or password!";
	}	
}









?>



<!DOCTYPE html>
<html>
<head>
<title>Shoutbox Admin | Usama Ejaz</title>

<!-- include jQuery if not available -->
<script>window.jQuery || document.write('<script src="//code.jquery.com/jquery-1.10.2.min.js"><\/script>')</script>

<style>
.container {
	margin: 0 auto;
	width: 800px;
	font-family: Verdana;
	padding-bottom:10px;
	border-bottom:2px solid #999;
}
h3.title { border-bottom:2px solid #999}
a {
	color: #333;
	text-decoration: none;
	font-family:Arial;
}
a:hover {
	color:#BF6517;
}
div.title {
	clear:both;font-weight:bold;font-style:italic;
	border-bottom:1px solid #ccc;
}
div.message {
	font-family:Arial;
	border: 1px solid #999;
	overflow: hidden;
	padding: 5px;
	margin-bottom: 15px;
}
div.msg { float:left;width:310px;clear:both;margin-top:5px;}
div.del_link { float:right;clear:both;}
.msgs_to_load:before {
	
}
form#login,form#updater{width:auto;padding:20px;padding-top: 40px;}.wrapper-panel{margin:0 auto;border:2px solid #C8C8C8;border-radius:10px;padding:20px;}form label,.hh{color:#595959;text-align:left;font-weight:500;display:block;padding-bottom:2px;max-width:100%;}input[type='text'],input[type='password']{min-height:30px;background-color:#FFF;border:2px solid #C8C8C8;width:100%;max-width:192px;display:block;margin-bottom:5px;padding:2px;}input.btn{min-height:36px;background-color:#FFF;border:2px solid #C8C8C8;width:100%;display:block;max-width:200px;margin-bottom:5px;}input[type='text'],input[type='password'],.btn{margin-bottom:10px;}input[type='text']:focus,input[type='password']:focus,input.btn:active{border:2px solid #FF7400;}h3.hh{clear:both;color:#333;margin-bottom:-10px;}
</style>

</head>
<body>
<div class="container">

<?php

if($_SESSION['admin_shoutbox']){
$menu=$_GET['menu'];
$a=$_GET['action'];
if($a=='logout'){
	session_destroy();
	header("Location: admin.php");
	exit();
}

$msg_id=$_GET['msg_id'];
if(($a=='delete') && (!empty($msg_id))){
	mysql_query("DELETE FROM `$tbl3` WHERE `id`='$msg_id'") or die("error while deleting: ".mysql_error());
}
if((empty($_POST['limit'])) || (!ctype_digit($_POST['limit']))){
	$limit=$_POST['limit']="100";
} else {
	$limit=$_POST['limit'];
}

$q=mysql_query("SELECT * FROM `$tbl3` ORDER BY `id` DESC LIMIT $limit") or die(mysql_error());



?>

<h3 class="hh title"><a href="admin.php">Admin Panel</a></h3>
<div style="padding:20px;">
<div class="wrapper-panel" style="width:90%;">
<a href="admin.php?action=logout" style="padding-bottom:2px;text-decoration:underline;float:right;font-size:12px;position:relative;bottom: 15px;left: 12px;">Logout</a>


<?php if($menu=='view_messages'){ ?>
Messages to load
<form style="margin-top:5px;" method="POST" action=""><input class="msgs_to_load" title="Last 'x' messages to load" style="display:inline;height: auto;min-height: unset;width: unset;" type="text" name="limit" value="<?=$_POST['limit']?>" /><input style="display: inline;width: unset;height: unset;min-height: unset;padding: 1px;border-left: unset;" type="submit" class="btn" value="Go" /></form>
<h3 class="hh" style="margin-bottom:unset;">Manage Messages <small>(<?=mysql_num_rows($q)?>)</small></h3>
<?php
while($r=mysql_fetch_assoc($q)){


echo "<div class='message'><div class='title'>".$r['name']."</div><div class='msg'>".$r['message']."</div><div class='del_link'><a href='?menu=view_messages&amp;action=delete&amp;msg_id=".$r['id']."'>Delete</a></div></div>";


}
?>


<?php } elseif($menu=='get_code'){ ?>
<style>h4 { border-bottom:1px solid #999;}</style>
<h3 class="hh">Get Code</h3>
<br/>
<i><small>You must set your details inside <b><u>config.php</u></b> file before copying the codes below!</small></i>
<h4><?=htmlspecialchars("<head>")?></h4>
<p>
<i>Paste the following code inside the <?=htmlspecialchars("<head>")?> tag of your website/webpage i.e <b>between <?=htmlspecialchars("<head>")?> and <?=htmlspecialchars("</head>")?></b></i>
</p>
<textarea onclick="this.focus();this.select()" readonly="readonly" style="
width: 99%;
height: 156px;
color: #000;
text-shadow: 0px 1px #FFF;
font-family: Consolas,Monaco,'Andale Mono',monospace;
direction: ltr;
text-align: left;
background: none repeat scroll 0% 0% #F5F2F0;
border: 2px solid #CCC;
padding-bottom: 10px;
padding-top: 10px;
margin-bottom: 20px;
">
<?=htmlspecialchars($code_head)?>
</textarea>

<h4><?=htmlspecialchars("<body>")?></h4>
<p>
<i>Paste the following code inside the <?=htmlspecialchars("<body>")?> tag of your website/webpage i.e <b>between <?=htmlspecialchars("<body>")?> and <?=htmlspecialchars("</body>")?></b><br/>
(not necessary when using in 'widget' mode)</i>
</p>
<textarea onclick="this.focus();this.select()" readonly="readonly" style="
width: 99%;
height: 156px;
color: #000;
text-shadow: 0px 1px #FFF;
font-family: Consolas,Monaco,'Andale Mono',monospace;
direction: ltr;
text-align: left;
background: none repeat scroll 0% 0% #F5F2F0;
border: 2px solid #CCC;
padding-bottom: 10px;
padding-top: 10px;
margin-bottom: 20px;
">
<?=htmlspecialchars($code_body)?>
</textarea>

<h4>Widget or Standalone?</h4>
<a href="admin.php?action=test_code&amp;type=full">&rarr; Click here to test Standalone Code</a> - <a href="?get_code_full=1&amp;body=1">View Code</a><br/>
<a href="admin.php?action=test_code&amp;type=widget">&rarr; Click here to test Widget Code</a> - <a href="?get_code_widget=1">View Code</a>
<ul>
<li>
Using the above code will add the Shoutbox to the website/webpage. If you want to use it as a widget which can be minimized too<small><i>(just like facebook chat)</i></small> than Replace the following part
<pre><?=htmlspecialchars("<script src=\"{$base_url}chat_full.js\"></script>")?></pre>
With:
<pre><?=htmlspecialchars("<script src=\"{$base_url}chat.js\"></script>")?></pre>
</li>
<li>
The code which needs to be pasted in the <?=htmlspecialchars("<body>")?> tag is not needed when using it as a widget. (Only needed when using it as standalone)
</li>
<br/>
<li>Note: When Chat <b>widget</b> is loaded but the current viewport width is not so enough to fit the widget (e.g on mobile devices), the user will be redirected to <pre style="display:inline;">chat_widget_full_url</pre> (which is same as <pre style="display:inline">base_url</pre> by default) upon clicking the Shoutbox widget. (these are set in javascript)<br/>
To disable this, you have to add the following part
<pre>
var no_redirect=1;
</pre>
Above this line
<pre>
var base_url="<?=$base_url?>"; //base url
</pre>
</li>
</ul>



<h4>Customization</h4>
<pre style="overflow:auto;background:#eee;">
var base_url="<b style="background:#ccc;"><?=$base_url?></b>"; //base url
var chat_widget_full_url="<b style="background:#ccc;"><?=$base_url?></b>"; //static chatbox page url
var chat_header_title="<b style="background:#ccc;">Shoutbox</b>"; //window title
</pre>

<ul>
<li>
You can set the name of the chat window <i>(e.g Shoutbox is default name)</i> by modifying <b style="background:#ccc;">Shoutbox</b> and writing anything instead of it like "<i>Chat Box</i>", "<i>Online Chat</i>" etc.
</li>
<li>Note: base_url <small><i>(in Javascript)</i></small> and $base_url <small><i>(in PHP)</i></small> refers to the path where the script/files are installed. <a href='#' onclick='alert("Files including but not limited to:\n\npost.php\nread.php\nmisc.php\nconfig.php\nchat.js\nchat_full.js\nchat.css\nadmin.php");return false;'>Which files?</a></li>
<li>Note: chat_widget_full_url <small><i>(in Javascript)</i></small> refers to the path of the page where the chatbox is added as static.</li>
<li>You can also customize the theme (css file) if necessary to suit your needs.</li>
</ul>

<h4>Help</h4>
<p>If you encounter any type of problem or have any question in mind than don't hesitate to drop me a few lines at <a href="mailto:osamaejaz1@gmail.com">osamaejaz1@gmail.com</a>.
<?php } else { ?>
<h3 class="hh">Welcome!</h3>
<ul>
<li><a href="?menu=view_messages">Manage Messages <small>(<?=mysql_num_rows($q)?>)</small></a></li>
<li><a href="?menu=get_code">Get Embed Code / Documentation</a></li>

</ul>





<?php if($a=='test_code' && $_GET['type']=='full'){ ?>
<script>
$(function(){

$.ajax({
  type: 'GET',
  url: 'admin.php?get_code_full=1',
  beforeSend:function(){
    title=document.title; document.title="Loading...";
  },
  success:function(data){
    document.title=title;
    $("head").append(data);
  },
  error:function(){
    alert("error occurred while loading files.\nbetter try pasting the code and checking manually");
  }
});
});
</script>
<?=$code_body?>
<?php } elseif($a=='test_code' && $_GET['type']=='widget'){ ?>

<script>
$(function(){

$.ajax({
  type: 'GET',
  url: 'admin.php?get_code_widget=1',
  beforeSend:function(){
    title=document.title; document.title="Loading...";
  },
  success:function(data){
    document.title=title;
    $("head").append(data);
  },
  error:function(){
    alert("error occurred while loading files.\nbetter try pasting the code and checking manually");
  }
});
});
</script>
<?php } ?>







<?php } ?>

</div>
</div>


<?php


} else {
?>
<script>document.title="Login to Admin Panel";</script>



<h3 class="hh title">Login to Admin Panel</h3>
<form id="login" style="" action="admin.php" method="POST">
<div class="wrapper-panel" style="max-width:200px;">
<label for="uname">Username</label><input type="text" name="uname" id="uname"/>
<label for="pwd">Password</label><input type="password" name="pwd" id="pwd"/>
<input type="submit" value="Login" class="btn"/>
</div>
</form>








<?php
}
?>
</div>
<div style="width:800px;margin:0 auto;text-align:right;">
<small>
Copyright &copy; <?=date("Y")?> <a href="http://www.thedeveloper24.com/">TheDeveloper24.Com</a>
</small>
</div>
</body>
</html>
