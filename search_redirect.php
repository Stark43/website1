<?php

	if(isset($mode))
	{
		if($mode=='S')
		{
			if($frm_type==1)// COMPANIES
				header("location: yp_list.php?mode=S&frm_name=$frm_name&frm_type=$frm_type&frm_location=$frm_location");
			else if($frm_type==2)// GENERAL DATABASE
				header("location: eg_list.php?mode=S&frm_name=$frm_name&frm_type=$frm_type&typ2=eg");
			else if($frm_type==3)// NEWS ARCHIVE
				header("location: ca_list.php?mode=S&frm_name=$frm_name&frm_type=$frm_type");
		}
	}
?>