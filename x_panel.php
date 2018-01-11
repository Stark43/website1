<?php
##########################################################################
##
##	!! DO NOT REMOVE THIS NOTICE !!																		
##
##	Digitalgoa.com
##	-----------------------						
##	A script by Ait			
##	(http://www.ait.co.in)		
##
##	"Digitalgoa.com" is not a free script. If you got this from someplace  
##  other than ait.co.in, please contact us, we do offer rewards   
##  for that type of information. Visit our site for up to date 		
##  versions. Most scripts are over $200, sometimes more than $500,		
##  this script is much less. We can keep this script cheap if people 
##  don't steal it.		
##	Also, no return links are required, but we appreciate it if you 	
##	do find a spot for us.												
##	Thanks!																
##
##  (c) copyright 2002 Ait.co.in.com 
##
##########################################################################

$me="x_panel.php";
include_once("includes/conf.php");
include_once(INCLUDES_FOLDER."x_functions.inc.php");
require_once("common.php");
require_once("x_loginfo.php");

if(!isset($logdat_dg))
{
	header("location: x_login.php");
	exit;
}

echo "<title>DigitalGoa.com Admin Login</title><link rel='stylesheet' href='html/b.css'>";

?>
<html>
<?
if(isset($m))
 if( ($m==2)||  ( ($m==71)&&(isset($a)) ) )
 echo"<body onload='initEditor()'>";
 ?>
 <script language="JavaScript" src="scripts/dg.js"></script>
 <script language="JavaScript" src="scripts/picker.js"></script>
<!-- ---------------------------------------------------------------------- -->
<!-- START : EDITOR HEADER - INCLUDE THIS IN ANY FILES USING EDITOR -->
<script language="Javascript1.2" src="includes/editor.js"></script>
<script>
_editor_url = "";
</script>
<style type="text/css"><!--
  .btn   { BORDER-WIDTH: 1; width: 26px; height: 24px; }
  .btnDN { BORDER-WIDTH: 1; width: 26px; height: 24px; BORDER-STYLE: inset; BACKGROUND-COLOR: buttonhighlight; }
  .btnNA { BORDER-WIDTH: 1; width: 26px; height: 24px; filter: alpha(opacity=25); }
--></style>
<!-- END : EDITOR HEADER -->
<!-- ---------------------------------------------------------------------- -->
<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar-setup.js"></script>
<script type="text/javascript" src="scripts/calendar-en.js"></script>
<script type="text/javascript" src="scripts/calendar_stuff.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="scripts/calendar-blue.css" title="win2k-cold-1">
<?
#######################################
// FUNCTION TO PRINT THE DROPDOWN
#######################################
function print_dropdown($arr_location,$loc) {
	foreach ($arr_location as $lng_key=>$var_value) {
		echo "<option value=".$lng_key;
		if ($loc==$lng_key) {
			echo " selected ";
		}
		echo ">$var_value</option>";
	}
}

$m=(!isset($m)) ? 0 : $m ;
$str_err="";

function fn_check_valid_user($str_username) {
	$bln_valid=1;
	
	$a_validchars=array("a","b","c","d","e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y","z","A","B","C","D","E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y","Z");
	for ($lng_i=0; $lng_i<strlen(trim($str_username)); $lng_i++) {
		if (!is_numeric(substr(trim($str_username),$lng_i,1))) {
			if (!in_array(substr(trim($str_username),$lng_i,1),$a_validchars)) $bln_valid=0;
		}
	}
	
	return $bln_valid;
}

//print("<input type='hidden' name='SECURITY' value='9'>");
 

#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
//START OF THE MAIN SWITCH BLOCK
switch ($m) {
#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
	##################################################
	// Classified_Category table
	case 70:  // CASE M
	##################################################
		if (!isset($a)) {$a=0;}	
		switch ($a) 
		{
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE Classified_Category
			case 6:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					
				$str_sql="DELETE FROM classifiedcats WHERE iCLID=$f";
				
				if($rst=mysql_query($str_sql)) 
				{
					print_message("The Category has been deleted");
					?><script>parent.l.document.location.reload(true);</script><?
				} 
				else 
					echo mysql_error($rst);
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE Classified Category QUESTION?
			case 5:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					
				/* echo "Hello!";
				exit; */
				$lng_flag=0;
				$str_sql="SELECT iClartID FROM classifiedarts WHERE iCLID=$i";

				if($rst=mysql_query($str_sql)) 
				{
					if(mysql_num_rows($rst)>0)
						print_error("The Classifieds Category is in use and hence cannot be deleted");
					else 
						$lng_flag++;
				}

				$str_sql="SELECT iCLID FROM classifiedcats WHERE iParentID=$i";

				if($rst=mysql_query($str_sql))
				{
					if(mysql_num_rows($rst)>0)
						print_error("The Classifieds Category is a parent to one or more Classifieds Categories. Kindly delete them first.");
					else
						$lng_flag++;
				}

				if($lng_flag==2) 
					echo "<center><b>Do you really want to delete this Classifieds Category?</b><br><a href=\"".$me."?m=70&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=70&a=7\">NO</a></center>";

				break;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND UPDATE THE DATABASE
			case 4:  // CASE A,M=20
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0)
				{
					$str_err.="Classifieds Category name cannot be left blank.<br>";
					$bln_err++;
				}
				elseif (fn_checkclasscategory($cat,$par, $i)>0) 
				{
					$str_err.="This Classifieds Category has already been entered.<br>";
					$bln_err++;
				}

				if (!$bln_err) 
				{
					if(!$par)	$par=0;
						$str_sql="UPDATE classifiedcats SET vName='".parse_sql($cat)."', iParentID=$par WHERE iCLID=$i";
						
												
					if (mysql_query($str_sql)) 
					{	
						print_message("<br> Classifieds Category has been updated. ");
						?><script>parent.l.document.location.reload(true);</script><?
					}
					else
					print_error("Error: ".mysql_error());
					
					break;
				}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT Classifieds Category FORM
			case 3:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				if ($a==3) 
				{
					$str_sql="SELECT vName, iParentID FROM classifiedcats WHERE iCLID=$i";
					
					if ($rst=mysql_query($str_sql)) 
					{
						$adata=mysql_fetch_row($rst);
						$cat=$adata[0];
						$par=$adata[1];
						
					}
					mysql_free_result($rst);
				}
					
				if(!isset($p)) $p=0;
				?><center>
					<table border=0>
						<form method=post action="<?php echo $me;?>">
						<input type=hidden name="m" value=70>
						<input type=hidden name="a" value=4>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<input type=hidden name="i" value=<?php echo $i;?>>
						<input type=hidden name=par value=<?php echo $par;?>>
						<tr><Td class="formcaption" colspan=2>Edit Classifieds Category</Td></tr>
<?
				if (strlen(trim($str_err))) 
					echo "<tr><Td valign=top colspan=2>".print_error1($str_err)."</td></tr>";
?>
						<tr><td>Category</td>
								<td><input type=text name="cat" maxlength=60 size="35" value="<?php echo format_str($cat);?>"></td></tr>
								
						<tr><td align=right colspan=2><input type=submit value="Update"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0)
				{
					$str_err.="Classifieds Category name cannot be left blank.<br>";
					$bln_err++;
				} 
				elseif (fn_checkclasscategory($cat,$p)>0) 
				{
					$str_err.="A Classifieds Category with the same name has already been entered.<br>";
					$bln_err++;
				}
				
				if (!$bln_err) 
				{
					if(!$p) $p=0;
					$clid=NextID("iCLID","classifiedcats");
					
						$str_sql="INSERT INTO classifiedcats (iCLID, vName, iParentID, iCount) VALUES ($clid ,'".parse_sql($cat)."', $p,0)";
				
											
						if(mysql_query($str_sql))
						{						
							print_message("<br>Classifieds Category has been created.");
							?><script>parent.l.document.location.reload(true);</script><?
						}
						else
						{
						print_error("Error: ".mysql_error());
						}
					break;
				}

			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW Classifieds Category
			case 1:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
			
				if(!isset($cat)) $cat="";
				?>
					<table border=0 align=center>
						<form method=post action="<?php echo $me;?>">
						<input type=hidden name="m" value=70>
						<input type=hidden name="a" value=2>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<tr><Td class="formcaption" colspan=2>Add a Classifieds Category</Td></tr>
<?
				if (strlen(trim($str_err))) 
					echo "<tr><Td valign=top colspan=2>".print_error1($str_err)."</td></tr>";
?>
						<tr><td>Name:</td>
								<td><input type=text name="cat" maxlength=60 size="35" value="<?php echo format_str($cat);?>"></td></tr>
								
						<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE CLASSIFIED CATEGORIES LIST
			default:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				if (!isset($p)) {$p=0;}
				?><a target="l" href="x_panel.php?m=70">List Classified Categories</a> | <a target=r href="<?php echo $me;?>?m=70&p=<?php echo $p;?>&a=1">Add</a><hr><?php
				fn_showclassparentname_gd($p,70,$p);
				if (!isset($s)) {$s=0;}
				$str_sql="SELECT iCLID, vName FROM classifiedcats WHERE iParentID=$p ORDER BY iRank";
				
				$rst=mysql_query($str_sql);

				if ($s<1) 
					$s=1;

				$lcnt = 1;

				if ($rst) 
				{
					if($r=mysql_num_rows($rst)) 
					{
						while($adata=mysql_fetch_row($rst))  
						{
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) 
								echo "<li><a href=\"$me?m=70&p=$adata[0]\">".format_str($adata[1])."</a> | <a target=r href=\"$me?m=70&a=3&i=$adata[0]\">Mod</a> | <a target=r href=\"$me?m=70&a=5&i=$adata[0]\">Del</a>";

							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT)) 
								break;
								
							$lcnt++;
						}
						echo "<hr>";
						
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1) 
							echo "| <a href=$me?m=70&p=$p&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";
						
						if ($lcnt<=mysql_num_rows($rst)) 
							echo "| <a href=$me?m=70&p=$p&s=$lcnt>Next</a> ";
					} 
					else 
						print_error("There are no records currently.");
				} 
				else 
					print_error ("Error: ".mysql_error());
		} //END OF CASE 70
		break;
		
	##################################################
	// Job_Category table
	case 20:  // CASE M
	##################################################
		if (!isset($a)) {$a=0;}	
		switch ($a) 
		{
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE Job_Category
			case 6:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					
				$str_sql="DELETE FROM job_categories WHERE iJID=$f";
				
				if(CheckIfCatIDPresent("JOB",$f))
				InsertOrUpdateOrDeleteCatID("","JOB",$f,"DELETE");
				
				if($rst=mysql_query($str_sql)) 
				{
					print_message("The Category has been deleted");
					?><script>parent.l.document.location.reload(true);</script><?
				} 
				else 
					echo mysql_error($rst);
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE Job Category QUESTION?
			case 5:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					
				/* echo "Hello!";
				exit; */
				$lng_flag=0;
				$str_sql="SELECT iJARTID FROM job_articles WHERE iJID=$i";

				if($rst=mysql_query($str_sql)) 
				{
					if(mysql_num_rows($rst)>0)
						print_error("The Job Category is in use and hence cannot be deleted");
					else 
						$lng_flag++;
				}

				$str_sql="SELECT iJID FROM job_categories WHERE iParentID=$i";

				if($rst=mysql_query($str_sql))
				{
					if(mysql_num_rows($rst)>0)
						print_error("The Job Category is a parent to one or more Job Categories. Kindly delete them first.");
					else
						$lng_flag++;
				}

				if($lng_flag==2) 
					echo "<center><b>Do you really want to delete this Job Category?</b><br>
								<a href=\"".$me."?m=20&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=20&a=7\">NO</a></center>";

				break;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND UPDATE THE DATABASE
			case 4:  // CASE A,M=20
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0)
				{
					$str_err.="Job Category name cannot be left blank.<br>";
					$bln_err++;
				}
				elseif (fn_checkjobcategory($cat,$par, $i)>0) 
				{
					$str_err.="This Job Category has already been entered.<br>";
					$bln_err++;
				}

				if (!$bln_err) 
				{
					if(!$par)	$par=0;
						$str_sql="UPDATE job_categories SET vName='".parse_sql($cat)."', iParentID=$par,iMCatID=$cmbmcat WHERE iJID=$i";
						
						if($cmbmcat==0)
						{
							if(CheckIfCatIDPresent("JOB",$i))	
							InsertOrUpdateOrDeleteCatID("","JOB",$i,"DELETE");						
						}
						else
						{
							if(CheckIfCatIDPresent("JOB",$i))
							{						
							InsertOrUpdateOrDeleteCatID($cmbmcat,"JOB",$i,"UPDATE",$titlecolor,$fontcolor,$bodybgcolor,$bodyfontcolor);
							}
							else
							InsertOrUpdateOrDeleteCatID($cmbmcat,"JOB",$i,"INSERT",$titlecolor,$fontcolor,$bodybgcolor,$bodyfontcolor);												
						}
						
					if (mysql_query($str_sql)) 
					{	
						print_message("<br> Job Category has been updated. ");
						?><script>parent.l.document.location.reload(true);</script><?
					}
					else
					print_error("Error: ".mysql_error());
					
					break;
				}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT Job Category FORM
			case 3:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				if ($a==3) 
				{
					$str_sql="SELECT vName, iParentID,iMCatID FROM job_categories WHERE iJID=$i";
					
					if ($rst=mysql_query($str_sql)) 
					{
						$adata=mysql_fetch_row($rst);
						$cat=$adata[0];
						$par=$adata[1];
						$mcatid=$adata[2];
					}
					mysql_free_result($rst);
				}
				
				$cols=GetAllColorsFromLinkageTable($mcatid,$i,'JOB');
				$titlecolor=$cols[0];
				$fontcolor=$cols[2];
				$bodybgcolor=$cols[1];
				$bodyfontcolor=$cols[3];
					
				if(!isset($p)) $p=0;
				?><center>
					<table border=0>
						<form method=post action="<?php echo $me;?>" name="frmjob">
						<input type=hidden name="m" value=20>
						<input type=hidden name="a" value=4>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<input type=hidden name="i" value=<?php echo $i;?>>
						<input type=hidden name=par value=<?php echo $par;?>>
						<tr><Td class="formcaption" colspan=2>Edit Job Category</Td></tr>
<?
				if (strlen(trim($str_err))) 
					echo "<tr><Td valign=top colspan=2>".print_error1($str_err)."</td></tr>";
?>
						
								<tr><td>Master Category</td>
								<td><?php
								
								FillData($adata[2], "cmbmcat", "COMBO", "0", "iMcatid,vname", "cat_master", "N", "vName" ,"");
								?></td></tr>
								<tr><td>Category</td>
								<td><input type=text name="cat" maxlength=60 size="35" value="<?php echo format_str($cat);?>"></td></tr>
		<tr> 
      <td>Title BG Colour:</td>
      <td ><input type='text' name='titlecolor' value="<? echo $titlecolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmjob.titlecolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Title Font Colour:</td>
      <td ><input type='text' name='fontcolor' value="<? echo $fontcolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmjob.fontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	
	 <tr> 
      <td>Content BG Colour:</td>
      <td ><input type='text' name='bodybgcolor' value="<? echo $bodybgcolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmjob.bodybgcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Content Font Colour:</td>
      <td ><input type='text' name='bodyfontcolor' value="<? echo $bodyfontcolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmjob.bodyfontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
						<tr><td align=right colspan=2><input type=submit value="Update"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0)
				{
					$str_err.="Job Category name cannot be left blank.<br>";
					$bln_err++;
				} 
				elseif (fn_checkjobcategory($cat,$p)>0) 
				{
					$str_err.="A Job Category with the same name has already been entered.<br>";
					$bln_err++;
				}
				
				if (!$bln_err) 
				{
					if(!$p) $p=0;
					$jid=NextID("iJID","job_categories");
					
						$str_sql="INSERT INTO job_categories (iJID, vName, iParentID,iMCatid) VALUES ($jid ,'".parse_sql($cat)."', $p,$cmbmcat)";
				
				if($cmbmcat!=0)					
				InsertOrUpdateOrDeleteCatID($cmbmcat,"JOB",$jid,"INSERT",$titlecolor,$fontcolor,$bodybgcolor,$bodyfontcolor);
								
						if(mysql_query($str_sql))
						{						
							print_message("<br>Job Category has been created.");
							?><script>parent.l.document.location.reload(true);</script><?
						}
						else
						{
						print_error("Error: ".mysql_error());
						}
					break;
				}

			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW Job Category
			case 1:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
			
				if(!isset($cat)) $cat="";
				?>
					<table border=0 align=center>
						<form method=post action="<?php echo $me;?>" name="frmjob">
						<input type=hidden name="m" value=20>
						<input type=hidden name="a" value=2>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<tr><Td class="formcaption" colspan=2>Add a Job Category</Td></tr>
<?
				if (strlen(trim($str_err))) 
					echo "<tr><Td valign=top colspan=2>".print_error1($str_err)."</td></tr>";
?>
						<tr><td>Name:</td>
								<td><input type=text name="cat" maxlength=60 size="35" value="<?php echo format_str($cat);?>"></td></tr>
								<tr><td>Master Category</td>
								<td><?php
								
								FillData("", "cmbmcat", "COMBO", "0", "iMcatid,vname", "cat_master", "N", "vName" ,"");
								?></td></tr>
																	
	<tr> 
      <td>Title BG Colour:</td>
      <td ><input type='text' name='titlecolor'  > 
        <a href="javascript:TCP.popup(document.frmjob.titlecolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Title Font Colour:</td>
      <td ><input type='text' name='fontcolor'  > 
        <a href="javascript:TCP.popup(document.frmjob.fontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	
	 <tr> 
      <td>Content BG Colour:</td>
      <td ><input type='text' name='bodybgcolor'  > 
        <a href="javascript:TCP.popup(document.frmjob.bodybgcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Content Font Colour:</td>
      <td ><input type='text' name='bodyfontcolor'  > 
        <a href="javascript:TCP.popup(document.frmjob.bodyfontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	
						<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE JOB CATEGORIES LIST
			default:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				if (!isset($p)) {$p=0;}
				?><a target="l" href="x_panel.php?m=20">List Job Categories</a> | <a target=r href="<?php echo $me;?>?m=20&p=<?php echo $p;?>&a=1">Add</a><hr><?php
				fn_showjobparentname_gd($p,12,$p);
				if (!isset($s)) {$s=0;}
				$str_sql="SELECT iJID, vName FROM job_categories WHERE iParentID=$p ORDER BY vName";
				
				$rst=mysql_query($str_sql);

				if ($s<1) 
					$s=1;

				$lcnt = 1;

				if ($rst) 
				{
					if($r=mysql_num_rows($rst)) 
					{
						while($adata=mysql_fetch_row($rst))  
						{
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) 
								echo "<li><a href=\"$me?m=20&p=$adata[0]\">".format_str($adata[1])."</a> | <a target=r href=\"$me?m=20&a=3&i=$adata[0]\">Mod</a> | <a target=r href=\"$me?m=20&a=5&i=$adata[0]\">Del</a>";

							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT)) 
								break;
								
							$lcnt++;
						}
						echo "<hr>";
						
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1) 
							echo "| <a href=$me?m=20&p=$p&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";
						
						if ($lcnt<=mysql_num_rows($rst)) 
							echo "| <a href=$me?m=20&p=$p&s=$lcnt>Next</a> ";
					} 
					else 
						print_error("There are no records currently.");
				} 
				else 
					print_error ("Error: ".mysql_error());
		} //END OF CASE 20
		break;
	
	#################################################
	// General Database Category
	case 12:  // CASE M
	##################################################
		if (!isset($a)) {$a=0;}	
		switch ($a) {
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE General Database Category
			case 6:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					
				$str_sql="DELETE FROM cat_general_database WHERE cat_gd_id=$f";
				
				if(CheckIfCatIDPresent("GENL",$f))
				InsertOrUpdateOrDeleteCatID("","GENL",$f,"DELETE");
				
				if($rst=mysql_query($str_sql)) {
					print_message("The Category has been deleted");
					?><script>parent.l.document.location.reload(true);</script><?
				} else {
					echo mysql_error($rst);
				}
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE General Database Category QUESTION?
			case 5:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
					
				$lng_flag=0;
				$str_sql="SELECT gd_article_id 
									FROM general_database_articles 
									WHERE cat_gd_id='$i'";
				
				if($rst=mysql_query($str_sql)) {
					if(mysql_num_rows($rst)>0) {
						print_error("The Category is in use and hence cannot be deleted");
					} else {
						$lng_flag++;
					}
				}
					
				$str_sql="SELECT cat_gd_id 
									FROM cat_general_database 
									WHERE cat_gd_parent_id='$i'";
									
				if($rst=mysql_query($str_sql)) {
					if(mysql_num_rows($rst)>0) {
						print_error("The General Database Category is a parent to one or more Categories. Kindly delete them first.");
					} else {
						$lng_flag++;
					}
				}
				
				if($lng_flag==2) {
					echo "<center><b>Do you really want to delete this Category?</b><br>
								<a href=\"".$me."?m=12&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=12&a=7\">NO</a></center>";
				}
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND UPDATE THE DATABASE
			case 4:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0){
					$str_err.="Category name cannot be left blank.<br>";
					$bln_err++;
				}elseif (fn_checkgencategory($cat,$par, $i)>0) {
					$str_err.="This Category has already been entered.<br>";
					$bln_err++;
				}

				if (!$bln_err) {
					if(!$par)	$par=0;
					$str_sql="UPDATE cat_general_database SET
										cat_gd_name='".parse_sql($cat)."', 
										cat_gd_parent_id=$par,iMCatID=$cmbmcat WHERE cat_gd_id=$i";
										
						if($cmbmcat==0)
						{
							if(CheckIfCatIDPresent("GENL",$i))	
							InsertOrUpdateOrDeleteCatID("","GENL",$i,"DELETE");						
						}
						else
						{
							if(CheckIfCatIDPresent("GENL",$i))
							{						
							InsertOrUpdateOrDeleteCatID($cmbmcat,"GENL",$i,"UPDATE",$titlecolor,$fontcolor,$bodybgcolor,$bodyfontcolor);
							}
							else
							InsertOrUpdateOrDeleteCatID($cmbmcat,"GENL",$i,"INSERT",$titlecolor,$fontcolor,$bodybgcolor,$bodyfontcolor);												
						}
						
						
					if (mysql_query($str_sql)) {
						print_message("<br>General Category has been updated.");
						?><script>parent.l.document.location.reload(true);</script><?
					}else{
						print_error("Error: ".mysql_error());
					}
					break;
				}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT General Database Category FORM
			case 3:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				if ($a==3) {
					$str_sql="SELECT cat_gd_name, cat_gd_parent_id ,iMCatID
										FROM cat_general_database WHERE cat_gd_id=$i";
					
					if ($rst=mysql_query($str_sql)) {
						$adata=mysql_fetch_row($rst);
						$cat=$adata[0];
						$par=$adata[1];
						$mcatid=$adata[2];
					}
					mysql_free_result($rst);
				}
				
				$cols=GetAllColorsFromLinkageTable($mcatid,$i,'GENL');
				$titlecolor=$cols[0];
				$fontcolor=$cols[2];
				$bodybgcolor=$cols[1];
				$bodyfontcolor=$cols[3];
				
									
				if(!isset($p)) $p=0;
				?><center>
					<table border=0>
						<form method=post action="<?php echo $me;?>" name='frmgen'>
						<input type=hidden name="m" value=12>
						<input type=hidden name="a" value=4>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<input type=hidden name="i" value=<?php echo $i;?>>
						<input type=hidden name=par value=<?php echo $par;?>>
						<tr><Td class="formcaption" colspan=2>Edit General Category</Td></tr>
<?
				if (strlen(trim($str_err))) {
					echo "<tr><Td valign=top colspan=2>".print_error1($str_err)."</td></tr>";
				}
?>
						<tr><td>Master Category</td>
								<td><?php
								
								FillData($adata[2], "cmbmcat", "COMBO", "0", "iMcatid,vname", "cat_master", "N", "vName" ,"");
								?></td></tr>
								
						<tr><td>Category</td>
			<td><input type=text name="cat" maxlength=60 value="<?php echo format_str($cat);?>"></td></tr>
		<tr> 
      <td>Title BG Colour:</td>
      <td ><input type='text' name='titlecolor' value="<? echo $titlecolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmgen.titlecolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Title Font Colour:</td>
      <td ><input type='text' name='fontcolor' value="<? echo $fontcolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmgen.fontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	
	 <tr> 
      <td>Content BG Colour:</td>
      <td ><input type='text' name='bodybgcolor' value="<? echo $bodybgcolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmgen.bodybgcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Content Font Colour:</td>
      <td ><input type='text' name='bodyfontcolor' value="<? echo $bodyfontcolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmgen.bodyfontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
						<tr><td align=right colspan=2><input type=submit value="Update"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0){
					$str_err.="General Category name cannot be left blank.<br>";
					$bln_err++;
				} elseif (fn_checkgencategory($cat,$p)>0) {
					$str_err.="A General Category with the same name has already been entered.<br>";
					$bln_err++;
				}
				
				if (!$bln_err) {
					if(!$p) $p=0;
					
					$genid=NextID("cat_gd_id","cat_general_database");
					$str_sql="INSERT INTO cat_general_database (cat_gd_id, cat_gd_name, cat_gd_parent_id,iMCatid) VALUES ($genid, '".parse_sql($cat)."', $p,$cmbmcat)";
					
					if($cmbmcat!=0)					
					InsertOrUpdateOrDeleteCatID($cmbmcat,"GENL",$genid,"INSERT",$titlecolor,$fontcolor,$bodybgcolor,$bodyfontcolor);
				
					if (mysql_query($str_sql)) {
						print_message("<br>General Category has been created.");
						?><script>parent.l.document.location.reload(true);</script><?
					} else {
						print_error("Error: ".mysql_error());
					}
					break;
				}
	
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW General Database Category
			case 1:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				if(!isset($cat)) $cat="";
				?>
					<table border=0 align=center>
						<form method=post action="<?php echo $me;?>" name='frmgen'>
						<input type=hidden name="m" value=12>
						<input type=hidden name="a" value=2>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<tr><Td class="formcaption" colspan=2>Add a General Category</Td></tr>
<?
				if (strlen(trim($str_err))) {
					echo "<tr><Td valign=top colspan=2>".print_error1($str_err)."</td></tr>";
				}
?>
						<tr><td>Master Category</td>
								<td><?php
								
								FillData("", "cmbmcat", "COMBO", "0", "iMcatid,vname", "cat_master", "N", "vName" ,"");
								?></td></tr>
						<tr><td>Name:</td>
								<td><input type=text name="cat" maxlength=60 value="
										<?php echo format_str($cat);?>"></td></tr>
										
	<tr> 
      <td>Title BG Colour:</td>
      <td ><input type='text' name='titlecolor'  > 
        <a href="javascript:TCP.popup(document.frmgen.titlecolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Title Font Colour:</td>
      <td ><input type='text' name='fontcolor'  > 
        <a href="javascript:TCP.popup(document.frmgen.fontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	
	 <tr> 
      <td>Content BG Colour:</td>
      <td ><input type='text' name='bodybgcolor'  > 
        <a href="javascript:TCP.popup(document.frmgen.bodybgcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Content Font Colour:</td>
      <td ><input type='text' name='bodyfontcolor'  > 
        <a href="javascript:TCP.popup(document.frmgen.bodyfontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
								
						<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE GENERAL CATEGORIES LIST
			default:  // CASE A,M=12
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				if (!isset($p)) {$p=0;}
				?><a target="l" href="x_panel.php?m=12">List General Categories</a> | <a target=r href="<?php echo $me;?>?m=12&p=<?php echo $p;?>&a=1">Add</a><hr><?php
				fn_showparentname_gd($p,12,$p);
				if (!isset($s)) {$s=0;}
				$str_sql="SELECT cat_gd_id, cat_gd_name 
									FROM cat_general_database 
									WHERE cat_gd_parent_id=$p";

				$rst=mysql_query($str_sql);
				if ($s<1) $s=1;
				$lcnt = 1;
				if ($rst) {
					if($r=mysql_num_rows($rst)) {
						while($adata=mysql_fetch_row($rst))  {
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) {
								echo "<li><a href=\"$me?m=12&p=$adata[0]\">".format_str($adata[1])."</a> | 
													<a target=r href=\"$me?m=12&a=3&i=$adata[0]\">Mod</a> |
													<a target=r href=\"$me?m=12&a=5&i=$adata[0]\">Del</a>";
							}
							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT)) {break;}
							$lcnt++;
						}
						echo "<hr>";
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1) { 
							echo "| <a href=$me?m=12&p=$p&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";
						}
						if ($lcnt<=mysql_num_rows($rst)) {
							echo "| <a href=$me?m=12&p=$p&s=$lcnt>Next</a> ";
						}
					} else {
						print_error("There are no records currently.");
					}
				} else {
					print_error ("Error: ".mysql_error());
				}	
		} //END OF CASE 12
		break;

	##################################################
	#	CURRENT AFFAIRS
	case 11:  // CASE M
	##################################################
		
	if (!isset($a)) {$a=0;}	
	switch ($a) {
		
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//EDITING NEWS ?
		case 10:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		
		echo "done";
		
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//DELETE NEWS
		case 9:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			
			if ($p==1) { 
				$sql=" news_photo ";
			} elseif ($p==2) {
				$sql=" news_logo ";
			}
			
			$str_sql="SELECT $sql FROM news WHERE news_id=$f";
			if($rst=mysql_query($str_sql)) {
				$adata=mysql_fetch_row($rst);
				if($adata[0]) {
					unlink(IMAGES_FOLDER.$adata[0]);
				}
			} else {
				echo mysql_error($rst);
			}
			
			$str_sql="UPDATE news SET $sql='' WHERE news_id=$f";
			if($rst=mysql_query($str_sql)) {
				print_message("The Image has been deleted");
				?><script>parent.l.document.location.reload(true);</script><?
			} else {
				echo mysql_error($rst);
			}
		
			break;
		
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//DELETE NEWS QUESTION?
		case 8:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			echo "<center><b>Do you really want to delete the Image?</b><br>
						<a href=\"".$me."?m=11&a=9&p=$p&f=$i&k=$k\">YES</a> / <a href=\"".$me."?m=11&a=7\">NO</a></center>";
			break;
			
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//PLACEBO
		case 7:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			break;
		
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//DELETE NEWS
		case 6:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			$bln_err=0;
			$str_err="";
			
			$str_sql="SELECT news_photo, news_logo FROM news WHERE news_id=$f";
			if($rst=mysql_query($str_sql)) {
				$adata=mysql_fetch_row($rst);
				if($adata[0]) {
					if(!unlink(IMAGES_FOLDER.$adata[0])) {
						$bln_err++;
						$str_err.="Main image $adata[0] deletion error<br>";
					}
				}					
				if($adata[1]) {
					if(!unlink(IMAGES_FOLDER.$adata[1])) {
						$bln_err++;
						$str_err.="Main image $adata[1] deletion error<br>";
					}
				}
			} else {
				echo mysql_error($rst);
			}
			
			if(!$bln_err) {
				$str_sql="DELETE FROM news WHERE news_id=$f";
				if($rst=mysql_query($str_sql)) {
					print_message("The News Article has been deleted");
					?><script>parent.l.document.location.reload(true);</script><?
				} else {
					echo mysql_error($rst);
				}
			} else {
				print_error(" $bln_err File deletion errors <br>$str_err");
			}
			break;
		
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//DELETE NEWS QUESTION?
		case 5:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			echo "<center><b>Do you really want to delete the News Article?</b><br>
						<a href=\"".$me."?m=11&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=11&a=7\">NO</a></center>";
			break;
		
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//VALIDATE AND MODIFYING THE PROFILE
		case 4:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		
		if($a==4) {
			$str_err=$cper="";
			$bln_err=0;
			
			if(!isset($chk)) $chk=0;
			
			if (strlen(trim($fnm))==0) {
				$str_err.="Title cannot be left blank.<br>"; 
				$bln_err++;
			}
			
			if($pic) {
				$str_picture=$HTTP_POST_FILES['pic']['name'];
				$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
				
				if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
					$str_err.="Photograph Uploaded is too Large.<br>"; 
					$bln_err++;
				}
				
				if(strlen(trim($str_picture))>0) {
					$str_file_extension=get_file_extension();
					if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
						$str_err.="Photograph must be of jpeg, jpg, png, bmp or gif format.<br>";
						$bln_err++;
					}						
				}
			}
			
			if($logo) {
				$temp_pic=$pic;
				$pic=$logo;
				$str_picture=$HTTP_POST_FILES['pic']['name'];
				$lng_file_size=fn_check_file_size(MAX_LOGO_UPLOAD_SIZE);
				
				if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
					$str_err.="Logo Uploaded is too Large.<br>"; 
					$bln_err++;
				}
			
				if(strlen(trim($str_picture))>0) {
					$str_file_extension=get_file_extension();
					if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
						$str_err.="Logo must be of jpeg, jpg, png, bmp or gif format.<br>";
						$bln_err++;
					}
				}
				$pic=$temp_pic;
			}
			
			if (strlen(trim($det))==0) {
				$str_err.="Description cannot be left blank.<br>"; 
				$bln_err++;
			}
			
			if(!$bln_err && $pic) {
				$str_file_name=$HTTP_POST_FILES['pic']['name'];
				if(strlen(trim($str_file_name))>0) {
					//PICTURE WAS SELECTED
					$str_new_file=time().".".$str_file_name;
					$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
					if (is_uploaded_file($str_temp)) {
						$str_destination=IMAGES_FOLDER.$str_new_file;
						if(move_uploaded_file($str_temp,$str_destination)) {
							$pic=$str_new_file;
						} else {
							$str_err.="Photograph upload error.<br>"; 
							$bln_err++;
						}
					}
				}
			}
			
			if(!$bln_err && $logo) {
				$str_file_name=$HTTP_POST_FILES['logo']['name'];
				if(strlen(trim($str_file_name))>0) {
					//PICTURE WAS SELECTED
					$str_new_file=time().".".$str_file_name;
					$str_temp=$HTTP_POST_FILES['logo']['tmp_name'];
					if (is_uploaded_file($str_temp)) {
						$str_destination=IMAGES_FOLDER.$str_new_file;
						if(move_uploaded_file($str_temp,$str_destination)) {
							$logo=$str_new_file;
						} else {
							$str_err.="Logo upload error.<br>"; 
							$bln_err++;
						}
					}
				}
			}
			
			if (!$bln_err) {																
				$str_sql="UPDATE news set news_title='".parse_sql($fnm)."', news_is_archived='".$chk."',
												 news_details='".parse_sql($det)."'";
				if($pic) {
					$str_sql.=", news_photo='".parse_sql($pic)."'";
					unlink(IMAGES_FOLDER.$pic1);
				}
				if($logo) {
					$str_sql.=", news_logo='".parse_sql($logo)."'";
					unlink(IMAGES_FOLDER.$logo1);
				}
				$str_sql.=" WHERE news_id=$i";
				
				if (mysql_query($str_sql))  {
					?><script>parent.l.document.location.reload(true);</script><?
					if($pln>0) {
						$a='3a';
					} else {
						echo"<center><b>The profile has been updated.</b></center>";
						break;
					}							
				} else print_error(mysql_error());
			}	
		}
		
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//SHOW THE EDIT NEWS FORM
		case 3:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		
		if($a==3) {
			
			$str_sql="SELECT news_id, news_title, news_details, news_photo, news_logo, 
											 news_type, news_is_archived
								FROM  news 
								WHERE news_id=".$i;
								
			if ($rst=mysql_query($str_sql)) {
				$adata=mysql_fetch_row($rst);
				mysql_free_result($rst);
				$fnm=$adata[1];
				$det=$adata[2];
				$pic=$adata[3];
				$logo=$adata[4];
				$t=$adata[5];
				$str_type="Latest News";
				if ($t==NEWS_ANALYSIS) $str_type="News Analysis";
				$ao=$adata[6];
				$chk=$adata[7];
			}
?>
				<table align=center border=0 cellpadding=3 cellspacing=0>
					<form method=post enctype="multipart/form-data" action="<?php echo $me;?>">
					<input type=hidden name="m" value=11>
					<input type=hidden name="a" value=4>
					<input type=hidden name="t" value=<? echo $t; ?>>
					<input type=hidden name="i" value=<? echo $i; ?>>
					<input type=hidden name="logo1" value=<? echo $logo; ?>>
					<input type=hidden name="pic1" value=<? echo $pic; ?>>
					<tr><td colspan=2 class="formcaption">Edit <? echo $str_type; ?></td></tr>
<?php
			if (strlen(trim($str_err))) {
				echo "<tr><Td colspan=2 align=center>".print_error1($str_err)."</td></tr>";
			}					
?>
					<tr><td valign=top>Title: </td>
							<td><input type=text name="fnm" maxlength=60 value="<?php echo format_str($fnm);?>"> 
									</td></tr>		
					<tr><td valign=top>Logo: </td>
							<td><input type=file name="logo"><br>
<? 
					if($logo) {
						?><img src="<?php echo format_str(IMAGES_FOLDER.$logo);?>"> <?
						echo "<a target=\"r\" href=\"".$me."?m=11&a=8&p=2&i=".$i."\">Delete Image</a>"; 
					}
?>
					</td></tr>
					<tr><td valign=top>Photograph: </td>
							<td><input type=file name="pic"><br>
<? 					
					if($pic) {
						?><img src="<?php echo format_str(IMAGES_FOLDER.$pic);?>"> <?
						echo "<a target=\"r\" href=\"".$me."?m=11&a=8&p=1&i=".$i."\">Delete Image</a>"; 
					}
?>
					</td></tr>
					<tr><td valign=top>Description: </td>
							<td><textarea name="det" cols=50 rows=15><?php echo format_str($det);?></textarea>
									<script language="javascript1.2">editor_generate('det');</script></td></tr>
					<tr><td>Type/Listed Since: </td>
							<td><?php if($t==NEWS_ANALYSIS) {
													echo "News Analysis/ ".format_str(date("dS M, Y",strtotime($ao)));
												} 
												else {
													echo "Latest News / ".format_str(date("dS M, Y",strtotime($ao)));
												} 
												
									?></td></tr>
					<!--tr><td>Archive? </td>
							<td><input name="chk" type="checkbox" value="1"<?echo ($chk)? "checked" : "" ;?>></td></tr-->
					<tr><td colspan=2 align=right><input type=submit name=profile value=Modify></td></tr>
					</form>
				</table></center>
			<?php
		}	
		
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//VALIDATE AND INSERT INTO THE DATABASE
		case 2:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		
		if($a==2) {
			$psd=$cper=$str_err="";
			$bln_err=0;
			
			if(!isset($chk)) $chk=0;
			
			if (strlen(trim($fnm))==0) {
				$str_err.="Title cannot be left blank.<br>"; 
				$bln_err++;
			}
			
			if($logo) {
				$str_picture=$HTTP_POST_FILES['logo']['name'];
				$lng_file_size=fn_check_file_size(MAX_LOGO_UPLOAD_SIZE);
				
				if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
					$str_err.="Logo Uploaded is too Large.<br>"; 
					$bln_err++;
				}
				
				if(strlen(trim($str_picture))>0) {
					$str_file_extension=get_file_extension();
					if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
						$str_err.="Logo must be of jpeg, jpg, png, bmp or gif format.<br>";
						$bln_err++;
					}						
				}
			}
			
			if($pic) {
				$str_picture=$HTTP_POST_FILES['pic']['name'];
				$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
				
				if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
					$str_err.="Photograph Uploaded is too Large.<br>"; 
					$bln_err++;
				}
				
				if(strlen(trim($str_picture))>0) {
					$str_file_extension=get_file_extension();
					if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
						$str_err.="Photograph must be of jpeg, jpg, png, bmp or gif format.<br>";
						$bln_err++;
					}						
				}
			}
			
			if (strlen(trim($det))==0) {
				$str_err.="Description cannot be left blank.<br>"; 
				$bln_err++;
			}
			
			if(!$bln_err && $logo) {
				$str_file_name=$HTTP_POST_FILES['logo']['name'];
				if(strlen(trim($str_file_name))>0) {
					//PICTURE WAS SELECTED
					$str_new_file=time().".".$str_file_name;
					$str_temp=$HTTP_POST_FILES['logo']['tmp_name'];
					if (is_uploaded_file($str_temp)) {
						$str_destination=IMAGES_FOLDER.$str_new_file;
						if(move_uploaded_file($str_temp,$str_destination)) {
							$logo=$str_new_file;
						} else {
							$str_err.="Logo upload error.<br>"; 
							$bln_err++;
						}
					}
				}
			}
			
			if(!$bln_err && $pic) {
				$str_file_name=$HTTP_POST_FILES['pic']['name'];
				if(strlen(trim($str_file_name))>0) {
				?>
				<script>alert("wassup!");</script>
				<?php
					//PICTURE WAS SELECTED
					$str_new_file=time().".".$str_file_name;
					$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
					if (is_uploaded_file($str_temp)) {
						$str_destination=IMAGES_FOLDER.$str_new_file;
						if(move_uploaded_file($str_temp,$str_destination)) {
							$pic=$str_new_file;
						} else {
							$str_err.="Photograph upload error.<br>";
							$bln_err++;
						}
					}
				}
			}
			
			if (!$bln_err) {
				$str_sql="INSERT INTO news (news_title, news_details, news_photo, news_logo, news_type, news_is_archived) VALUES ('".parse_sql($fnm)."','".parse_sql($det)."', '".parse_sql($pic)."','".parse_sql($logo)."',".$t.",".$chk.")";
				if (mysql_query($str_sql))  {
					$lng_insert_id=mysql_insert_id();

					if(!isset($chknewsmailer))
						{?><script>parent.l.document.location.reload(true);</script><? }
				} else print_error(mysql_error());
//				break;
			} else {
				$a=1;
			}
			
################################## Checking 4 Mailer Option ######################################
			if(isset($chknewsmailer))
			{
				?><script language="JavaScript">document.location.href="x_mailer.php?det=<? echo $det; ?>";</script><?
			}
			break;
		}		

		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//ADD NEW LISTINGS
		case 1:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

		if($a==1) {
			if($t==NEWS_ANALYSIS) {
				$str_type="News Analysis";
			} elseif($t==LATEST_NEWS) {
				$str_type="Latest News";
			}																

?>
				<table border=0 align=center>
					<form method=post enctype="multipart/form-data" action="<?php echo $me;?>">
					<input type=hidden name="m" value=11>
					<input type=hidden name="a" value=2>
					<input type=hidden name="t" value=<? echo $t; ?>>
					<tr><td colspan=2 class="formcaption">Add <? echo $str_type; ?></td></tr>
<?php
			if (strlen(trim($str_err))) {
				echo "<tr><Td colspan=2 align=center>".print_error1($str_err)."</td></tr>";
			}					
?>
					<tr><td valign=top>Title: </td>
							<td><input type=text name="fnm" maxlength=255 value="<?php echo format_str($fnm);?>"></td></tr>		
					<tr><td valign=top>Logo: </td>
							<td><input type=file name="logo" maxlength=60 value="<?php echo format_str($logo);?>"></td></tr>
					<tr><td valign=top>Photograph: </td>
							<td><input type=file name="pic" maxlength=60 value="<?php echo format_str($pic);?>"></td></tr>
					<tr><td valign=top>Description: </td>
							<td><textarea name="det" cols=50 rows=10><?php echo format_str($det);?></textarea>
									<script language="JavaScript">editor_generate('det');</script></td></tr>
					<tr><td valign=top colspan="2"><input type="checkbox" name="chknewsmailer" value="checkbox">Send this article to all subscribers</td></tr>
					<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
					</form>
				</table></center>
			<?php
			break;
		}
		break;
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		//SHOW THE LISTINGS
		default:  // CASE A,M=11
		#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		
		if(isset($mode))
		{
			if($mode=='S')//must SET it...
				$q = "update news set news_is_archived=1 where news_id=$id";
			else if($mode=='U')
				$q = "update news set news_is_archived=0 where news_id=$id";
				
			$r = mysql_query($q);
		}			
			?><a href="x_panel.php?m=11">List Current Affairs</a><br>Add: <a target=r href="<?php echo $me;?>?m=11&a=1&t=<? echo LATEST_NEWS; ?>">Latest News</a>/ 
			<a target=r href="<?php echo $me;?>?m=11&a=1&t=<? echo NEWS_ANALYSIS; ?>">News Analysis</a> <hr><?php

			if (!isset($s)) {$s=0;}
			$str_sql="SELECT news_id, news_title, news_details, news_photo, news_logo, 
											 news_type, news_is_archived
								FROM news
								ORDER BY news_id desc";
			if ($s<1) $s=1;
			$lcnt = 1;
			 if ($rst=mysql_query($str_sql)) {
				if($r=mysql_num_rows($rst)) {
					while($adata=mysql_fetch_row($rst))  {
						if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) {
							echo "<li><a target=r href=\"$me?m=11&a=3&i=$adata[0]\">";
							echo ($adata[5]==NEWS_ANALYSIS) ? format_str($adata[1])." (Analysis) " : format_str($adata[1])." (Latest)" ;
							echo "</a> | <a target=r href=\"$me?m=11&a=5&i=$adata[0]\">Del</a> | ";
							ToggleArchived($adata[0], $adata[6]);
						} 
						if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT)) {break;}
						$lcnt++;	
					} 
					echo "<hr>";
					if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1) { 
						echo "| <a href=$me?m=11&p=$p&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";
					}
					if ($lcnt<=mysql_num_rows($rst)) { 
						echo "| <a href=$me?m=11&p=$p&s=$lcnt>Next</a> ";
					}
				} else {
					print_error("There are no records currently.");
				}
			} else {
				print_error ("Error: ".mysql_error());
			}
		} // END OF CASE 11 SWITCH 
	
	break;
	//END OF THE MANAGE NEWS BLOCK
	
	##################################################
	# THERE IS NO CASE 10
	#	case 10:  // CASE M
	##################################################
/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////
	##################################################
	// JOB ARTICLES
	case 21:  // CASE M
	##################################################
		if (!isset($a)) 
			$a=0;
			
		switch ($a) 
		{
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//EDITING A JOB ARTICLE ?
			case 10:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			echo "done";
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE JOB ARTICLE IMAGES
			case 9:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
					// DELETION OF ARTICLE IMAGES
					if ($p==1) 
						$sql=" vPhoto";
					elseif ($p==2)
						$sql=" vLogo";
					
					$str_sql="SELECT $sql FROM job_articles WHERE iJARTID=$f";
					
					if($rst=mysql_query($str_sql)) 
					{
						$adata=mysql_fetch_row($rst);
						
						if($adata[0]) 
							unlink(JOB_IMAGES_FOLDER.$adata[0]);
					} 
					else
						echo mysql_error($rst);
					
					$str_sql="UPDATE job_articles SET $sql='' WHERE iJARTID=$f";
					
					if($rst=mysql_query($str_sql)) 
					{
						print_message("The Image has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} 
					else 
						echo mysql_error($rst);

				break;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE JOB ARTICLE QUESTION?
			case 8:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				echo "<center><b>Do you really want to delete the Image?</b><br>
							<a href=\"".$me."?m=21&a=9&p=$p&f=$i\">YES</a> / <a href=\"".$me."?m=21&a=7\">NO</a></center>";
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE JOB ARTICLE
			case 6:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				$bln_err=0;
				$str_err="";
				$str_sql="SELECT vPhoto, vLogo, iJID FROM job_articles WHERE iJARTID=$f";
				
				if($rst=mysql_query($str_sql)) 
				{
					$adata=mysql_fetch_row($rst);
					if($adata[0]) 
					{
						if(!unlink(JOB_IMAGES_FOLDER.$adata[0])) 
						{
							$bln_err++;
							$str_err.="Main image $adata[0] deletion error<br>";
						}
					}					
					if($adata[1]) 
					{
						if(!unlink(JOB_IMAGES_FOLDER.$adata[1])) 
						{
							$bln_err++;
							$str_err.="Main image $adata[1] deletion error<br>";
						}
					}
					
					$sql_query="UPDATE job_categories SET iCount=iCount-1 WHERE iJID=".$adata[2];
					
					if(!mysql_query($sql_query,$dbc)) 
						echo mysql_error();
				} 
				else 
					echo mysql_error($rst);
				
				if(!$bln_err) 
				{
					$str_sql="DELETE FROM job_articles WHERE iJARTID=$f";
					
					if($rst=mysql_query($str_sql)) 
					{
						print_message("The Job Article has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} 
					else 
						echo mysql_error($rst);
				} 
				else 
					print_error(" $bln_err File deletion errors <br>$str_err");

				break;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE JOB ARTICLE QUESTION?
			case 5:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				echo "<center><b>Do you really want to delete the Job Article?</b><br>							<a href=\"".$me."?m=21&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=21&a=7\">NO</a></center>";
				break;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND MODIFYING THE JOB ARTICLE
			case 4:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			if($a==4) 
			{
				$str_err=$cper="";
				$bln_err=0;
				
				if (strlen(trim($fnm))==0) 
				{
					$str_err.="First name cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if($pic) 
				{
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) 
					{
						$str_err.="Photograph Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) 
					{
						$str_file_extension=get_file_extension();
						
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) 
						{ 
							$str_err.="Photograph must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if($logo) 
				{
					$temp_pic=$pic;
					$pic=$logo;
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_LOGO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) 
					{
						$str_err.="Logo Uploaded is too Large.<br>"; 
						$bln_err++;
					}
				
					if(strlen(trim($str_picture))>0)
					{
						$str_file_extension=get_file_extension();
						
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) 
						{ 
							$str_err.="Logo must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
					$pic=$temp_pic;
				}
				
				if (strlen(trim($det))==0) 
				{
					$str_err.="Details cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if ($lu1==0) 
				{
					$str_err.="Choose a category to be listed under.<br>"; 
					$bln_err++;
				} 
				
/////////////////////////////////new code
				if (strlen(trim($dt))==0) 
				{
					$str_err.="Article date cannot be left blank.<br>"; 
					$bln_err++;
				}
/////////////////////////////////new code
				
				if(!$bln_err && $pic) 
				{
					$str_file_name=$HTTP_POST_FILES['pic']['name'];
					
					if(strlen(trim($str_file_name))>0) 
					{
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
						
						if (is_uploaded_file($str_temp)) 
						{
							$str_destination=JOB_IMAGES_FOLDER.$str_new_file;
							
							if(move_uploaded_file($str_temp,$str_destination)) 
								$pic=$str_new_file;
							else 
							{
								$str_err.="Photograph upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if(!$bln_err && $logo) 
				{
					$str_file_name=$HTTP_POST_FILES['logo']['name'];
					
					if(strlen(trim($str_file_name))>0) 
					{
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['logo']['tmp_name'];
						
						if (is_uploaded_file($str_temp)) 
						{
							$str_destination=JOB_IMAGES_FOLDER.$str_new_file;
							
							if(move_uploaded_file($str_temp,$str_destination)) 
								$logo=$str_new_file;
							else 
							{
								$str_err.="Logo upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if (!$bln_err) 
				{
					$str_sql="SELECT iJID FROM job_articles WHERE iJARTID=".$i;
					
					if ($rst=mysql_query($str_sql)) 
					{
						$adata=mysql_fetch_row($rst);
						mysql_free_result($rst);
						$sql_query="UPDATE job_categories SET iCount=iCount-1 WHERE iJID=".$adata[0];
						
						if(!mysql_query($sql_query,$dbc)) 
							echo mysql_error();
					}
					
					$str_sql="UPDATE job_articles SET vName='".parse_sql($fnm)."', iJID=".$lu1.", bDetails='".parse_sql($det)."', dDate='".$dt."'";
													 
					if($pic) 
					{
						$str_sql.=", vPhoto='".parse_sql($pic)."'";
						unlink(JOB_IMAGES_FOLDER.$pic1);
					}
					if($logo) {
						$str_sql.=", vLogo='".parse_sql($logo)."'";
						unlink(JOB_IMAGES_FOLDER.$logo1);
					}
					$str_sql.=" WHERE iJARTID=$i";
					
					if (mysql_query($str_sql))  
					{
						$sql_query="UPDATE job_categories SET iCount=iCount+1 WHERE iJID=".$lu1;
					
						if(!mysql_query($sql_query,$dbc)) 
							echo mysql_error();
						?><script>parent.l.document.location.reload(true);</script><?
						print_message ("Article has been updated.");
						break;						

					} 
					else 
						print_error(mysql_error());
				}	
			}
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT JOB ARTICLE FORM
			case 3:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			$sql_query="SELECT iJID, vName, iParentID FROM job_categories ORDER BY iParentID asc, vName";
			
				if($rst=mysql_query($sql_query,$dbc)) 
				{
					$l_cnt=0;
					while($adata=mysql_fetch_row($rst))
					{
						$acat[$l_cnt][0]=$adata[0]; //cat id
						$acat[$l_cnt][1]=$adata[1]; //name
						$acat[$l_cnt][2]=$adata[2]; //parent
						$l_cnt++;
					}
				} 
				else 
					echo mysql_error();
				
				$str_out="";	//global variable
				build_tree(0,0);

				// BUILDING OF THE ARRAYS -- END
				$str_sql="SELECT iJARTID, vName, bDetails, vPhoto, vLogo, iJID, dDate FROM  job_articles WHERE iJARTID=".$i;
				if ($rst=mysql_query($str_sql)) 
				{
					$adata=mysql_fetch_row($rst);
					mysql_free_result($rst);
					$pic1=$adata[3];
					$logo1=$adata[4];
					$adata[3]=JOB_IMAGES_FOLDER.$adata[3];
					$adata[4]=JOB_IMAGES_FOLDER.$adata[4];
				}
				
				if(strlen($str_err)>0) 
					$adata=array($i,$fnm,$det,$adata[3],$adata[4],$lu1, $adata[6]);
				?>
							<!-- 			new code -->
				<DIV id=popCal onclick=event.cancelBubble=true 
style="BORDER-BOTTOM: 2px ridge; BORDER-LEFT: 2px ridge; BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; POSITION: absolute; VISIBILITY: hidden; WIDTH: 10px; Z-INDEX: 100">
				<IFRAME frameBorder=0 height=188 name=popFrame scrolling=no src="./scripts/popcjs.htm" width=183></IFRAME></DIV>
				<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
							<!-- 			new code -->
					<table border=0 cellpadding=3 cellspacing=0 align=center>
						<form method=post enctype="multipart/form-data" action="<?php echo $me;?>">
						<input type=hidden name="m" value=21>
						<input type=hidden name="a" value=4>
						<input type=hidden name="i" value=<? echo $i; ?>>
						<input type=hidden name="logo1" value=<? echo $logo1; ?>>
						<input type=hidden name="pic1" value=<? echo $pic1; ?>>
						<tr>
      <Td colspan=2 class="formcaption">Edit Job Articles</Td>
    </tr>
<?php
				if (strlen(trim($str_err))) 
					echo "<tr><Td valign=top align=center colspan=2>".print_error1($str_err)."</Td></tr>";
?>
						<tr><td>Name: </td>
								<td><input type=text name="fnm" maxlength=60 size="60" value="<?php echo format_str($adata[1]);?>"></td></tr>		
						<tr><td valign=top>Logo: </td>
								<td><input type=file name="logo"><br>
						<? if($logo1) {
								?><img src="<?php echo format_str($adata[4]);?>"><?php
						  	 echo " <a target=\"r\" href=\"".$me."?m=21&a=8&p=2&i=".$i."\">Delete Image</a>"; 
					  	 } ?>
						</td></tr>
						<tr><td valign=top>Photograph: </td>
								<td><input type=file name="pic"><br>
						<? if($pic1) {
								?><img src="<?php echo format_str($adata[3]);?>"><?php
						  	 echo " <a target=\"r\" href=\"".$me."?m=21&a=8&p=1&i=".$i."\">Delete Image</a>"; 
							 } ?>
						</td></tr>
						<tr><td valign=top>Details: </td>
								<td><textarea name="det" cols=50 rows=15><?php echo format_str($adata[2]);?></textarea>
										<script language="javascript1.2">editor_generate('det');</script></td></tr>
						<tr><td>List Under: </td>
								<td valign=top>
									<select name="lu1"><option value=0 selected>Choose ... </option><? print_dropdown($a_list_under,$adata[5])?></select></td></tr>
			<!-- 			new code -->
						<tr><td valign=top>Date: </td>
								<td valign=top> <input type=text name="dt" maxlength=10 size="10" value="<?php echo $adata[6];?>" readonly id="dt"><input name="reset" type="reset" class="box" onclick="return showCalendar('dt', '%Y-%m-%d ', '24', true);" value=" V "></td></tr>
			<!-- 			new code -->		
						<tr><td colspan=2 align=right><input type=submit name=profile value=Modify></td></tr>
						</form>
					</table>
				<?php			
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&	
				
				$psd=$cper=$str_err="";
				$bln_err=0;
				
				if (strlen(trim($fnm))==0) 
				{
					$str_err.="Article name cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if(check_duplicate_entry("job_articles", "vName", $fnm)) 
				{
					$str_err.="This Article name has already been taken. Please try another one. <br>"; 
					$bln_err++;
				}
				
				if($logo) 
				{
					$str_picture=$HTTP_POST_FILES['logo']['name'];
					$lng_file_size=fn_check_file_size(MAX_LOGO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) 
					{
						$str_err.="Image 1 Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) 
					{
						$str_file_extension=get_file_extension();
						
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) 
						{ 
							$str_err.="Image 1 must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if($pic) 
				{
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) 
					{
						$str_err.="Image 2 Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) 
					{
						$str_file_extension=get_file_extension();
						
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) 
						{ 
							$str_err.="Image 2 must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if (strlen(trim($det))==0) 
				{
					$str_err.="Details cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if ($lu1==0) 
				{
					$str_err.="Choose a category to be listed under.<br>"; 
					$bln_err++;
				}

				if (strlen(trim($dt))==0) 
				{
					$str_err.="Article date cannot be left blank.<br>"; 
					$bln_err++;
				}

				if(!$bln_err && $logo) 
				{
					$str_file_name=$HTTP_POST_FILES['logo']['name'];
					
					if(strlen(trim($str_file_name))>0) 
					{
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['logo']['tmp_name'];
						
						if (is_uploaded_file($str_temp)) 
						{
							$str_destination=JOB_IMAGES_FOLDER.$str_new_file;
							
							if(move_uploaded_file($str_temp,$str_destination)) 
								$logo=$str_new_file;
							else 
							{
								$str_err.="Image 1 upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if(!$bln_err && $pic) 
				{
					$str_file_name=$HTTP_POST_FILES['pic']['name'];
					
					if(strlen(trim($str_file_name))>0) 
					{
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
						
						if (is_uploaded_file($str_temp)) 
						{
							$str_destination=JOB_IMAGES_FOLDER.$str_new_file;
							
							if(move_uploaded_file($str_temp,$str_destination)) 
								$pic=$str_new_file;
							else 
							{
								$str_err.="Image 2 upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if (!$bln_err) 
				{	
					$str_sql="INSERT INTO job_articles (vName, bDetails, vPhoto, vLogo, iJID, dDate) VALUES ('".parse_sql($fnm)."','".parse_sql($det)."', '".parse_sql($pic)."','".parse_sql($logo)."',".$lu1.", '".$dt."')";
					
					if (mysql_query($str_sql)) 
					{
						$lng_insert_id=mysql_insert_id();
						$sql_query="UPDATE job_categories SET iCount=iCount+1 WHERE iJID=".$lu1;
						
						if(!mysql_query($sql_query,$dbc)) 
							echo mysql_error();
						else 
						{
							?><script>parent.l.document.location.reload(true);</script><?
							print_message ("Article has been added.");
							break;
							$a=1;
						}
					} 
					else 
						print_error(mysql_error());
				}
				else
					$a=1;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW JOB ARTICLE
			case 1:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			if($a==1) 
			{
				// REGISTERING A JOB ARTICLE
				$sql_query="SELECT iJID, vName, iParentID FROM job_categories ORDER BY iParentID asc, vName";
				if($rst=mysql_query($sql_query,$dbc)) 
				{
					$l_cnt=0;
					
					while($adata=mysql_fetch_row($rst))
					{
						$acat[$l_cnt][0]=$adata[0]; 
						$acat[$l_cnt][1]=$adata[1]; 
						$acat[$l_cnt][2]=$adata[2]; 
						$l_cnt++;
					}
				} 
				else 
					echo mysql_error();

				$str_out="";	//global variable
				build_tree(0,0);
				?>
				<DIV id=popCal onclick=event.cancelBubble=true 
style="BORDER-BOTTOM: 2px ridge; BORDER-LEFT: 2px ridge; BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; POSITION: absolute; VISIBILITY: hidden; WIDTH: 10px; Z-INDEX: 100">
				<IFRAME frameBorder=0 height=188 name=popFrame scrolling=no src="./scripts/popcjs.htm" width=183></IFRAME></DIV>
				<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
					<table border=0 align=center>
						<form method=post enctype="multipart/form-data" action="<?php echo $me;?>">
						<input type=hidden name="m" value=21>
						<input type=hidden name="a" value=2>
						<tr><Td colspan=2 class="formcaption">Add Job Articles</Td></tr>
<?php
				if (strlen(trim($str_err)))
					echo "<tr><Td valign=top align=center colspan=2>".print_error1($str_err)."</Td></tr>";
?>
						<tr><td>Name: </td>
								<td><input type=text name="fnm" maxlength=60 size="60" value="<?php echo format_str($fnm);?>"></td></tr>		
						<tr><td>Image 1: </td>
								<td><input type=file name="logo" maxlength=60 value="<?php echo format_str($logo);?>"></td></tr>
						<tr><td>Image 2: </td>
								<td><input type=file name="pic" maxlength=60 value="<?php echo format_str($pic);?>"></td></tr>
						<tr><td valign=top>Details: </td>
								<td><textarea name="det" cols=50 rows=15><?php echo format_str($det);?></textarea>
										<script language="javascript1.2">editor_generate('det');</script></td></tr>
						<tr><td>List Under: </td>
								<td valign=top>
									<select name="lu1"><option value=0 selected>Choose ... </option><?print_dropdown($a_list_under,$lu1)?></select>									
								</td></tr>
						<tr><td valign=top>Date: </td>
								<td valign=top> <input type=text name="dt" maxlength=10 size="10" value="<?php echo $adata[6];?>" readonly id="dt"><input name="reset" type="reset" class="box" onclick="return showCalendar('dt', '%Y-%m-%d ', '24', true);" value=" V "></td></tr>
						<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
						</form>
					</table>
				<?php
				break;
			}
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//LIST JOB ARTICLES
			default:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				?><a href="x_panel.php?m=21">List Job Articles</a> |  
					<a target=r href="<?php echo $me;?>?m=21&a=1">Add</a><hr><?

				if (!isset($s)) {$s=0;}
				$str_sql="SELECT iJARTID, vName, bDetails, vPhoto, vLogo, iJID FROM job_articles ORDER BY vName ";
				if ($s<1) 
					$s=1;
					
				$lcnt = 1;
				if ($rst=mysql_query($str_sql)) 
				{
					if($r=mysql_num_rows($rst)) 
					{
						while($adata=mysql_fetch_row($rst))  
						{
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) 
								echo "<li><a target=r href=\"$me?m=21&a=3&i=$adata[0]\">".format_str($adata[1])."</a> | <a target=r href=\"$me?m=21&a=5&i=$adata[0]\">Del</a>";

							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT))
								break;
								
							$lcnt++;	
						} 
						echo "<hr>";
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1)
							echo "| <a href=$me?m=21&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";

						if ($lcnt<=mysql_num_rows($rst))
							echo "| <a href=$me?m=21&s=$lcnt>Next</a> ";
					} 
					else 
						print_error("There are no records currently.");
				} 
				else
					print_error ("Error: ".mysql_error());
			} //END OF CASE 21
			break;
//////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
##################################################
	// CLASSIFIED ARTICLES
	case 71:  // CASE M
	##################################################
		if (!isset($a)) 
			$a=0;
			
		switch ($a) 
		{
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//EDITING A CLASSIFIED ARTICLE ?
			case 10:  // CASE A,M=71
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			echo "done";
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE CLASSIFIED ARTICLE IMAGES
			case 9:  // CASE A,M=71
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
					// DELETION OF ARTICLE IMAGES
					if ($p==1) 
						$sql=" vPic";
						
								
					$str_sql="SELECT $sql FROM classifiedarts WHERE iClartID=$f";
					
					if($rst=mysql_query($str_sql)) 
					{
						$adata=mysql_fetch_row($rst);
						
						if($adata[0]) 
							unlink(CLASSIFIED_IMAGES_FOLDER.$adata[0]);
					} 
					else
						echo mysql_error($rst);
					
					$str_sql="UPDATE classifiedarts SET $sql='' WHERE iClartID=$f";
					
					if($rst=mysql_query($str_sql)) 
					{
						print_message("The Image has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} 
					else 
						echo mysql_error($rst);

				break;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE CLASSIFIED ARTICLE QUESTION?
			case 8:  // CASE A,M=71
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				echo "<center><b>Do you really want to delete the Image?</b><br>
							<a href=\"".$me."?m=71&a=9&p=$p&f=$i\">YES</a> / <a href=\"".$me."?m=71&a=7\">NO</a></center>";
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=71
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE CLASSIFIED ARTICLE
			case 6:  // CASE A,M=71
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
								
				$bln_err=0;
				$str_err="";
				$str_sql="SELECT vPic, iCLID FROM classifiedarts WHERE iClartID=$f";
				
				if($rst=mysql_query($str_sql)) 
				{
					$adata=mysql_fetch_row($rst);
					if($adata[0]) 
					{
						if(!unlink(CLASSIFIED_IMAGES_FOLDER.$adata[0])) 
						{
							$bln_err++;
							$str_err.="Main image $adata[0] deletion error<br>";
						}
					}					
					
					
					$sql_query="UPDATE classifiedcats SET iCount=iCount-1 WHERE iCLID=".$adata[1];
					
					if(!mysql_query($sql_query,$dbc)) 
						echo mysql_error();
				} 
				else 
					echo mysql_error($rst);
				
				if(!$bln_err) 
				{
					$str_sql="DELETE FROM classifiedarts WHERE iClartID=$f";
					
					if($rst=mysql_query($str_sql)) 
					{
						print_message("The Classifieds Article has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} 
					else 
						echo mysql_error($rst);
				} 
				else 
					print_error(" $bln_err File deletion errors <br>$str_err");

				break;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE CLASSIFIED ARTICLE QUESTION?
			case 5:  // CASE A,M=71
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				echo "<center><b>Do you really want to delete the Classifieds Article?</b><br>							<a href=\"".$me."?m=71&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=71&a=7\">NO</a></center>";
				break;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND MODIFYING THE CLASSIFIED ARTICLE
			case 4:  // CASE A,M=71
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			if($a==4) 
			{
				$str_err=$cper="";
				$bln_err=0;
				
				if (strlen(trim($fnm))==0) 
				{
					$str_err.="First name cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if($pic) 
				{
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) 
					{
						$str_err.="Photograph Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) 
					{
						$str_file_extension=get_file_extension();
						
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) 
						{ 
							$str_err.="Photograph must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if($logo) 
				{
					$temp_pic=$pic;
					$pic=$logo;
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_LOGO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) 
					{
						$str_err.="Logo Uploaded is too Large.<br>"; 
						$bln_err++;
					}
				
					if(strlen(trim($str_picture))>0)
					{
						$str_file_extension=get_file_extension();
						
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) 
						{ 
							$str_err.="Logo must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
					$pic=$temp_pic;
				}
				
				if (strlen(trim($det))==0) 
				{
					$str_err.="Details cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if ($lu1==0) 
				{
					$str_err.="Choose a category to be listed under.<br>"; 
					$bln_err++;
				} 
				
/////////////////////////////////new code
				if (strlen(trim($dt))==0) 
				{
					$str_err.="Article date cannot be left blank.<br>"; 
					$bln_err++;
				}
/////////////////////////////////new code
				
				if(!$bln_err && $pic) 
				{
					$str_file_name=$HTTP_POST_FILES['pic']['name'];
					
					if(strlen(trim($str_file_name))>0) 
					{
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
						
						if (is_uploaded_file($str_temp)) 
						{
							$str_destination=CLASSIFIED_IMAGES_FOLDER.$str_new_file;
							
							if(move_uploaded_file($str_temp,$str_destination)) 
								$pic=$str_new_file;
							else 
							{
								$str_err.="Photograph upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if(!$bln_err && $logo) 
				{
					$str_file_name=$HTTP_POST_FILES['logo']['name'];
					
					if(strlen(trim($str_file_name))>0) 
					{
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['logo']['tmp_name'];
						
						if (is_uploaded_file($str_temp)) 
						{
							$str_destination=CLASSIFIED_IMAGES_FOLDER.$str_new_file;
							
							if(move_uploaded_file($str_temp,$str_destination)) 
								$logo=$str_new_file;
							else 
							{
								$str_err.="Logo upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if (!$bln_err) 
				{
					$str_sql="SELECT iCLID FROM classifiedarts WHERE iClartID=".$i;
					
					if ($rst=mysql_query($str_sql)) 
					{
						$adata=mysql_fetch_row($rst);
						mysql_free_result($rst);
					$sql_query="UPDATE classifiedcats SET iCount=iCount-1 WHERE iClID=".$adata[0];
						
						if(!mysql_query($sql_query,$dbc)) 
							echo mysql_error();
					}
					
					$str_sql="UPDATE classifiedarts SET vName='".parse_sql($fnm)."', iCLID=".$lu1.", bDetails='".parse_sql($det)."', dDate='".$dt."'";
													 
					if($pic) 
					{
						$str_sql.=", vPic='".parse_sql($pic)."'";
						unlink(CLASSIFIED_IMAGES_FOLDER.$pic1);
					}
					
					$str_sql.=" WHERE iClartID=$i";
					
					if (mysql_query($str_sql))  
					{
						$sql_query="UPDATE classifiedcats SET iCount=iCount+1 WHERE iCLID=".$lu1;
					
						if(!mysql_query($sql_query,$dbc)) 
							echo mysql_error();
						?><script>parent.l.document.location.reload(true);</script><?
						print_message ("Article has been updated.");
						break;						

					} 
					else 
						print_error(mysql_error());
				}	
			}
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT CLASSIFIED ARTICLE FORM
			case 3:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			$sql_query="SELECT iCLID, vName, iParentID FROM classifiedcats ORDER BY iParentID asc, vName";
			
				if($rst=mysql_query($sql_query,$dbc)) 
				{
					$l_cnt=0;
					while($adata=mysql_fetch_row($rst))
					{
						$acat[$l_cnt][0]=$adata[0]; //cat id
						$acat[$l_cnt][1]=$adata[1]; //name
						$acat[$l_cnt][2]=$adata[2]; //parent
						$l_cnt++;
					}
				} 
				else 
					echo mysql_error();
				
				$str_out="";	//global variable
				build_tree(0,0);

				// BUILDING OF THE ARRAYS -- END
				$str_sql="SELECT iClartID, vName, bDetails, vPic,  iCLID, dDate FROM  classifiedarts WHERE iClartID=".$i;
				if ($rst=mysql_query($str_sql)) 
				{
					$adata=mysql_fetch_row($rst);
					mysql_free_result($rst);
					$pic1=$adata[3];
					$adata[3]=CLASSIFIED_IMAGES_FOLDER.$adata[3];
					
				}
				
				if(strlen($str_err)>0) 
					$adata=array($i,$fnm,$det,$adata[3],$adata[4],$lu1, $adata[6]);
				?>
							<!-- 			new code -->
				<DIV id=popCal onclick=event.cancelBubble=true 
style="BORDER-BOTTOM: 2px ridge; BORDER-LEFT: 2px ridge; BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; POSITION: absolute; VISIBILITY: hidden; WIDTH: 10px; Z-INDEX: 100">
				<IFRAME frameBorder=0 height=188 name=popFrame scrolling=no src="./scripts/popcjs.htm" width=183></IFRAME></DIV>
				<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
							<!-- 			new code -->
					<table border=0 cellpadding=3 cellspacing=0 align=center>
	<form method=post enctype="multipart/form-data" action="<?php echo $me;?>" name="editlist">
						<input type=hidden name="m" value=71>
						<input type=hidden name="a" value=4>
						<input type=hidden name="i" value=<? echo $i; ?>>
						<input type=hidden name="pic1" value=<? echo $pic1; ?>>
						<tr>
      <Td colspan=2 class="formcaption">Edit Classified Articles</Td>
    </tr>
<?php
				if (strlen(trim($str_err))) 
					echo "<tr><Td valign=top align=center colspan=2>".print_error1($str_err)."</Td></tr>";
?>
						<tr><td>Name: </td>
								<td><input type=text name="fnm" maxlength=60 size="60" value="<?php echo format_str($adata[1]);?>"></td></tr>		
						
						<tr><td valign=top>Photograph: </td>
								<td><input type=file name="pic"><br>
						<? if($pic1) {
								?><img src="<?php echo format_str($adata[3]);?>"><?php
						  	 echo " <a target=\"r\" href=\"".$me."?m=71&a=8&p=1&i=".$i."\">Delete Image</a>"; 
							 } ?>
						</td></tr>
						<tr><td valign=top>Details: </td>
						<td><textarea name="det" cols=50 rows=15><?php echo format_str($adata[2]);?></textarea>
										</td></tr>
						<tr><td>List Under: </td>
								<td valign=top>
									<select name="lu1"><option value=0 selected>Choose ... </option><? print_dropdown($a_list_under,$adata[4])?></select></td></tr>
			<!-- 			new code -->
						<tr><td valign=top>Date: </td>
								<td valign=top> <input type=text name="dt" maxlength=10 size="10" value="<?php echo $adata[5];?>" readonly id="dt"><input name="reset" type="reset" class="box" onclick="return showCalendar('dt', '%Y-%m-%d ', '24', true);" value=" V "></td></tr>
			<!-- 			new code -->		
						<tr><td colspan=2 align=right><input type=submit name=profile value=Modify></td></tr>
						</form>
					</table>
				<?php			
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&	
				
				$psd=$cper=$str_err="";
				$bln_err=0;
				
				if (strlen(trim($fnm))==0) 
				{
					$str_err.="Article name cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if(check_duplicate_entry("classifiedarts", "vName", $fnm)) 
				{
					$str_err.="This Article name has already been taken. Please try another one. <br>"; 
					$bln_err++;
				}
				
				
				if($pic) 
				{
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) 
					{
						$str_err.="Image 2 Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) 
					{
						$str_file_extension=get_file_extension();
						
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) 
						{ 
							$str_err.="Image 2 must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if (strlen(trim($det))==0) 
				{
					$str_err.="Details cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if ($lu1==0) 
				{
					$str_err.="Choose a category to be listed under.<br>"; 
					$bln_err++;
				}

				if (strlen(trim($dt))==0) 
				{
					$str_err.="Article date cannot be left blank.<br>"; 
					$bln_err++;
				}

								
				if(!$bln_err && $pic) 
				{
					$str_file_name=$HTTP_POST_FILES['pic']['name'];
					
					if(strlen(trim($str_file_name))>0) 
					{
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
						
						if (is_uploaded_file($str_temp)) 
						{
							$str_destination=CLASSIFIED_IMAGES_FOLDER.$str_new_file;
							
							if(move_uploaded_file($str_temp,$str_destination)) 
								$pic=$str_new_file;
							else 
							{
								$str_err.="Image 2 upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if (!$bln_err) 
				{	
					$str_sql="INSERT INTO classifiedarts (vName, bDetails, vPic,  iCLID, dDate) VALUES ('".parse_sql($fnm)."','".parse_sql($det)."', '".parse_sql($pic)."',".$lu1.", '".$dt."')";
					
					if (mysql_query($str_sql)) 
					{
						$lng_insert_id=mysql_insert_id();
						$sql_query="UPDATE classifiedcats SET iCount=iCount+1 WHERE iCLID=".$lu1;
						
						if(!mysql_query($sql_query,$dbc)) 
							echo mysql_error();
						else 
						{
							?><script>parent.l.document.location.reload(true);</script><?
							print_message ("Article has been added.");
							break;
							$a=1;
						}
					} 
					else 
						print_error(mysql_error());
				}
				else
					$a=1;
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW CLASSIFIEDS ARTICLE
			case 1:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			if($a==1) 
			{
				// REGISTERING A CLASSIFIEDS ARTICLE
				$sql_query="SELECT iCLID, vName, iParentID FROM classifiedcats ORDER BY iParentID asc, vName";
				if($rst=mysql_query($sql_query,$dbc)) 
				{
					$l_cnt=0;
					
					while($adata=mysql_fetch_row($rst))
					{
						$acat[$l_cnt][0]=$adata[0]; 
						$acat[$l_cnt][1]=$adata[1]; 
						$acat[$l_cnt][2]=$adata[2]; 
						$l_cnt++;
					}
				} 
				else 
					echo mysql_error();

				$str_out="";	//global variable
				build_tree(0,0);
				?>
				<DIV id=popCal onclick=event.cancelBubble=true 
style="BORDER-BOTTOM: 2px ridge; BORDER-LEFT: 2px ridge; BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; POSITION: absolute; VISIBILITY: hidden; WIDTH: 10px; Z-INDEX: 100">
				<IFRAME frameBorder=0 height=188 name=popFrame scrolling=no src="./scripts/popcjs.htm" width=183></IFRAME></DIV>
				<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
					<table border=0 align=center>
						<form method=post enctype="multipart/form-data" action="<?php echo $me;?>" name="editlist">
						<input type=hidden name="m" value=71>
						<input type=hidden name="a" value=2>
						<tr><Td colspan=2 class="formcaption">Add Classified Articles</Td></tr>
<?php
				if (strlen(trim($str_err)))
					echo "<tr><Td valign=top align=center colspan=2>".print_error1($str_err)."</Td></tr>";
?>
						<tr><td>Name: </td>
								<td><input type=text name="fnm" maxlength=60 size="60" value="<?php echo format_str($fnm);?>"></td></tr>		
						
						<tr><td>Image 2: </td>
								<td><input type=file name="pic" maxlength=60 value="<?php echo format_str($pic);?>"></td></tr>
						<tr><td valign=top>Details: </td>
			<td><textarea name="det" cols=50 rows=15><?php echo format_str($det);?></textarea>
						</td></tr>
						<tr><td>List Under: </td>
								<td valign=top>
									<select name="lu1"><option value=0 selected>Choose ... </option><? print_dropdown($a_list_under,$lu1)?></select>									
								</td></tr>
						<tr><td valign=top>Date: </td>
								<td valign=top> <input type=text name="dt" maxlength=10 size="10" value="<?php echo $adata[5];?>" readonly id="dt"><input name="reset" type="reset" class="box" onclick="return showCalendar('dt', '%Y-%m-%d ', '24', true);" value=" V "></td></tr>
						<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
						</form>
					</table>
				<?php
				break;
			}
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//LIST CLASSIFIEDS ARTICLES
			default:  // CASE A,M=21
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				?><a href="x_panel.php?m=71">List Classifieds Articles</a> |  
					<a target=r href="<?php echo $me;?>?m=71&a=1">Add</a><hr><?

				if (!isset($s)) {$s=0;}
				$str_sql="SELECT iClartID, vName, bDetails, vPic,  iCLID FROM classifiedarts ORDER BY vName ";
				if ($s<1) 
					$s=1;
					
				$lcnt = 1;
				if ($rst=mysql_query($str_sql)) 
				{
					if($r=mysql_num_rows($rst)) 
					{
						while($adata=mysql_fetch_row($rst))  
						{
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) 
								echo "<li><a target=r href=\"$me?m=71&a=3&i=$adata[0]\">".format_str($adata[1])."</a> | <a target=r href=\"$me?m=71&a=5&i=$adata[0]\">Del</a>";

							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT))
								break;
								
							$lcnt++;	
						} 
						echo "<hr>";
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1)
							echo "| <a href=$me?m=71&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";

						if ($lcnt<=mysql_num_rows($rst))
							echo "| <a href=$me?m=71&s=$lcnt>Next</a> ";
					} 
					else 
						print_error("There are no records currently.");
				} 
				else
					print_error ("Error: ".mysql_error());
			} //END OF CASE 71
			break;
//////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////
	##################################################
	// GENERAL DATABASE ARTICLES
	case 9:  // CASE M
	##################################################
		if (!isset($a)) {$a=0;}	
		switch ($a) {
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//EDITING A GENERAL DATABASE ARTICLE ?
			case 10:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			echo "done";
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE GENERAL DATABASE ARTICLE IMAGES
			case 9:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
					// DELETION OF ARTICLE IMAGES
					if ($p==1) { 
						$sql=" gd_article_photo ";
					} elseif ($p==2) {
						$sql=" gd_article_logo ";
					}	
					
					$str_sql="SELECT $sql FROM general_database_articles WHERE gd_article_id=$f";
					if($rst=mysql_query($str_sql)) {
						$adata=mysql_fetch_row($rst);
						if($adata[0]) {
							unlink(IMAGES_FOLDER.$adata[0]);
						}
					} else {
						echo mysql_error($rst);
					}
					
					$str_sql="UPDATE general_database_articles SET $sql='' WHERE gd_article_id=$f";
					if($rst=mysql_query($str_sql)) {
						print_message("The Image has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} else {
						echo mysql_error($rst);
					}
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE GENERAL DATABASE ARTICLE QUESTION?
			case 8:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				echo "<center><b>Do you really want to delete the Image?</b><br>
							<a href=\"".$me."?m=9&a=9&p=$p&f=$i\">YES</a> / <a href=\"".$me."?m=9&a=7\">NO</a></center>";
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE GENERAL DATABASE ARTICLE
			case 6:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				$bln_err=0;
				$str_err="";
				$str_sql="SELECT gd_article_photo, gd_article_logo, cat_gd_id FROM general_database_articles WHERE gd_article_id=$f";
				if($rst=mysql_query($str_sql)) {
					$adata=mysql_fetch_row($rst);
					if($adata[0]) {
						if(!unlink(IMAGES_FOLDER.$adata[0])) {
							$bln_err++;
							$str_err.="Main image $adata[0] deletion error<br>";
						}
					}					
					if($adata[1]) {
						if(!unlink(IMAGES_FOLDER.$adata[1])) {
							$bln_err++;
							$str_err.="Main image $adata[1] deletion error<br>";
						}
					}
					
					$sql_query="UPDATE cat_general_database SET cat_gd_count=cat_gd_count-1 WHERE cat_gd_id=".$adata[2];
					if(!mysql_query($sql_query,$dbc)) {
						echo mysql_error();
					}
					
				} else {
					echo mysql_error($rst);
				}
				
				if(!$bln_err) {
					$str_sql="DELETE FROM general_database_articles WHERE gd_article_id=$f";
					if($rst=mysql_query($str_sql)) {
						print_message("The Gen. Dat. Article has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} else {
						echo mysql_error($rst);
					}
				} else {
					print_error(" $bln_err File deletion errors <br>$str_err");
				}
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE GENERAL DATABASE ARTICLE QUESTION?
			case 5:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				echo "<center><b>Do you really want to delete the Gen. Dat. Article?</b><br>
							<a href=\"".$me."?m=9&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=9&a=7\">NO</a></center>";
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND MODIFYING THE GENERAL DATABASE ARTICLE
			case 4:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			if($a==4) {
				$str_err=$cper="";
				$bln_err=0;
				
				if (strlen(trim($fnm))==0) {
					$str_err.="First name cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if($pic) {
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
						$str_err.="Photograph Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) {
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Photograph must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if($logo) {
					$temp_pic=$pic;
					$pic=$logo;
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_LOGO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
						$str_err.="Logo Uploaded is too Large.<br>"; 
						$bln_err++;
					}
				
					if(strlen(trim($str_picture))>0) {
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Logo must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
					$pic=$temp_pic;
				}
				
				if (strlen(trim($det))==0) {
					$str_err.="Details cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if ($lu1==0) {
					$str_err.="Choose a category to be listed under.<br>"; 
					$bln_err++;
				} 
				
/////////////////////////////////new code
				if (strlen(trim($dt))==0) {
					$str_err.="Article date cannot be left blank.<br>"; 
					$bln_err++;
				}
/////////////////////////////////new code
				
				if(!$bln_err && $pic) {
					$str_file_name=$HTTP_POST_FILES['pic']['name'];
					if(strlen(trim($str_file_name))>0) {
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
						if (is_uploaded_file($str_temp)) {
							$str_destination=IMAGES_FOLDER.$str_new_file;
							if(move_uploaded_file($str_temp,$str_destination)) {
								$pic=$str_new_file;
							} else {
								$str_err.="Photograph upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if(!$bln_err && $logo) {
					$str_file_name=$HTTP_POST_FILES['logo']['name'];
					if(strlen(trim($str_file_name))>0) {
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['logo']['tmp_name'];
						if (is_uploaded_file($str_temp)) {
							$str_destination=IMAGES_FOLDER.$str_new_file;
							if(move_uploaded_file($str_temp,$str_destination)) {
								$logo=$str_new_file;
							} else {
								$str_err.="Logo upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if (!$bln_err) {
					$str_sql="SELECT cat_gd_id
										FROM  general_database_articles 
										WHERE gd_article_id=".$i;
					if ($rst=mysql_query($str_sql)) {
						$adata=mysql_fetch_row($rst);
						mysql_free_result($rst);
						$sql_query="UPDATE cat_general_database SET cat_gd_count=cat_gd_count-1 WHERE cat_gd_id=".$adata[0];
						if(!mysql_query($sql_query,$dbc)) {
							echo mysql_error();
						}
					}
					
					$str_sql="UPDATE general_database_articles SET gd_article_name='".parse_sql($fnm)."', 
													 cat_gd_id=".$lu1.", 
													 gd_article_details='".parse_sql($det)."',
													 gd_article_date='".$dt."'";
													 
					if($pic) {
						$str_sql.=", gd_article_photo='".parse_sql($pic)."'";
						unlink(IMAGES_FOLDER.$pic1);
					}
					if($logo) {
						$str_sql.=", gd_article_logo='".parse_sql($logo)."'";
						unlink(IMAGES_FOLDER.$logo1);
					}
					$str_sql.=" WHERE gd_article_id=$i";
					
					if (mysql_query($str_sql))  {
						$sql_query="UPDATE cat_general_database SET cat_gd_count=cat_gd_count+1 WHERE cat_gd_id=".$lu1;
						if(!mysql_query($sql_query,$dbc)) {
							echo mysql_error();
						}
						?><script>parent.l.document.location.reload(true);</script><?
						print_message ("Article has been updated.");
						break;						
					} else print_error(mysql_error());
				}	
			}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT GENERAL DATABASE ARTICLE FORM
			case 3:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
			
				$sql_query="SELECT cat_gd_id, cat_gd_name, cat_gd_parent_id 
										FROM cat_general_database 
										ORDER BY cat_gd_parent_id asc, cat_gd_name";
				if($rst=mysql_query($sql_query,$dbc)) {
					$l_cnt=0;
					while($adata=mysql_fetch_row($rst)){
						$acat[$l_cnt][0]=$adata[0]; //cat id
						$acat[$l_cnt][1]=$adata[1]; //name
						$acat[$l_cnt][2]=$adata[2]; //parent
						$l_cnt++;
					}
				} else echo mysql_error();
				
				$str_out="";	//global variable
				build_tree(0,0);

				// BUILDING OF THE ARRAYS -- END
				$str_sql="SELECT gd_article_id, gd_article_name, gd_article_details, 
												 gd_article_photo, gd_article_logo, cat_gd_id, 
												 gd_article_date
									FROM  general_database_articles 
									WHERE gd_article_id=".$i;
				if ($rst=mysql_query($str_sql)) {
					$adata=mysql_fetch_row($rst);
					mysql_free_result($rst);
					$pic1=$adata[3];
					$logo1=$adata[4];
					$adata[3]=IMAGES_FOLDER.$adata[3];
					$adata[4]=IMAGES_FOLDER.$adata[4];
				}
				
				if(strlen($str_err)>0) {
					$adata=array($i,$fnm,$det,$adata[3],$adata[4],$lu1, $adata[6]);
				}
				
				?>
							<!-- 			new code -->
				<DIV id=popCal onclick=event.cancelBubble=true 
style="BORDER-BOTTOM: 2px ridge; BORDER-LEFT: 2px ridge; BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; POSITION: absolute; VISIBILITY: hidden; WIDTH: 10px; Z-INDEX: 100">
				<IFRAME frameBorder=0 height=188 name=popFrame scrolling=no src="./scripts/popcjs.htm" width=183></IFRAME></DIV>
				<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
							<!-- 			new code -->
					<table border=0 cellpadding=3 cellspacing=0 align=center>
						<form method=post enctype="multipart/form-data" action="<?php echo $me;?>">
						<input type=hidden name="m" value=9>
						<input type=hidden name="a" value=4>
						<input type=hidden name="i" value=<? echo $i; ?>>
						<input type=hidden name="logo1" value=<? echo $logo1; ?>>
						<input type=hidden name="pic1" value=<? echo $pic1; ?>>
						<tr><Td colspan=2 class="formcaption">Edit General Articles</Td></tr>
<?php
				if (strlen(trim($str_err))) {
					echo "<tr><Td valign=top align=center colspan=2>".print_error1($str_err)."</Td></tr>";
				}
?>
						<tr><td>Name: </td>
								<td><input type=text name="fnm" maxlength=60 size="60" value="<?php echo format_str($adata[1]);?>"></td></tr>		
						<tr><td valign=top>Logo: </td>
								<td><input type=file name="logo"><br>
						<? if($logo1) {
								?><img src="<?php echo format_str($adata[4]);?>"><?php
						  	 echo " <a target=\"r\" href=\"".$me."?m=9&a=8&p=2&i=".$i."\">Delete Image</a>"; 
					  	 } ?>
						</td></tr>
						<tr><td valign=top>Photograph: </td>
								<td><input type=file name="pic"><br>
						<? if($pic1) {
								?><img src="<?php echo format_str($adata[3]);?>"><?php
						  	 echo " <a target=\"r\" href=\"".$me."?m=9&a=8&p=1&i=".$i."\">Delete Image</a>"; 
							 } ?>
						</td></tr>
						<tr><td valign=top>Details: </td>
								<td><textarea name="det" cols=50 rows=15><?php echo format_str($adata[2]);?></textarea>
									<script language="javascript1.2">editor_generate('det');</script></td></tr>
						<tr><td>List Under: </td>
								<td valign=top>
									<select name="lu1"><option value=0 selected>Choose ... </option><? print_dropdown($a_list_under,$adata[5])?></select></td></tr>
			<!-- 			new code -->
						<tr><td valign=top>Date: </td>
								<td valign=top> <input type=text name="dt" maxlength=10 size="10" value="<?php echo $adata[6];?>" readonly id="dt"><input name="reset" type="reset" class="box" onclick="return showCalendar('dt', '%Y-%m-%d ', '24', true);" value=" V "></td></tr>
			<!-- 			new code -->		
						<tr><td colspan=2 align=right><input type=submit name=profile value=Modify></td></tr>
						</form>
					</table>
				<?php			
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&	
				
				$psd=$cper=$str_err="";
				$bln_err=0;
				
				if (strlen(trim($fnm))==0) {
					$str_err.="Article name cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if(check_duplicate_entry("general_database_articles", "gd_article_name", $fnm)) {
					$str_err.="This Article name has already been taken. Please try another one. <br>"; 
					$bln_err++;
				}
				
				if($logo) {
					$str_picture=$HTTP_POST_FILES['logo']['name'];
					$lng_file_size=fn_check_file_size(MAX_LOGO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
						$str_err.="Image 1 Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) {
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Image 1 must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if($pic) {
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
						$str_err.="Image 2 Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) {
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Image 2 must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if (strlen(trim($det))==0) {
					$str_err.="Details cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if ($lu1==0) {
					$str_err.="Choose a category to be listed under.<br>"; 
					$bln_err++;
				}
/////////////////////////////////new code
				if (strlen(trim($dt))==0) {
					$str_err.="Article date cannot be left blank.<br>"; 
					$bln_err++;
				}
/////////////////////////////////new code

				if(!$bln_err && $logo) {
					$str_file_name=$HTTP_POST_FILES['logo']['name'];
					if(strlen(trim($str_file_name))>0) {
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['logo']['tmp_name'];
						if (is_uploaded_file($str_temp)) {
							$str_destination=IMAGES_FOLDER.$str_new_file;
							if(move_uploaded_file($str_temp,$str_destination)) {
								$logo=$str_new_file;
							} else {
								$str_err.="Image 1 upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if(!$bln_err && $pic) {
					$str_file_name=$HTTP_POST_FILES['pic']['name'];
					if(strlen(trim($str_file_name))>0) {
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
						if (is_uploaded_file($str_temp)) {
							$str_destination=IMAGES_FOLDER.$str_new_file;
							if(move_uploaded_file($str_temp,$str_destination)) {
								$pic=$str_new_file;
							} else {
								$str_err.="Image 2 upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if (!$bln_err) {	
					$str_sql="INSERT INTO general_database_articles (gd_article_name, gd_article_details, 
												 gd_article_photo, gd_article_logo, cat_gd_id, gd_article_date)
										VALUES ('".parse_sql($fnm)."','".parse_sql($det)."',
												 '".parse_sql($pic)."','".parse_sql($logo)."',".$lu1.", '".$dt."')";
					
					if (mysql_query($str_sql)) {
						$lng_insert_id=mysql_insert_id();
						$sql_query="UPDATE cat_general_database 
												SET cat_gd_count=cat_gd_count+1 
												WHERE cat_gd_id=".$lu1;
						if(!mysql_query($sql_query,$dbc)) {
							echo mysql_error();
						}	else {
							?><script>parent.l.document.location.reload(true);</script><?
							print_message ("Article has been added.");
							break;
							$a=1;
						}
					} else print_error(mysql_error());
				}else{
					$a=1;
				}				
		
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW GENERAL DATABASE ARTICLE
			case 1:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			if($a==1) {
				
				// REGISTERING A GENERAL DATABASE ARTICLE
				$sql_query="SELECT cat_gd_id, cat_gd_name, cat_gd_parent_id 
										FROM cat_general_database 
										ORDER BY cat_gd_parent_id asc, cat_gd_name";
				if($rst=mysql_query($sql_query,$dbc)) {
					$l_cnt=0;
					while($adata=mysql_fetch_row($rst)){
						$acat[$l_cnt][0]=$adata[0]; 
						$acat[$l_cnt][1]=$adata[1]; 
						$acat[$l_cnt][2]=$adata[2]; 
						$l_cnt++;
					}
				} else echo mysql_error();
				$str_out="";	//global variable
				build_tree(0,0);
				
				?>
							<!-- 			new code -->
				<DIV id=popCal onclick=event.cancelBubble=true 
style="BORDER-BOTTOM: 2px ridge; BORDER-LEFT: 2px ridge; BORDER-RIGHT: 2px ridge; BORDER-TOP: 2px ridge; POSITION: absolute; VISIBILITY: hidden; WIDTH: 10px; Z-INDEX: 100">
				<IFRAME frameBorder=0 height=188 name=popFrame scrolling=no src="./scripts/popcjs.htm" width='183'></IFRAME></DIV>
				<SCRIPT event=onclick() for=document>popCal.style.visibility = "hidden";</SCRIPT>
							<!-- 			new code -->
					<table border=0 align=center>
						<form method=post enctype="multipart/form-data" action="<?php echo $me;?>">
						<input type=hidden name="m" value=9>
						<input type=hidden name="a" value=2>
						<tr><Td colspan=2 class="formcaption">Add General Articles</Td></tr>
<?php
				if (strlen(trim($str_err))) {
					echo "<tr><Td valign=top align=center colspan=2>".print_error1($str_err)."</Td></tr>";
				}
?>
						<tr><td>Name: </td>
								<td><input type=text name="fnm" maxlength=60 size="60" value="<?php echo format_str($fnm);?>"></td></tr>		
						<tr><td>Image 1: </td>
								<td><input type=file name="logo" maxlength=60 value="<?php echo format_str($logo);?>"></td></tr>
						<tr><td>Image 2: </td>
								<td><input type=file name="pic" maxlength=60 value="<?php echo format_str($pic);?>"></td></tr>
						<tr><td valign=top>Details: </td>
				<td><textarea name="det" cols=50 rows=15><?php echo format_str($det);?></textarea>
							<script language="javascript1.2">editor_generate('det');</script></td></tr>
						<tr><td>List Under: </td>
								<td valign=top>
									<select name="lu1"><option value=0 selected>Choose ... </option><?print_dropdown($a_list_under,$lu1)?></select>									
								</td></tr>
			<!-- 			new code -->
						<tr><td valign=top>Date: </td>
								<td valign=top> <input type=text name="dt" maxlength=10 size="10" value="<?php echo $adata[6];?>" readonly id="dt"><input name="reset" type="reset" class="box" onclick="return showCalendar('dt', '%Y-%m-%d ', '24', true);" value=" V "></td></tr>
			<!-- 			new code -->

						<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
						</form>
					</table>
				<?php
				break;
			}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//LIST GENERAL DATABASE ARTICLES
			default:  // CASE A,M=9
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				?><a href="x_panel.php?m=9">List General Articles</a> |  
					<a target=r href="<?php echo $me;?>?m=9&a=1">Add</a><hr><?

				if (!isset($s)) {$s=0;}
				$str_sql="SELECT gd_article_id, gd_article_name, gd_article_details, 
												 gd_article_photo, gd_article_logo, cat_gd_id
									FROM general_database_articles
									ORDER BY gd_article_date desc ";
				if ($s<1) $s=1;
				$lcnt = 1;
				if ($rst=mysql_query($str_sql)) {
					if($r=mysql_num_rows($rst)) {
						while($adata=mysql_fetch_row($rst))  {
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) {
								echo "<li><a target=r href=\"$me?m=9&a=3&i=$adata[0]\">".format_str($adata[1])."</a> | <a target=r href=\"$me?m=9&a=5&i=$adata[0]\">Del</a>";
							} 
							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT)) {break;}
							$lcnt++;	
						} 
						echo "<hr>";
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1) { 
							echo "| <a href=$me?m=9&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";
						}
						if ($lcnt<=mysql_num_rows($rst)) { 
							echo "| <a href=$me?m=9&s=$lcnt>Next</a> ";
						}
					} else {
						print_error("There are no records currently.");
					}
				} else {
					print_error ("Error: ".mysql_error());
				}
			} //END OF CASE 9
			break;	
		
	##################################################
	#	BANNER MANAGEMENT
	case 8:
	##################################################	
		include_once("x_banner.php");
	
	break;
	##################################################
	// LOCATIONS
	case 7:  // CASE M
	##################################################
		if (!isset($a)) {$a=0;}	
		switch ($a) {
		
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE LOCATION
			case 6:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				$str_sql="DELETE FROM locations WHERE location_id=$f";
				if($rst=mysql_query($str_sql)) {
					print_message("The Location has been deleted");
					?><script>parent.l.document.location.reload(true);</script><?
				} else {
					echo mysql_error($rst);
				}
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE LOCATION QUESTION?
			case 5:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				echo "<center><b>Do you really want to delete the Location?</b><br>
							<a href=\"".$me."?m=7&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=7&a=7\">NO</a></center>";
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND UPDATE THE DATABASE
			case 4:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($loc))==0) {
					$str_err.="Location name cannot be left blank.<br>";					
				} elseif(check_duplicate_entry("locations", "location_name", $loc)) {
					$str_err.="The Location already exists.<br>";
				} else {
					// IF NO ERRORS
					$str_sql="UPDATE locations SET location_name='".parse_sql($loc)."' 
										WHERE location_id=$i";
					if (mysql_query($str_sql)) {
						echo"<center><b>The Location has been Modified.</b></center>";  
					?><script>parent.l.document.location.reload(true);</script><?
						break;
					} else print_error(mysql_error());
				}
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT LOCATION FORM
			case 3:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			$str_sql="SELECT location_name 
								FROM locations 
								WHERE location_id=".$i."  
								ORDER BY location_name";
			if ($rst=mysql_query($str_sql)) {
				$adata=mysql_fetch_row($rst);
				$loc=$adata[0];
				mysql_free_result($rst);
			}	
				
				?><table border=0 align=center>
						<form method=post enctype="multipart/form-data" action="<?php echo $me;?>">
						<input type=hidden name="m" value=7>
						<input type=hidden name="a" value=4>
						<input type=hidden name="i" value=<? echo $i; ?>>
						<tr><td colspan=2 class="formcaption">Edit Location</td></tr>
<?								
					if (strlen(trim($str_err))) {
						echo "<tr><td colspan=2 align=center>".print_error1($str_err)."</td></tr>";
					} 
?>
						<tr><td>Location</td>
								<td><input type=text name="loc" maxlength=60 value="<?php echo format_str($loc);?>"></td></tr>
						<tr><td colspan=2 align=right><input type=submit value="Edit"></td></tr>
						</form>
					</table>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&	
				
				$bln_err=0;
				$str_err="";
				
				if (strlen(trim($loc))==0) {
					$str_err.="Location name cannot be left blank.<br>";
				} elseif(check_duplicate_entry("locations", "location_name", $loc)) { 
					$str_err.="The Location has already been entered.<br>";				
				} else {
					// IF NO ERRORS
					$str_sql="INSERT INTO locations (location_name)
										VALUES ('".parse_sql($loc)."')";
					if (mysql_query($str_sql))  {
						print_message("The location has been entered.");
						?><script>parent.l.document.location.reload(true);</script><?
						break;
					} else print_error(mysql_error());
				}	
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW LOCATION
			case 1:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				?><table align=center border=0>
						<form method=post enctype="multipart/form-data" action="<?php echo $me;?>">
						<input type=hidden name="m" value=7>
						<input type=hidden name="a" value=2>
						<tr><td colspan=2 class="formcaption"><? echo $str_type; ?> Add Location</td></tr>
<?php
				if (strlen(trim($str_err))) {
					echo "<tr><Td valign=top align=center colspan=2>".print_error1($str_err)."</Td></tr>";
				}
?>
						<tr><td>Location</td>
								<td><input type=text name="loc" maxlength=60 value="<?php echo format_str($loc);?>"></td></tr>
						<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
						</form>
					</table></center>
				<?php
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE LISTINGS
			default:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				?><a href="x_panel.php?m=7">List Locations</a> |
					<a target=r href="<?php echo $me;?>?m=7&p=<?php echo $p;?>&a=1">Add</a><hr><?php
				
				if (!isset($s)) {$s=0;}
				$str_sql="SELECT location_id, location_name
									FROM locations 
									WHERE location_id ";
				$str_sql.=(!$p) ? " >0 " : " =$p ";
				$str_sql.=" ORDER BY location_name";
				if ($s<1) $s=1;
				$lcnt = 1;
				if ($rst=mysql_query($str_sql)) {
					if($r=mysql_num_rows($rst)) {
						while($adata=mysql_fetch_row($rst))  {
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) {
								echo "<li><a target=r href=\"$me?m=7&a=3&i=$adata[0]\">".format_str($adata[1])."</a> 
											 | <a target=r href=\"$me?m=7&a=5&i=$adata[0]\">Del</a>";
							}
							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT)) {break;}
							$lcnt++;	
						} 
						echo "<hr>";
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1) { 
							echo "| <a href=$me?m=7&p=$p&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";
						}
						if ($lcnt<=mysql_num_rows($rst)) { 
							echo "| <a href=$me?m=7&p=$p&s=$lcnt>Next</a> ";
						}
					} else {
						print_error("There are no records currently.");
					}
				} else {
					print_error ("Error: ".mysql_error());
				}	
		}	// END OF CASE 7 SWITCH
			
	break;
	
	##################################################
	// SEND MAIL
	case 6:  // CASE M
	##################################################	
	
		$bln_err=0;
		$str_err="";
		
		if (strlen(trim($commail))==0) {
			$str_err="Your message is empty";			
		} else {
			$headers .= "From: $to \n\r";
			$str_sql="SELECT DISTINCT listing_email
								FROM listings";	
			if($rst=mysql_query($str_sql)) {
				while($adata=mysql_fetch_row($rst)) {
					if(!mail($adata[0],$subject,$commail,$headers)) {
						$bln_err=1;						
					}
				}
			} else {
				echo mysql_error();
			}			
			if(!$bln_err) {
				print_message("The Mails have been sent.");
			}
			break;
		}
		
	##################################################
	// COMPOSE MAIL
	case 5:  // CASE M
	##################################################
	
		echo "<table align=center border=0>
						<form method=post action=".$me." enctype=\"multipart/form-data\">
						<input type=hidden name=\"m\" value=6>
						<tr><td align=center class=\"formcaption\">Mail to all Listed</td></tr>";
		if (strlen(trim($str_err))) {
			echo "<tr><Td valign=top align=center colspan=2>".print_error1($str_err)."</Td></tr>";
		}
		echo "	<tr><td>Subject:</td></tr>
						<tr><td><input type=text name=\"subject\" maxlength=160 size=50 value=".format_str($subject)."></td></tr>
						<tr><td>Mail:</td></tr>
						<tr><td><textarea name=\"commail\" cols=50 rows=20>".format_str($commail)."</textarea></td></tr>
						<tr><td align=right><input type=submit value=\"Send\"></td></tr>
					</table>";
		break;
		
	##################################################
	// General Database ARTICLES
	case 4:  // CASE M
	##################################################
		if (!isset($a)) {$a=0;}	
		switch ($a) {
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=4
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE PROFESSIONAL 
			case 6:  // CASE A,M=4
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				$str_sql="DELETE FROM cat_services WHERE cat_service_id=$f";
				if($rst=mysql_query($str_sql)) {
					print_message("The Category has been deleted");
					?><script>parent.l.document.location.reload(true);</script><?
				} else {
					echo mysql_error($rst);
				}
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE PROFESSIONAL QUESTION?
			case 5:  // CASE A,M=4
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				$lng_flag=0;
				$str_sql="SELECT listing_id 
									FROM listings 
									WHERE listing_type=1
									AND (listing_cat1='$i' OR listing_cat2='$i' OR listing_cat3='$i')";	
									
				if($rst=mysql_query($str_sql)) {
					if(mysql_num_rows($rst)>0) {
						print_error("The Category is in use and hence cannot be deleted");
					} else {
						$lng_flag++;
					}
				}
				
				$str_sql="SELECT cat_service_id 
									FROM cat_services 
									WHERE cat_service_parent_id='$i'";	
									
				if($rst=mysql_query($str_sql)) {
					if(mysql_num_rows($rst)>0) {
						print_error("The Professional Category is a parent to one or more Categories. Kindly delete them first.");
					} else {
						$lng_flag++;
					}
				}
				
				if($lng_flag==2) {
					echo "<center><b>Do you really want to delete the Category?</b><br>
								<a href=\"".$me."?m=4&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=4&a=7\">NO</a></center>";
				}
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND UPDATE THE DATABASE
			case 4:  // CASE A,M=4
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0){
					$str_err.="Category name cannot be left blank.<br>";
					$bln_err++;
				}elseif (fn_checkcategory($cat,$par, $i)>0) {
					$str_err.="This Category has already been entered.<br>";
					$bln_err++;
				}

				if (!$bln_err) {
					if(!$par)	$par=0;
					$str_sql="UPDATE cat_services SET
										cat_service_name='".parse_sql($cat)."', 
										cat_service_parent_id=$par WHERE cat_service_id=$i";
					if (mysql_query($str_sql)) {
						echo "<br><b>Professional has been updated.</b>";
						?><script>parent.l.document.location.reload(true);</script><?
					}else{
						print_error("Error: ".mysql_error());
					}
					break;
				}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT CATEGORY FORM
			case 3:  // CASE A,M=4
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				if ($a==3) {
					$str_sql="SELECT cat_service_name, cat_service_parent_id 
										FROM cat_services WHERE cat_service_id=$i";
					
					if ($rst=mysql_query($str_sql)) {
						$adata=mysql_fetch_row($rst);
						$cat=$adata[0];
						$par=$adata[1];
					}
					mysql_free_result($rst);
				}
					
				if (strlen(trim($str_err))) {
					print_error($str_err);
				}
				if(!isset($p)) $p=0;
				?><center>
					<table border=0>
						<form method=post action="<?php echo $me;?>" enctype="multipart/form-data">
						<input type=hidden name="m" value=4>
						<input type=hidden name="a" value=4>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<input type=hidden name="i" value=<?php echo $i;?>>
						<input type=hidden name=par value=<?php echo $par;?>>
						<tr><Td align=center colspan=2><b>Edit Professional Category</b></td></tr>
						<tr><td>Category</td>
								<td><input type=text name="cat" maxlength=60 value="
													<?php echo format_str($cat);?>"></td></tr>
						<tr><td align=center colspan=2><input type=submit value="Update"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=4
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&	
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0){
					$str_err.="Professional Category name cannot be left blank.<br>";
					$bln_err++;
				} elseif (fn_checkcategory($cat,$p)>0) {
					$str_err.="This Category has already been entered.<br>";
					$bln_err++;
				}					
				
				if (!$bln_err) {
					if(!$p) $p=0;
					$str_sql="INSERT INTO cat_services
										(cat_service_name, cat_service_parent_id)
										VALUES ('".parse_sql($cat)."', $p)";
					
					if (mysql_query($str_sql)) {
						echo "<br><b>Professional has been inserted.</b>";
						?><script>parent.l.document.location.reload(true);</script><?
					} else {
						print_error("Error: ".mysql_error());
					}
					break;
				}
	
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW CATEGORIES
			case 1:  // CASE A,M=4
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				if (strlen(trim($str_err))) {
					print_error($str_err);
				}
				if(!isset($cat)) $cat="";
				?><center>
					<table border=0>
						<form method=post action="<?php echo $me;?>" enctype="multipart/form-data">
						<input type=hidden name="m" value=4>
						<input type=hidden name="a" value=2>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<tr><Td colspan=2 align=center><b>Add Professional Category</b></td></tr>
						<tr><td>Category</td>
								<td><input type=text name="cat" maxlength=60 value="
										<?php echo format_str($cat);?>"></td></tr>
						<tr><td colspan=2 align=center><input type=submit value="Add"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE CATGORIES LIST
			default:  // CASE A,M=4
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				if (!isset($p)) {$p=0;}
				?><a target=r href="<?php echo $me;?>?m=4&p=<?php echo $p;?>&a=1">Add a Professional Category</a><hr><?php
				fn_showparentname($p,"service");
				if (!isset($s)) {$s=0;}
				$str_sql="SELECT cat_service_id, cat_service_name 
									FROM cat_services 
									WHERE cat_service_parent_id=$p";
				$rst=mysql_query($str_sql);
				if ($s<1) $s=1;
				$lcnt = 1;
				if ($rst) {
					if($r=mysql_num_rows($rst)) {
						while($adata=mysql_fetch_row($rst))  {
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) {
								echo "<li><a href=\"$me?m=4&p=$adata[0]\">".format_str($adata[1])."</a> | 
													<a target=r href=\"$me?m=4&a=3&i=$adata[0]\">Mod</a> |
													<a target=r href=\"$me?m=4&a=5&i=$adata[0]\">Del</a>";
							} 	
							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT)) {break;}
							$lcnt++;	
						}
						echo "<hr>";
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1) { 
							echo "| <a href=$me?m=4&p=$p&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";
						}
						if ($lcnt<=mysql_num_rows($rst)) {
							echo "| <a href=$me?m=4&p=$p&s=$lcnt>Next</a> ";
						}
					} else {
						print_error("There are no records currently.");
					}
				} else {
					print_error ("Error: ".mysql_error());
				}	
			}
	
		break;
		//END OF THE MANAGE CATEGORIES BLOCK	
	
	##################################################
	// COMPANIES CATEGORIES
	case 3:  // CASE M
	##################################################
		if (!isset($a)) {$a=0;}	
		switch ($a) {
		
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=3
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE COMPANY
			case 6:  // CASE A,M=3
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				$str_sql="DELETE FROM cat_products WHERE cat_product_id=$f";
				
				if(CheckIfCatIDPresent("COMP",$f))
				InsertOrUpdateOrDeleteCatID("","COMP",$f,"DELETE");
				
				if($rst=mysql_query($str_sql)) {
					print_message("The Category has been deleted");
					?><script>parent.l.document.location.reload(true);</script><?
				} else {
					echo mysql_error($rst);
				}
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE COMPANY QUESTION?
			case 5:  // CASE A,M=3
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				$lng_flag=0;
				$str_sql="SELECT listing_id 
									FROM listings 
									WHERE listing_type=2
									AND (listing_cat1='$i' OR listing_cat2='$i' OR listing_cat3='$i')";	
									
				if($rst=mysql_query($str_sql)) {
					if(mysql_num_rows($rst)>0) {
						print_error("The Category is in use and hence cannot be deleted");
					} else {
						$lng_flag++;
					}
				}
				
				$str_sql="SELECT cat_product_id 
									FROM cat_products 
									WHERE cat_product_linked_id='$i'";	
									
				if($rst=mysql_query($str_sql)) {
					if(mysql_num_rows($rst)>0) {
						print_error("The Company Category is a parent to one or more Categories. Kindly delete them first.");
					} else {
						$lng_flag++;
					}
				}
				
				if($lng_flag==2) {
					echo "<center><b>Do you really want to delete the Category?</b><br>
								<a href=\"".$me."?m=3&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=3&a=7\">NO</a></center>";
				}
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND UPDATE THE DATABASE
			case 4:  // CASE A,M=3
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0) {
					$str_err.="Category name cannot be left blank.<br>";
					$bln_err++;
				} elseif (fn_checkproduct($cat,$par,$i)>0) {
					$str_err.="This Category has already been entered.<br>";
					$bln_err++;
				}
				
				if (!$bln_err) {
					if(!$par)	$par=0;
$str_sql="UPDATE cat_products SET cat_product_name='".parse_sql($cat)."',cat_product_linked_id=$par,iMCatID=$cmbmcat WHERE cat_product_id=$i";

					if($cmbmcat==0)
						{
							if(CheckIfCatIDPresent("COMP",$i))	
							InsertOrUpdateOrDeleteCatID("","COMP",$i,"DELETE");						
						}
						else
						{
							if(CheckIfCatIDPresent("COMP",$i))
							{						
							InsertOrUpdateOrDeleteCatID($cmbmcat,"COMP",$i,"UPDATE",$titlecolor,$fontcolor,$bodybgcolor,$bodyfontcolor);
							}
							else
							InsertOrUpdateOrDeleteCatID($cmbmcat,"COMP",$i,"INSERT",$titlecolor,$fontcolor,$bodybgcolor,$bodyfontcolor);												
						}
						
		
					if (mysql_query($str_sql)) {
						print_message("Company Category has been updated.");
						?><script>parent.l.document.location.reload(true);</script><?
					}else{
						print_error("Error: ".mysql_error());
					}
					break;
				}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT CATEGORY FORM
			case 3:  // CASE A,M=3
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				if ($a==3) {
					$str_sql="SELECT cat_product_name, cat_product_linked_id,iMCatID 
										FROM cat_products WHERE cat_product_id=$i";
					
					if ($rst=mysql_query($str_sql)) {
						$adata=mysql_fetch_row($rst);
						$cat=$adata[0];
						$par=$adata[1];
						$mcatid=$adata[2];
						}
					mysql_free_result($rst);
				}
				$cols=GetAllColorsFromLinkageTable($mcatid,$i,'COMP');
				$titlecolor=$cols[0];
				$fontcolor=$cols[2];
				$bodybgcolor=$cols[1];
				$bodyfontcolor=$cols[3];
				
				if(!isset($p)) $p=0;
				?><center>
					<table border=0>
						<form method=post action="<?php echo $me;?>" enctype="multipart/form-data" name="frmcomp">
						<input type=hidden name="m" value=3>
						<input type=hidden name="a" value=4>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<input type=hidden name="i" value=<?php echo $i;?>>
						<input type=hidden name=par value=<?php echo $par;?>>
						<tr><Td colspan=2 class="formcaption">Edit Company Category</td></tr>
<?php
				if (strlen(trim($str_err))) echo "<tr><td valign=top colspan=2>".print_error1($str_err)."</td></tr>";	
?>
						<tr><td>Category</td>
		<td><input type=text name="cat" maxlength=60 value="<?php echo format_str($cat);?>"></td></tr>
						<tr><td>Master Category</td>
								<td>		
								<?php
								
								FillData($adata[2], "cmbmcat", "COMBO", "0", "iMcatid,vname", "cat_master", "n", "iRank" ,"");
								?>
								</td></tr>
		<tr> 
      <td>Title BG Colour:</td>
      <td ><input type='text' name='titlecolor' value="<? echo $titlecolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmcomp.titlecolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Title Font Colour:</td>
      <td ><input type='text' name='fontcolor' value="<? echo $fontcolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmcomp.fontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	
	 <tr> 
      <td>Content BG Colour:</td>
      <td ><input type='text' name='bodybgcolor' value="<? echo $bodybgcolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmcomp.bodybgcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Content Font Colour:</td>
      <td ><input type='text' name='bodyfontcolor' value="<? echo $bodyfontcolor; ?>" > 
        <a href="javascript:TCP.popup(document.frmcomp.bodyfontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>						
		
			<tr><td align=right colspan=2><input type=submit value="Update"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=3
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&	
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($cat))==0) {
					$str_err.="Category name cannot be left blank.<br>";
					$bln_err++;
				} elseif (fn_checkproduct($cat,$p)>0) {
					$str_err.="This Category has already been entered.<br>";
					$bln_err++;
				}					
				
				if (!$bln_err) {
					if(!$p) $p=0;
					
					$compid=NextID("cat_product_id","cat_products");
					
					$str_sql="INSERT INTO cat_products
										(cat_product_id,cat_product_name, cat_product_linked_id,iMCatid)
										VALUES ($compid, '".parse_sql($cat)."', $p,$cmbmcat)";
								
				if($cmbmcat!=0)					
				InsertOrUpdateOrDeleteCatID($cmbmcat,"COMP",$compid,"INSERT",$titlecolor,$fontcolor,$bodybgcolor,$bodyfontcolor);
				
					if (mysql_query($str_sql)) {
						print_message("Company Category has been inserted.");
						?><script>parent.l.document.location.reload(true);</script><?
					}else{
						print_error("Error: $str_sql ".mysql_error());
					}
					break;
				}
	
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW CATEGORIES
			case 1:  // CASE A,M=3
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				if(!isset($cat)) $cat="";
				?><center>
					<table border=0>
						<form method=post action="<?php echo $me;?>" enctype="multipart/form-data" name="frmcomp">
						<input type=hidden name="m" value=3>
						<input type=hidden name="a" value=2>
						<input type=hidden name="p" value=<?php echo $p;?>>
						<tr><Td colspan=2 class="formcaption">Add Company Category</td></tr>
<?php
				if (strlen(trim($str_err))) echo "<tr><td valign=top colspan=2>".print_error1($str_err)."</td></tr>";	
?>
						<tr><td>Category</td>
								<td><input type=text name="cat" maxlength=60 value="<?php echo format_str($cat);?>"></td></tr>
								<tr><td>Master Category</td>
								<td><?php 								
								FillData("", "cmbmcat", "COMBO", "0", "iMcatid,vname", "cat_master", "N", "vName" ,"");
								?></td></tr>
								
				<tr> 
      <td>Title BG Colour:</td>
      <td ><input type='text' name='titlecolor'  > 
        <a href="javascript:TCP.popup(document.frmcomp.titlecolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Title Font Colour:</td>
      <td ><input type='text' name='fontcolor'  > 
        <a href="javascript:TCP.popup(document.frmcomp.fontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	
	 <tr> 
      <td>Content BG Colour:</td>
      <td ><input type='text' name='bodybgcolor'  > 
        <a href="javascript:TCP.popup(document.frmcomp.bodybgcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
	 <tr> 
      <td>Content Font Colour:</td>
      <td ><input type='text' name='bodyfontcolor'  > 
        <a href="javascript:TCP.popup(document.frmcomp.bodyfontcolor)"><img width="15" height="13" border="0" alt="Click Here to Pick up the color" src="images/sel.gif"></a></td>
    </tr>
						<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
						</form>
					</table></center>
				<?php
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE CATGORIES LIST
			default:  // CASE A,M=3
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				if (!isset($p)) {$p=0;}
				?><a href="x_panel.php?m=3">List Categories</a> | <a target=r href="<?php echo $me;?>?m=3&p=<?php echo $p;?>&a=1">Add</a><hr><?php
				if ($p) fn_showparentname($p, "product", 3, $p);
				
				if (!isset($s)) {$s=0;}
				$str_sql="SELECT cat_product_id, cat_product_name 
									FROM cat_products 
									WHERE cat_product_linked_id=$p ORDER BY cat_product_name";
							
				if ($s<1) $s=1;
				$lcnt = 1;
				if ($rst=mysql_query($str_sql)) {
					if($r=mysql_num_rows($rst)) {
						while($adata=mysql_fetch_row($rst))  {
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) {
								echo "<li><a href=\"$me?m=3&p=$adata[0]\">".format_str($adata[1])."</a> | 
													<a target=r href=\"$me?m=3&a=3&i=$adata[0]\">Mod</a> |
													<a target=r href=\"$me?m=3&a=5&i=$adata[0]\">Del</a>";
							} 	
							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT)) {break;}
							$lcnt++;	
						} 
						echo "<hr>";
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1) { 
							echo "| <a href=$me?m=3&p=$p&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";
						}
						if ($lcnt<=mysql_num_rows($rst)) { 
							echo "| <a href=$me?m=3&p=$p&s=$lcnt>Next</a> ";
						}
					} else {
						print_error("There are no records currently.");
					}
				} else {
					print_error ("Error: ".mysql_error());
				}	
			}
			
		break;
		//END OF THE MANAGE CATEGORIES BLOCK
	
	##################################################
	// LISTINGS
	case 2:  // CASE M
	##################################################
		
		if (!isset($a)) {$a=0;}	
		switch ($a) {
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//EDITING A PAGE ?
			case 10:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			echo "done";
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE LISTING
			case 9:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				if(isset($k) && $k==9) {
					// DELETION OF PAGES IMAGES
					if ($p==1) { 
						$sql=" page_image2 ";
					} elseif ($p==2) {
						$sql=" page_image1 ";
					}	
					
					$str_sql="SELECT $sql FROM pages WHERE page_id=$f";
					if($rst=mysql_query($str_sql)) {
						$adata=mysql_fetch_row($rst);
						if($adata[0]) {
							unlink(IMAGES_FOLDER.$adata[0]);
						}
					} else {
						echo mysql_error($rst);
					}
					
					$str_sql="UPDATE pages SET $sql='' WHERE page_id=$f";

					if($rst=mysql_query($str_sql)) {
						print_message("The Image has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} else {
						echo mysql_error($rst);
					}
				} else {
					// DELETION OF LISTING IMAGES
					if ($p==1) { 
						$sql=" listing_photo ";
					} elseif ($p==2) {
						$sql=" listing_logo ";
					}	
					
					$str_sql="SELECT $sql FROM listings WHERE listing_id=$f";
					if($rst=mysql_query($str_sql)) {
						$adata=mysql_fetch_row($rst);
						if($adata[0]) {
							unlink(IMAGES_FOLDER.$adata[0]);
						}
					} else {
						echo mysql_error($rst);
					}
					
					$str_sql="UPDATE listings SET $sql='' WHERE listing_id=$f";
					if($rst=mysql_query($str_sql)) {
						print_message("The Image has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} else {
						echo mysql_error($rst);
					}
				}	
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE LISTING QUESTION?
			case 8:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				echo "<center><b>Do you really want to delete the Image?</b><br>
							<a href=\"".$me."?m=2&a=9&p=$p&f=$i&k=$k\">YES</a> / <a href=\"".$me."?m=2&a=7\">NO</a></center>";
				break;
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//PLACEBO
			case 7:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE LISTING
			case 6:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				$bln_err=0;
				$str_err="";
				$str_sql="SELECT listing_photo, listing_logo FROM listings WHERE listing_id=$f";
				if($rst=mysql_query($str_sql)) {
					$adata=mysql_fetch_row($rst);
					if($adata[0]) {
						if(!unlink(IMAGES_FOLDER.$adata[0])) {
							$bln_err++;
							$str_err.="Main image $adata[0] deletion error<br>";
						}
					}
					if($adata[1]) {
						if(!unlink(IMAGES_FOLDER.$adata[1])) {
							$bln_err++;
							$str_err.="Main image $adata[1] deletion error<br>";
						}
					}
				} else {
					echo mysql_error($rst);
				}
				
				$str_sql="SELECT page_image1, page_image2 FROM pages WHERE listing_id=$f";
				if($rst=mysql_query($str_sql)) {
					while($adata=mysql_fetch_row($rst)) {
						if($adata[0]) {
							if(!unlink(IMAGES_FOLDER.$adata[0])) {
								$bln_err++;
								$str_err.="Page image $adata[0] deletion error<br>";
							}
						}
						if($adata[1]) {
							if(!unlink(IMAGES_FOLDER.$adata[1])) {
								$bln_err++;
								$str_err.="Page image $adata[1] deletion error<br>";
							}
						}
					}	
				} else {
					echo mysql_error($rst);
				}
				
				if(!$bln_err) {
					$str_sql="DELETE FROM listings WHERE listing_id=$f";
					if($rst=mysql_query($str_sql)) {
						print_message("The Listing has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} else {
						echo mysql_error($rst);
					}
				} else {
					print_error(" $bln_err File deletion errors <br>$str_err");
				}
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE LISTING QUESTION?
			case 5:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				echo "<center><b>Do you really want to delete the Listing?</b><br>
							<a href=\"".$me."?m=2&a=6&f=$i\">YES</a> / <a href=\"".$me."?m=2&a=7\">NO</a></center>";
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//DELETE PAGE
			case '4c':  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				$bln_err=0;
				$str_err="";
				
				$str_sql="SELECT page_image1, page_image2 FROM pages WHERE page_id=$f";
				if($rst=mysql_query($str_sql)) {
					$adata=mysql_fetch_row($rst);
					if($adata[0]) {
						if(!unlink(IMAGES_FOLDER.$adata[0])) {
							$bln_err++;
							$str_err.=" $adata[0] unlink error<br>";
						}
					}			
					if($adata[1]) {
						if(!unlink(IMAGES_FOLDER.$adata[1])) {
							$bln_err++;
							$str_err.=" $adata[1] unlink error<br>";
						}
					}
				} else {
					echo mysql_error($rst);
				}
				
				if(!$bln_err) {
					$str_sql="DELETE FROM pages WHERE page_id=$f";
					if($rst=mysql_query($str_sql)) {
						print_message("The Page has been deleted");
						?><script>parent.l.document.location.reload(true);</script><?
					} else {
						echo mysql_error($rst);
					}
				} else {
					print_error(" $bln_err File deletion errors <br>$str_err");
				}
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND ADD NEW PAGE
			case '4b':  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			if($a=='4b') {
				$str_err="";
				$bln_err=0;
				
				if (strlen(trim($capt))==0) {
					$str_err.="Page's Caption is empty.<br>"; 
					$bln_err++;
				}
				
				if (strlen(trim($cont))==0) {
					$str_err.="Page's Content is empty.<br>"; 
					$bln_err++;
				}
				
				if($img1) {
					$pic=$img1;
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					if(strlen(trim($str_picture))>0) {
						if($lng_file_size==0) {
							$str_err.="Page's Image 1 is too Large.<br>"; 
							$bln_err++;
						}
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Page's Image 1 is not of the following format .jpeg, .jpg, .png, .bmp or .gif.<br>";
							$bln_err++;
						}
					}
				}
				
				if($img2) {
					$pic=$img2;
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					if(strlen(trim($str_picture))>0) {
						if($lng_file_size==0) {
							$str_err.="Page's Image 2 is too Large.<br>"; 
							$bln_err++;
						}
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Page's Image 2 is not of the following format .jpeg, .jpg, .png, .bmp or .gif.<br>";
							$bln_err++;
						}
					}
				}

				if(!$bln_err ) {
					if(!$bln_err && $img1) {
						$str_file_name=$HTTP_POST_FILES['img1']['name'];
						if(strlen(trim($str_file_name))>0) {
							//PICTURE WAS SELECTED
							$str_new_file=time().".".$str_file_name;
							$str_temp=$HTTP_POST_FILES['img1']['tmp_name'];
							if (is_uploaded_file($str_temp)) {
								$str_destination=IMAGES_FOLDER.$str_new_file;
								if(move_uploaded_file($str_temp,$str_destination)) {
									$img1=$str_new_file;
								} else {
									$str_err.="Page's Image1 had an upload error.<br>"; 
									$bln_err++;
								}
							}
						}
					}
					
					if(!$bln_err && $img2) {
						$str_file_name=$HTTP_POST_FILES['img2']['name'];
						if(strlen(trim($str_file_name))>0) {
							//PICTURE WAS SELECTED
							$str_new_file=time().".".$str_file_name;
							$str_temp=$HTTP_POST_FILES['img2']['tmp_name'];
							if (is_uploaded_file($str_temp)) {
								$str_destination=IMAGES_FOLDER.$str_new_file;
								if(move_uploaded_file($str_temp,$str_destination)) {
									$img2=$str_new_file;
								} else {
									$str_err.="Page's Image2 had an upload error.<br>"; 
									$bln_err++;
								}
							}
						}
					}
				}	// IF (!$BLN_ERR) 
				
				if (!$bln_err) {
					$str_sql="INSERT INTO pages (listing_id, page_caption, page_content, page_image1)
										VALUES (".$i.", '".parse_sql($capt)."', '".parse_sql($cont)."', '".parse_sql($img1)."')";
					if(!mysql_query($str_sql)) {
						echo mysql_error();
						$bln_err++;
					}
				}
				
				if (!$bln_err) {
					echo"<center><b>The Page is added.</b></center>";
					break;
				} else {
					$a=3;
				}
			}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND MODIFYING THE EXISTING PAGES
			case '4a':  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
			if($a=='4a') {
				if($page=="Delete") {
					echo "<center><b>Do you really want to delete the Page?</b><br>
								<a href=\"".$me."?m=2&a=4c&f=".$page_id."\">YES</a> / <a href=\"".$me."?m=2&a=7\">NO</a></center>";
					break;
				} elseif($page=="Modify") {	
					$str_err="";
					$bln_err=0;
					
					if (strlen(trim($capt))==0) {
						$str_err.="Page's Caption is empty.<br>"; 
						$bln_err++;
					}
					
					if (strlen(trim($cont))==0) {
						$str_err.="Page's Content is empty.<br>"; 
						$bln_err++;
					}
					
					if($img1) {
						$pic=$img1;
						$str_picture=$HTTP_POST_FILES['pic']['name'];
						$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
						if(strlen(trim($str_picture))>0) {
							if($lng_file_size==0) {
								$str_err.="Page's Image 1 is too Large.<br>"; 
								$bln_err++;
							}
							$str_file_extension=get_file_extension();
							if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
								$str_err.="Page's Image 1 is not of the following format .jpeg, .jpg, .png, .bmp or .gif.<br>";
								$bln_err++;
							}
						}
					}
					
					if($img2) {
						$pic=$img2;
						$str_picture=$HTTP_POST_FILES['pic']['name'];
						$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
						if(strlen(trim($str_picture))>0) {
							if($lng_file_size==0) {
								$str_err.="Page's Image 2 is too Large.<br>"; 
								$bln_err++;
							}
							$str_file_extension=get_file_extension();
							if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
								$str_err.="Page's Image 2 is not of the following format .jpeg, .jpg, .png or .gif.<br>";
								$bln_err++;
							}
						}
					}
	
	
					if(!$bln_err ) {
						if(!$bln_err && $img1) {
							$str_file_name=$HTTP_POST_FILES['img1']['name'];
							if(strlen(trim($str_file_name))>0) {
								//PICTURE WAS SELECTED
								$str_new_file=time().".".$str_file_name;
								$str_temp=$HTTP_POST_FILES['img1']['tmp_name'];
								if (is_uploaded_file($str_temp)) {
									$str_destination=IMAGES_FOLDER.$str_new_file;
									if(move_uploaded_file($str_temp,$str_destination)) {
										$img1=$str_new_file;
									} else {
										$str_err.="Page's Image1 had an upload error.<br>"; 
										$bln_err++;
									}
								}
							}
						}
						
						if(!$bln_err && $img2) {
							$str_file_name=$HTTP_POST_FILES['img2']['name'];
							if(strlen(trim($str_file_name))>0) {
								//PICTURE WAS SELECTED
								$str_new_file=time().".".$str_file_name;
								$str_temp=$HTTP_POST_FILES['img2']['tmp_name'];
								if (is_uploaded_file($str_temp)) {
									$str_destination=IMAGES_FOLDER.$str_new_file;
									if(move_uploaded_file($str_temp,$str_destination)) {
										$img2=$str_new_file;
									} else {
										$str_err.="Page's Image2 had an upload error.<br>"; 
										$bln_err++;
									}
								}
							}
						}
					}	// IF (!$BLN_ERR) 
					
					if (!$bln_err) {
						$str_sql="SELECT page_image1, page_image2
											FROM pages 
											WHERE page_id=".$page_id;
						if(!mysql_query($str_sql)) {
							echo mysql_error();
						} else {
							if($img1 && $adata[0]) {
								if(unlink(IMAGES_FOLDER.$adata[0])) {
									$str_err="$adata[0] unlink failed <br>";
									$bln_err++;
								}
							}
							if($img2 && $adata[1]) {
								if(unlink(IMAGES_FOLDER.$adata[1])) {
									$str_err="$adata[1] unlink failed <br>";
									$bln_err++;
								}
							}						
						}
					}	
					
					if (!$bln_err) {
						$str_sql="UPDATE pages SET page_caption='".parse_sql($capt)."', page_content='".parse_sql($cont)."' ";
						
						if($img1) {
							$str_sql.=", page_image1='".parse_sql($img1)."' ";
						}
						if($img2) {
							$str_sql.=", page_image2='".parse_sql($img2)."' ";
						}
						$str_sql.=" WHERE page_id=".$page_id;
						if(!mysql_query($str_sql)) {
							echo mysql_error();
							$bln_err++;
						}
					}
				
					if (!$bln_err) {
						echo"<center><b>The Pages are added.</b></center>";
						break;
					} else {
						$a=3;
					}
				}
			}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND MODIFYING THE PROFILE
			case 4:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			if($a==4) {
				$str_err=$cper="";
				$bln_err=0;
				
				if($t==1) {
					if (strlen(trim($fnm))==0) {
						$str_err.="First name cannot be left blank.<br>"; 
						$bln_err++;
					}
					if (strlen(trim($lnm))==0) {
						$str_err.="Last name cannot be left blank.<br>"; 
						$bln_err++;
					}
				}	
				
				if ($t==2 && strlen(trim($comp))==0) {
					$str_err.="Company cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if($pic) {
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
						$str_err.="Photograph Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) {
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Photograph must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if($logo) {
					$temp_pic=$pic;
					$pic=$logo;
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_LOGO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
						$str_err.="Logo Uploaded is too Large.<br>"; 
						$bln_err++;
					}
				
					if(strlen(trim($str_picture))>0) {
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Logo must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
					$pic=$temp_pic;
				}
				
				if (strlen(trim($phn))==0) {
					$str_err.="Phone Number cannot be left blank.<br>"; 
					$bln_err++;
				} 
				
				if (strlen(trim($add1))==0 && strlen(trim($add2))==0) {
					$str_err.="Address cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if (strlen(trim($zip))==0) {
					$str_err.="Pincode cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				
				if (strlen(trim($mail))>0 && !check_email($mail)) {
					$str_err.="Enter a valid Email .<br>"; 
					$bln_err++;
				} 
				
				if (strlen(trim($det))==0) {
					$str_err.="Details cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if ($lu1==0 && $lu2==0 && $lu3==0) {
					$str_err.="Choose atleast one category to be listed under.<br>"; 
					$bln_err++;
				} elseif(($lu1==$lu2 && $lu1!=0) || ($lu3==$lu2 && $lu2!=0) || ($lu1==$lu3 && $lu1!=0)) {
					$str_err.="Selected categories must be different.<br>"; 
					$bln_err++;
				}
				
				if(!$bln_err && $pic) {
					$str_file_name=$HTTP_POST_FILES['pic']['name'];
					if(strlen(trim($str_file_name))>0) {
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
						if (is_uploaded_file($str_temp)) {
							$str_destination=IMAGES_FOLDER.$str_new_file;
							if(move_uploaded_file($str_temp,$str_destination)) {
								$pic=$str_new_file;
							} else {
								$str_err.="Photograph upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if(!$bln_err && $logo) {
					$str_file_name=$HTTP_POST_FILES['logo']['name'];
					if(strlen(trim($str_file_name))>0) {
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['logo']['tmp_name'];
						if (is_uploaded_file($str_temp)) {
							$str_destination=IMAGES_FOLDER.$str_new_file;
							if(move_uploaded_file($str_temp,$str_destination)) {
								$logo=$str_new_file;
							} else {
								$str_err.="Logo upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if (!$bln_err) {
					$str_sql="SELECT listing_cat1, listing_cat2, listing_cat3
										FROM  listings 
										WHERE listing_id=".$i;
					if ($rst=mysql_query($str_sql)) {
						$adata=mysql_fetch_row($rst);
						mysql_free_result($rst);
						if($t==1) {
							// PROFESSIONAL
							foreach($adata as $var_val) {
								if($var_val) {
									$sql_query="UPDATE cat_services SET cat_service_count=cat_service_count-1 WHERE cat_service_id=".$var_val;
									if(!mysql_query($sql_query,$dbc)) {
										echo mysql_error();
									}
								}
							}
						} elseif($t==2) {
							// COMPANY
							foreach($adata as $var_val) {
								if($var_val) {
									$sql_query="UPDATE cat_products SET cat_product_count=cat_product_count-1 WHERE cat_product_id=".$var_val;
									if(!mysql_query($sql_query,$dbc)) {
										echo mysql_error();
									}
								}
							}
						}
					}
				
					$str_sql="UPDATE listings set listing_fname='".parse_sql($fnm)."', listing_lname='".parse_sql($lnm)."', listing_company='".parse_sql($comp)."',listing_addr1='".parse_sql($add1)."',listing_addr2='".parse_sql($add2)."',listing_zip='".parse_sql($zip)."', location_id=".$loc.", listing_since='".date("Y-m-d")."', listing_email='".parse_sql($mail)."', listing_phone='".$phn."', listing_plan=".$pln.", listing_cat1=".$lu1.", listing_cat2=".$lu2.", listing_cat3=".$lu3.", listing_contact_person='".parse_sql($cper)."', listing_designation='".parse_sql($desg)."', listing_cellphone='".$mob."', listing_website='".parse_sql($web)."', listing_details='".parse_sql($det)."', listing_mode_of_payment='".$mop."',listing_fax='".$fax."'";
					if($pic) {
						$str_sql.=", listing_photo='".parse_sql($pic)."'";
						unlink(IMAGES_FOLDER.$pic1);
					}
					if($logo) {
						$str_sql.=", listing_logo='".parse_sql($logo)."'";
						unlink(IMAGES_FOLDER.$logo1);
					}
					$str_sql.=" WHERE listing_id=$i";
					
					if (mysql_query($str_sql))  {
						$lu=array($lu1,$lu2,$lu3);
						if($t==1) {
							// PROFESSIONAL
							foreach($lu as $var_val) {
								if($var_val) {
									$sql_query="UPDATE cat_services SET cat_service_count=cat_service_count+1 WHERE cat_service_id=".$var_val;
									if(!mysql_query($sql_query,$dbc)) {
										echo mysql_error();
									}
								}
							}
						} elseif($t==2) {
							// COMPANY
							foreach($lu as $var_val) {
								if($var_val) {
									$sql_query="UPDATE cat_products SET cat_product_count=cat_product_count+1 WHERE cat_product_id=".$var_val;
									if(!mysql_query($sql_query,$dbc)) {
										echo mysql_error();
									}
								}
							}
						}
						
						?><script>parent.l.document.location.reload(true);</script><?
						if($pln>0) {
							$a='3a';
						} else {
							print_message("The profile has been updated.");
							break;
						}							
					} else print_error(mysql_error());
				}	
			}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE EDIT LISTINGS FORM
			case 3:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
			
				$str_sql="SELECT listing_type FROM listings WHERE listing_id=".$i;
				if ($rst=mysql_query($str_sql)) {
					$adata=mysql_fetch_row($rst);
					$t=$adata[0];
					mysql_free_result($rst);
				}
				
				// BUILDING OF THE ARRAYS -- START
				$str_sql="SELECT location_id, location_name 
									FROM locations ORDER BY location_name";
				if ($rst=mysql_query($str_sql)) {
					while($adata=mysql_fetch_row($rst)) {
						$arr_location[$adata[0]]=$adata[1];
					}
					mysql_free_result($rst);
				}	
				
				if($t==2) {
					// REGISTERING A COMPANY
					$sql_query="SELECT cat_product_id, cat_product_name, cat_product_linked_id 
											FROM cat_products 
											WHERE cat_product_linked_id=0";
											
					if($rst=mysql_query($sql_query,$dbc)) {
						while($adata=mysql_fetch_row($rst)) {
							$a_list_under[$adata[0]]=$adata[1];
						}
					} else echo mysql_error();
				} elseif($t==1) {
					// REGISTERING A PROFESSIONAL
					$sql_query="SELECT cat_service_id, cat_service_name, cat_service_parent_id 
											FROM cat_services  
											ORDER BY cat_service_parent_id asc, cat_service_name";
					if($rst=mysql_query($sql_query,$dbc)) {
						$l_cnt=0;
						while($adata=mysql_fetch_row($rst)){
							$acat[$l_cnt][0]=$adata[0]; //cat id
							$acat[$l_cnt][1]=$adata[1]; //name
							$acat[$l_cnt][2]=$adata[2]; //parent
							$l_cnt++;
						}
					} else echo mysql_error();
					
					$str_out="";	//global variable
					build_tree(0,0);
				}
				// BUILDING OF THE ARRAYS -- END
				
				$str_sql="SELECT listing_id, listing_fname, listing_lname, listing_company, listing_addr1, listing_addr2, listing_zip, location_id, listing_type, listing_password,									 listing_since, listing_email, listing_phone, listing_plan, listing_cat1, listing_cat2, listing_cat3, listing_username, listing_contact_person, listing_designation, listing_cellphone, listing_website, listing_details, listing_photo, listing_mode_of_payment, listing_logo,listing_fax		FROM  listings WHERE listing_id=".$i;
				if ($rst=mysql_query($str_sql)) {
					$adata=mysql_fetch_row($rst);
					mysql_free_result($rst);
					$logo1=$adata[25];
					$pic1=$adata[23];
					$adata[23]=IMAGES_FOLDER.$adata[23];
					$adata[25]=IMAGES_FOLDER.$adata[25];
				}
				
				if(strlen($str_err)>0) {
					$adata=array($i,$fnm,$lnm,$comp,$add1,$add2,$zip,$loc,
											 $t,$psd,$adata[10],$mail,$phn,$pln,$lu1,$lu2,$lu3,
											 $adata[17],$cper,$desg,$mob,$web,$det,$adata[23],$mop,$adata[25],$fax);
				}

				if (strlen(trim($str_err))) echo print_error($str_err);	
				?>
					
<table border=0 cellpadding=3 cellspacing=0 align=center>
  <form method=post enctype="multipart/form-data" action="<?php echo $me;?>" name='editlist'>
    <input type=hidden name="m" value=2>
    <input type=hidden name="a" value=4>
    <input type=hidden name="t" value=<? echo $t; ?>>
    <input type=hidden name="i" value=<? echo $i; ?>>
    <input type=hidden name="logo1" value=<? echo $logo1; ?>>
    <input type=hidden name="pic1" value=<? echo $pic1; ?>>
    <tr>
      <Td colspan=2 class="formcaption">Edit Company Profile</Td>
    </tr>
    <tr>
      <td>Name First/Last: </td>
      <td><input type=text name="fnm" maxlength=60 value="<?php echo format_str($adata[1]);?>"> 
        <input type=text name="lnm" maxlength=60 value="<?php echo format_str($adata[2]);?>"></td>
    </tr>
    <tr>
      <td>Company/Designation: </td>
      <td><input type=text name="comp" maxlength=60 value="<?php echo format_str($adata[3]);?>"> 
        <input type=text name="desg" maxlength=60 value="<?php echo format_str($adata[19]);?>"></td>
    </tr>
    <tr>
      <td valign=top>Logo: </td>
      <td><input type=file name="logo">
        <br> 
        <? if($logo1) {
									?>
        <img src="<?php echo format_str($adata[25]);?>"> 
        <?
									echo "<a target=\"r\" href=\"".$me."?m=2&a=8&p=2&i=".$i."\">Delete Image</a>"; 
								}
						?>
      </td>
    </tr>
    <tr>
      <td valign=top>Photograph: </td>
      <td><input type=file name="pic">
        <br> 
        <? if($pic1) {
								?>
        <img src="<?php echo format_str($adata[23]);?>"> 
        <?
						  	echo "<a target=\"r\" href=\"".$me."?m=2&a=8&p=1&i=".$i."\">Delete Image</a>"; 
								}
						?>
      </td>
    </tr>
    <tr>
      <td>Phone/Cellphone: </td>
      <td><input type=text name="phn" maxlength=60 value="<?php echo format_str($adata[12]);?>"> 
        <input type=text name="mob" maxlength=60 value="<?php echo format_str($adata[20]);?>"></td>
    </tr>
	<tr><td>Fax No: </td>
	<td><input type=text name="fax" maxlength=60 value="<?php echo format_str($adata[26]);?>">
	</td></tr>
    <tr>
      <td>Address: </td>
      <td><input type=text name="add1" maxlength=60 value="<?php echo format_str($adata[4]);?>"> 
        <input type=text name="add2" maxlength=60 value="<?php echo format_str($adata[5]);?>"></td>
    </tr>
    <tr>
      <td>Zipcode/Location: </td>
      <td><input type=text name="zip" maxlength=60 value="<?php echo format_str($adata[6]);?>"> 
        <select name="loc">
          <?print_dropdown($arr_location,$adata[7]);?></select></td>
    </tr>
    <tr>
      <td>Email/Website: </td>
      <td><input type=text name="mail" maxlength=60 value="<?php echo format_str($adata[11]);?>"> 
        <input type=text name="web" maxlength=60 value="<?php echo format_str($adata[21]);?>"></td>
    </tr>
    <tr>
      <td>Plan: </td>
      <td>
        <!--input type=text name="cper" maxlength=60 value="<?php echo format_str($adata[18]);?>"-->
        <select name="pln">
          <? print_dropdown($ga_plans,$adata[13]);?></select></td>
    </tr>
    <tr>
      <td valign=top>Upload Pics:</td>
      <td><input type="button" name="Submit2" value="&gt;&gt;" onClick="comppics(<? echo $i; ?>)"></td>
    </tr>
    <tr>
      <td valign=top>Details: </td>
      <td><textarea name="det" cols=60 rows=15><?php echo format_str($adata[22]);?></textarea> 
        <input type='hidden' name='lid' value=<? echo $i; ?>> </td>
    </tr>
    <tr>
      <td valign=top>List Under 1/2/3: </td>
      <td valign=top> <select name="lu1">
          <option value=0 selected>Choose ... </option>
          <? FillCatProductsCombo($adata[14]); ?>
        </select>
        <br> <select name="lu2">
          <option value=0 selected>Choose ... </option>
          <? FillCatProductsCombo($adata[15]);?>
        </select>
        <br> <select name="lu3">
          <option value=0 selected>Choose ... </option>
          <? FillCatProductsCombo($adata[16]);?>
        </select></td>
    </tr>
    <tr>
      <td>Payment Mode: </td>
      <td valign=top><select name="mop">
          <? print_dropdown($ga_payment,$adata[24]);?></select></td>
    </tr>
    <tr>
      <td>Username: </td>
      <td valign=top><? echo format_str($adata[17]); ?></td>
    </tr>
    <tr>
      <td>Type/Listed Since: </td>
      <td>
        <?php if($adata[8]==2) {
														echo "Company / ".format_str(date("dS M, Y",strtotime($adata[10])));
													} else {
														echo "Professional / ".format_str(date("dS M, Y",strtotime($adata[10])));
													} 
										?>
      </td>
    </tr>
    <tr>
      <td colspan=2 align=right><input type=submit name=profile value=Modify></td>
    </tr>
  </form>
</table>
				<?php
				// EXISTING PAGES
				// DISPLAY THE REQUIRED NUMBER OF FORM-PAGES
					$sql_query="SELECT page_id, listing_id, page_caption, page_content, page_image1, page_image2 
											FROM pages 
											WHERE listing_id=".$i."
											ORDER BY page_id";
					if($rst=mysql_query($sql_query,$dbc)) {
						if($lng_rownum=mysql_num_rows($rst)) {
							$l_i=1;
							while($adata=mysql_fetch_row($rst)) {
								echo "
											<table align=center border=0 cellpadding=3 cellspacing=0>
											<form method=post enctype=\"multipart/form-data\" action=\"".$me."\">
												<input type=hidden name=\"m\" value=2>
												<input type=hidden name=\"a\" value=\"4a\">
												<tr><td colspan=\"2\" class='formcaption'>Page ".$l_i." Details</td></tr>
												<tr><td>Caption: </td>
														<td><input type=\"text\" name=\"capt\" maxlength=\"60\" value=\"".$adata[2]."\"></td></tr>		
												<tr><td>Image 1: </td>
														<td><input type=\"file\" name=\"img1\">";
								if($adata[4]) {
									echo "<br><img ".resize_img(IMAGES_FOLDER.$adata[4])." src=\"".IMAGES_FOLDER.$adata[4]."\">
												<a target=\"r\" href=\"".$me."?m=2&a=8&p=2&k=9&i=".$adata[0]."\"><small>Delete Image</small></a>";
								}
								echo "</td></tr>
										<tr><td>Content: </td>
												<td><textarea name=\"cont\" cols=\"40\" rows=\"7\">".$adata[3]."</textarea><br><div align=right><small><strong><a onClick=\"window.open('x_listing_page_det.php?pageid=$adata[0]','','menubars=0,width=600,height=500,scrollbars=1');\">Edit Content</a></strong></small></div>";
				
								echo "</td></tr>
											<tr><td colspan=2 align=right><br><input type=submit name=page value=Modify>
																										<input type=submit name=page value=Delete></td></tr>
											<input type=hidden name=\"page_id\" value=\"".$adata[0]."\"></form></table>";
								$l_i++;
							}
						}
						
						// NEW PAGES
						
						if($lng_rownum<5) {
								echo "<br>
											<table align=center border=0 cellpadding=3 cellspacing=0>
											<form method=post enctype=\"multipart/form-data\" action=\"".$me."\">
												<input type=hidden name=\"m\" value=2>
												<input type=hidden name=\"a\" value=\"4b\">
												<input type=hidden name=\"p\" value=\"".$pln."\">
												<input type=hidden name=\"l\" value=\"".$lng_insert_id."\">
												<input type=hidden name=\"i\" value=\"".$i."\">
												<tr><td colspan=2 class='formcaption'>Add New Page</td></tr>
												<tr><td>Caption: </td>
														<td><input type=text name=\"capt\" maxlength=60 value=\"".$capt[$l_pid]."\"></td></tr>
												<tr><td>Image 1: </td>
														<td><input type=file name=\"img1\"></td></tr>
												<tr><td>Content: </td>
														<td><textarea name=\"cont\" cols=40 rows=7></textarea>";
								echo "</td></tr>
											<tr><td colspan=2 align=right><input type=submit name=page value=Add></td></tr>
											<input type=hidden name=\"page_id\" value=\"0\">
											</form></table>";
						}
						break;		
					} else echo mysql_error();
				
				
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case 2:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				$psd=$cper=$str_err="";
				$bln_err=0;
				
				if($t==1) {
					if (strlen(trim($fnm))==0) {
						$str_err.="First name cannot be left blank.<br>"; 
						$bln_err++;
					}
					if (strlen(trim($lnm))==0) {
						$str_err.="Last name cannot be left blank.<br>"; 
						$bln_err++;
					}
				}	
				
				if ($t==2 && strlen(trim($comp))==0) {
					$str_err.="Company cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if($logo) {
					$str_picture=$HTTP_POST_FILES['logo']['name'];
					$lng_file_size=fn_check_file_size(MAX_LOGO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
						$str_err.="Logo Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) {
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Logo must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if($pic) {
					$str_picture=$HTTP_POST_FILES['pic']['name'];
					$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
					
					if(strlen(trim($str_picture))>0 && $lng_file_size==0) {
						$str_err.="Photograph Uploaded is too Large.<br>"; 
						$bln_err++;
					}
					
					if(strlen(trim($str_picture))>0) {
						$str_file_extension=get_file_extension();
						if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
							$str_err.="Photograph must be of jpeg, jpg, png, bmp or gif format.<br>";
							$bln_err++;
						}						
					}
				}
				
				if (strlen(trim($phn))==0) {
					$str_err.="Phone Number cannot be left blank.<br>"; 
					$bln_err++;
				} 
				
				if (strlen(trim($add1))==0 && strlen(trim($add2))==0) {
					$str_err.="Address cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if (strlen(trim($zip))==0) {
					$str_err.="Zipcode cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if (strlen(trim($mail))>0 && !check_email($mail)) {
					$str_err.="Enter a valid Email .<br>"; 
					$bln_err++;
				} 
				
				if (strlen(trim($det))==0) {
					$str_err.="Details cannot be left blank.<br>"; 
					$bln_err++;
				}
				
				if ($lu1==0 && $lu2==0 && $lu3==0) {
					$str_err.="Choose atleast one category to be listed under.<br>"; 
					$bln_err++;
				} elseif(($lu1==$lu2 && $lu1!=0) || ($lu3==$lu2 && $lu2!=0) || ($lu1==$lu3 && $lu1!=0)) {
					$str_err.="Selected categories must be different.<br>"; 
					$bln_err++;
				}
				
				if (strlen(trim($unm))<2) {
					$str_err.="Username cannot be less than 2 characters.<br>"; 
					$bln_err++;
				}elseif (!fn_check_valid_user($unm)) {
					$str_err.="Username entered is invalid.<br>"; 
					$bln_err++;		
				} elseif(fbln_pass_user("listings", $unm)) {
					$str_err.="This Username has already been taken. Please try another one. <br>"; 
					$bln_err++;
				}

				if(!$bln_err && $logo) {
					$str_file_name=$HTTP_POST_FILES['logo']['name'];
					if(strlen(trim($str_file_name))>0) {
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['logo']['tmp_name'];
						if (is_uploaded_file($str_temp)) {
							$str_destination=IMAGES_FOLDER.$str_new_file;
							if(move_uploaded_file($str_temp,$str_destination)) {
								$logo=$str_new_file;
							} else {
								$str_err.="Logo upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if(!$bln_err && $pic) {
					$str_file_name=$HTTP_POST_FILES['pic']['name'];
					if(strlen(trim($str_file_name))>0) {
						//PICTURE WAS SELECTED
						$str_new_file=time().".".$str_file_name;
						$str_temp=$HTTP_POST_FILES['pic']['tmp_name'];
						if (is_uploaded_file($str_temp)) {
							$str_destination=IMAGES_FOLDER.$str_new_file;
							if(move_uploaded_file($str_temp,$str_destination)) {
								$pic=$str_new_file;
							} else {
								$str_err.="Photograph upload error.<br>"; 
								$bln_err++;
							}
						}
					}
				}
				
				if (!$bln_err) {	
					$str_sql="INSERT INTO listings (listing_fname, listing_lname, listing_company, listing_addr1, listing_addr2, listing_zip, location_id, listing_type, listing_password, listing_since, listing_email, listing_phone, listing_plan, listing_cat1, listing_cat2, listing_cat3, listing_username, listing_contact_person, listing_designation, listing_cellphone, listing_website, listing_details,  listing_photo, listing_mode_of_payment, listing_logo, listing_fax) VALUES ('".parse_sql($fnm)."','".parse_sql($lnm)."', '".parse_sql($comp)."', '".parse_sql($add1)."','".parse_sql($add2)."','".parse_sql($zip)."',".$loc.", ".$t.",'".parse_sql($psd)."','".date("Y-m-d H:i:s")."','".parse_sql($mail)."', '".parse_sql($phn)."',".$pln.",".$lu1.",".$lu2.",".$lu3.", '".parse_sql($unm)."','".parse_sql($cper)."','".parse_sql($desg)."', '".$mob."','".parse_sql($web)."','".parse_sql($det)."', '".parse_sql($pic)."',".$mop.",'".parse_sql($logo)."','".$fax."')";

												 
					$headers .= "From: $mail \n\r";
					$str_email=str_replace ("[[NAME]]",'"$fname". ."$lname"',"$str_email") ;																
					$str_email=str_replace ("[[ADDR]]","$add1","$str_email") ;																				
					$str_email=str_replace ("[[STATE]]","$add2","$str_email") ;																				
					$str_email=str_replace ("[[ZIP]]","$zip","$str_email") ;																				
					$str_email=str_replace ("[[PHONE]]","$phn, $mob","$str_email") ;																				
					$str_email=str_replace ("[[EMAIL]]","$mail","$str_email") ;																				
					$str_email=str_replace ("[[USER]]","$unm","$str_email") ;																				
					$str_email=str_replace ("[[PASS]]","$psd","$str_email") ;	
					
					if (mysql_query($str_sql))  {
						$lng_insert_id=mysql_insert_id();
						$lu=array($lu1,$lu2,$lu3);
						if($t==1) {
							// PROFESSIONAL
							foreach($lu as $var_val) {
								if($var_val) {
									$sql_query="UPDATE cat_services SET cat_service_count=cat_service_count+1 WHERE cat_service_id=".$var_val;
									if(!mysql_query($sql_query,$dbc)) {
										echo mysql_error();
									}
								}
							}
						} elseif($t==2) {
							// COMPANY
							foreach($lu as $var_val) {
								if($var_val) {
									$sql_query="UPDATE cat_products SET cat_product_count=cat_product_count+1 WHERE cat_product_id=".$var_val;
									if(!mysql_query($sql_query,$dbc)) {
										echo mysql_error();
									}
								}
							}
						}
						mail($to,$str_subject,$str_email,$headers);
						?><script>parent.l.document.location.reload(true);</script><?
						if($pln==0) {
							print_message ("Listing has been added.");
							break;
						} else {
							// GO TO CASE 2A
							$a='2a';
						}							
					} else print_error(mysql_error());
				}	

			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//VALIDATE AND INSERT INTO THE DATABASE
			case '2b':  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&	
				
				if($a=='2b') {
					$str_err="";
					$bln_err=0;
					
					for($l_pid=1; $l_pid<=$p; $l_pid++) {
						if (strlen(trim($capt[$l_pid]))==0) {
							$str_err.="Page $l_pid's Caption is empty.<br>"; 
							$bln_err++;
						}
						
						if (strlen(trim($cont[$l_pid]))==0) {
							$str_err.="Page $l_pid's Content is empty.<br>"; 
							$bln_err++;
						}
						
						if($img1[$l_pid]) {
							$pic=$img1[$l_pid];
							$str_picture=$HTTP_POST_FILES['pic']['name'];
							$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
							if(strlen(trim($str_picture))>0) {
								if($lng_file_size==0) {
									$str_err.="Page $l_pid's Image 1 is too Large.<br>"; 
									$bln_err++;
								}
								$str_file_extension=get_file_extension();
								if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
									$str_err.="Page $l_pid's Image 1 is not of the following format .jpeg, .jpg, .png, .bmp or .gif.<br>";
									$bln_err++;
								}
							}
						}
						
						if($img2[$l_pid]) {
							$pic=$img2[$l_pid];
							$str_picture=$HTTP_POST_FILES['pic']['name'];
							$lng_file_size=fn_check_file_size(MAX_PHOTO_UPLOAD_SIZE);
							if(strlen(trim($str_picture))>0) {
								if($lng_file_size==0) {
									$str_err.="Page $l_pid's Image 2 is too Large.<br>"; 
									$bln_err++;
								}
								$str_file_extension=get_file_extension();
								if (!in_array(trim($str_file_extension),array_values($ga_imagetypes))) { 
									$str_err.="Page $l_pid's Image 2 is not of the following format .jpeg, .jpg, .png, .bmp or .gif.<br>";
									$bln_err++;
								}
							}
						}
					} // END OF THE FOR 
					
					if(!$bln_err ) {
						for($l_pid=1; $l_pid<=$p; $l_pid++) {
							if(!$bln_err && $img1[$l_pid]) {
								$str_file_name=$HTTP_POST_FILES['img1']['name'][$l_pid];
								if(strlen(trim($str_file_name))>0) {
									//PICTURE WAS SELECTED
									$str_new_file=time().".".$str_file_name;
									$str_temp=$HTTP_POST_FILES['img1']['tmp_name'][$l_pid];
									if (is_uploaded_file($str_temp)) {
										$str_destination=IMAGES_FOLDER.$str_new_file;
										if(move_uploaded_file($str_temp,$str_destination)) {
											$img1[$l_pid]=$str_new_file;
										} else {
											$str_err.="Page $l_pid's Image1 had an upload error.<br>"; 
											$bln_err++;
										}
									}
								}
							}							
							if(!$bln_err && $img2[$l_pid]) {
								$str_file_name=$HTTP_POST_FILES['img2']['name'][$l_pid];
								if(strlen(trim($str_file_name))>0) {
									//PICTURE WAS SELECTED
									$str_new_file=time().".".$str_file_name;
									$str_temp=$HTTP_POST_FILES['img2']['tmp_name'][$l_pid];
									if (is_uploaded_file($str_temp)) {
										$str_destination=IMAGES_FOLDER.$str_new_file;
										if(move_uploaded_file($str_temp,$str_destination)) {
											$img2[$l_pid]=$str_new_file;
										} else {
											$str_err.="Page $l_pid's Image2 had an upload error.<br>"; 
											$bln_err++;
										}
									}
								}
							}
						} // END OF THE FOR 
					}	// IF (!$BLN_ERR) 
					
					if (!$bln_err) {
						for($l_pid=1; $l_pid<=$p; $l_pid++) {
							$str_sql="INSERT INTO pages (listing_id, page_caption, page_content, page_image1, page_image2)
												VALUES(".$l.",'".parse_sql($capt[$l_pid])."', '".parse_sql($cont[$l_pid])."',
															 '".parse_sql($img1[$l_pid])."','".parse_sql($img2[$l_pid])."')";
							if(!mysql_query($str_sql)) {
								echo mysql_error();
								$bln_err++;
							}
						}
					}
					
					if (!$bln_err) {
						echo"<center><b>The Pages are added.</b></center>";
						break;
					} else {
						$a='2a'; $pln=$p; $lng_insert_id=$l;
					}
				}	
					
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			// ADD PAGE DETAILS
			case '2a':  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&	

				if($a=='2a') {
					if (strlen(trim($str_err))) {
						print_error($str_err);
					}
					echo "<center>
								<table border=0 cellpadding=3>
									<form method=post enctype=\"multipart/form-data\" action=\"".$me."\">
									<input type=hidden name=\"m\" value=2>
									<input type=hidden name=\"a\" value=\"2b\">
									<input type=hidden name=\"p\" value=\"".$pln."\">
									<input type=hidden name=\"l\" value=\"".$lng_insert_id."\">";
					for($l_pid=1; $l_pid<=$pln; $l_pid++) {
						echo "<tr><td colspan=2 align=center><b> Page ".$l_pid." Details</b></td></tr><tr><td>Caption: </td>	<td><input type=text name=\"capt[".$l_pid."]\" maxlength=60 value=\"".$capt[$l_pid]."\"></td></tr>	<tr><td>Image 1: </td><td><input type=file name=\"img1[".$l_pid."]\"></td></tr><tr><td>Image 2: </td><td><input type=file name=\"img2[".$l_pid."]\"></td></tr><tr><td>Content: </td><td><textarea name=\"cont[".$l_pid."]\" cols=40 rows=7>".$cont[$l_pid]."</textarea>";
						?>
			<script language="javascript1.2">editor_generate('cont[$l_pid]');</script>
						</td></tr>
						<?
					}
					echo "	<tr><td colspan=2><input type=submit value=Save></td></tr>
								</form>
							</table></center>";
					break;
				}
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//ADD NEW LISTINGS
			case 1:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			
				$str_sql="SELECT location_id, location_name 
									FROM locations ORDER BY location_name";
				if ($rst=mysql_query($str_sql)) {
					while($adata=mysql_fetch_row($rst)) {
						$arr_location[$adata[0]]=$adata[1];
					}
					mysql_free_result($rst);
				}	
				
				if($t==COMPANY) {
					// REGISTERING A COMPANY
					$str_type="Company";
					$sql_query="SELECT cat_product_id, cat_product_name, cat_product_linked_id 
											FROM cat_products 
											WHERE cat_product_linked_id=0";											
					if($rst=mysql_query($sql_query,$dbc)) {
						while($adata=mysql_fetch_row($rst)) {
							$a_list_under[$adata[0]]=$adata[1];
						}
					} else echo mysql_error();
				} elseif($t==PROFESSIONAL) {
					// REGISTERING A PROFESSIONAL
					$str_type="Professional";
					$sql_query="SELECT cat_service_id, cat_service_name, cat_service_parent_id 
											FROM cat_services  
											ORDER BY cat_service_parent_id asc, cat_service_name";
					if($rst=mysql_query($sql_query,$dbc)) {
						$l_cnt=0;
						while($adata=mysql_fetch_row($rst)){
							$acat[$l_cnt][0]=$adata[0]; //cat id
							$acat[$l_cnt][1]=$adata[1]; //name
							$acat[$l_cnt][2]=$adata[2]; //parent
							$l_cnt++;
						}
					} else echo mysql_error();
					
					$str_out="";	//global variable
					build_tree(0,0);
				}
				
				?>
					<table border=0 align=center>
						<form method=post enctype="multipart/form-data" action="<?php echo $me;?>" name='editlist'>
						<input type=hidden name="m" value=2>
						<input type=hidden name="a" value=2>
						<input type=hidden name="t" value=<? echo $t; ?>>
						<tr><td colspan=2 class="formcaption">Company Registration</td></tr>
<?php
				if (strlen(trim($str_err))) echo "<tr><Td valign=top colspan=2 align=center>".print_error1($str_err)."</td></tr>";
?>
						<tr><td>Name First/Last: </td>
								<td><input type=text name="fnm" maxlength=60 value="<?php echo format_str($fnm);?>">
								    <input type=text name="lnm" maxlength=60 value="<?php echo format_str($lnm);?>"></td></tr>		
						<tr><td>Company/Designation: </td>
								<td><input type=text name="comp" maxlength=60 value="<?php echo format_str($comp);?>">
										<input type=text name="desg" maxlength=60 value="<?php echo format_str($desg);?>"></td></tr>
						<tr><td>Logo: </td>
								<td><input type=file name="logo" maxlength=60 value="<?php echo format_str($logo);?>"></td></tr>
						<tr><td>Photograph: </td>
								<td><input type=file name="pic" maxlength=60 value="<?php echo format_str($pic);?>"></td></tr>
						<tr><td>Phone/Cellphone: </td>
								<td><input type=text name="phn" maxlength=60 value="<?php echo format_str($phn);?>">
										<input type=text name="mob" maxlength=60 value="<?php echo format_str($mob);?>"></td></tr>
								<tr><td>Fax No: </td>
								<td><input type=text name="fax" maxlength=60 value="<?php echo format_str($fax);?>">
										</td></tr>
						<tr><td>Address: </td>
								<td><input type=text name="add1" maxlength=60 value="<?php echo format_str($add1);?>">
										<input type=text name="add2" maxlength=60 value="<?php echo format_str($add2);?>"></td></tr>
						<tr><td>Zipcode/Location: </td>
								<td><input type=text name="zip" maxlength=60 value="<?php echo format_str($zip);?>">
										<select name="loc"><?print_dropdown($arr_location,$loc);?></select></td></tr>
						<tr><td>Email/Website: </td>
								<td><input type=text name="mail" maxlength=60 value="<?php echo format_str($mail);?>">
										<input type=text name="web" maxlength=60 value="<?php echo format_str($web);?>"></td></tr>
						<tr><td>Plan: </td>
								<td><select name="pln"><?print_dropdown($ga_plans,$pln);?></select></td></tr>	
						<tr><td valign=top>Details: </td>
								<td><textarea name="det" cols='60' rows='10' id='det'><?php echo format_str($det);?></textarea>
												</td></tr>
						<tr><td valign=top>List Under 1/2/3: </td>
								<td valign=top>
									<select name="lu1"><option value=0 selected>Choose ... </option><? FillCatProductsCombo(0);?></select><Br>
									<select name="lu2"><option value=0 selected>Choose ... </option><? FillCatProductsCombo(0);?></select><br>
									<select name="lu3"><option value=0 selected>Choose ... </option><? FillCatProductsCombo(0);?></select>
								</td></tr>
						<tr><td>Payment Mode: </td>
								<td valign=top><select name="mop"><?print_dropdown($ga_payment,$mop);?></select></td></tr>
						<tr><td>Username: </td>
								<td valign=top><input type=text name="unm" maxlength=30 value="<?php echo format_str($unm);?>"></td></tr>
						<tr><td colspan=2 align=right><input type=submit value="Add"></td></tr>
						</form>
					</table></center>
				
				<?php
				break;
			
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
			//SHOW THE LISTINGS
			default:  // CASE A,M=2
			#&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
				
				?><a href="x_panel.php?m=2">List Companies</a> |  
					<a target=r href="<?php echo $me;?>?m=2&p=<?php echo $p;?>&a=1&t=<? echo COMPANY; ?>">Add</a>
					<!--Add a Profile (<a target=r href="<?php echo $me;?>?m=2&p=<?php echo $p;?>&a=1&t=<? echo PROFESSIONAL; ?>">Professional</a>/>
												 <a target=r href="<?php echo $me;?>?m=2&p=<?php echo $p;?>&a=1&t=<? echo COMPANY; ?>">Company</a>)--> <hr>
<?php
				
				if (!isset($s)) {$s=0;}
				$str_sql="SELECT listing_id, listing_fname, listing_lname, listing_company, listing_addr1, listing_addr2, listing_zip, location_id, listing_type, listing_password, listing_since, listing_email, listing_phone, listing_fax,listing_plan, listing_cat1,  listing_cat2, listing_cat3, listing_username, listing_contact_person, listing_designation, listing_cellphone, listing_website, listing_details, listing_photo, listing_mode_of_payment FROM listings 				WHERE listing_id ";
				$str_sql.=(!$p) ? " >0 " : " =$p ";
				$str_sql.=" ORDER BY listing_since desc, listing_fname, listing_lname";
				if ($s<1) $s=1;
				$lcnt = 1;
				if ($rst=mysql_query($str_sql)) {
					if($r=mysql_num_rows($rst)) {
						while($adata=mysql_fetch_row($rst))  {
							if ($lcnt>=$s && $lcnt<($s+ADMIN_PANEL_PAGE_LIMIT)) {
							
								echo "<li><a target=r href=\"$me?m=2&a=3&i=$adata[0]\">".format_str($adata[1])." (".format_str($adata[3]).")</a>";

#								echo ($adata[3]) ? "<li>".format_str($adata[1])." (".format_str($adata[3]).") " : "<li>".format_str($adata[1]) ;
#								if($adata[8]==3) {
#									echo " | <a target=r href=\"$me?m=10&i=$adata[0]\">Mod</a> ";
#								} else {
#									echo " | <a target=r href=\"$me?m=2&a=3&i=$adata[0]\">Mod</a> ";
#								}								
								
								echo " | <a target=r href=\"$me?m=2&a=5&i=$adata[0]\">Del</a>";
							} 
							if ($lcnt>=($s+ADMIN_PANEL_PAGE_LIMIT)) {break;}
							$lcnt++;	
						} 
						echo "<hr>";
						if ($lcnt>ADMIN_PANEL_PAGE_LIMIT && $s>1) { 
							echo "| <a href=$me?m=2&p=$p&s=".($s-ADMIN_PANEL_PAGE_LIMIT).">Prev</a> ";
						}
						if ($lcnt<=mysql_num_rows($rst)) { 
							echo "| <a href=$me?m=2&p=$p&s=$lcnt>Next</a> ";
						}
					} else {
						print_error("There are no records currently.");
					}
				} else {
					print_error ("Error: ".mysql_error());
				}
			} // END OF CASE 2 SWITCH 
			
		break;
		
		//END OF THE MANAGE LISTINGS BLOCK
	
	##################################################
		//DRAW THE MENU
		case 1: // CASE M
	##################################################
	?>
<b>Menu:</b>
 <a class="menu" target="l" href="<?php echo $me;?>?m=11">Current Affairs</a> | 
 <a class="menu" target="l" href="<?php echo $me;?>?m=12">General Categories</a> | 
 <a class="menu" target="l" href="<?php echo $me;?>?m=9">General Articles</a> | 
 <a class="menu" target="l" href="<?php echo $me;?>?m=3">Company Categories</a> | 
 <a class="menu" target="l" href="<?php echo $me;?>?m=2">Listings</a> | 
 <a class="menu" target="l" href="<?php echo $me;?>?m=7">Locations</a> | 
 <a class="menu" target="r" href="<?php echo $me;?>?m=5">Compose Mail</a> | 
 <a class="menu" target="l" href="x_banner.php">Banners</a> | 
 <a class="menu" target="l" href="listoffers.php">Offers</a> | 
 <a class="menu" target="l" href="pic.php">Pic of the day</a> | 
 <a class="menu" target="l" href="popular_art.php">Popular Articles</a> | 
 <a class="menu" target="l" href="<?php echo $me;?>?m=20">Job Categories</a> | 
 <a class="menu" target="l" href="<?php echo $me;?>?m=21">Job Articles</a> | 
 <a class="menu" target="l" href="subscriber.php">Subscribers</a> | 
 <a class="menu" target="r" href="x_mailer.php">Subscriber Mailer</a> | 
 <a class="menu" target="l" href="x_mastcatlist.php">Master Categories</a> | 
 <a class="menu" target="l" href="x_catbanner.php?show=YES">Category Banners</a> | 
 <a class="menu" target="l" href="x_logolist.php">Logo</a> | 
 <a class="menu" target="l" href="x_eventlist.php?show=YES">Events</a> | 
 <a class="menu" target="l" href="x_eventcatlist.php">Event Categories</a> | 
 <a class="menu" target="l" href="<?php echo $me;?>?m=70">Classified Categories</a> | 
 <a class="menu" target="l" href="<?php echo $me;?>?m=71">Classified Articles</a> | 
 <a class="menu" target=_top href="x_logout.php">Logout</a> 
<?php
	
	##################################################
	//DRAW THE FRAMES
	default:
	##################################################
	
	?><frameset rows="70,*" frameborder='YES' border=0 framespacing=0>
<frame name='m' noresize scrolling=NO src="<? echo $me;?>?m=1"> <frameset cols="240,*" frameborder='YES' border=1 framespacing=1> <frame name='l' src="<?php echo HTML_FOLDER."blank.htm";?>"> <frame name='r' src="<?php echo HTML_FOLDER."blank.htm";?>"> </frameset> </frameset><noframes></noframes> 
<?php
}

//END OF THE MAIN SWITCH BLOCK
mysql_close($dbc);
?>
<SCRIPT 
					src="misc/htmlarea.js" 
					type=text/javascript></SCRIPT>
					
					<SCRIPT 
					src="misc/htmlarea-lang-en.js" 
					type=text/javascript></SCRIPT>
					
					<SCRIPT 
					src="misc/dialog.js" 
					type=text/javascript></SCRIPT>
					
					<STYLE type=text/css>@import url( misc/htmlarea.css );
					</STYLE>
					
					
					<script language="JavaScript">
					var comment = null;
					function initEditor() 
					{
					  comment = new HTMLArea("det");
					  
					  comment.config.editorURL ="misc/";
					  comment.config.sizeIncludesToolbar = false;
					  comment.config.bodyStyle = "background-color: #fff; font-family: arial,helvetica,sans-serif; font-size: x-small";
					  if(document.editlist.a.value!=2 || document.editlist.m.value==71 )
					  {
					  							
						 if(document.editlist.m.value!=71 )
					 	 lid=document.editlist.lid.value;
					  
					  comment.config.toolbar = [
											  [ "fontname", "space" ],
											  [ "fontsize", "space" ],
											  [ "bold", "italic", "underline", "separator" ],
											  [ "justifyleft", "justifycenter", "justifyright", "justifyfull", "linebreak" ],
											  [ "orderedlist", "unorderedlist", "outdent", "indent", "separator" ],
											  [ "forecolor", "backcolor", "textindicator", "separator" ],
											  [ "createlink", "insertimage", "inserttable", "separator" ],
											  [ "htmlmode", "separator" ],
											  [ "popupeditor" ]
											];
					  }
					  else
					  {
					  comment.config.toolbar = [
											  [ "fontname", "space" ],
											  [ "fontsize", "space" ],
											  [ "bold", "italic", "underline", "separator" ],
											  [ "justifyleft", "justifycenter", "justifyright", "justifyfull", "linebreak" ],
											  [ "orderedlist", "unorderedlist", "outdent", "indent", "separator" ],
											  [ "forecolor", "backcolor", "textindicator", "separator" ],
											  [ "createlink", "inserttable", "separator" ],
											  [ "htmlmode", "separator" ],
											  [ "popupeditor" ]
											];
					}
					  
					  
					  comment.generate();
					}
					
					</script> 
					<?
					if(isset($m))
					 if(($m==2)||($m==71))
					echo"</body>";
					?>
					</html>