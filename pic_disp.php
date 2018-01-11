<?php
require_once("common.php");

getconnected();

if(isset($mode))
{
	if($mode=="EVENT")
	{
	$q = "select * from events where iEVID=$id";
$result = mysql_query($q)or die("<b>Error Code:</b>PIC_DSP01<br><b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $q);
	$R = mysql_fetch_object($result);
	$path="./events/".$R->vPic;
	$name=$R->vTitle;
	}

	if($mode=="PIC_OF_DAY")
	{
	$q = "select * from pic_of_the_day where iPID=$id";
	$result = mysql_query($q)or die("<b>Error Code:</b>PIC_DSP01<br><b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $q);
	$R = mysql_fetch_object($result);
	$path="./pics_of_the_day/".$R->vPic;
	$name=$R->vName;
	}
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php echo $name; ?> </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="dg.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0">
<br><div align="center">

  <table width="50%" border="0" cellspacing="0" cellpadding="0">
    <tr align="center"> 
      <td class="cadisp"><?php echo $name; ?></td>
    </tr>
    <tr align="center"> 
      <td><br> <img src="<?php echo "$path"; ?>" align="middle"></td>
    </tr>
   
   <?
   if(isset($mode))
   {
   	
   ?>
    <tr align="center"> 
      <td class="ypdata"><br> <?php echo $R->bDesc; ?></td>
    </tr>
	<?
	
	}
	?>
    <tr align="center">
      <td class="ypdata">&nbsp;</td>
    </tr>
    <tr align="center"> 
      <td class="ftr"><div align="center"><a href="#" onClick="window.close()" class="ftr">close 
          window</a> </div></td>
    </tr>
  </table>
</div>
</body>
</html>