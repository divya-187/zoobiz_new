<!DOCTYPE html>

<html>
<head>
<title>TODO supply a title</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>

<script src="jspdf.min.js"></script>
<script type="text/javascript">
$(function () {

$('#cmd').click(function () {
var doc = new jsPDF();
doc.addHTML($('#content'), 15, 15, {
'background': '#fff',
'border':'2px solid white',
}, function() {
doc.save('sample-file.pdf');
});
});
});
</script>
<style>
input{display:block;
}
label{
float:left;
}
</style>
</head>
<body>
<form id="smdiv">
<div id="content">
<label>Name</label>
<input type="text" name="name"/>
<label>Empid</label>
<input type="text" name="empid"/>
<label>Age</label>
<input type="text" name="age"/>

</div>
</form>
<button id="cmd">generate PDF</button>
</body>
</html>