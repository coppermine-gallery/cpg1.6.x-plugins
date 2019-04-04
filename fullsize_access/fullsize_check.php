<?php
function fullsize_check_user(){
    global $CONFIG;
	$superCage = Inspekt::makeSuperCage();
	if( USER_ID && $superCage->cookie->getInt($CONFIG['cookie_name'].'_agb') === 1){
		return(true);
	} else{
		return(false);
	}	
}
?>