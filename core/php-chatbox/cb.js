$(window).load(function() {

$('#chatResults').css("height", $(window).height() - 120);

var focusFlag = 1;
var lastTime = '';
var newTime = '';

$(window).bind("blur", function() {
	focusFlag = 0;
}).bind("focus", function() {
	focusFlag = 1;
	document.title = "Chatty!";
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
   url: "ajax.php",
   data: {
        author: $('#author').val(),
        text: $('#text').val()
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
        $('#chatResults').prop('scrollTop', $('#chatResults').prop('scrollHeight'));
   }
 });
}

function reload() {
$.ajax({
   type: "POST",
   url: "ajax.php",
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
        $('#chatResults').prop('scrollTop', $('#chatResults').prop('scrollHeight'));	
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
