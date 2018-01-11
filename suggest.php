<?php
	require_once("common.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>DigitalGoa.com-Goa Centric Portal, Goa Yellow Pages, Goa Who's Who, Explore 
Goa</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="dg.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="scripts/dg.js"></script>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="2" class="search">&nbsp;</td>
  </tr>
  <tr> 
    <td width="29%"><img src="images/dg.gif" width="225" height="57"></td>
    <td width="71%">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="2" class="search">&nbsp;</td>
  </tr>
  <tr> 
    <td height="28" colspan="2" class="cadata"><div align="center"> 
        <?php
	if(isset($mode))
	{
		if($mode=='N')
		{		
			$n=1;	

			while ($n<=5)
			{	
				$nmx='txtem' . $n;

				if( isset(${$nmx})&&(trim(${$nmx})<>"") )
				{
					$subject = " Digital Goa - The Active Goa Centric Portal";
					
///////////////////////////// GET INVITE.HTM //////////////////////
					$fp = fopen(INVITE,"r");
					$str = fread($fp, filesize(INVITE));
					fclose($fp);
///////////////////////////// GOT INVITE.HTM //////////////////////
					$headers = "MIME-Version: 1.0\r\n"; 
					$headers.= "Content-type: text/html; charset=iso-8859-1\r\n"; 
					$headers.= "From: Digital Goa <digitalg@digitalgoa.com>\n";
					$headers.= "Reply-To: Digital Goa <digitalg@digitalgoa.com>\n\r";
					
					$to = ${$nmx};
					$response = mail ($to, $subject, $str, $headers);
				
					if($response==false)
						 print("Sorry, we cannot process your details at the moment. Please try again after sometime. We are extremely sorry for the inconvienience");
					else
					{
						$txtem='txtem'.$n;
					}
				}
				$n++;
			}
			print("<b>Thank you for suggesting digITal Goa to your friends.</b>");
		}
	}
	else
	{
		print("You Can Tell Your Friends Or Relatives about Goa's only Active Web Centric Portal");
	}
?>
      </div></td>
  </tr>
  <tr> 
    <td colspan="2" align="center"> <table width="47%" border="0" cellspacing="2" cellpadding="0" >
        <form name="suggest" method="post" action="suggest.php?mode=N">
          <tr> 
            <td width="27%" class="ypdata">Email 1</td>
            <td colspan="2" class="cadata"> <input name="txtem1" type="text" class="box" id="txtem1" size="25"></td>
          </tr>
          <tr> 
            <td class="ypdata">Email 2</td>
            <td colspan="2" class="cadata"> <input name="txtem2" type="text" class="box" id="txtem2" size="25"></td>
          </tr>
          <tr> 
            <td class="ypdata">Email 3</td>
            <td colspan="2" class="cadata"> <input name="txtem3" type="text" class="box" id="txtem3" size="25"></td>
          </tr>
          <tr> 
            <td class="ypdata">Email 4</td>
            <td colspan="2" class="cadata"> <input name="txtem4" type="text" class="box" id="txtem4" size="25"></td>
          </tr>
          <tr> 
            <td class="ypdata">Email 5</td>
            <td colspan="2" class="cadata"> <input name="txtem5" type="text" class="box" id="txtem5" size="25"></td>
          </tr>
          <tr> 
            <td class="cadata">&nbsp;</td>
            <td width="73%" class="cadata"> <input type="button" name="Submit" value="Submit" onClick="email()" class="box"></td>
            <!-- <td width="43%" class="cadata"> <input type="button" name="Submit2" value="Close Window" onClick="closewindow()"></td> -->
          </tr>
          <tr> 
            <td height="27" colspan="3" class="cadata"> <div align="center"></div></td>
          </tr>
        </form>
      </table></td>
  </tr>
  <tr> 
    <td colspan="2" align="center" class="search">&nbsp;</td>
  </tr>
  <tr>
    <td height="36" colspan="2" align="center" class="cadata">
<div align="center"><a  class="ftr" href="" onClick="closewindow()">Close 
        This Window</a></div></td>
  </tr>
</table>
</body>
</html>
