<?php
require_once("common.php");
//getconnected();
getconnected_to_TI();

if(isset($mode))
{
	if($mode=='A')
	{
		//$subid
		$name = "";
		$email ="";
	}
	else if($mode=='I')
	{
		$txtsubid = NextID('iSID', 'subscribers');

		$no = CheckDuplicate($txtemail, 'vEmail', 'subscribers', 'c');
		if($no==1)
		{
			$query = "insert into subscribers values($txtsubid, '$txtname', '$txtemail', 'Y')";
			$result = mysql_query($query) or die("<b>Error Code:</b>SUB_EDT01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT")."<br><b> Query : </b>" . $query);
		}
		else
		{
			$mode='A';
			$err = 1;
			header("location: subscriber_edit.php?mode=A&errmsg=$err");
		}
	}
	else if($mode=='E')
	{
		$query = "select * from subscribers where iSID=$id";
		$result = mysql_query($query) or die("<b>Error Code:</b>SUB_EDT02 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT")."<br><b> Query : </b>" . $query);
		
		list($subid, $name, $email, $flag) = mysql_fetch_row($result);
	}
	else if($mode=='U')
	{
		$no = CheckDuplicate($txtemail, 'vEmail', 'subscribers', 'c');
		if($no==1)
		{
			$query = "update subscribers set vName='$txtname', vEmail='$txtemail', cFlag='Y' where iSID=$txtsubid";
			$result = mysql_query($query) or die("<b>Error Code:</b>SUB_EDT03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT")."<br><b> Query : </b>" . $query);
		}
		else
		{
			$mode='E';
			$err = 1;
			header("location: subscriber_edit.php?mode=E&id=$txtsubid&errmsg=$err");
		}
	}
	else if($mode=='D')
	{
		$query = "delete from subscribers where iSID=$id";
		$result = mysql_query($query) or die("<b>Error Code:</b>SUB_EDT04 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT")."<br><b> Query : </b>" . $query);
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
</head>
<script language="JavaScript">
function just_reload()
{
	parent.l.location="subscriber.php";
}
</script>
<body onLoad="just_reload()" >
<br><br>
<?php
	if(isset($mode)&&(($mode=='I')||($mode=='U')||($mode=='D')))
		exit();
		
	if(!isset($errmsg))
		$errmsg = "";
	else
		if($errmsg==1)
		print("<center><strong>Error: </strong>The email id specified has already been chosen.<br> Pls chose another...</center>");
?>
<form name="frmsubscriber" method="post" action="subscriber_edit.php">
  <table width="80%" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr> 
<?php
if(isset($mode))
{
	if($mode=='A')
		print("<input type='hidden' name='mode' value='I'>");
	if($mode=='E')
	{
		print("<input type='hidden' name='mode' value='U'>");
		print("<input type='hidden' name='txtsubid' value='$subid'>");
	}
}
?>
      <td width="35%">Subscriber Name :</td>
      <td width="65%"><input name="txtname" type="text" value="<?php echo $name; ?>"></td>
    </tr>
    <tr> 
      <td>Subscriber Email :</td>
      <td><input name="txtemail" type="text" value="<?php echo $email; ?>" size="50"></td>
    </tr>
    <tr> 
      <td><input type="reset" name="Submit2" value="Reset"></td>
      <td><input type="submit" name="Submit" value="Submit">&nbsp;&nbsp;
<?php
	if(isset($mode)&&$mode=='E')
		print("<a href='subscriber_edit.php?mode=D&id=$subid'>delete this subscriber</a>");
?>
	  </td>
    </tr>
  </table>
</form>
</body>
</html>