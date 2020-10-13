<?php
/**
 * Coppermine 1.6.x Plugin - final_extract
 *
 * @copyright	Copyright (c) 2009 Donnovan Bray
 * @license		GNU General Public License version 3 or later; see LICENSE
 *
 * @author		Donnovan Bray (original)
 * @author		ron4mac (23 Dec 2018); version for CPG 1.6.x
 */

if (!GALLERY_ADMIN_MODE) cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);

if ($lang_text_dir=='ltr') {
	$align="left";
	$direction="ltr";
} else {
	$align="right";
	$direction="rtl";
}
$req_uri = $superCage->server->getMatched('REQUEST_URI', '/([^\/]+\.php)$/');

// Check for change status Final extract 2.3

if ($superCage->post->keyExists('change_stat')){
	$change_stat=$superCage->post->getAlnum('change_stat');
	//set new values for bloc status

	$groupid = $superCage->post->getInt('groupid');
	$nbcheck = $superCage->post->getInt('nb');
//test if this usergroup exist in the FINAL_EXTRACT_CONFIG table:
	$sql = "select group_id FROM `{$CONFIG['TABLE_FINAL_EXTRACT_CONFIG']}` WHERE `group_id`=$groupid";
	$result = cpg_db_query($sql);
	$row = cpg_db_num_rows($result);
	$home=0;$register=0;$login=0;$my_gallery=0;$upload_pic=0;$album_list=0;$lastup=0;$lastcom=0;$topn=0;$toprated=0;$favpics=0;$search=0;$my_profile=0;
	$cnt = 0;
	if ($superCage->post->getAlpha('home')<>""){
		$home=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('register')<>""){
		$register=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('login')<>""){
		$login=1;
		$cnt++;
	}	
	if ($superCage->post->getAlpha('my_gallery')<>""){
		$my_gallery=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('upload_pic')<>""){
		$upload_pic=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('album_list')<>""){
		$album_list=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('lastup')<>""){
		$lastup=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('lastcom')<>""){
		$lastcom=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('topn')<>""){
		$topn=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('toprated')<>""){
		$toprated=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('favpics')<>""){
		$favpics=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('search')<>""){
		$search=1;
		$cnt++;
	}
	if ($superCage->post->getAlpha('my_profile')<>""){
		$my_profile=1;
		$cnt++;
	}
	if ($row==FALSE){
		$sql = "INSERT INTO `{$CONFIG['TABLE_FINAL_EXTRACT_CONFIG']}`VALUE($groupid,$home,$login,$my_gallery,$upload_pic,$album_list,$lastup,$lastcom,$topn,$toprated,$favpics,$search,$my_profile,$register)";
		cpg_db_query($sql);
	} else {	
		$sql = "UPDATE `{$CONFIG['TABLE_FINAL_EXTRACT_CONFIG']}` SET `home`=$home,`login`=$login,`my_gallery`=$my_gallery,`upload_pic`=$upload_pic,`album_list`=$album_list,`lastup`=$lastup,`lastcom`=$lastcom,`topn`=$topn,`toprated`=$toprated,`favpics`=$favpics,`search`=$search,`my_profile`=$my_profile,`register`=$register WHERE Group_Id=$groupid";
		cpg_db_query($sql);

		unset($chang_stat);

		if ($cnt==$nbcheck) {
			pageheader($lang_plugin_final_extract['display_name']);
			msg_box($lang_plugin_final_extract['display_name'], $lang_plugin_final_extract['nothing_changed'], $lang_continue, 'index.php?file=final_extract/plugin_config');
			pagefooter();
			exit;
		}
	}

		pageheader($lang_plugin_final_extract['display_name']);
		msg_box($lang_plugin_final_extract['display_name'], $lang_plugin_final_extract['success'], $lang_continue, 'index.php?file=final_extract/plugin_config');
		pagefooter();
		exit;
}

pageheader($lang_plugin_final_extract['display_name']);
?>
<script language="javascript" type="text/javascript">
function change() {
	var Nodes = document.getElementsByTagName("table");
	var max = Nodes.length;
	for (var i = 0;i < max;i++) {
		var nodeObj = Nodes.item(i);
		var str = nodeObj.id;
		if (str.match("section")) {
			nodeObj.style.display = 'none';
		}
	}
	advkind = document.getElementById("plugin_status").value;
}
function change_conf() {
	advkind = document.getElementById("plugin_status").value;
	if (advkind==3) {
		document.getElementById("max_show").style.display='block';
	} else {
		document.getElementById("max_show").style.display='none';
	}
}
function check_all(formname) {
	i=0;
	while (document.getElementById(formname).elements[i]) {
		document.getElementById(formname).elements[i].checked="checked";
	i+=1;
	}
}
//onload = change;
</script>
<?php
//create usergroup dropdown list
$sql = "SELECT group_id,group_name FROM `{$CONFIG['TABLE_USERGROUPS']}`";
$result = cpg_db_query($sql);
if ($superCage->post->keyExists('usergroup')) {
	$usergroup = $superCage->post->getAlpha('usergroup');
} else {
	$usergroup = '';
}
starttable('100%', 'Final Extract v'.$version, 3);
?>
<form id='username' name='username' action='<?php echo $req_uri ?>' method='post'>
<tr>
	<td class="tableh2" align="rigth"><?php  echo $lang_plugin_final_extract['group_name']; ?>:
	<select name='usergroup' >
		<?php while ($row = cpg_db_fetch_assoc($result)) {
			extract($row);
			if ($usergroup==$row['group_name']) {
				echo"<option value='$group_name'selected>$group_name \n";
			} else {
				echo"<option value='$group_name'>$group_name \n";
			}
		 } ?>
	</select>
	<input name="groupid" type="hidden" value="<?php echo $row['group_id']; ?>">		
	<input type='submit'value="<?php echo $lang_plugin_final_extract['button_submit'];?>">
</tr>
</form>
<?php

//if usergroup selected
if ($usergroup<>'') {
	//extract groupid from the selected usergroup
	$sql3 = "SELECT group_id,group_name FROM `{$CONFIG['TABLE_USERGROUPS']}`WHERE group_name = '$usergroup'";
	$result3 = cpg_db_query($sql3);
	$row3 = cpg_db_fetch_assoc($result3, true);
	$groupid = $row3['group_id'];

	//create block list to configure
	$sql2 = "SELECT * FROM `{$CONFIG['TABLE_FINAL_EXTRACT_CONFIG']}` WHERE group_id LIKE'$groupid'";
	$result2 = cpg_db_query($sql2);
	$row2 = cpg_db_fetch_assoc($result2, true);
	$nb = 0;
?>
<tr><td><form id="blocks" name="blocks" action="<?php echo $req_uri ?>" method="POST">
	<table class="maintable" id="section0" cellSpacing="1" cellPadding="0" width="50%" align="center" border="0">
		<tr>			
              		<td width="70%" align="<?php echo $align ?>" dir="<?php echo $direction ?>" class=tableb><strong><?php echo $lang_plugin_final_extract['list_name']; ?></strong></td>
              		<td width="10%" align="center" valign=top class=tableb><strong><?php echo $lang_plugin_final_extract['list_check']; ?></strong></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['home_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="home" type="checkbox"   <?php if($row2['home']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['register_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="register" type="checkbox"  <?php if($row2['register']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['login_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="login" type="checkbox"  <?php if($row2['login']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['my_galery_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="my_gallery" type="checkbox"  <?php if($row2['my_gallery']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['upload_pic_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="upload_pic" type="checkbox"  <?php if($row2['upload_pic']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            		<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['album_list_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="album_list" type="checkbox"   <?php if($row2['album_list']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['lastup_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="lastup" type="checkbox"   <?php if($row2['lastup']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['lastcom_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="lastcom" type="checkbox"  <?php if($row2['lasctom']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['topn_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="topn" type="checkbox"   <?php if($row2['topn']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['toprated_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="toprated" type="checkbox"   <?php if($row2['toprated']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['favpics_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="favpics" type="checkbox"   <?php if($row2['favpics']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['search_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="search" type="checkbox"  <?php if($row2['search']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
		<tr>
            		<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>"><?php echo $lang_plugin_final_extract['my_profile_block'];?></td>
            		<td align="center" valign=top class=tableb><input name="my_profile" type="checkbox"  <?php if($row2['my_profile']==1) { echo 'checked="cheked"';$nb++;} ?>/></td>
            	</tr>
            	<tr>
                	<td class=tableb align="<?php echo $align ?>" dir="<?php echo $direction ?>">&nbsp;</td>
                	<td align="center" valign=top class=tableb>&nbsp;&nbsp;
                  	<input class="button" type="button" value="<?php echo $lang_plugin_final_extract['list_chkall']; ?>" name="restore_config" onclick="return check_all('blocks');"></td>
              	</tr>
	</table>
</td></tr><tr>
	
        <td align="center" class="tableb"><input type="hidden" name="groupid" value="<?php echo $groupid;?>"><input type="hidden" name="nb" value="<?php echo $nb;?>"><input class="button" type="submit" value="<?php echo $lang_plugin_final_extract['list_chstat']; ?>" name="change_stat" />
        </td>
      </tr></form>
<?php
}
endtable();
pagefooter();
ob_end_flush();

//EOF