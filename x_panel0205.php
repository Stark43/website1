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

echo "<title>DigitalGoa.com Admin Login</title><link rel='stylesheet' href='html/b.css'>";

?>
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
	
	$a_validchars=array("a","b","c","d","e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y","z",
											"A","B","C","D","E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y","Z");
	for ($ln