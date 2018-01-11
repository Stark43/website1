<?php

require_once("common.php");

require_once("./includes/vars.php");

require_once("./includes/conf.php");

getconnected();

$res=GetOfferID('Y','Y');



//////////////// GETTING DATA FROM cat_general_database TABLE ////////////////////////

/*	$q1="select * from listings where listing_id=$liid ";

	//$q1 = "SELECT * FROM cat_general_database WHERE cat_gd_parent_id=0 ORDER BY cat_gd_name ASC";

	$r1 = mysql_query($q1) or die ("<b>Error Code:</b>IND01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q1);*/



	$q2 = "SELECT * FROM news where news_is_archived = 0";

	$r2 = mysql_query($q2) or die ("<b>Error Code:</b>IND02 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q2);

	

	$q3 = "select * from listings order by listing_since desc limit 10";

	$r3 = mysql_query($q3) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q3);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<title>DigitalGoa.com- Goa, Goa Holidays, Goa Centric Portal, Goa Yellow Pages, Explore Goa, Goa Breaking News, Goa News, Goa Current Affairs, Goa Events</title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript" src="scripts/dg.js"></script>

<link href="dg.css" rel="stylesheet" type="text/css">

</head>



<body leftmargin="0" topmargin="0">

<input type="hidden" name="liid" value="<? if(isset($liid)){ echo $liid;} ?>">

<input type="hidden" name="nme" value="<? if(isset($nme)){ echo $nme;} ?>">

<table width="760" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr> 

    <td height="16" colspan="2" class="bluebdr">&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

  <tr> 

    <td height="71" colspan="2"> <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr> 

          <td width="31%" height="66"><a href="index.php"><img src="<? print(Get_Logo_Path()); ?>" width="225" height="57" border="0"></a></td>

          <td width="69%"><? include_once("topmenu.php"); ?></td>

        </tr>

      </table></td>

  </tr>

  <tr> 

     <td height="25" colspan="3"> 

	<? include_once("side_prints_prod3.php"); ?>

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

    <td width="150" rowspan="2" class="cabg" valign="top"><div class="intro">

        

      </div>  

      <?

	ShowOffer(0,'Y','N');

	?>

      &nbsp;</td>

    <td width="610" height="14" class="ticker">&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

  <tr> 

    <td height="332" valign="top"> 

      <table width="100%" height="26%" border="0" cellpadding="5" cellspacing="0">

        <tr> 

          <td width="63%" height="81" valign="top" class="ypbg"> 

            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="yptable">

              <tr> 

                <td class="yptitle"><img src="images/yptitle.gif" width="100" height="14"></td>

              </tr>

              <tr> 

                <td class="cadata"> 

                  <!--                   <form name="form1" method="post" action="">

                    <input type="hidden" name="id" value="<? //if(isset($id)){echo $id;} ?>">

                  </form>-->

                  <strong>&nbsp; </strong></td>

              </tr>

              <!-- da display starts here -->

              <?php /*

	if(isset($mode))

	{

		if($mode=='C')// search by CATEGORY...

		{

			//$title = GetXFromYID("select from cat_products where cat_product_id=$id");

			

			$qry="select * from listings where listing_id=$liid ";

			$result=mysql_query($qry) or die("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $qry);

		}

		else if($mode=='A')//search by ALPHABET...

		{

			if(isset($a))

				$title = "Search Results for $a";



			$qry = "select * from cat_products where cat_product_name like '$a%' order by cat_product_name asc";

			$result=mysql_query($qry) or die("<b>Error Code:</b>IND04 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $qry);

		}

		else if($mode=='S')//SEARCH TRHU THE DATABASE

		{

			$title = "&nbsp;<b>Search Results</b>";

		

			#	frm_type = 1 (company) 2 (general database)	3 (archives)

			$str_data=$str_data1="";

			if ($frm_type==1) 	#	DEFINED IN THE SIDE_PRINTS_PROD.PHP 

			{

				$str_sql="SELECT listing_company, listing_id, listing_username FROM listings WHERE listing_type=".COMPANY." AND LOWER(listing_company) like '".strtolower($frm_name)."%' ";

			

				if ($frm_location>0) 

					$str_sql.=" AND location_id=$frm_location ";

		

				$str_sql.=" ORDER BY listing_company ASC";

			}

			elseif ($frm_type==3) 

			{

				$str_sql="SELECT news_id, news_title, news_type FROM news WHERE news_title like '".strtolower($frm_name)."%' AND news_is_archived=1 ORDER BY news_title ASC";

				

				$str_data="&nbsp;<b>Latest News</b><br>";

				# $str_data1="&nbsp;<b>News Analysis</b><br>";

			}

			

			if ($rst=mysql_query($str_sql)) 

			{

				if (mysql_num_rows($rst)) 

				{

					while ($adata=mysql_fetch_array($rst)) 

					{

						if ($frm_type==1) 

						{

							$str_data.="&nbsp; <a href='".HTTP_PATH.$adata['listing_username']."'>".$adata['listing_company']."</a><br>";

						}

						elseif ($frm_type==2) 

						{

							$str_data.="&nbsp; <a href='index.php?m=5&i=".$adata['gd_article_id']."'>".$adata['gd_article_name']."</a><br>";

						}

						elseif ($frm_type==3) 

						{

							if ($adata['news_type']==LATEST_NEWS) 

							{

								$str_data.="&nbsp; <a href='index.php?m=4&i=".$adata['news_id']."'>".$adata['news_title']."</a><br>";

							}

							elseif ($adata['news_type']==NEWS_ANALYSIS) 

							{

								$str_data1.="&nbsp; <a href='index.php?m=4&i=".$adata['news_id']."'>".$adata['news_title']."</a><br>";

							}

						}

					}

		

					if (strlen(trim($str_data1))) 

						echo "<br>&nbsp;<b>News Analysis</b><br>".$str_data1;

				}

				else

					echo "<b>No Records found...</b>";

			}

			mysql_free_result($rst);

			

			#	END OF THE CODE TO SEARCH TRHU THE DATABASE

			#######################

		}

	}*/

	$q1="select * from listings where listing_username='$nme'";

	$r1 = mysql_query($q1) or die ("<b>Error Code:</b>IND01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q1);

	$RST= mysql_fetch_object($r1);

?>

              <tr> 

                <td class="cadisp" > <strong><?php echo "$RST->listing_company";?></strong> 

                </td>

              </tr>

              <tr> 

                <td>&nbsp; 

                  <?php

	print("<table width='100%' border='0' cellspacing='0' cellpadding='0' >");

	print("<tr><td>");

	print("<table width=95% border=0 cellspacing=0 cellpadding=0>");

			if(isset($RST->listing_logo)&&trim($RST->listing_logo)<>"")

	{

		print("<tr>");

		  print("<td colspan=2>");

			print("<img src='listing_images/$RST->listing_logo' >");

		  print("</td>");

		print("</tr>");

	}

////////////////////////////// listing address

	print("<tr>");

	  print("<td width=30% class='ypdata'>");

	  	print("<strong>Address :</strong>");

	  print("</td>");

	

	

	  print("<td class='ypdata'>");

	  	print("$RST->listing_addr1");

	  print("</td>");

	print("</tr>");



	if(isset($RST->listing_addr2)&&(trim($RST->listing_addr2)<>""))

	{

		print("<tr>");

		print("<td width=30>&nbsp;</td>");

		  print("<td class='ypdata'>");

			print("$RST->listing_addr2");

		  print("</td>");

		print("</tr>");

	}

	

//////////////////////// listing zip

	if(isset($RST->listing_zip)&&(trim($RST->listing_zip)<>""))

	{

		



		print("<tr>");

		  print("<td class='ypdata'>");

			print("<strong>Zip Code : </strong>");

		  print("</td>");

		

		  print("<td class=ypdata>");

			print("$RST->listing_zip");

		  print("</td>");

		print("</tr>");

	}

	

//////////////////////////////// listing email

	if(isset($RST->listing_email)&&(trim($RST->listing_email)<>""))

	{

		



		print("<tr>");

		  print("<td class='ypdata'>");

			print("<strong>Email Address : </strong>");

		  print("</td>");

		

		  print("<td class=ypdata>");

			print("<a href='mailto:$RST->listing_email'>$RST->listing_email</a>");

		  print("</td>");

		print("</tr>");

	}

	

//////////////////////////////// listing phone

	if(isset($RST->listing_phone)&&(trim($RST->listing_phone)<>""))

	{

		



		print("<tr>");

		  print("<td class='ypdata'>");

			print("<strong>Phone No : </strong>");

		  print("</td>");

		

		  print("<td class=ypdata>");

			print("$RST->listing_phone");

		  print("</td>");

		print("</tr>");

	}

	

//////////////////////////////// listing fax

	if(isset($RST->listing_fax)&&(trim($RST->listing_fax)<>""))

	{

		



		print("<tr>");

		  print("<td class='ypdata'>");

			print("<strong>Fax : </strong>");

		  print("</td>");

		

		  print("<td class=ypdata>");

			print("$RST->listing_fax");

		  print("</td>");

		print("</tr>");

	}

	

//////////////////////////////// listing website

	if(isset($RST->listing_website)&&(trim($RST->listing_website)<>""))

	{

		



		print("<tr>");

		  print("<td  class='ypdata'>");

			print("<strong>Company Website : </strong>");

		  print("</td>");

		

		  print("<td class=ypdata>");

			print("<a href='http://$RST->listing_website'>$RST->listing_website</a>");

		  print("</td>");

		print("</tr>");

	}

	print("</table>");



print("</td></tr>");

//////////////////////////////// listing Details

	if(isset($RST->listing_details)&&(trim($RST->listing_details)<>""))

	{

		print("<tr>");

		  print("<td>");

			print("&nbsp;");

		  print("</td>");

		print("</tr>");



		print("<tr>");

		  print("<td>");

		////////////////////////////////////////////////////////////////// listing photo 

		if(isset($RST->listing_photo)&&(trim($RST->listing_photo)<>""))

		{

		  //print("<table width='30%' border='0' cellspacing='0' cellpadding='0' align='right'>");

		//	print("<tr>");

			  //print("<td align='center' >");

				print("<div align=center> <img src='./listing_images/$RST->listing_photo'></div>");

			  print("</td>");

			print("</tr><tr><td>");

		//  print("</table>");

		}

			print("<div class=ypdata>$RST->listing_details</div>");

		  print("</td>");

		print("</tr>");

	}

	

/*		print("<tr>");

	  print("<td>");

	  	print("$RST->listing_addr1");

	  print("</td>");

	print("</tr>");

	print("<tr>");

	  print("<td>");

	  	print("$RST->listing_addr1");

	  print("</td>");

	print("</tr>");*/

//	echo $RST->listing_details;

	print("</table>");

?>

                </td>

              </tr>

              <!-- da display ends here -->

            </table></td>

        </tr>

        <tr> 

          <td height="203" align="center" valign="top" class="ypbg"> 

            <form name="form1" method="post" action="yp_disp.php?mode=M">

              <table width="50%" border="0" cellspacing="2" cellpadding="0" class="yptable">

                <tr> 

                  <td colspan="2" class="yptitle" ><div align="center"><strong>Post 

                      A Message .</strong></div></td>

                </tr>

                <tr> 

                  <td width="32%" height="20" class="ypdata">Your Name</td>

                  <td width="68%"><input name="txtnm" type="text" id="txtnm" class="box"></td>

                </tr>

                <tr> 

                  <td class="ypdata">Email Address</td>

                  <td><input name="txtem" type="text" id="txtem" class="box" onBlur="checkEmail(form1.txtem)"></td>

                </tr>

                <tr> 

                  <td colspan="2" class="ypdata">Enquiry/Comments</td>

                </tr>

                <tr align="center"> 

                  <td colspan="2"> <textarea name="txtenq" cols="40" rows="5" class='box' id="txtenq"></textarea> 

                  </td>

                </tr>

                <tr align="center"> 

                  <td colspan="2"> <input type="submit" name="Submit" value="Submit" class='box'> 

                  </td>

                </tr>

              </table>

            </form>

            <?php

													

				if(isset($mode))

				{

					if($mode=='M')

					{						

						$subject = " Enquiry on Digital Goa";

						$str="Hello!!!\n There was a enquiry at DigitalGoa.com\n.The following are the details about the enquiry that has been forwarded to you for your action.\n";

						//$str.="------------------------------------------------------------------------------------------------\n";

						$str.="Name = \t".$txtnm;

						$str.= "\n";

						$str.="Email Address= \t".$txtem;

						$str.= "\n";

						$str.="Enquiry= \t".$txtenq;

						$str.= "\n";

						

						//echo $str;

						//$headers = "From: ". $txtem;

						//$to = "enquiries@team-inertia.net";

						//$response = mail ( $to, $subject, $str, $headers);

						$headers = "From: ".$txtem;

						$to = "$RST->listing_email";

						$response = mail ( $to, $subject, $str, $headers);

						$to = "teaminertia@sancharnet.in";

						$response = mail ( $to, $subject, $str, $headers);

					//	echo "==>$response = mail ( $to, $subject, $str, $headers)";

						

						if ($response==false)

						{

						

							 print("Sorry, we cannot process your details at the moment. Please try again after sometime. We are extremely sorry for the inconvienience");

						}

						else

						{

							/*print("Your information is now being sent to us.");

							$str="Hello,\n " .$txtnm ;

							$str.="\n\nThank you for visiting and making an enquiry at DigitalGoa";

							$str.="The details about your enquiry that has been forwarded to DigitalGoa for action.\n";

							$str.="You will be contacted within 24 hours with more details.";

							$str.="Regards \n\nVrundavan";

							

							

							$headers = "From:".$RST->listing_email;

							$to = $txtem;

							$subject = "Re: Enquiry on ";

							$response = mail ( $to, $subject, $str, $headers); */

						}

					}

				}

?>

          </td>

        </tr>

        <tr> 

          <td width="63%" height="48" valign="top" class="ypbg">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="yptable">

              <tr> 

                <td class="yptitle"><img src="images/allcat.gif" width="158" height="18"></td>

              </tr>

              <tr> 

                <td> 

                  <?php

				print("<table width=100%>");

			$str_alphabet="A";

			for ($int_i=0; $int_i<26; $int_i++, $str_alphabet++) {

				if ($int_i==13) 

				echo "<tr>";

				echo "<td valign=top align=center class='ypdata'><a href='yp_list.php?mode=A&a=".$str_alphabet."'>".$str_alphabet."</a></td>";

			}

			print("</tr>");

			print("</table>");

?>

                </td>

              </tr>

            </table></td>

        </tr>

      </table></td>

  </tr>

  <tr> 

    <td height="17" colspan="2" class="bluebdr">&nbsp;&nbsp;&nbsp;</td>

  </tr>

  <tr> 

    <td height="19" colspan="2" class="ftr">Copyright &copy; 2005 Digital Goa 

      | <a href="contactus.php" class="ftr">Contact Us</a> | <a href="advertise.php" class="ftr">Advertise 

      With Us</a> | <a  class="ftr" href="#" onClick="suggestdg()">Suggest This 

      Site</a> </td>

  </tr>

</table>

</body>

</html>