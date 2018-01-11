<?php
require_once("common.php");
require_once("x_loginfo.php");
include_once("includes/conf.php");
include_once(INCLUDES_FOLDER."x_functions.inc.php");
GetConnected();

if(isset($mode1))		
{
		if($mode1=="ADD")	
		{
			
			$evid=NextID("iEvID","events");
			
			$title=str_replace('\'','&acute;',$title);
			
			$q="insert into events values('$evid','$title','$dfrom','$dto','$time','NA','$desc','$loc','$visi','$flag','$eventcat')";
			mysql_query($q) or die("<b>Error Code:</b>insert events<br><b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);
			
			
			if(is_uploaded_file($HTTP_POST_FILES['picfile']['tmp_name']))
			{ 
				
				$newname = $evid . "_pic_" . $picfile_name;
				$dir = opendir(UPLOAD_EVENT);				
				@chmod(UPLOAD_EVENT,0777);
				copy($HTTP_POST_FILES['picfile']['tmp_name'],UPLOAD_EVENT. $newname); 				  			
				
				$q1="update events set vPic='$newname' where iEvID='$evid'";
				mysql_query($q1) or die("<b>Error Code:</b>insert events<br><b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);
				
				@chmod(UPLOAD_EVENT,0000);
				
			}
			?><script>parent.l.document.location.reload(true);</script><?
			print_message("<br>Insertion Successful.<br>");
		}
		
			if($mode1=="UPDATE")			
			{
			$title=str_replace('\'','&acute;',$title);
			$q="update events set vTitle='$title',dSDate='$dfrom',dEDate='$dto',vTime='$time',bDesc='$desc',vLocation='$loc',cVisibility='$visi',cFlag='$flag',iEvCatID='$eventcat' where iEvID='$evid'";
			mysql_query($q) or die("<b>Error Code:</b>update events<br><b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);
				
				if(is_uploaded_file($HTTP_POST_FILES['picfile']['tmp_name']))
				{ 
					$pic_name=GetFileName('vPic','events','iEvID',$evid);
					$dir = opendir(UPLOAD_EVENT);				
					@chmod(UPLOAD_EVENT,0777);
					
							while ($file_name = readdir($dir)) 
							{				 
								if($file_name==$pic_name)
								{
								$f= UPLOAD_EVENT. $file_name;					
								unlink ($f);
								}
							}
							
					@chmod(UPLOAD_EVENT,0000);									
					closedir($dir);
					$newname = $evid . "_pic_" . $picfile_name;
					$dir = opendir(UPLOAD_EVENT);				
					@chmod(UPLOAD_EVENT,0777);
																
					copy($HTTP_POST_FILES['picfile']['tmp_name'],UPLOAD_EVENT. $newname); 				  			
					
					$q1="update events set vPic='$newname' where iEvID='$evid'";
					mysql_query($q1) or die("<b>Error Code:</b>update events<br><b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);
					
					@chmod(UPLOAD_EVENT,0000);
					
				}
				?><script>parent.l.document.location.reload(true);</script><?
				print_message("<br>Updation Successful<br>");
			}
			if($mode1=="DELETE")	 
			{							
					$pic_name=GetFileName('vPic','events','iEvID',$evid);
					$dir = opendir(UPLOAD_EVENT);				
					@chmod(UPLOAD_EVENT,0777);
					while ($file_name = readdir($dir)) 
					{				 
						if($file_name==$pic_name)
						{
							$f= UPLOAD_EVENT.$file_name;					
							unlink ($f);
						}
					}
					@chmod(UPLOAD_EVENT,0000);									
					closedir($dir);
					
					$qdel="delete from events where iEvID='$evid'";
					mysql_query($qdel) or die("<b>Error Code:</b>delete events<br><b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);
									
					?><script>parent.l.document.location.reload(true);</script><?			
					print_message("<br>Deletion Successful<br>");
			}
								
}				

?>

<html>
<head>
<title>DigitalGoa.com- Goa, Goa Holidays, Goa Centric Portal, Goa Yellow Pages, Explore Goa, Goa Breaking News, Goa News, Goa Current Affairs, Goa Events</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="dg.css" rel="stylesheet" type="text/css">
<link href="html/b.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="scripts/calendar.js"></script>
<script type="text/javascript" src="scripts/calendar-setup.js"></script>
<script type="text/javascript" src="scripts/calendar-en.js"></script>
<script type="text/javascript" src="scripts/calendar_stuff.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="scripts/calendar-blue.css" title="win2k-cold-1">
<script language="JavaScript">
function check()
{
	if(document.form1.title.value=='')
	{
	alert("Title Cannot Be Left Blank");
	return false;
	}
	
	if(document.form1.dfrom.value=='')
	{
	alert("From Date Cannot Be Left Blank");
	return false;
	}
	
	if(document.form1.dto.value=='')
	{
	alert("To Date Cannot Be Left Blank");
	return false;
	}
	
	date1=document.form1.dfrom.value;
	date2=document.form1.dto.value;

	msg="To Date Cannot Precede From Date";
	return range(date1,date2,msg);
	
return true;
}

function range(date1,date2,msg)
{
		yr1=date1.substring(0,4);
		mn1=date1.substring(5,7);
		dy1=date1.substring(8,10);
		yr2=date2.substring(0,4);
		mn2=date2.substring(5,7);
		dy2=date2.substring(8,10);

		if(yr1==yr2)
			{
			if(mn1==mn2)
				{
				if(dy1<=dy2)
				return true;
					else
					{
					alert(msg);
					return false;
					}
				}
				else
				if(mn1<mn2)
				return true;
				else
				{
				alert(msg);
				return false;
				}
			}
		else
		if(yr1<yr2)
		return true;
		else
		{
		alert(msg);
		return false;
		}
}

</script>

</head>

<body>
	<form method="post" action="x_eventedit.php" enctype="multipart/form-data" name='form1'>			
<?php  
	if(isset($mode))
		{
		if($mode=='A') 
			{
			?>
		
  <table border='0' cellspacing='2' cellpadding='2' align='center' class='bdr'>
    <tr class=hdr> 
      <td align=center colspan='2'><div align='center'><strong>Add New Event:</strong></div></td>
    </tr>
    <tr> 
      <td class='dt'><div id='title'><strong>Title:</strong></div></td>
      <td class='dt'><input type='text' name='title' id='Title' value=''  maxlength='200' size=40></td>
    </tr>
    <tr> 
      <td class='dt'><div id='dfromdiv'><strong>From:</strong></div></td>
      <td class='dt'><input type='text' name='dfrom' id='dfrom' readonly size='10'><input name="reset" type="reset" class="box" onclick="return showCalendar('dfrom', '%Y-%m-%d ', '24', true);" value=" V "></td>
    </tr>
    <tr> 
      <td class='dt'><div id='dtodiv'><strong>To:</strong></div></td>
      <td class='dt'><input type='text' name='dto' id='dto' readonly size='10'><input name="reset" type="reset" class="box" onclick="return showCalendar('dto', '%Y-%m-%d ', '24', true);" value=" V "></td>
    </tr>
    <tr>
      <td class='dt'><strong>Category:</strong></td>
      <td class='dt'><select name="eventcat">
            <? FillEventCatsCombo(); ?>
        </select></td>
    </tr>
    <tr> 
      <td class='dt'><strong>Time:</strong></td>
      <td class='dt'><input type='text' name='time' id='Time' value=''  maxlength='100'></td>
    </tr>
    <tr> 
      <td class='dt'><div id='loc'><strong>Location:</strong></div></td>
      <td class='dt'><input type='text' name='loc' id='Location' value=''  maxlength='200'></td>
    </tr>
    <tr> 
      <td class='dt'><div id='desc'><strong>Description:</strong></div></td>
      <td class='dt'><textarea name="desc" id='Description' rows="5" cols='30'></textarea></td>
    </tr>
    <tr> 
      <td class='dt'><div id='picfile'><strong>Picture:</strong></div></td>
      <td class='dt'><input type='file' name='picfile' id='Picture'></td>
    </tr>
    <tr> 
      <td class='dt'><strong>Visibility:</strong></td>
      <td class='dt'> <input type='radio' name='visi' value='Y' checked>
        YES&nbsp;&nbsp; <input type='radio' name='visi' value='N' >
        NO </td>
    </tr>
    <tr> 
      <td class='dt'><strong>Flag:</strong></td>
      <td class='dt'> <input type='radio' name='flag' value='Y' checked>
        YES&nbsp;&nbsp; <input type='radio' name='flag' value='N' >
        NO </td>
    </tr>
    <tr> 
      <td colspan='2' class=dt> <center>
          <input type='submit' value='SUBMIT' onClick='return check();'>
        </center></td>
    </tr>
  </table>
			<input type='hidden' name='mode1' value='ADD'>
			
		<? }  
				
				
		if($mode=="E")	
		{
			//$rs2=Q_GetEventMaster($evid);
			$qev="select * from events where iEvID='$evid'";
			$rs2=mysql_query($qev) or die("<b>Error Code:</b>events<br><b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME"). "<br><b> Query : </b>" . $query);
			list($evid,$title,$dfrom,$dto,$time,$pic,$desc,$loc,$visi,$flag,$eventcat)=mysql_fetch_array($rs2);
			
			?>				
			
  <table  border='0' cellspacing='2' cellpadding='2' align='center' class='bdr'>
    <tr class=hdr> 
      <td align=center  colspan=2><div ><strong>Update Event: </strong></div></td>
    </tr>
    <tr> 
      <td class=dt><strong>Title:</strong></td>
      <td class=dt><input size=40 type='text' name='title' id='Title' value="<? echo $title; ?>"  maxlength='200'></td>
    </tr>
    <tr> 
      <td class='dt'><div id='dfromdiv'><strong>From:</strong></div></td>
      <td class='dt'><input name='dfrom' type='text' id='dfrom' value='<? echo $dfrom; ?>' size="10" readonly><input name="reset" type="reset" class="box" onclick="return showCalendar('dfrom', '%Y-%m-%d ', '24', true);" value=" V "></td>
    </tr>
    <tr> 
      <td class='dt'><div id='dtodiv'><strong>To:</strong></div></td>
      <td class='dt'><input name='dto' type='text' id='dto' value='<? echo $dto; ?>' size="10" readonly><input name="reset" type="reset" class="box" onclick="return showCalendar('dto', '%Y-%m-%d ', '24', true);" value=" V "></td>
    </tr>
    <tr> 
      <td class='dt'><strong>Category:</strong></td>
      <td class='dt'><select name="eventcat">
          <? FillEventCatsCombo($eventcat); ?>
        </select></td>
    </tr>
    <tr> 
      <td class='dt'><strong>Time:</strong></td>
      <td class='dt'><input type='text' name='time' id='Time' value='<? echo $time; ?>'  maxlength='100'></td>
    </tr>
    <tr> 
      <td class='dt'><div id='loc'><strong>Location:</strong></div></td>
      <td class='dt'><input type='text' name='loc' id='Location' value='<? echo $loc; ?>'  maxlength='200'></td>
    </tr>
    <tr> 
      <td class='dt'><div id='desc'><strong>Description:</strong></div></td>
      <td class='dt'><textarea name="desc" id='Description' rows="5" cols='30'><? echo $desc; ?></textarea></td>
    </tr>
    <tr> 
      <td class=dt><strong>Picture:</strong></td>
      <td class=dt><input type='file' name='picfile' id='Picture'> 
        <? if($pic!='NA'&&$pic!=''){?>
        &nbsp;<a href='pic_disp.php?id=<? echo $evid; ?>&mode=EVENT' target='_blank'>View</a> 
        <? } ?>
      </td>
    </tr>
    <tr> 
      <td class=dt><strong>Visibility:</strong></td>
      <td class=dt> <input type='radio' name='visi' value='Y' <? if($visi=='Y')echo "checked"; ?>>
        YES&nbsp;&nbsp; <input type='radio' name='visi' value='N' <? if($visi=='N')echo "checked"; ?>>
        NO </td>
    </tr>
    <tr> 
      <td class=dt><strong>Flag:</strong></td>
      <td class=dt> <input type='radio' name='flag' value='Y' <? if($flag=='Y')echo "checked"; ?>>
        YES&nbsp;&nbsp; <input type='radio' name='flag' value='N' <? if($flag=='N')echo "checked"; ?>>
        NO </td>
    </tr>
    <tr> 
      <td colspan=2 align=center  class=dt> <div align='center'> 
          <input type='submit' value='SUBMIT' onClick='return check();'>
        </div>
        <div align="right"><a href='x_eventedit.php?evid=<? echo $evid; ?>&mode1=DELETE'>Delete</a></div></td>
    </tr>
  </table>
				<input type='hidden' name='mode1' value='UPDATE' >
				
				<input type='hidden' name='evid' value='<? echo $evid; ?>'>
		<?
		}
	}
		?>
</form>
</body>
</html>
