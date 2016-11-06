#JUST A BASIC EXAMPLE ON CREATING A SHOUTBOX. USE AT YOUR OWN RESPONSIBILITY.

#My Shoutbox

A tiny Shoutbox created with jQuery and PHP
http://www.thedeveloper24.com/2014/10/ajax-shoutbox-with-jquery-and-php.html


##Installation

* Copy all the files inside ```my_shoutbox``` in any directory on your website (for example: ```my_shoutbox``` in my case).
*Edit config.php to add your database settings, admin details and website settings
* Import ```create_table.sql``` to your database or simply copy and paste the command(s) inside it to create the table for shoutbox (you can set your own table name too)
* Now login to admin panel by navigating to ```admin.php``` in your web browser using the details that you set in config.php
* Embed Codes and Documentation is waiting for you in admin.php (after logging in)
* Thats all :)



##Requirements

* PHP
* jQuery
* MySQL
 


##HTML Code (example)

#### &lt;head&gt;
```html
<!-- include jQuery if not available -->
<script>window.jQuery || document.write('<script src="//code.jquery.com/jquery-1.10.2.min.js"><\/script>')</script>

<!-- script variables -->
<script>
var base_url="http://www.domain.com/my_shoutbox/"; //base url
var chat_widget_full_url="http://www.domain.com/my_shoutbox/"; //static chatbox page url
var chat_header_title="Shoutbox"; //window title
</script>

<!-- include js files -->
<script src="http://www.domain.com/my_shoutbox/chat_full.js"></script>

<!-- inlcude css -->
<link href="http://www.domain.com/my_shoutbox/chat.css" rel="stylesheet" type="text/css" />
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
```

#### &lt;body&gt;
```html
<!-- inside <body> tag -->
<!-- include this div for loading shoutbox -->
<div class="chat_window">
<noscript><div style="text-algin:center;">It needs <b>JAVASCRIPT</b> to be enabled to access this page. Please <a target="_blank" href="http://enable-javascript.com/">enable javascript</a></div></noscript>
</div>
```



##Widget or Standalone?

This shoutbox comes with two modes.
* Widget mode (will be added just like facebook chat)
* Standalone/Static mode (will be displayed on a page that you specify)
 


##Some tips

* Using the above code will add the Shoutbox to the website/webpage. If you want to use it as a widget which can be minimized too(just like facebook chat) than Replace the following part 
```<script src="http://www.domain.com/my_shoutbox/chat_full.js"></script>```
with
```<script src="http://www.domain.com/my_shoutbox/chat.js"></script>```
* The code which needs to be pasted in the <body> tag is not needed when using it as a widget. (Only needed when using it as standalone)
* Note: When Chat widget is loaded but the current viewport width is not so enough to fit the widget (e.g on mobile devices), the user will be redirected to ```chat_widget_full_url``` (which is same as ```base_url``` by default) upon clicking the Shoutbox widget. (these are set in javascript)
To disable this, you have to add the following part 
```var no_redirect=1;```
Above this line 
```var base_url="http://www.domain.com/my_shoutbox/"; //base url```
* For Admin Panel, default username is: ```admin``` and password is ```t00r```.

##Customization

```javascript
var base_url="http://www.domain.com/my_shoutbox/"; //base url
var chat_widget_full_url="http://www.domain.com/my_shoutbox/"; //static chatbox page url
var chat_header_title="Shoutbox"; //window title
```
* You can set the name of the chat window (e.g Shoutbox is default name) by modifying Shoutbox and writing anything instead of it like "Chat Box", "Online Chat" etc.
* Note: base_url (in Javascript) and $base_url (in PHP) refers to the path where the script/files are installed. 
* Note: chat_widget_full_url (in Javascript) refers to the path of the page where the chatbox is added as static.
* You can also customize the theme (css file) if necessary to suit your needs.
 


##Help?

Well, you can reach me at www.thedeveloper24.com :)
