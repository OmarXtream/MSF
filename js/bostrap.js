function post(){
var name = $('#pseudo').val();
var pass =  $('#password').val();

document.getElementById("result").innerHTML = '<center><img src="ajax-loader.gif"></center>';
$.post('index.php',{pseudo:name ,password:pass},
function(data,ts,xhr)
{

$('#result').html(data);

});
}