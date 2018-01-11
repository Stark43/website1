<?php

require_once("common.php");

include_once("includes/conf.php");



getconnected();

$res=GetOfferID('E','Y');



if($typ=='eg')

{

//////////////// GETTING DATA FROM cat_general_database TABLE ////////////////////////

	$q1 = "select * from general_database_articles where gd_article_id=$cid";

	$r1 = mysql_query($q1) or die ("<b>Error Code:</b>IND01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q1);



	$q2 = "SELECT * FROM news where news_is_archived = 0";

	$r2 = mysql_query($q2) or die ("<b>Error Code:</b>IND02 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q2);

	

	$q3 = "select * from listings order by listing_since desc limit 10";

	$r3 = mysql_query($q3) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q3);

}

else if($typ=='vc')

{

	$q = "select * from job_articles where iJARTID = $cid ";

	$rvc = mysql_query($q) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q);

	

	$q = "select * from job_categories where iJID = $jid ";

	$rjid = mysql_query($q) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q);

}

else if($typ=='cls')

{

	$q = "select * from classifiedarts where iClartID = $cid ";

	$rvcl = mysql_query($q) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q);

	

	$q = "select * from classifiedcats where iCLID = $clid ";

	$rjid = mysql_query($q) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q);

}

else if($typ=='DS')

{

		$qds = "select * from job_articles where iJARTID = $cid ";

			$rvc = mysql_query($qds) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $qds);

}

	

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

<input type="hidden" name='cid' value='<? echo $cid ?>'>

<input type="hidden" name='typ' value='<? echo $typ ?>'>

<input type="hidden" name="jid" value='<? if(isset($jid)){echo $jid;} ?>'>

<input type="hidden" name="clid" value='<? if(isset($clid)){echo $clid;} ?>'>



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

    <td width="150" rowspan="2" class="sobg" valign="top"><div class="intro">

        

      </div> 

	<?

	ShowOffer(0,'E','N');

	?>&nbsp;</td>

    <td width="610" height="14" class="ticker">&nbsp;&nbsp;&nbsp;&nbsp;</td>

  </tr>

  <tr> 

    <td height="251" valign="top"> <table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0">

        <tr> 

		<? if($typ=='eg')

			{

				

				$bg='cabg';

			}

		else if(($typ=='vc')||($typ=='DS')||($typ=='cls'))

			{

				

				$bg='vcbg';

			} ?>

          <td width="63%" height="100%" valign="top" class="<? echo $bg; ?>"> 

            <table width="100%" border="0" cellspacing="0" cellpadding="0" >

              <tr> 

                <?

			    if($typ=='eg')

				print("<td height=18 class=egtitle><img src=images/egtitle.gif width=94 height=12></td>");

				else if(($typ=='vc')||($typ=='DS'))

				print("<td height=18 class=vctitle><img src=images/vacancies2.gif></td>");

				else if($typ=='cls')

				print("<td height=18 class=vctitle><img src=images/classified.gif></td>");

				

				?> 

              </tr>

              <tr> 

                <td height="22" > 

                  <?php  

				  if($typ=='eg')

				  {

						print(" <table width=100% border=0 cellspacing=0 cellpadding=0 class='egtable'>");

						 $R1 = mysql_fetch_object($r1);

						 print("<tr>"); 

						

						 print("<td width=38% class=cadisp height=40><strong>$R1->gd_article_name</strong></td>                 ");

						print("</tr>");

						if($R1->gd_article_photo=="")

						{

						}

						else

						{

							print("<tr><td><img src='http://digitalgoa.com/listing_images/$R1->gd_article_photo'></td></tr>");

						}

									

	

			print(" <tr><td colspan=2 class=egdata>".$R1->gd_article_details."</td></tr>");

			print(" <tr><td colspan=2 class=egdata height=40>Posted On :&nbsp;".ConvertDate($R1->gd_article_date)."</td></tr>");

			print("</table>");

		 }

		 else if($typ=='vc')

		 {

		 

					print("<table width=100% border=0 cellspacing=0 cellpadding=0 class=vctable>");

					$Rjid = mysql_fetch_object($rjid);

				//	print("<tr><td class=cadisp height=40><strong>$Rjid->vName</strong></td></tr>");

					//print("<tr><td class=egdata>");

					if(mysql_num_rows($rvc)>0)

					{					

						while($R1 = mysql_fetch_object($rvc))

						{	

							print("<tr><td class=cadisp><strong>$R1->vName</strong></td></tr>");

							//print("<br>");

							print("<tr><td class=egdata>$R1->bDetails</td></tr>");

							print("<tr><td class=intro height=40>Posted On :&nbsp ".ConvertDate($R1->dDate)." &nbsp;</td></tr>");

						}	

					}

					else

					{

						print("<div class=egdata>Currently No Information Available</div>");

					}

					//print("</td></tr>");

					print("</table>");

				

		 }

		 else if($typ=='cls')

		 {

		 

					print("<table width=100% border=0 cellspacing=0 cellpadding=0 class=vctable>");

					$Rjid = mysql_fetch_object($rjid);

				//	print("<tr><td class=cadisp height=40><strong>$Rjid->vName</strong></td></tr>");

					//print("<tr><td class=egdata>");

					if(mysql_num_rows($rvcl)>0)

					{					

						while($R1 = mysql_fetch_object($rvcl))

						{	

							print("<tr><td class=cadisp><strong>$R1->vName</strong></td></tr>");

							

							if(($R1->vPic!='NA') && ($R1->vPic!=''))

							print("<tr><td ><img src='".CLASSIFIED_IMAGES_FOLDER.$R1->vPic."' ></td></tr>");

							print("<tr><td >$R1->bDetails</td></tr>");

							print("<tr><td class=intro height=40>Posted On :&nbsp ".ConvertDate($R1->dDate)." &nbsp;</td></tr>");

						}	

					}

					else

					{

						print("<div class=egdata>Currently No Information Available</div>");

					}

					//print("</td></tr>");

					print("</table>");

				

		 }

		else if($typ=='DS')

		 {

		 	while($R1 = mysql_fetch_object($rvc))

			{

					print("<table width=100% border=0 cellspacing=0 cellpadding=0 class=vctable>");

					print("<tr><td class=cadisp height=40><strong>$R1->vName</strong></td></tr>");

					print("<tr><td class=egdata>$R1->bDetails</td></tr>");

					print("<tr><td class=intro height=40>Posted On :&nbsp ".ConvertDate($R1->dDate)." &nbsp;</td></tr>");

					print("</table>");

			}	

		 }

?>

                 </td>

              </tr>

            </table>

          </td>

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

