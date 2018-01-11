<?php
require_once("common.php");
require_once("x_loginfo.php");
include_once("includes/conf.php");
include_once(INCLUDES_FOLDER."x_functions.inc.php");

$passwd = $cookie{"admin_login_pass"};
if(!isset($logdat_dg))
{
	echo "<title>DigitalGoa.com Admin Login</title><link rel='stylesheet' href='html/b.css'>";
	print_message ("<br><br>You have been logged out sucessfully.");
	echo "<br><center><a href='x_login.php'>Click HERE to login.</a></center>";
	exit();	
}
#######################################################################################################

echo "<title>DigitalGoa.com Admin Login</title><link rel='stylesheet' href='html/b.css'>";

#####################################################

if(isset($mode))
{
	
	if($mode=='D')
	{
	$picname=GetXFromYID("select vPic from logo where iLogoID='$logoid'");

			$dir = opendir(UPLOADPATH_LOGO);				
	
			while ($file_name = readdir($dir)) 
			{				 								 
				if($file_name==$picname)
				{
					$f= UPLOADPATH_LOGO . $file_name;
					unlink ($f);
				}
			}									
			
	closedir($dir);
	
	$q="delete from logo where iLogoID='$logoid'";
	mysql_query($q) or die("Error in deleting logo");
	?> <script>parent.l.document.location.reload(true);</script><?
		print_message("<br>Logo Deleted Successfully. ");
		exit(); 
	}
	
	
	if($mode=='U')
	{
				
	$q="update logo set vName='$picname',cVisibility='$visi' where iLogoID='$logoid'";
	mysql_query($q) or die("Error in updating logo");
	}
	
	if($mode=='I')
	{
		
	$logoid=NextID("iLogoID","logo");
	$q="insert into logo values('$logoid','$picname','NA','$visi')";
	mysql_query($q) or die("Error in inserting logo");
	}

	if(($mode=='I')||($mode=='U'))//////////////////////// IMAGE/ SWF FILE UPLOAD //////
	{
		if (is_uploaded_file($HTTP_POST_FILES['filepic']['tmp_name']) )
		{
			$ext= $dir = substr(strrchr( $HTTP_POST_FILES['filepic']['name'], "."), 1);
			$newname= "pic_" . $logoid . "." . $ext;
			
				$dir = opendir(UPLOADPATH_LOGO);				

				while ($file_name = readdir($dir)) 
				{				 
					if($file_name==$newname)
					{
						$f= UPLOADPATH_LOGO . $file_name;
						unlink ($f);
					}
				}		
				copy($HTTP_POST_FILES['filepic']['tmp_name'],UPLOADPATH_LOGO . $newname); 				  			
				$q = "Update logo set vPic = '$newname' where iLogoID= $logoid";

			$result = mysql_query($q) or die("<b>Error Code:</b>BAN_EDT06<b> Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);
		}
		?> <script>parent.l.document.location.reload(true);</script><?
		if($mode=='I')
		print_message("<br>Logo Added Successfully. ");
		else
		print_message("<br>Logo Updated Successfully. ");
		
		exit(); 		
	}
	
	if($mode=='E')
	{
	$q="select vName,vPic,cVisibility from logo where iLogoID='$logoid'";
	$rs=mysql_query($q) or die("Error in getting logo details");
	
	list($picname,$pic,$vis)=mysql_fetch_row($rs);
	$mode='U';
	}
	
	if($mode=='A')
	{
	$logoid="";
	$picname="";
	$vis="";
	$mode='I';		
	}

}



?>
<link href="dg.css" rel="stylesheet" type="text/css">
	
<form method='post' action='x_logoedit.php' enctype="multipart/form-data">	
  <table border=0 align=center>
    <tr> 
      <td>Name:</td>
      <td><input type='text' name='picname' value='<? echo $picname; ?>'></td>
    </tr>
    <tr> 
      <td>Logo:</td>
      <td><input type='file' name='filepic'></td>
    </tr>
    <?
if(isset($mode))
if($mode!='I')
{
?>
    <tr> 
      <td colspan='2' align='center'> 
        <img src='<? print(LOGO_ROOT.$pic); ?>' width='225' height='57'>
      </td>
    </tr>
    <? } ?>
    <tr> 
      <td>Visibility:</td>
      <td><select name='visi'>
          <option value='E' <? if($vis=='E') echo "selected"; ?>>Enabled</option>
          <option value='D' <? if($vis=='D') echo "selected"; ?>>Disabled</option>
        </select></td>
    </tr>
    <input type='hidden' name='mode' value='<? echo $mode; ?>'>
    <input type='hidden' name='logoid' value='<? echo $logoid; ?>'>
    <tr> 
      <td><input type='submit' value='Done'></td>
      <td align='right'> 
        <? if($mode!='I'){ ?>
        <a href='x_logoedit.php?mode=D&logoid=<? echo $logoid; ?>'>delete</a> 
        <? } ?>
      </td>
    </tr>
  </table>
</form>