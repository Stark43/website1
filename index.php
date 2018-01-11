<?php
//include_once("includes/conf.php");
require_once("common.php");

getconnected();


if(isset($modesend))
if($modesend=='SEND')
{		
	$mail=GetEmailFromListingID($listID);
	$listcompname=GetXFromYID("select listing_company from listings where listing_id='$listID'");

	$headers = "MIME-Version: 1.0\r\n"; 
	$headers.= "Content-type: text/html; charset=iso-8859-1\r\n";  
	$headers.= "From: $name <$email>\r\n";
	$headers.= "Reply-To: $name <$email>\r\n";

	$subject="Enquiry Via DigitalGoa.com";
				
	$response = mail ( $mail, $subject , $message, $headers);			
	$response = mail ("digitalg@digitalgoa.com", $subject." For ".$listcompname , $message, $headers);		
}

$res=GetOfferID('H','Y'); // get the OID for popups on home page

#	CODE TO CHECK IF THE CUSTOMER IS TRYING TO VIEW THE COMPANY DETAILS
if(isset($q))
if (strlen(trim($q))>0) $m=2;
#	CODE TO CHECK IF THE CUSTOMER IS TRYING TO VIEW THE COMPANY DETAILS


//////////////// GETTING DATA FROM cat_general_database TABLE ////////////////////////
	$q1 = "SELECT * FROM cat_general_database WHERE cat_gd_parent_id=0 ORDER BY cat_gd_name ASC";
	$r1 = mysql_query($q1) or die ("<b>Error Code:</b>IND01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q1);

	$q2 = "SELECT * FROM news where news_is_archived = 0";
	$r2 = mysql_query($q2) or die ("<b>Error Code:</b>IND02 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q2);
	
	/* $q3 = "select * from listings order by listing_since desc limit 10";
	$r3 = mysql_query($q3) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q3); */
	//Displays Vacancies 
	$qvc="select * from job_categories where iParentID=0";
	$rvc = mysql_query($qvc) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $qvc);
	
	$qvcl = "select * from classifiedcats where iParentID=0 order by iRank";
	$rvcl = mysql_query($qvcl) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $qvcl);	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>DigitalGoa.com- Goa, Goa Holidays, Goa Centric Portal, Goa Yellow Pages, Explore Goa, Goa Breaking News, Goa News, Goa Current Affairs, Goa Events</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<META content="DIGITAL GOA.COM, GOA CENTRIC WEBSITE WHICH PROVIDES COMPREHENSIVE INFORMATION ON EVERY ASPECT OF GOA AND GOAN PEOPLE THROUGH ITS POPULAR COLUMNS LIKE CURRENT AFFAIRS, ONLINE YELLOW PAGES AND EXPLORE GOA" name="description">

<META content="goa tourism, goa, goa news, goa hotels, goa restaurants, goa travel, goa shopping, current affairs, India, goans, goa companies, goem, gomantak, goa news, goa government,events in Goa, comprehensive news coverage on goa updated daily, goan politics, goan cuisine, goan culture, folk culture, goan entertainment, goan classifieds, real estates, goa jobs, photo gallery " name="keywords">

<link href="dg.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="scripts/dg.js"></script>
<script language="JavaScript">

function checktxtemail(s)
{
	a=new Array();
	//s=document.frmreservation.txtemail.value;
	for(i=0; i<s.length; i++)
	{
		a[i]=s.charAt(i);
	}
	
	dot = s.indexOf(".");
	at   = s.indexOf("@");
	
	if (dot == -1 || at == -1)
	{
		document.send.email.focus()
		alert ("Email id does not exist");
		return 1;
	}

	str1=s.substring(dot+1,s.length);
	str2=s.substring(at+1, dot);
	str3=s.substring(0,at);

	if((str2.length==0)||(str3.length==0))
	{
		document.send.email.focus()     
		alert ("Invalid email id");
		return 1;
	}

	return 0;
}
function check()
{

if(document.send.name.value=='')
{
alert("Please Enter Your Name");
return false;
}

if(document.send.email.value=='')
{
alert("Please Enter Your Email Address");
return false;
}

if(checktxtemail(document.send.email.value))
{
return false;
}


if(document.send.message.value=='')
{
alert("Please Enter Your Message");
return false;
}

return true;
}
</script>
</head> 

<body leftmargin="0" topmargin="0">
<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="16" colspan="3" class="bluebdr">&nbsp;&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr> 
    <td height="71" colspan="3"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="31%" height="66"><a href="index.php"><img src="<? print(Get_Logo_Path()); ?>" alt="GOA NEWS, GOA EVENTS, GOA HOLIDAYS, GOA YELLOW PAGES," width="225" height="57" border="0"></a></td>
          <td width="69%"> <? require_once("topmenu.php");?> </td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td colspan="3"> 
	<? require_once("side_prints_prod3.php"); ?>
    </td>
  </tr>
  <tr> 
    <td colspan="3"> <table border=0 cellspacing=1 cellpadding=0 width=100%>
        <tr> 
          <td width=245> 
            <? InsertBanner(1,245,75); ?>
          </td>
          <td width=245> 
            <? InsertBanner(2,245,75); ?>
          </td>
          <td width=245> 
            <? InsertBanner(3,245,75); ?>
          </td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td height="10" colspan="3" class="ticker"> 
      <table width="100%" border="0" cellspacing="3" cellpadding="3">
        <tr> 
          <td width="15%" height="10" class="cadata" ><strong>TODAY'S EVENTS</strong></td>
          <td width="63%" class="cadata" height="10"><marquee behavior="scroll" direction="left" scrollamount="3" id="marq" onMouseOver="marq.stop()" onMouseOut="marq.start()">
            <?php
				DispEventsMarquee();
			?>
            </marquee></td>
          <td width="22%" class="cadata"><div class="cadata">
              <div align="center"><? if(strlen($q)<=0) { ?><a href="#event"><strong>UPCOMING EVENTS </strong></a><? } ?></div>
            </div></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td width="150" rowspan="4" class="sobg" valign="top"> &nbsp; <div class="intro"> 
        <?
	ShowOffer(0,'H','N');
	?>
      </div></td>
  
  </tr>
  <!-- the following table should not be shown IF THE CUSTOMER IS TRYING TO VIEW THE COMPANY DETAILS-->
  <!-- replace it with the company details template using the listing username available when called-->
  <? 
 //$q="savoiplantation";
	if(strlen($q)>0)
		{
			$q1="select * from listings where listing_username='$q'";
			$r1 = mysql_query($q1) or die ("<b>Error Code:</b>IND01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q1);			
			
			$RST= mysql_fetch_object($r1);
	?>
  <tr valign="top"> 
    <td colspan=2  valign='top' width=610 >
	 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="yptable">
        <tr> 
          <td class="yptitle"><img src="images/yptitle.gif" width="100" height="14"></td>
        </tr>
       <tr> 
          <td class="cadisp"> <strong> 
            <?php 
				if(mysql_num_rows($r1)==0)
				echo "<div class=ypdata>No Company found</div>";
				else
				echo "$RST->listing_company";
				?>
            </strong> </td>
        </tr>
        <tr valign="top"> 
          <td valign="top" >
            <?php
				if(mysql_num_rows($r1)!=0)
				{			
				  if(isset($showpage))
				  if($showpage=='NO')
				  unset($showpage);
				  
				  if(!isset($showpage))
				  {
					print("<table width='100%' border='0' cellspacing='0' cellpadding='0'>");
					
						  if(isset($RST->listing_logo) && trim($RST->listing_logo)<>"")
						{		
							print("<tr>\n");
							print("<td colspan=2 align='center'>");
							print("<img src='./listing_images/$RST->listing_logo' >");
							print("</td></tr>\n");
						}
						  
					print("<tr><td width='60%' valign='top'>&nbsp;\n");
					
					print("<table width=95% border=0 cellspacing=2 cellpadding=0 align='center'>\n");			
					
					
					////////////////////////////// listing name
				  if(isset($RST->listing_fname)&&(trim($RST->listing_fname)<>""))
					{	print("<tr>\n");
					  print("<td width=32% class='ybox'>");
						print("<strong>Name :</strong>");
					  print("</td>\n");
					
					
					
					  print("<td class='ybox'>&nbsp;");
					
						print("$RST->listing_fname"." "."$RST->listing_lname");
						
					  print("</td>\n");
					print("</tr>\n");
					}
					
				////////////////////////////// listing address
				
				 if(isset($RST->listing_addr1)&&(trim($RST->listing_addr1)<>""))
				 {
				 
					print("<tr>\n");
					  print("<td width=32% class='ybox'>");
						print("<strong>Address :</strong>");
					  print("</td>\n");
					
					
					  print("<td class='ybox'>&nbsp;");
						print("$RST->listing_addr1");
						
						if(isset($RST->listing_addr2))
						print("<br>&nbsp;$RST->listing_addr2");
						
					  print("</td>\n");
					print("</tr>\n");
				
				}
				
			/*	 if(isset($RST->listing_addr2)&&(trim($RST->listing_addr2)<>""))
				 {
						print("<tr>\n");
						print("<td width=30>&nbsp;</td>\n");
						  print("<td class='ybox'>&nbsp;");
							print("$RST->listing_addr2");
						  print("</td>\n");
						print("</tr>\n");
				 }
			*/
					
					
					////////////////////////////// listing designation
				  if(isset($RST->listing_designation)&&(trim($RST->listing_designation)<>""))
					{
						print("<tr>\n");
					  print("<td width=32% class='ybox'>");
						print("<strong>Designation :</strong>");
					  print("</td>\n");
					
					  print("<td class='ybox'>&nbsp;");
					
						print("$RST->listing_designation");
						
					  print("</td>\n");
					print("</tr>\n");
					}
					
				//////////////////////// listing zip
					
						
					  if(isset($RST->listing_zip)&&(trim($RST->listing_zip)<>""))
					{
						print("<tr>\n");
						  print("<td class='ybox'>");
							print("<strong>Zip Code : </strong>");
						  print("</td>\n");
						
						  print("<td class=ybox>&nbsp;");
					
							print("$RST->listing_zip");
							
						  print("</td>\n");
						print("</tr>\n");
				
					}
				//////////////////////////////// listing email
/*
					  if(isset($RST->listing_email)&&(trim($RST->listing_email)<>""))
					{
						print("<tr>");
						  print("<td class='ybox'>");
							print("<strong>Email Address : </strong>");
						  print("</td>");
						
						  print("<td class=ybox>&nbsp;");
					
							print("<a href='mailto:$RST->listing_email'>$RST->listing_email</a>");
							
						  print("</td>");
						print("</tr>");
					} */
				//////////////////////////////// listing phone
					
						
					  if(isset($RST->listing_phone)&&(trim($RST->listing_phone)<>""))
					{
						print("<tr>\n");
						  print("<td class='ybox'>\n");
							print("<strong>Phone No : </strong>");
						  print("</td>\n");
						
						  print("<td class=ybox>&nbsp;");
					
							print("$RST->listing_phone");
							
						  print("</td>\n");
						print("</tr>\n");
				}
					
					
					//////////////////////////////// listing cell phone
					
						  if(isset($RST->listing_cellphone)&&(trim($RST->listing_cellphone)<>""))
					{	
				
						print("<tr>\n");
						  print("<td class='ybox'>");
							print("<strong>Mobile: </strong>");
						  print("</td>\n");
						
						  print("<td class=ybox>&nbsp;");
					
							print("$RST->listing_cellphone");
							
						  print("</td>\n");
						print("</tr>\n");
					}
					
					
				//////////////////////////////// listing fax
					
						
					  if(isset($RST->listing_fax)&&(trim($RST->listing_fax)<>""))
					{
						print("<tr>\n");
						  print("<td class='ybox'>");
							print("<strong>Fax : </strong>");
						  print("</td>\n");
						
						  print("<td class=ybox>&nbsp;");
					
							print("$RST->listing_fax");
							
						  print("</td>\n");
						print("</tr>\n");
					}
					
				//////////////////////////////// listing website
					
				  if(isset($RST->listing_website)&&(trim($RST->listing_website)<>""))
					{	
				
						print("<tr>\n");
						  print("<td  class='ybox'>");
							print("<strong>Website : </strong>");
						  print("</td>\n");
						
						  print("<td class=ybox>&nbsp;");
					
							print("<a href='http://$RST->listing_website'>$RST->listing_website</a>");
							
						  print("</td>\n");
						print("</tr>\n");
					}
					print("</table>\n");
					
#########################################################################
// this puts the message box on the right side - modified by dave on 17 September 05
print("</td><td valign=top><br>");
//print("<table width=95% border=2 cellspacing=0 cellpadding=0 align='right'>\n");
//print("<tr><td>");

$zx=GetEmailFromListingID($RST->listing_id);
				
				if($zx!='0')
				{
				
		$listusername=GetXFromYID("select listing_username from listings where listing_id='$RST->listing_id'");

				print("<table width='85%' border='0' cellspacing='1' cellpadding='0' align='center' bordercolor='#FDF8C0'>");
				print("<form method='post' action='http://www.digitalgoa.com/$listusername' name='send'>");

				print("<input type='hidden' name='modesend' value='SEND'>");
				print("<input type='hidden' name='listID' value='$RST->listing_id'>");
				print("<tr align='center'><td height=20 colspan='2'  class='yboxhdr' bgcolor='#FEE19D' ><strong>Contact The Company For More Details</strong></td></tr>");
				print("<tr align='center'><td class='ybox1' width=100>Your Name: </td><td class='ybox1'><input type='text' name='name' class='box' size='30'></td></tr>");
				print("<tr align='center'><td class='ybox1'>Your Email: </td><td class='ybox1'><input type='text' name='email' class='box' size='30'></td></tr>");
				print("<tr><td class='ybox1' colspan=2>Message:</td></tr><tr><td colspan=2 class='ybox1'><textarea name='message' rows='6' cols='50' class='box'></textarea></td></tr>");
				print("<tr align='center'><td colspan='2' align='center' class='yboxhdr' bgcolor='#FDF8C0'><input type='submit' value='SEND MESSAGE' onClick='return check()' class='box'></td></tr></form></table>");
				
				}
				

//print("</td></tr>");
//print("</table>");

##########################################################################					
							
				print("</td>\n</tr>\n");
				
				
				print("<tr><td colspan=2>".DisplayCaptions($RST->listing_id)."</td></tr>");
			
				
				
				//////////////////////////////// listing Details
					if(isset($RST->listing_details)&&(trim($RST->listing_details)<>""))
					{
									
						print("<tr><td colspan=2>");
						
					
						  
						////////////////////////////////////////////////////////////////// listing photo 
						if(isset($RST->listing_photo)&&(trim($RST->listing_photo)<>""))
						{
								print("<div align=center><img src='./listing_images/$RST->listing_photo'></div>");
								
						}
							 
							  print("</td>");
							  
							print("</tr><tr><td colspan=2 class=ypdetail>&nbsp;");
					
							print("<div>$RST->listing_details</div>");
						  print("</td>");
						print("</tr>");
					}
					
			
					print("</table>");
					
			}	
			else
			{
			print("<table width='100%' border='1' cellspacing='0' cellpadding='0' >");
			print("<tr><td colspan='2' valign=top>".DisplayPageDetails($pageid,$RST->listing_id)."</td></tr></table>");
			}
			DisplayCaptions($RST->listing_id);
				

			print("</td></tr></table>");
				
				
				
				
			}
				?>
          </td>
        </tr>
        <!-- da display ends here -->
      </table>
      <?
		}
		else
		{
	?>
  <tr> 
    <td width="300"  valign="top" class="cabg"> <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" valign="top" >
        <tr> 
          <td height="30"  class="catitle"><img src="images/caffair.gif" width="145" height="18">.</td>
        </tr>
        <tr> 
          <td height="15" class="hline"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr> 
                <td width="47%" height="20"><img src="images/hline.gif" width="136" height="15"></td>
                <td width="53%"><div align="center"><span class="small"><strong>Updated 
                    everday at 7 pm IST</strong></span></div></td>
              </tr>
            </table></td>
        </tr>
        <!-- <tr> 
          <td class="cabg"><br> <div class="intro">First time in Goa’s history, 
              Digital Goa brings you Goa news updates as they happen across the 
              State. Alternatively, you can even receive these news updates directly 
              in your mail box by <a href="#" onClick="client_ids()"><strong>registering 
              here</strong>.</a><br>
            </div></td>
        </tr> -->
        <tr> 
          <td class="cabg" valign="top"> <br> 
            <?php
		GetNews('N', 'news_type=5', 175);
?>
          </td>
        </tr>
        <tr> 
          <td height="120" valign="top"> 
		  
		  	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="catable">
              <tr> 
                <td height=25 class="catitle" width="98%"><img src="images/events.gif" width="69" height="18"><a name="event"></a></td>
              </tr>
              <tr > 
                <td height="100"   align="center" valign="top"> <div align="center"> 
                    <iframe align="top" src="home_cal.php" frameborder="0" scrolling="no" height="190" ></iframe>
                  </div></td>
              </tr>
            </table>
			
		  </td>
        </tr>
        <tr> 
          <td valign="top">
		  
		    <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="vctable">
              <tr> 
                <td height="25" class="vctitle" valign='middle'>&nbsp;<img src="images/classified.gif"></td>
              </tr>
              <tr> 
                <td class="egdata" width="98%"> 
                  <? 
				while($RVCL = mysql_fetch_object($rvcl))
				{
					print("<strong>$RVCL->vName</strong>");// display parent category names 
					print("<br>"); 
					$s = GetClassifiedTypes($RVCL->iCLID);// returns child category names as a string 
  				    if(trim($s)<>"") 
					print("$s<br>"); 
				}
				  ?>
                </td>
              </tr>
            </table>
			
		  </td>
        </tr>
        <? if(CheckNewsAnalysis())
		   {
			  ?>
        <tr> 
          <td height="40" valign="top"> <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="catable">
              <tr> 
                <td height="18" class="catitle"><img src="images/news1.gif" width="130" height="15"></td>
              </tr>
              <tr> 
                <td > <br> 
                  <?php
		GetNews('N', 'news_type=4', 175);
		
?>
                </td>
              </tr>
            </table></td>
        </tr>
        <? } ?>
        <tr> 
          <td  valign="top" > <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="catable">
              <tr> 
                <td height="18" class="catitle"><img src="images/pod.gif" width="140" height="12"></td>
              </tr>
              <tr > 
                <td height="159" valign='top'> <br> 
                  <?php
	GetPicOfTheDay();
?>
                </td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td  valign="top" ><script type="text/javascript"><!--
google_ad_client = "pub-9026857711513326";
google_ad_width = 300;
google_ad_height = 250;
google_ad_format = "300x250_as";
google_ad_type = "text_image";
google_ad_channel ="";
google_color_border = ["B4D0DC","A8DDA0","DDB7BA","FDEFD2"];
google_color_bg = ["ECF8FF","EBFFED","FFF5F6","FDEFD2"];
google_color_link = "0000CC";
google_color_url = "008000";
google_color_text = ["6F6F6F","6F6F6F","6F6F6F","000000"];
//--></script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script></td>
        </tr>
      </table></td>
    <td width="300" valign="top" class="ypbg"> <table width="100%" cellpadding="0" cellspacing="0">
        <!--  <tr> 
      <td height="48" valign="top" class="intro"> <div align="center"> 
          <?php
	$pic= GetXFromYID("select banner_image_name from af_banners where banner_type='top'");
		  print("<img src='banners/109449295214.gif' width=283 height=79>");
		  print("<br><a class=ftr href=# onClick=client_ids()>click 2 subscribe</a> ");
?>
        </div></td>
    </tr> -->
        <tr> 
          <td height="30" class="yptitle"><img src="images/ypages.gif" width="145" height="18"></td>
        </tr>
        <tr> 
          <td valign="top"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <!--     <tr> 
                <td height="90" class="intro" valign="top"><br>
                  Goa&#8217;s fastest growing Yellow Pages on the web, comes with 
                  host of unique features that can immensely help smallest commercial 
                  venture to the corporate house in leveraging IT for business 
                  growth. More details <a href="yp_details.php"><strong>here</strong></a>. 
                </td>
              </tr> -->
              <!--  <tr> 
                <td height="20" class="yptitle"><img src="images/tc.gif" width="115" height="14"></td>
              </tr>-->
              <tr> 
                <td  class="ypbg" valign='top' width='100%'> 
                  <?php
	DisplayAllMastCats();
?>
                </td>
              </tr>
              <tr > 
                <td height="90" class="ypbg" valign="top"> <div align="center"> 
                    <?php
				/*print("<table width=100%>");
			$str_alphabet="A";
			for ($int_i=0; $int_i<26; $int_i++, $str_alphabet++) {
				if ($int_i==13) 
				echo "<tr>";
				echo "<td valign=top align=center class='ypdata'><a href='yp_list.php?mode=A&a=".$str_alphabet."'>".$str_alphabet."</a></td>";
			}
			print("</tr>");
			print("</table>");*/
			 AllCategories();
?>
                  </div></td>
              </tr>
              <!--    <tr> 
            <td class="ypbg" valign='top'> 
              <?php
	TopCategoryDisplay(1, 12, 'ypdata','yp_list.php?mode=C&','T'); //$cols, $rows, $css="",$action
			?>
            </td>
          </tr> -->
              <tr valign='top'> 
                <td class="ypbg" valign='top' > 
                  <?php
	ShowNewCompanies();
?>
               </td>
              </tr>
              <tr>
                <td  valign='top'> <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" class="egtable">
                    <tr> 
                      <td height="20" class="egtitle" valign='top'><img src="images/egoa.gif"  height="18"> 
                      </td>
                    </tr>
                    <tr> 
                      <td height="100" class="egdata" valign='top'> 
                        <?php		
////////////////////////////	EXPLORE GOA		/////////////////////////////////////		
	while($R1 = mysql_fetch_object($r1))
	{
		print("<strong> $R1->cat_gd_name</strong>");// display parent category names
			print("<br>");
			$s = GetChildServices($R1->cat_gd_id);// returns child category names as a string
			
			if(trim($s)<>"")
				print("$s <br>");
	}
//	ShowLatestGeneral_Database_Articles();
?>
                      </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table>
	  <? }
  ?>
</table>
<table border="0" cellpadding="0" cellspacing="0" align="center" width='760'>
  <tr> 
    <td height="17"  class="bluebdr">&nbsp;&nbsp;&nbsp;</td>
  </tr>
  <tr> 
    <td height="17" class="ftr">Copyright &copy; 2005 Digital Goa | <a href="contactus.php" class="ftr">Contact 
      Us</a> | <a href="advertise.php" class="ftr">Advertise With Us</a> | <a  class="ftr" href="#" onClick="suggestdg()">Suggest 
      This Site</a> </td>
  </tr>
</table>

</body>
</html>