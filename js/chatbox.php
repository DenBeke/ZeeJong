<?php
require(dirname(__FILE__) . '/../core/config.php');
?>

$(window).load(function() {

$('#chatResults').css("height", $(window).height() - 120);

var focusFlag = 1;
var lastTime = '';
var newTime = '';
var first = true;


$(window).bind("blur", function() {
    focusFlag = 0;
}).bind("focus", function() {
    focusFlag = 1;
});

$('#submitter').click(function() {
    send();
    $('#text').val('');
});

$("#text").keyup(function(e) {
if(e.keyCode == 13) {
send();
$('#text').val('');
}
});

function send() {
$.ajax({
   type: "POST",
   url: "<?php echo SITE_URL; ?>core/php-chatbox/ajax.php",
   data: {
        author: $('#author').val(),
        text: $('#text').val(),
        group: $('#chat-group-id').val()
   },
   dataType: "json",
   success: function(data){
        var chatContent = '';
        for (var i in data) {
          chatContent += "<b>" + data[i].author + ": </b> [" + data[i].timestamp + "] " + data[i].text + "<br>";
        }
        $('#chatResults').html(chatContent);
        if (focusFlag == 0) {
        document.title = "Update!";
    }
        $("#chatResults").scrollTop($("#chatResults")[0].scrollHeight);
   }
 });
}

function reload() {
$.ajax({
   type: "POST",
   url: "<?php echo SITE_URL; ?>core/php-chatbox/ajax.php",
   data: {
     group: $('#chat-group-id').val()
   },
   dataType: "json",
   success: function(data){
        var chatContent = '';
        for (var i in data) {
          chatContent += "<b>" + data[i].author + ": </b> [" + data[i].timestamp + "] " + data[i].text + "<br>";
        }
        $('#chatResults').html(chatContent);
    newTime = data[0].timestamp;
    if ((focusFlag == 0) && (lastTime != newTime)) {
        document.title = data[0].author + " spoke! It's probably important!";
        lastTime = newTime = data[0].timestamp;
        $("#chatResults").scrollTop($("#chatResults")[0].scrollHeight);
    }

    if (first) {
        $("#chatResults").scrollTop($("#chatResults")[0].scrollHeight);
        first = false;
    }

   }
 });
}

var int = setInterval(function()
{
    reload();
}
, 2000);

});