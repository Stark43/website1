<?php
require_once("common.php");
getconnected();

if(isset($mode))
{
	if($mode=='A')
	{
		$popid = "";
		$gdaid = ""; // gd_article_id;
//		flag="";
	}
	else if($mode=='I')
	{
		$txtpopid = NextID('iPOPID', 'popular_gd_articles');
		
		$q = "insert into popular_gd_articles values($txtpopid, $cmbgdaid, 'Y')";
		$r = mysql_query($q) or die ("<b>Error Code:</b>POP_ART_EDT01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q);
	}
	else if($mode=='E')
	{
		$q = "select * from popular_gd_articles where iPOPID=$id";
		$r = mysql_query($q) or die ("<b>Error Code:</b>POP_ART_EDT02 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q);
		
		list($popid, $gdaid, $flag) = mysql_fetch_row($r);
	}
	else if($mode=='U')
	{
		$q = "update popular_gd_articles set gd_article_id = $cmbgdaid, cFlag = 'Y' where iPOPID=$txtpopid";
		$r = mysql_query($q) or die ("<b>Error Code:</b>POP_ART_EDT03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q);
	}
	else if($mode=='D')
	{
		$q = "delete from popular_gd_articles where iPOPID=$id";
		$r = mysql_query($q) or die ("<b>Error Code:</b>POP_ART_EDT04 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q);
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="dg.css" rel="stylesheet" type="text/css">
<link href="html/b.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function just_reload()
{
	parent.l.location="popular_art.php";
}

function submitform()
{
	var f = document.forms[0];
	var err = 0;
	
	if(f.cmbgdaid.value=="0")
	{
		alert("Please choose an article.")
		f.cmbgdaid.focus();
		err=1;
		return
	}
	
	if(err==0)
		document.popular_art.submit();
}
</script>
</head>
<body onLoad="just_reload()" >
<?php
	if(isset($mode)&&(($mode=='I')||($mode=='U')||($mode=='D')))
		exit();
?>
<form name="popular_art" method="post" action="popular_art_edit.php">
  <table width="80%" border="0" align="center" cellpadding="2" cellspacing="2">
 <?php
 	if(isset($mode))
	{
		if($mode=='A')
			print("<input type='hidden' name='mode' value='I'>");
		if($mode=='E')
		{
			print("<input type='hidden' name='mode' value='U'>");
			print("<input type='hidden' name='txtpopid' value='$popid'>");
		}
	}
?>
    <tr>
      <td width="35%">Popular Article :</td>
      <td width="65%">
<?php
		FillData($gdaid, 'cmbgdaid', 'COMBO', '0', 'gd_article_id, gd_article_name', 'general_database_articles', 'N', 'gd_article_id');
?>
      </td>
    </tr>
    <tr> 
      <td><input type="reset" name="Submit2" value="Reset"></td>
      <td><input type="button" name="Button" value="Submit" onClick="submitform()">
        &nbsp;&nbsp;&nbsp;
<?php
	if(isset($mode)&&($mode=='E'))
		print("<a href='popular_art_edit.php?mode=D&id=$popid'>delete article data</a>");
?>
	  </td>
    </tr>
  </table>
</form>
</body>
</html>
