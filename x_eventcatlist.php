<?php
require_once("common.php");

getconnected();

	$query = "select * from event_cats order by iRank";
	$result = mysql_query($query) or die("<b>Error Code:</b>PIC_EDT05<br><b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>DigitalGoa.com- Goa, Goa Holidays, Goa Centric Portal, Goa Yellow Pages, Explore Goa, Goa Breaking News, Goa News, Goa Current Affairs, Goa Events</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="dg.css" rel="stylesheet" type="text/css">
<link href="html/b.css" rel="stylesheet" type="text/css">

</head>

<body >
<div align="center" class="headcaption">Event Categories</div>
<br>
<?
if(mysql_num_rows($result))
{
?>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr align="center">
  <td width="20%" class="formcaption"><div align="center"><strong>#</strong></div></td>
	<td width="80%" class="formcaption"><strong>Name</strong></td>
  </tr>
<?php
$srno=0;
	while($R = mysql_fetch_object($result))
	{
	$srno++;
	  print("<tr align='center'>");
	  	print("<td>$srno</td>");
		print("<td><a href='x_eventcatedit.php?mode=E&id=$R->iEvCatID' target='r'>$R->vName</a></td>");
	  print("</tr>");
	}
?>
</table>
<? } 
else
{
?>
<div align="center">No Categories Found ...</div>
<? } ?>
<br>
<a href="x_eventcatedit.php?mode=A" target="r">&raquo; add</a>

</body>
</html>
