/*
* Usama Ejaz
* thedeveloper24.com
* osamaejaz1[at]gmail.com
*/
url=document.location.href;


if (typeof chat_widget_full_url === 'undefined') {
	chat_widget_full_url=base_url;
}

function trim(str){
	return str.trim();
}
function dynamicSort(property, property2) {
    var sortOrder = 1;
    if(property[0] === "-") {
        sortOrder = -1;
        property = property.substr(1);
    }
    return function (a,b) {
        var result = (a[property] < b[property]) ? -1 : (a[property] > b[property]) ? 1 : 0;
        return result * sortOrder;
    }
}

function replaceLinksSO(text) {
    rex = /(<a href=")?(?:https?:\/\/)?(?:(?:www)[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+\.)+[-A-Za-z0-9+&@#\/%?=~_|$!:,.;]+/ig;   
    return text.replace(rex, function ( $0, $1 ) {
		if ($0.length > 60 )
			long_link=true;
		else
			long_link=false;    

        if(/^https?:\/\/.+/i.test($0)) {
		if(!long_link){
	            return $1 ? $0: '<a href="'+$0+'" target="_blank">'+$0+'</a>';
		} else {
	            return $1 ? $0: '<a href="'+$0+'" target="_blank"><i>Link</i></a>';
		}
        }
        else {
		if(!long_link){
	            return $1 ? $0: '<a href="http://'+$0+'" target="_blank">'+$0+'</a>';
		} else {
	            return $1 ? $0: '<a href="http://'+$0+'" target="_blank"><i>Link</i></a>';
		}
        }
    });
}

function chat_heartbeat(){ 
var time = Math.round(new Date().getTime()/1000.0); 
if(!$(".chat_wrapper").is(".minimized_chat")){
$.ajax({
dataType: "json",
url: base_url+"read.php?time="+time,
beforeSend:function(){
start=1;
},
success: function(data){
//data=data.sort(dynamicSort("time"));
data=data.sort(function(obj1, obj2) {
	return obj1.id - obj2.id;
});
var items = [];
$.each( data, function( key, val ) {
if($("#chat"+val['id']).length=="0"){

message=val['message'];
message = message.replace(/(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig, function($0) { 
		if ($0.length > 60 )
			return "<a href='" + $0 + "' target='_blank'><i>Link</i></a>" 
		else
			return "<a href='" + $0 + "' target='_blank'>" + $0 + "</a>"     
		});
message=replaceLinksSO(message);
var emoticon_folder = emoticon_folder || "http://usamaejaz-html-files.googlecode.com/git/emoticons/";
	var emotes ={
	    "heart": Array("&lt;3"),
	    "thumbsup": Array("\\(y\\)","\\(Y\\)"),
	    "happy": Array(":\\)\\)"),
	    "smile": Array(":-\\)",":\\)","=\\]","=\\)"),
	    "grin": Array(":D",":-D",":d",":-d"),
	    "sad": Array(":-\\(",":\\("),
	    "cool": Array("8\\)","8-\\)","B\\)","B\\|"),
	    "surprised": Array(":o",":-o",":O",":-O"),
	    "tongue": Array(":P",":-P",":p",":-p"),
	    "waii": Array("3\\)","3-\\)"),
	    "angry": Array("&gt;_&lt;"),
	    "crying": Array(":'\\("),
	    "wink": Array(";\\)",";-\\)")
	};
	var emoticonimgprefix = emoticonimgprefix || "emoticon_";
	    for(var emoticon in emotes){
	        for(var i = 0; i < emotes[emoticon].length; i++){
	            var re = new RegExp(emotes[emoticon][i],"g");
	            message = message.replace(re,"<img align=\"absmiddle\" src=\""+emoticon_folder+emoticonimgprefix+emoticon+".png\" alt=\""+emoticon+"\" title=\""+emoticon+"\" style=\"border:none;height:16px;width:16px;\" />");
	            }
	        }

val['message']=message;

$("#chatmessages").append( "<div class='chat-container' id='chat" + val['id'] + "'><a id='chatter_href' onclick='return false;' href='"+val['url']+"'>"+val['name']+":</a>&nbsp;" + val['message'] + "</div>" );
$('#chatmessages').scrollTop($('#chatmessages')[0].scrollHeight);
}
});
start=0;
},
  error:function(){
	start=0;
  }
});
}
}
function getChatterName(){
if(!$(".chat_wrapper").is(".minimized_chat")){
$.ajax({
  type: 'GET',
  url: base_url+'misc.php?action=getname',
  beforeSend:function(){
	start=1;
  },
  success:function(data){
	chatter=$("#chatform #chatter_name");
	if(data!=''){
		if(!(chatter.attr("disabled"))){
			chatter.val(data).attr("disabled","disabled");
		}
	} else {
		if((chatter.attr("disabled"))){
			chatter.removeAttr("disabled");
		}
	}
	start=0;

  },
  error:function(){
	start=0;

  }
});
}
}

$(function(){

if( ($(window).width()>700) && ($(window).height()>400) ){

$("body").append('<div class="chat_wrapper"><div id="chat_header"> <span style="float:right;"><a href="http://www.thedeveloper24.com">?</a></span></div><div id="chatmessages"></div><div id="chatposter"></div></div>');

$("#chatmessages, #chatposter").toggle();
$(".chat_wrapper").toggleClass("minimized_chat");


chat_heartbeat();
getChatterName();


$("#chat_header").append(chat_header_title).on("click",function(){
$("#chatmessages, #chatposter").toggle();
$(".chat_wrapper").toggleClass("minimized_chat");
});

$("#chatposter").append('<form id="chatform" method="POST" action="'+base_url+'post.php"><input id="chatter_name" type="text" name="name" placeholder="Name" /><div id="post_status"></div><input id="postmsg_btn" type="submit" value="Post" /><textarea id="chat_msg" type="text" name="message" style="width:100%;" placeholder="Message"></textarea></form>');

$("#chatform").on("submit",function(e){

e.preventDefault();

value=$("#chatform #chat_msg").val();

value=$.trim(value);

$("#chatform #chat_msg").val(value);

value=$("#chatform #chatter_name").val();

value=$.trim(value);

$("#chatform #chatter_name").val(value);

if(($("#chatform #chatter_name").val()!="") && ($("#chatform #chat_msg").val()!="")){
$.ajax({
  type: 'POST',
  url: base_url+'post.php',
  data: $("#chatform").serialize()+"&url="+url,
  beforeSend:function(){
	$("#post_status").empty().append('<i>Posting...</i>').show();
	msg=$("#chatform #chat_msg").val();
	$("#chatform #chat_msg").val("");
  },
  success:function(data){
	if(data=='error'){
		$("#post_status").empty().append('<strong>Try again</strong>');
	} else {
		$("#addlink").removeAttr("checked");
		$("#post_status").hide();
	}
  },
  error:function(){
	$("#post_status").empty().append('<strong>Network error</strong>').show();
	$("#chatform #chat_msg").val(msg);
  }
});
} else {
$("#post_status").empty().append('<strong>Please fill all fields</strong>').show();
}
});

$("#chatform #chat_msg").on("keydown",function(e){

var code = e.keyCode || e.which;

if (code == 13 && !e.shiftKey){

e.preventDefault();

value=$(this).val();

value=$.trim(value);

$(this).val(value);

if($(this).val()!=""){
	$(this).closest("form").submit();
} else {
	$("#post_status").empty().append('<strong>Please fill all fields</strong>').show();
}

}


});

start=0;
setInterval(function(){
	if(!$(".chat_wrapper").is(".minimized_chat")){
		if(start==0){
			chat_heartbeat();
			getChatterName();
		}
	}
},500);

} else {

if (typeof no_redirect === 'undefined') {
$("body").append('<div class="chat_wrapper minimized_chat"><div id="chat_header">'+chat_header_title+' <span style="float:right;"><a href="http://www.thedeveloper24.com">?</a></span></div></div>');
$("#chat_header").on("click",function(){
	window.location=chat_widget_full_url;
});
}

}

});