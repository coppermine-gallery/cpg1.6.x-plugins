<?php
/**************************************************
  Coppermine 1.6.x Plugin - EnlargeIt!
  *************************************************
  Copyright (c) 2010 Timos-Welt (www.timos-welt.de)
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
 **************************************************/

require_once 'init.inc.php';

// if guest login not allowed => go to login page
if (!USER_ID && $CONFIG['allow_unlogged_access'] == 0) 
{
  $redirect = $redirect . "login.php";
  header("Location: $redirect");
  exit();
}

// only count if not in admin mode 
if (!GALLERY_ADMIN_MODE) {

  // init pid variable
  $enlcnt_pid = '';

  // create Inspekt instance to sanitize data
  $enlcnt_superCage = Inspekt::makeSuperCage();

  // check if GET variable a exists
  if ($enlcnt_superCage->get->keyExists('a'))
  {
    // if yes, get Variable a
    $enlcnt_pid = $enlcnt_superCage->get->getInt('a');

   // increase pic counter in database
   $enlcnt_query="UPDATE `".$CONFIG['TABLE_PREFIX']."pictures` SET hits=hits+1 WHERE (pid = '".$enlcnt_pid."')";
   cpg_db_query($enlcnt_query);
  }
}
