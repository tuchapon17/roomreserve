<!doctype>
<html lang='th'>
<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
.table-bordered{
	width:auto;
	height:auto;
}
.calendar {
	font-family: Arial, Verdana, Sans-serif;
	width: 100%;
	min-width: 960px;
	border-collapse: collapse;
}

.calendar tbody tr:first-child th {
	color: #505050;
	margin: 0 0 10px 0;
}

.day_header {
	font-weight: normal;
	text-align: center;
	color: #757575;
	font-size: 10px;
}

.calendar td {
	width: 14%; /* Force all cells to be about the same width regardless of content */
	border:1px solid #CCC;
	height: 100px;
	vertical-align: top;
	font-size: 10px;
	padding: 0;
}

.calendar td:hover {
	background: #F3F3F3;
}

.day_listing {
	display: block;
	text-align: right;
	font-size: 12px;
	color: #2C2C2C;
	padding: 5px 5px 0 0;
}

div.today {
	background: #E9EFF7;
	height: 100%;
}
.testtable tr,td{
	border:1px solid #ddd;
	padding:0;
}
.testtable .content{
	width:100%;
}
.testtable tr{
	height:60px;
}
#testdiv{
	position:absolute;
	z-index:99;
	top:0;
	border:1px solid red;
}
#testdiv2{
	position:absolute;
	z-index:99;
	top:0;
	border:1px solid green;
}
</style>
</head>
<body>
<?php //echo $calendar;
/*$begin = new DateTime( '2010-05-01 05:01:24' );
$end = new DateTime( '2010-05-10 23:23:23' );

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ( $period as $dt )
	echo $dt->format( "Y-m-d H:i:s" )."<br>";*/
?>
<br>
<h1>H1</h1>
<table class="testtable">
<tr id="00">
	<td>00.00</td><td class="content"></td>
</tr>
<tr id="01">
	<td>01.00</td><td class="content"></td>
</tr>
<tr id="02">
	<td>02.00</td><td class="content"></td>
</tr>
<tr id="03">
	<td>03.00</td><td class="content"></td>
</tr>
<tr id="04">
	<td>04.00</td><td class="content"></td>
</tr>
<tr id="05">
	<td>05.00</td><td class="content"></td>
</tr>
<tr id="06">
	<td>06.00</td><td class="content"></td>
</tr>
<tr id="07">
	<td>07.00</td><td class="content"></td>
</tr>
<tr id="08">
	<td>08.00</td><td class="content"></td>
</tr>
<tr id="09">
	<td>09.00</td><td class="content"></td>
</tr>
<tr id="10">
	<td>10.00</td><td class="content"></td>
</tr>
<tr id="11">
	<td>11.00</td><td class="content"></td>
</tr>
<tr id="12">
	<td>12.00</td><td class="content"></td>
</tr>
<tr id="13">
	<td>13.00</td><td class="content"></td>
</tr>
<tr id="14">
	<td>14.00</td><td class="content"></td>
</tr>
<tr id="15">
	<td>15.00</td><td class="content"></td>
</tr>
<tr id="16">
	<td>16.00</td><td class="content"></td>
</tr>
<tr id="17">
	<td>17.00</td><td class="content"></td>
</tr>
<tr id="18">
	<td>18.00</td><td class="content"></td>
</tr>
<tr id="19">
	<td>19.00</td><td class="content"></td>
</tr>
<tr id="20">
	<td>20.00</td><td class="content"></td>
</tr>
<tr id="21">
	<td>21.00</td><td class="content"></td>
</tr>
<tr id="22">
	<td>22.00</td><td class="content"></td>
</tr>
<tr id="23">
	<td>23.00</td><td class="content"></td>
</tr>
</table>
<div id="testdiv">11</div>
<div id="testdiv2">11</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(function(){

//substract time to minutes
var start0="2013-12-10 08:15:00";
var end0="2013-12-10 23:59:00";
var year_start=start0.substr(0,4);
var year_end=end0.substr(0,4);
	var month_start=start0.substr(5,2);
	var month_end=end0.substr(5,2);
		var date_start=start0.substr(8,2);
		var date_end=end0.substr(8,2);
var hour_start=start0.substr(11,2);
var hour_end=end0.substr(11,2);
	var min_start=parseInt(start0.substr(14,2));
	var min_end=parseInt(end0.substr(14,2));

var start = '8:33';
var end = '12:11';
//var startDate1 = new Date("1/1/1900 " + start);
//var endDate = new Date("1/1/1900 " + end );
var startDate = new Date(date_start+"/"+month_start+"/"+year_start+" "+hour_start+":"+min_start);
var endDate = new Date(date_end+"/"+month_end+"/"+year_end+" "+hour_end+":"+min_end);

var diff=endDate-startDate; //diff in milliseconds
s=diff;
var ms = s % 1000;
s = (s - ms) / 1000;
var secs = s % 60;
s = (s - secs) / 60;


$("#testdiv").offset({left:($("tr#"+hour_start).offset().left+$("tr td:first").width()),top:$("tr#"+hour_start).offset().top+min_start});
$("#testdiv2").offset({left:($("#testdiv").offset().left+$("#testdiv").width()),top:$("tr#"+hour_start).offset().top});
$("#testdiv").height(s-2);
});
function convertDateToDate()
{
	
}
function msToTime(s) {
	  var ms = s % 1000;
	  s = (s - ms) / 1000;
	  var secs = s % 60;
	  s = (s - secs) / 60;
	  var mins = s % 60;
	  var hrs = (s - mins) / 60;

	  return hrs + ':' + mins + ':' + secs + '.' + ms;
	}
</script>
</body>
</html>