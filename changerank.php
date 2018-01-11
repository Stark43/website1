<?php
require_once('common.php');
GetConnected();

if(isset($mode))
{
if($mode=='CHANGE')				
	{	
		if($mode1=='MASTER')
		{					
			$srno=1;
			
			foreach($topics as $value)				//topics value taken from javascript function from rank.js
			{			
				$q = "update cat_master set iRank=$srno where iMCatID=$value";
				$r = mysql_query($q) or die ("<b>Error Code:</b>CHGRNK02<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
								
				$srno++;			
			}
		}
		
		if($mode1=='CAT')
		{
			$srno=1;
			
			foreach($topics as $value)				//topics value taken from javascript function from rank.js
			{			
				$q = "update ct_banner set iRank=$srno where iCBID=$value";
				$r = mysql_query($q) or die ("<b>Error Code:</b>CHGRNK04<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
								
				$srno++;			
			}
		
		
		}
		
		if($mode1=='MASTCATS')
		{					
			$srno=1;
			
			foreach($topics as $value)		//topics value taken from javascript function from rank.js
			{		
				list($val,$type)=explode("~",$value);
				$q = "update mast_cat_linkage set iRank=$srno where iMCatID=$txtID and iCatID='$val' and cType='$type'";
				$r = mysql_query($q) or die ("<b>Error Code:</b>CHGRNK06<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
								
				$srno++;			
			}
		}
		
		if($mode1=='SUBCATS')
		{					
			$srno=1;
			
			foreach($topics as $value)		//topics value taken from javascript function from rank.js
			{		
				if($type=='COMP')
				{
				$q = "update cat_products set iRank=$srno where cat_product_id=$value";				
				}
				if($type=='GENL')
				{
				$q = "update cat_general_database set iRank=$srno where cat_gd_id=$value";				
				}
				if($type=='JOB')
				{
				$q = "update job_categories set iRank=$srno where iJID=$value";				
				}
				
				
				$r = mysql_query($q) or die ("<b>Error Code:</b>CHGRNK08<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
								
				$srno++;			
			}
		}
		
		
		if($mode1=='EVENTCAT')
		{					
			$srno=1;
			
			foreach($topics as $value)				//topics value taken from javascript function from rank.js
			{			
				$q = "update event_cats set iRank=$srno where iEvCatID=$value";
				$r = mysql_query($q) or die ("<b>Error Code:</b>CHGRNK10<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
								
				$srno++;			
			}
		}
					
	}

}


if($mode1=='MASTER')
$title="Master Categories";
if($mode1=='CAT')
$title="Banners";
if($mode1=='MASTCATS')
$title=GetMastCatNameFromiMCatID($txtID)." -- Categories";
if($mode1=='SUBCATS')
{
		if($type=="COMP")
		$type1='C';
		 if($type=="GENL")
		 $type1='G';
		 if($type=="JOB")
		 $type1='J';
$title=GetCategoryNameFromTypeAndID($type1,$txtID)." -- Sub-Categories";
}
if($mode1=='EVENTCAT')
$title="Event Categories";

?>

<html>
<head>
<title>Change Rank</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css"><!--
  .btn   { BORDER-WIDTH: 1; width: 26px; height: 24px; }
  .btnDN { BORDER-WIDTH: 1; width: 26px; height: 24px; BORDER-STYLE: inset; BACKGROUND-COLOR: buttonhighlight; }
  .btnNA { BORDER-WIDTH: 1; width: 26px; height: 24px; filter: alpha(opacity=25); }
--></style>
<!-- END : EDITOR HEADER -->
<link href="dg.css" rel="stylesheet" type="text/css">
<link href="html/b.css" rel="stylesheet" type="text/css">
<?
if($mode1=='MASTER')
{
?>
<script language="JavaScript">
function just_reload()
{
	d=document.form1.txtID.value;
	window.opener.parent.r.location="x_mastcat_edit.php?mode=E&id="+d;
}


</script>
<?
}

if($mode1=='EVENTCAT')
{
?>
<script language="JavaScript">
function just_reload()
{
	d=document.form1.txtID.value;
	window.opener.parent.r.location="x_eventcatedit.php?mode=E&id="+d;
}


</script>
<?
}

?>
</head>

<body <? if($mode1=='MASTER' || $mode1=='EVENTCAT') print("onLoad='just_reload()'"); ?>>


<SCRIPT language="JavaScript" src="scripts/rank.js"></SCRIPT>	<!-- File containing listbox moving functions -->
<script language="JavaScript">
function subcat()
{
i=document.form1.topics.value
id=document.form1.txtID.value
a=i.split('~');
parent.document.location="changerank.php?mode1=SUBCATS&txtID="+a[0]+"&type="+a[1]+"&mastid="+id;
}
</script>

<form method='post' action='changerank.php?mode=CHANGE' name='form1'>
<br>
<p>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
    <tr> 
      
    <td width="30%" class="formcaption"><? echo $title; ?></td>
      
    </tr>
	</table></p>
	<table  width="94%" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td width='29%'>
<?	
if(isset($mode1))
{
if($mode1=='MASTER')
{
	$checkq = "select iMCatID,vName,iRank from cat_master order by iRank";   
	$result = mysql_query($checkq) or die ("<b>Error Code:</b>CHGRNK01<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
			
				$n=0;
				print( "<select name=topics[] id='topics' size=10 class=box multiple>");
				while(list($mcatid,$name,$rank)=mysql_fetch_row($result))
				{
					 if($txtID==$mcatid)				 
					 print( "<option value=$mcatid selected> $name</option>") ;  
					 else
					 print( "<option value=$mcatid> $name </option>"); 
					 
					
				}
				print( "</select>");
				
				print("<input type='hidden' name='txtID' value='$txtID'>");
}

if($mode1=='CAT')
{
	$type=GetCatTypeFromCBID($txtID);
	$catid=GetCatIDFromCBID($txtID);
	
	
$nm=GetCategoryNameFromTypeAndID($type,$catid);

print("</td></tr><tr align='center' ><td width='35%' colspan='3' ><strong>".$nm."</strong></td></tr><tr><td>");
	
		$checkq = "select iCBID,vFile,iRank from ct_banner where iCatID='$catid' order by iRank";   
		$result = mysql_query($checkq) or die ("<b>Error Code:</b>CHGRNK03<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
			
				$n=0;
				print( "<select name=topics[] id='topics' size=10 class=box multiple>");
				while(list($mcatid,$name,$rank)=mysql_fetch_row($result))
				{
					 if($txtID==$mcatid)				 
					 print( "<option value=$mcatid selected> $name</option>") ;  
					 else
					 print( "<option value=$mcatid> $name </option>"); 
					 
					
				}
				print( "</select>");
				
				print("<input type='hidden' name='txtID' value='$txtID'>");
	
	


}

if($mode1=='MASTCATS')
{	
	$checkq = "select iCatID,cType,iRank from mast_cat_linkage where iMCatID='$txtID' order by iRank";   
	$result = mysql_query($checkq) or die ("<b>Error Code:</b>CHGRNK05<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
			
			if(mysql_num_rows($result))
			{
				$n=0;
				print( "<select name=topics[] id='topics' size=14 class=box multiple>");
				while(list($catid,$type,$rank)=mysql_fetch_row($result))
				{
					 if($type=="COMP")
					 $type1='C';
					 if($type=="GENL")
					 $type1='G';
					 if($type=="JOB")
					 $type1='J';
					 
					 $name=GetCategoryNameFromTypeAndID($type1,$catid);
					 if($n==0)				 
					 print( "<option value=$catid~$type selected> $name </option>"); 
					 else
					  print( "<option value=$catid~$type > $name </option>"); 
					 
					$n++;
				}
				print( "</select>");
			}
			else
			print("No Categories Listed ...");
			
				print("<input type='hidden' name='txtID' value='$txtID'>");
}

if($mode1=='SUBCATS')
{		
	
	if($type=='COMP')
	{
		$checkq = "select cat_product_id,iRank from cat_products where cat_product_linked_id=$txtID order by iRank";
	}
	if($type=='GENL')
	{
		$checkq = "select cat_gd_id,iRank from cat_general_database where cat_gd_parent_id=$txtID order by iRank";
	}
	if($type=='JOB')
	{
		$checkq = "select iJID,iRank from job_categories where iParentID=$txtID order by iRank";
	}
	  
	$result = mysql_query($checkq) or die ("<b>Error Code:</b>CHGRNK07<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
			
			if(mysql_num_rows($result))
			{
				$n=0;
				print( "<select name=topics[] id='topics' size=14 class=box multiple>");
				while(list($catid,$rank)=mysql_fetch_row($result))
				{
									 
					 $name=GetCategoryNameFromTypeAndID($type1,$catid);
					 if($n==0)				 
					 print( "<option value=$catid selected> $name </option>"); 
					 else
					  print( "<option value=$catid > $name </option>"); 
					 
					$n++;
				}
				print( "</select>");
			}
			else
			print("No Categories Listed ...");
			
				print("<input type='hidden' name='type' value='$type'>");			
				print("<input type='hidden' name='txtID' value='$txtID'>");
				print("<input type='hidden' name='mastid' value='$mastid'>");
				
}

if($mode1=='EVENTCAT')
{
	$checkq = "select iEvCatID,vName,iRank from event_cats order by iRank";   
	$result = mysql_query($checkq) or die ("<b>Error Code:</b>CHGRNK09<b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br>Please report this error to the System Administrator. Thanks.");
			
				$n=0;
				print( "<select name=topics[] id='topics' size=10 class=box multiple>");
				while(list($evcatid,$name,$rank)=mysql_fetch_row($result))
				{
					 if($txtID==$evcatid)				 
					 print( "<option value=$evcatid selected> $name</option>") ;  
					 else
					 print( "<option value=$evcatid> $name </option>"); 
					 
					
				}
				print( "</select>");
				
				print("<input type='hidden' name='txtID' value='$txtID'>");
}

}
	?>
			</td><td >			
			<p>									<!--  To move up in the list  Javascript function   rank.js  -->			<input type='hidden' name='title' value='<? echo $title; ?>'>
				<input type='hidden' name='mode1' value='<? echo $mode1; ?>'>
			  <input type="button" name="Button" class="box" onclick='Move(document.form1.topics,1)' value="  ^  ">		
			</p>
			<p> 								<!--  To move down in the list  Javascript function    rank.js -->
			  <input type="button" name="Button" class="box" value="  v  " onclick='Move(document.form1.topics,0)'>
			</p>
			</td><? if($mode1=="MASTCATS")
				{
				?><td align="center">To change rank of sub-categories, choose category and click Here <br><input type="button" onClick="subcat();" value=' >> '></td>
				<?
				}
				?>
				
				</tr><tr><td <? if($mode1=="MASTCATS"){?>
				colspan="2"
				<? } ?>
				><br><p> 				<!--  To select all in the list for updation Javascript function    rank.js -->
			
			  <input type="button" name="Submit" value="U P D A T E" class="box" onclick='selectall(document.form1.topics)'></p></td><td><br><? if($mode1=='SUBCATS') print("<a href='changerank.php?mode1=MASTCATS&txtID=$mastid'>Go Back</a>"); ?></td>
			</tr></table>
<tr><td>

</form>
<br><br><br><br>
<p>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr valign="bottom" > 
 <hr  size="1">
 </hr>
 <td  align="center" >						<!--  To close this window -->
  <a href="#" onClick="window.close()"  ><strong>CLOSE WINDOW</strong></a>
  <hr  size="1"></hr>
	</td>
  </tr>
</table></p>


</body>
</html>

