<?php

	require_once("x_loginfo.php");

	require_once("common.php");

	require_once("./includes/conf.php");



	getconnected();	  



if(isset($LOGGED))

{

	if($LOGGED==1)				

	{
	

		if($psd == ADMIN_PANEL_PASSWORD && $unm==ADMIN_USERNAME) 

		{

			$logdat_dg= new loginfo();

			session_register("logdat_dg");



			$logdat_dg->logstat="A";  //active

			$logdat_dg->utype="A";
			
			
			header("location:x_panel.php");
			exit;						

		} 

		else

		{

	//		$str_err.="Either the username/password is invalid.";

			header("location:x_login.php?errmsg=1");

			exit;

		}

	}

}

?>