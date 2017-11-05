<?php
/**************************************************
  Coppermine 1.6.x Plugin - xfeed
  *************************************************
  Copyright (c) 2008 lee (www.mininoteuser.com)
  Plugin for CPG 1.4 created by Lee
  Ported to CPG 1.5.x by Aditya Mooley <adityamooley@sanisoft.com>
  Ported to CPG 1.6.x by ron4mac
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  **************************************************/
if (!defined('IN_COPPERMINE')) die('Not in Coppermine');
require './plugins/xfeed/include/load_xfdset.php';

global $CONFIG, $lang_xfeeds, $lang_meta_album_names;

if (!GALLERY_ADMIN_MODE) {
    cpg_die(ERROR, $lang_errors['access_denied'], __FILE__, __LINE__);
}

if ($lang_text_dir == 'ltr') {
  $align = "left";
  $direction = "ltr";
} else {
  $align = "right";
  $direction = "rtl";
}

if($superCage->post->keyExists('update')) {
    $xfd_rss_button = $superCage->post->getEscaped('xfd_rss_button');
    $xfd_rss_button_position = $superCage->post->getEscaped('xfd_rss_button_position');
    $xfd_feed_items = $superCage->post->testInt('xfd_feed_items') ? $superCage->post->getInt('xfd_feed_items') : 10;
    $xfd_standard = $superCage->post->getEscaped('xfd_standard');
    $xfd_google = $superCage->post->getEscaped('xfd_google');
    $xfd_yahoo = $superCage->post->getEscaped('xfd_yahoo');
    $xfd_msn = $superCage->post->getEscaped('xfd_msn');
    $xfd_lines = $superCage->post->getEscaped('xfd_lines');
    $xfd_aol = $superCage->post->getEscaped('xfd_aol');
    $xfd_feedburn = $superCage->post->getEscaped('xfd_feedburn');
    $xfd_feedburnuname = $superCage->post->getEscaped('xfd_feedburnuname');
    $xfd_feedroute = $superCage->post->getEscaped('xfd_feedroute');
    $xfd_customenable1 = $superCage->post->getEscaped('xfd_customenable1');
    $xfd_customenable2 = $superCage->post->getEscaped('xfd_customenable2');
    $xfd_customenable3 = $superCage->post->getEscaped('xfd_customenable3');
    $xfd_customenable4 = $superCage->post->getEscaped('xfd_customenable4');
    $xfd_customenable5 = $superCage->post->getEscaped('xfd_customenable5');
    $xfd_customtitle1 = $superCage->post->getEscaped('xfd_customtitle1');
    $xfd_customtitle2 = $superCage->post->getEscaped('xfd_customtitle2');
    $xfd_customtitle3 = $superCage->post->getEscaped('xfd_customtitle3');
    $xfd_customtitle4 = $superCage->post->getEscaped('xfd_customtitle4');
    $xfd_customtitle5 = $superCage->post->getEscaped('xfd_customtitle5');
    $xfd_customurl1 = $superCage->post->getEscaped('xfd_customurl1');
    $xfd_customurl2 = $superCage->post->getEscaped('xfd_customurl2');
    $xfd_customurl3 = $superCage->post->getEscaped('xfd_customurl3');
    $xfd_customurl4 = $superCage->post->getEscaped('xfd_customurl4');
    $xfd_customurl5 = $superCage->post->getEscaped('xfd_customurl5');
    $xfd_theme = $superCage->post->getEscaped('xfd_theme');

    $s  = "UPDATE `{$CONFIG['TABLE_PREFIX']}plugin_xfeeds` SET ";
    $s .= "xfd_rss_button_position=($xfd_rss_button_position),";
    $s .= "xfd_rss_button=($xfd_rss_button),";
    $s .= "xfd_feed_items=($xfd_feed_items),";
    $s .= "xfd_standard=($xfd_standard),xfd_google=($xfd_google),";
    $s .= "xfd_yahoo=($xfd_yahoo),xfd_msn=($xfd_msn),";
    $s .= "xfd_lines=($xfd_lines),xfd_aol=($xfd_aol),";
    $s .= "xfd_feedburn=($xfd_feedburn),xfd_feedburnuname=('$xfd_feedburnuname'),";
    $s .= "xfd_feedroute=($xfd_feedroute),xfd_customenable1=($xfd_customenable1),";
    $s .= "xfd_customenable2=($xfd_customenable2),xfd_customenable3=($xfd_customenable3),";
    $s .= "xfd_customenable4=($xfd_customenable4),xfd_customenable5=($xfd_customenable5),";
    $s .= "xfd_customtitle1=('$xfd_customtitle1'),xfd_customtitle2=('$xfd_customtitle2'),";
    $s .= "xfd_customtitle3=('$xfd_customtitle3'),xfd_customtitle4=('$xfd_customtitle4'),";
    $s .= "xfd_customtitle5=('$xfd_customtitle5'),xfd_customurl1=('$xfd_customurl1'),";
    $s .= "xfd_customurl2=('$xfd_customurl2'),xfd_customurl3=('$xfd_customurl3'),";
    $s .= "xfd_customurl4=('$xfd_customurl4'),xfd_customurl5=('$xfd_customurl5'),";
    $s .= "xfd_theme=($xfd_theme)";

    cpg_db_query($s);
    pageheader($lang_xfeeds['display_name']);
    msg_box($lang_xfeeds['display_name'], $lang_xfeeds['update_success'], $lang_continue, 'index.php');
    pagefooter();
    exit();
}

pageheader($lang_xfeeds['display_name']);starttable('100%', $lang_xfeeds['main_title'].' - '.$lang_xfeeds['version'].' - <a href="pluginmgr.php" class="admin_menu">'.$lang_xfeeds['pluginmanager'].'</a>', 3);

echo $xfdchk_row['name'];
?>

<TR>
  <td><form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="xfeeds_settings">
      <table class="maintable" cellSpacing="2" cellPadding="2" width="100%" align="<?php echo $align; ?>" border="0" id="section1">
        <tr>
          <td width="50%">&nbsp;</td>
          <td width="50%">&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_rss_button']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_rss_button" id="xfd_rss_button">
                <option value="1" <?php if($XFDSET['xfd_rss_button'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_rss_button'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_rss_button_position']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_rss_button_position" id="xfd_rss_button_position">
                <option value="1" <?php if($XFDSET['xfd_rss_button_position'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_rss_button_position_template']?></option>
                <option value="0" <?php if($XFDSET['xfd_rss_button_position'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_rss_button_position_gallery']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_feed_items']; ?>&nbsp;&nbsp;</td>
          <td>
              <input name="xfd_feed_items" id="xfd_feed_items" value="<?php echo $XFDSET['xfd_feed_items']; ?>" />
          </select>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_standard']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_standard" id="xfd_standard">
                <option value="1" <?php if($XFDSET['xfd_standard'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_standard'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_google']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_google" id="xfd_google">
                <option value="1" <?php if($XFDSET['xfd_google'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_google'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_yahoo']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_yahoo" id="xfd_yahoo">
                <option value="1" <?php if($XFDSET['xfd_yahoo'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_yahoo'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_msn']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_msn" id="xfd_msn">
                <option value="1" <?php if($XFDSET['xfd_msn'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_msn'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_lines']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_lines" id="xfd_lines">
                <option value="1" <?php if($XFDSET['xfd_lines'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_lines'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_aol']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_aol" id="xfd_aol">
                <option value="1" <?php if($XFDSET['xfd_aol'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_aol'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td><hr></td><td><hr></td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_feedburn']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_feedburn" id="xfd_feedburn">
                <option value="1" <?php if($XFDSET['xfd_feedburn'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_feedburn'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_feedroute']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_feedroute" id="xfd_feedroute">
                <option value="1" <?php if($XFDSET['xfd_feedroute'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_feedroute'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>
        <tr>
          <td width="50%" align="right">
            <?php echo $lang_xfeeds['xfd_feedburnuname']; ?>&nbsp;&nbsp;
          </td>
          <td width="50%">
            <input id="xfd_feedburnuname" name="xfd_feedburnuname" value="<?php echo $XFDSET['xfd_feedburnuname']; ?>">
          </td>
        </tr>
        <tr>
          <td><hr></td><td><hr></td>
        </tr>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_theme']; ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_theme" id="xfd_theme">
                 <option value="0" <?php if($XFDSET['xfd_theme'] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['orange']?></option>
                 <option value="1" <?php if($XFDSET['xfd_theme'] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['azure']?></option>
                 <option value="2" <?php if($XFDSET['xfd_theme'] == 2) echo 'selected="selected"';?>><?php echo $lang_xfeeds['red']?></option>
                 <option value="3" <?php if($XFDSET['xfd_theme'] == 3) echo 'selected="selected"';?>><?php echo $lang_xfeeds['blue']?></option>
                 <option value="4" <?php if($XFDSET['xfd_theme'] == 4) echo 'selected="selected"';?>><?php echo $lang_xfeeds['transd']?></option>
                 <option value="5" <?php if($XFDSET['xfd_theme'] == 5) echo 'selected="selected"';?>><?php echo $lang_xfeeds['transl']?></option>
              </select>
          </td>
        </tr>
        <tr>
          <td><hr></td><td><hr></td>
        </tr>
        <?php
        // Show 5 custom blocks.
        for ($i = 1; $i <= 5; $i++) {
        ?>
        <tr>
          <td align="right"><?php echo $lang_xfeeds['xfd_customenable']; ?> <?php echo $i ?>&nbsp;&nbsp;</td>
          <td>
              <select name="xfd_customenable<?php echo $i ?>" id="xfd_customenable<?php echo $i ?>">
                <option value="1" <?php if($XFDSET['xfd_customenable'.$i] == 1) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_yes']?></option>
                <option value="0" <?php if($XFDSET['xfd_customenable'.$i] == 0) echo 'selected="selected"';?>><?php echo $lang_xfeeds['xfd_no']?></option>
          </select>
          </td>
        </tr>

        <tr>
          <td width="50%" align="right">
            <?php echo $lang_xfeeds['xfd_customtitle']; ?> <?php echo $i ?>&nbsp;&nbsp;
          </td>
          <td width="50%">
            <input id="xfd_customtitle<?php echo $i ?>" name="xfd_customtitle<?php echo $i ?>" value="<?php echo $XFDSET['xfd_customtitle'.$i]; ?>">
          </td>
        </tr>
        <tr>
          <td width="50%" align="right">
            <?php echo $lang_xfeeds['xfd_customurl']; ?> <?php echo $i ?>&nbsp;&nbsp;
          </td>
          <td width="50%">
            <input id="xfd_customurl<?php echo $i ?>" name="xfd_customurl<?php echo $i ?>" value="<?php echo $XFDSET['xfd_customurl'.$i]; ?>">
          </td>
        </tr>
        <tr>
          <td><hr></td><td><hr></td>
        </tr>
        <?php
        }
        ?>
		<tr>
			<td colspan="2" style="text-align:center">
				<input name="update" type="hidden" id="update" value="1" />
				<button value="<?=$lang_common['apply_changes']?>" name="submit" class="button" type="submit"><?=cpg_fetch_icon('ok', 1).$lang_common['apply_changes']?></button>
			</td>
		</tr>
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
      </table>
    </form></td>
</tr>

<?php
endtable();
pagefooter();
ob_end_flush();
?>