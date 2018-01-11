<?php

require_once("common.php");



getconnected();

$res=GetOfferID('E','Y');





if($typ2=='eg')

{

			$q2 = "SELECT * FROM news where news_is_archived = 0";

			$r2 = mysql_query($q2) or die ("<b>Error Code:</b>IND02 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q2);

			

			$q3 = "select * from listings order by listing_since desc limit 10";

			$r3 = mysql_query($q3) or die ("<b>Error Code:</b>IND03 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q3);

			

		if(isset($mode)) // coming thru search_redirect.php

		{

			if($mode=='S')//SEARCH TRHU THE DATABASE

			{

				#	frm_type = 1 (company) 2 (general database)	3 (archives)

				$str_data=$str_data1="";

				if ($frm_type==2) 

				{

					$str_sql="SELECT gd_article_id, gd_article_name FROM general_database_articles WHERE gd_article_name like '%".strtolower($frm_name)."%' ORDER BY gd_article_name ASC";

				}

				

				if ($rst=mysql_query($str_sql)) 

					if (mysql_num_rows($rst)) 

						while ($adata=mysql_fetch_array($rst)) 

						{

							if ($frm_type==2) 

								$str_data.="&nbsp; <a href='eg_disp.php?typ=eg&cid=".$adata['gd_article_id']."'><span class=egdata>".$adata['gd_article_name']."</span></a><br>";

						}

		

				mysql_free_result($rst);

				

				#	END OF THE CODE TO SEARCH TRHU THE DATABASE

				#######################

			}

		}

		else

		{

			//////////////// GETTING DATA FROM cat_general_database TABLE ////////////////////////

			$q1 = "select * from general_database_articles where cat_gd_id=$cid";

			$r1 = mysql_query($q1) or die ("<b>Error Code:</b>IND01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q1);

		}

} //end of typ2=='eg' if 

else if($typ2=='vc')

{

	$q1 = "select * from job_articles where iJID=$cid";

			$rvc = mysql_query($q1) or die ("<b>Error Code:</b>IND01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q1);

}

else if($typ2=='cls')

{

	$q1 = "select * from classifiedarts where iCLID=$cid";

			$rvcl = mysql_query($q1) or die ("<b>Error Code:</b>IND01 <b>Desc:</b>".mysql_error()."<br><b>File Name:</b>".getenv ("SCRIPT_NAME")."<br><b> Query : </b>" . $q1);

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

<input type="hidden" name='cid' value='<? echo $cid; ?>'>

<input type="hidden" name="nm" value="<? echo $nm; ?>">

<input type="hidden"   name="typ2" value="<? echo $typ2; ?>" >

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

    <td height="221" valign="top"> 

      <table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0">

        <tr> 

		<? 

		if($typ2=='eg')

			{$css='egtable';

			$bg='cabg';

			}

		else if($typ2=='vc')

			{$css='vctable';

			$bg='vcbg';

			}

		else if($typ2=='cls')

			{$css='vctable';

			$bg='vcbg';

			}

		?>

          <td width="63%" height="221" valign="top" class="<? echo $bg;?>"><table width="100%" border="0" cellspacing="0" cellpadding="0" class='<? echo $css; ?>'>

              <tr> 

                <?

			    if($typ2=='eg')

				print("<td height=18 class=egtitle><img src=images/egtitle.gif width=94 height=12></td>");

				else if($typ2=='vc')

				print("<td height=18 class=vctitle><img src=images/vacancies2.gif></td>");

				else if($typ2=='cls')

				print("<td height=18 class=vctitle><img src=images/classified.gif></td>");

				

				?> 

              </tr>

              <tr> 

                <td height="22" class="egdata"> 

				<br>

                  <?php		

////////////////////////////	EXPLORE GOA		/////////////////////////////////////

if($typ2=='eg')

{		

		if(isset($mode))

		{

			if($mode=='S')

			{

				if(trim($str_data)=="")

					print("No results found...");

				else

					echo $str_data;

			}

		}

		else

		{

			print("<div class=cadisp><strong>$nm</strong></div>");// display parent category names

			if(mysql_num_rows($r1)>0)

			{

				while($R1 = mysql_fetch_object($r1))

				{

					print("<a href=eg_disp.php?cid=$R1->gd_article_id&typ=eg><div class=egdata>".$R1->gd_article_name."</div></a>");

				}

			}

			else

			{

				print("<div class=egdata>Currently No Information Available</div>");

			}

		}

}

else if($typ2=='vc')

{

	print("<div class=cadisp><strong>$nm</strong></div>");

	if(mysql_num_rows($rvc)>0)

	{

		while($R1 = mysql_fetch_object($rvc))

		{

			print("<a href=eg_disp.php?cid=$R1->iJARTID&typ=vc&jid=$R1->iJID><div class=egdata>".$R1->vName."</div></a>");

		}

	}

	else

	{

		print("<div class=egdata>Currently No Information Available</div>");

	}

}

else if($typ2=='cls')

{

	print("<div class=cadisp><strong>$nm</strong></div>");

	if(mysql_num_rows($rvcl))

	{

		while($R1 = mysql_fetch_object($rvcl))

		{

			print("<a href=eg_disp.php?cid=$R1->iClartID&typ=cls&clid=$R1->iCLID><div class=egdata>".$R1->vName."</div></a>");

		}

	}

	else

	{

		print("<div class=egdata>Currently No Information Available</div>");

	}

}

?>

                  

                </td>

              </tr>

            </table> </td>

          <td width="37%" height="221" valign="top" class="ypbg"> <div align="center"> 

            <?php

			if($typ2=='eg')

			DisplaySideMenu('eg');

			else if($typ2=='vc')

			DisplaySideMenu('vc');

			else if($typ2=='cls')

			DisplaySideMenu('cls');

			

	/*ShowNewCompanies();

 	print("<br>");

		while($R2 = mysql_fetch_object($r2))

		{

			echo "<a href='ca_disp.php?id=$R2->news_id'><strong>$R2->news_title</strong></a><br>";

		}

		BreakingNews();*/

?>

           

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