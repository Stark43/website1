<?php										// DAVE
require_once("common.php");			
getconnected();

if(isset($mode))
{
if($mode=='COMP')
$type='C';
if($mode=='GEN')
$type='G';
if($mode=='JOB')
$type='J';
}

if(isset($mode1))
{
if($mode1=='ADD')
{
$CBID=NextID("iCBID","ct_banner");
$catid=GetCatIDFromCBID($CBID);
$rank=GetMaxRank($type,$p);
if(!isset($cmblisting))
$cmblisting='NA';
if(!isset($exlink))
$exlink='NA';


$qadd="insert into ct_banner values('$CBID','$p','$type','$cmblisting','NA','$btype','$exlink',$rank+1,'$cflag')";
mysql_query($qadd) or die ("<b>Error Code:</b>ADDCATBAN04<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");

print("Banner Successfully Added");

}
if($mode1=='UPDATE')
{
if(!isset($cmblisting))
$cmblisting='';
if(!isset($exlink))
$exlink='NA';

$qedit="update ct_banner set vExternalLink='$exlink',cBType='$btype',cFlag='$cflag',iListingID='$cmblisting' where iCBID='$CBID'";
mysql_query($qedit) or die ("<b>Error Code:</b>ADDCATBAN05<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
print("Banner Successfully Updated");
}

if($mode1=='ADD'||$mode1=='UPDATE')
{

if (is_uploaded_file($HTTP_POST_FILES['banner']['tmp_name']) )
		{
			$ext= $dir = substr(strrchr( $HTTP_POST_FILES['banner']['name'], "."), 1);
			$newname= "banner_" . $CBID . "." . $ext;
			
			//$ext = strtolower($ext);
						
			$dir = opendir(UPLOADPATH_BAN);				
				while ($file_name = readdir($dir)) 
				{				 
					if($file_name==$newname)
					{
						$f= UPLOADPATH_BAN . $file_name;
						//echo "deleting $f <br>";
						unlink ($f);
					}
				 }									
				//closedir($dir);				
				
				copy($HTTP_POST_FILES['banner']['tmp_name'],UPLOADPATH_BAN . "$newname"); 
								  			
				$q = "Update ct_banner set vFile='$newname' where iCBID = $CBID";
				$result = mysql_query($q) or die("<b>Error Code:</b>ADDCATBAN06<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);		
		}


}
if($mode1=='DELETE')
{

	$banname=GetXFromYID("select vFile from ct_banner where iCBID = $cbid");
	
		$dir = opendir(UPLOADPATH_BAN);				

		while ($file_name = readdir($dir)) 
		{				 								 
			if($file_name==$banname)
			{
				$f= UPLOADPATH_BAN . $file_name;
				//echo "deleting $f <br>";
				unlink ($f);
			}
		}									

		closedir($dir);
	
$qdel="delete from ct_banner where iCBID='$cbid'";
mysql_query($qdel) or die("<b>Error Code:</b>ADDCATBAN07<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);
print("Banner Successfully Deleted");

}


}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!-- ---------------------------------------------------------------------- -->
<!-- START : EDITOR HEADER - INCLUDE THIS IN ANY FILES USING EDITOR -->
<script language="Javascript1.2" src="includes/editor.js"></script>
<script language="JavaScript" src="scripts/dg.js"></script>
<script language="JavaScript">
function sel()
{
if(document.banner.btype[1].checked)
{
document.banner.cmblisting.disabled=true;
document.banner.cmblisting.value=0;
document.banner.exlink.disabled=false;
}
else
{
document.banner.cmblisting.disabled=false;
document.banner.exlink.value='';
document.banner.exlink.disabled=true;
}
}

function check()
{
	
if(document.banner.btype[1].checked)
	{
	if(document.banner.exlink.value=='')
		{
		alert("Cannot leave External Link Field Empty");
		return false;
		}
			
		x=document.banner.exlink.value.substring(0,7);
		if(x!="http://")
		{
		alert("Please Enter External Link As Per Example");
		return false;
		}
	}
	
if(document.banner.btype[0].checked)
	{
	if(document.banner.cmblisting.value==0)
		{
		alert("Choose Appropriate Listing");
		return false;
		}
	}


return true;

}
</script>
<script>
_editor_url = "";
</script>
<style type="text/css"><!--
  .btn   { BORDER-WIDTH: 1; width: 26px; height: 24px; }
  .btnDN { BORDER-WIDTH: 1; width: 26px; height: 24px; BORDER-STYLE: inset; BACKGROUND-COLOR: buttonhighlight; }
  .btnNA { BORDER-WIDTH: 1; width: 26px; height: 24px; filter: alpha(opacity=25); }
--></style>
<!-- END : EDITOR HEADER -->
<link href="dg.css" rel="stylesheet" type="text/css">
<link href="html/b.css" rel="stylesheet" type="text/css">
</head>

<body>
<form action="x_addcatbanner.php" method="post" enctype="multipart/form-data" name='banner'>

<?
if(isset($action))
	{
		$banner='';
		$exlink='';
		$listing='';
		
					
		   if($action=='E')
		   {
		   $q3="select iCatID,cCatType,vFile,cBType,vExternalLink,iListingID,cFlag from ct_banner where iCBID='$id'";
		   $rs3=mysql_query($q3) or die ("<b>Error Code:</b>ADDCATBAN03<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
		   
		   list($catid,$ctype,$banner,$btype,$exlink,$listing,$cflag)=mysql_fetch_row($rs3);
		   
		   print("<input name='CBID' type='hidden' id='CBID' value='$id'>");  
		   }
		
		 
		
	print("<br><p><table width='80%' border='1' cellspacing='0' cellpadding='0' align='center'>\n");
	
	$nm=GetCategoryNameFromTypeAndID($type,$p);
print("<tr align='center' ><td width='35%' colspan='3' class='formcaption'>".$nm."</td></tr>");

	print("<tr><td align='center' colspan='2'><strong>");
	
	
	if($action=='E')
	print("Update Banner Details:</strong>");
	else	
	{
	print("Add New Banner:</strong>");
	}
	print("</td></tr>");
	

//////////////////////////////////////////////////////	
	if($action=='E')
	print("<tr><td><strong>Rank:</strong></td><td><a href='#' onClick=\"changerank('$id','CAT');\">Change Rank</a></td></tr>");
//////////////////////////////////////////////////////////	
	 print("<tr><td align='left'><strong>Banner:&nbsp;&nbsp;</strong></td><td><input type='file' name='banner' size='25'>");
	 print("</td></tr>");
	 if($banner!='NA'&& $banner!='')
	 {
	 	$ext= $dir = substr(strrchr( $banner, "."), 1);
		
		if(strtolower($ext)=='swf')
		{
		print("<tr><td valign=top colspan=2 align=center><object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0'  width='120' height='120'>
	<param name='movie' value='".BAN_ROOT.$banner."'>
	<param name='quality' value='high'>
	<embed src='".BAN_ROOT.$banner."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'  width='120' height='120'></embed></object></td></tr>");
		}
		else
		{
	 print("<tr><td valign=top colspan=2 align=center><img border=1 alt='".$banner."' src='".BAN_ROOT.$banner."'></td></tr>");
	 	}
	 }
	 
//////////////////////////////////////////////////////////////////	
	 print("<tr><td><strong>Banner Type:</strong></td>");
	if(isset($btype))
	{
	if($btype=='E')
	print("<td><input type='radio' name='btype' value='I' onClick='sel()'>Internal&nbsp;&nbsp;<input type='radio' name='btype' value='E' checked onClick='sel()'>External</td></tr>");
	else
	print("<td><input type='radio' name='btype' value='I' checked onClick='sel()'>Internal&nbsp;&nbsp;<input type='radio' name='btype' value='E' onClick='sel()'>External</td></tr>");	
	}
	else
	print("<td><input type='radio' name='btype' value='I' checked onClick='sel()'>Internal&nbsp;&nbsp;<input type='radio' name='btype' value='E' onClick='sel()'>External</td></tr>");
///////////////////////////////////////////////////////////////////
?>
	<tr><td align='left'><strong>Listing:&nbsp;&nbsp;</strong></td><td>
	<? FillData($listing, 'cmblisting', 'COMBO', 6,'listing_id,listing_company','listings', 'n','listing_company',''); ?>
	</td></tr>
	<?
////////////////////////////////////////////////////////////////////
	print("<tr><td align='left'><strong>External Link:&nbsp;&nbsp;</strong></td><td><input type='text' name='exlink' value='$exlink' class='box' size='40'>&nbsp;&nbsp;&nbsp;&nbsp;Eg:&nbsp;http://www.digitalgoa.com</td></tr>");
///////////////////////////////////////////////////////////////////	
    print("<tr><td><strong>Visibility:</strong></td>");
	if(isset($cflag))
	{
	if($cflag=='NO')
	print("<td><input type='radio' name='cflag' value='YES' >YES&nbsp;&nbsp;<input type='radio' name='cflag' value='NO' checked>NO</td></tr>");
	else
	print("<td><input type='radio' name='cflag' value='YES' checked>YES&nbsp;&nbsp;<input type='radio' name='cflag' value='NO'>NO</td></tr>");	
	}
	else
	print("<td><input type='radio' name='cflag' value='YES' checked>YES&nbsp;&nbsp;<input type='radio' name='cflag' value='NO'>NO</td></tr>");	
///////////////////////////////////////////////////////////////	


 	 if($action=='E')
	{
	 print("<tr><td colspan='2' align='center'><br>");
	 print("<input type='hidden' name='mode1' value='UPDATE'>");
	 print("<input type='hidden' name='CBID' value='$id'>");
	 print("<input type='submit' value='UPDATE' onClick='return check();'>");
    }
	else
	{
	 print("<input type='hidden' name='mode1' value='ADD'>");
	print("<tr><td colspan='2' align='center'><br>");	
	print("<input type='submit' value='ADD' onClick='return check();'>");
	}
	
	
	 print("<input type='hidden' name='type' value='$type'>");
	 print("<input type='hidden' name='p' value='$p'>");
	print("<a href='x_addcatbanner.php?p=$p&type=$type'>Cancel</a></td></tr></table></p>");   
	
	}






?>

</form>
<?
if(!isset($action))
{
$cat=GetCategoryFromType($type);
$nm=GetCategoryNameFromTypeAndID($type,$p);

$q="select iCBID,vFile from ct_banner where iCatID='$p' and cCatType='$type' order by iRank";
$rs=mysql_query($q) or die ("<b>Error Code:</b>ADDCATBAN01<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks."); 

print("<br><table width='60%' border='0' align='center' cellpadding='2' cellspacing='2'>");

if(mysql_num_rows($rs))
{
print("<tr align='center' ><td width='35%' colspan='4' class='formcaption'>".$cat." CATEGORY - Banners</td></tr>");
print("<tr align='left' ><td width='35%' colspan='4' ><strong>".$nm."</strong></td></tr>");
print("<tr align='center'><td width='35%' >Sr No.</td><td>Name</td><td >Banner</td><td width='10%'>&nbsp;</td></tr>");
}
else
{
print("<tr align='center' ><td width='35%' colspan='3' >No Banners Found ...</td></tr>");
}
$xyz=0;
while(list($cbid,$fname)=mysql_fetch_row($rs))
{	
$xyz++;
	print("<tr align='center'><td width='35%'>$xyz</td><td width='35%'>$fname</td>");
	
		$ext= $dir = substr(strrchr( $fname, "."), 1);
		
		if(strtolower($ext)=='swf')
		{
		print("<td><object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0'  width='120' height='120'>
	<param name='movie' value='".BAN_ROOT.$fname."'>
	<param name='quality' value='high'>
	<embed src='".BAN_ROOT.$fname."' quality='high' pluginspage='http://www.macromedia.com/go/getflashplayer' type='application/x-shockwave-flash'  width='120' height='120'></embed></object></td>");
		}
		else
		{
		print("<td><img border=1 alt='".$fname."' src='".BAN_ROOT.$fname."'></td>");
		}
		
		print("<td ><a href='x_addcatbanner.php?action=E&id=$cbid&p=$p&type=$type'>Edit</a>&nbsp;&nbsp;&nbsp;<a href='x_addcatbanner.php?mode1=DELETE&cbid=$cbid&p=$p&type=$type'>Delete</a></tr>");
}
print("</table>");
}
?>
<br><a href='x_addcatbanner.php?action=A&p=<? echo $p; ?>&type=<? echo $type; ?>'>&raquo;add </a>

</body>
</html>
