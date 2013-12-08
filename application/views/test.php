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
</style>
</head>
<body>
<?php echo $calendar;
/*$begin = new DateTime( '2010-05-01 05:01:24' );
$end = new DateTime( '2010-05-10 23:23:23' );

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

foreach ( $period as $dt )
	echo $dt->format( "Y-m-d H:i:s" )."<br>";*/
?>
</body>
</html>