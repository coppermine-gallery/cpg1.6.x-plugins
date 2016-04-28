<?php
/**************************************************
  Coppermine 1.5.x Plugin - remote_videos
  *************************************************
  Copyright (c) 2009-2016 eenemeenemuu
  *************************************************
  $HeadURL: https://svn.code.sf.net/p/coppermine/code/branches/cpg1.5.x/plugins/remote_videos/codebase.php $
  $Revision: 8843 $
  $LastChangedBy: eenemeenemuu $
  $Date: 2016-03-23 12:11:09 +0100 (Wed, 23 Mar 2016) $
  **************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$thisplugin->add_action('plugin_install', 'remote_videos_install');
$thisplugin->add_action('plugin_uninstall', 'remote_videos_uninstall');
$thisplugin->add_filter('html_other_media', 'remote_videos_other_media');

/*
if (defined('THUMBNAILS_PHP') && USER_CAN_UPLOAD_PICTURES) {
    $thisplugin->add_action('post_breadcrumb','remote_videos_post_breadcrumb');
}


function remote_videos_upload_permission($aid) {

    global $CONFIG, $USER_DATA;

    // check if user can upload to the current album
    if (!GALLERY_ADMIN_MODE) {
        $row = mysql_fetch_assoc(cpg_db_query("SELECT uploads, owner FROM {$CONFIG['TABLE_ALBUMS']} WHERE aid = $aid LIMIT 1"));
        if ($row['owner'] == USER_ID) {
            return TRUE;
        } elseif ($row['uploads'] == 'YES') {
            $result = cpg_db_query("SELECT can_upload_pictures FROM {$CONFIG['TABLE_USERGROUPS']} WHERE group_id IN (".implode(',', $USER_DATA['groups']).")");
            while ($row = mysql_fetch_assoc($result)) {
                if ($row['can_upload_pictures']) {
                    return TRUE;
                    break;
                }
            }
            mysql_free_result($result);
        } else {
            return FALSE;
        }
    } else {
        return TRUE;
    }
}


function remote_videos_post_breadcrumb() {

    $superCage = Inspekt::makeSuperCage();
    $album = $superCage->get->getInt('album');

    if (remote_videos_upload_permission($album)) {
        global $CONFIG, $lang_main_menu;

        $options = "";
        foreach(remote_videos_get_hoster() as $key => $value) {
            if (is_numeric(strpos($CONFIG['allowed_mov_types'], $key))) {
                $options .= "<option value=\"$key\">$value</option>";
            }
        }

        if ($options != "") {
            $options = "<option disabled=\"disabled\" selected=\"selected\">-- Select --</option>".$options;
            $form = <<< EOT
                <form method="post" action="index.php?file=remote_videos/add_video">
                    <input type="hidden" name="album" value="$album" />
                    <select name="extension" class="listbox">$options</select>
                    <input type="text" name="filename" class="textinput" />
                    <input name="url" type="text" class="textinput"/>
                    <input type="submit" class="button" value="{$lang_main_menu['upload_pic_lnk']}" />
                </form>
EOT;
            starttable('100%', $form);
            endtable();
            echo '<img src="images/spacer.gif" width="1" height="7" alt="" />';
        }
    }
}
*/


function remote_videos_install() {
    global $CONFIG;
    cpg_db_query("ALTER TABLE {$CONFIG['TABLE_FILETYPES']} MODIFY extension CHAR(12)");

    return true;
}


function remote_videos_uninstall() {
    global $CONFIG;
    foreach(remote_videos_get_hoster() as $filetype => $value) {
        $CONFIG['allowed_mov_types'] = str_replace("/{$filetype}", '', $CONFIG['allowed_mov_types']);
        $CONFIG['allowed_mov_types'] = str_replace("{$filetype}/", '', $CONFIG['allowed_mov_types']);
        $CONFIG['allowed_mov_types'] = str_replace("{$filetype}", '', $CONFIG['allowed_mov_types']);
        cpg_db_query("DELETE FROM {$CONFIG['TABLE_FILETYPES']} WHERE extension = '{$filetype}'");
    }
    cpg_db_query("UPDATE {$CONFIG['TABLE_CONFIG']} SET value = '{$CONFIG['allowed_mov_types']}' WHERE name = 'allowed_mov_types'");

    return true;
}


function remote_videos_get_hoster() {
    $hoster = array(
        'youtube'      => 'YouTube',
        'myvideo'      => 'MyVideo',
        'vimeo'        => 'Vimeo',
        'yahoo'        => 'Yahoo! Video',
        'metacafe'     => 'Metacafe',
        'google'       => 'Google Video',
        'myspace'      => 'Myspace Video',
        'sevenload'    => 'SevenLoad',
        'clipfish'     => 'ClipFish',
        'dailymotion'  => 'Dailymotion',
        'gametrailers' => 'GameTrailers',
        'megavideo'    => 'MegaVideo',
        'spike'        => 'Spike',
        'current'      => 'Current',
        'collegehumor' => 'College Humor',
        'stickam'      => 'Stickam',
        'revver'       => 'Revver',
        'vine'         => 'Vine',
    );
    asort($hoster);

    return $hoster;
}


function remote_videos_html_replace($params, $pic_html) {
    global $CONFIG, $CURRENT_PIC_DATA;
    $check_result = preg_match($params['search_pattern']."i", file_get_contents(urldecode($CURRENT_PIC_DATA['url'])), $video_id);
    if ($check_result == "1") {
        $row = cpg_db_fetch_array(cpg_db_query("SELECT pwidth, pheight FROM {$CONFIG['TABLE_PICTURES']} WHERE pid = '{$CURRENT_PIC_DATA['pid']}'"), MYSQL_ASSOC, true);
        $pwidth = $row['pwidth'];
        $pheight = $row['pheight'];
        if ($pwidth == 0 || $pheight == 0) {
            if ($CONFIG['remote_video_movie_width'] == 0 || $CONFIG['remote_video_movie_width'] == 0) {
                $pwidth = $params['default_width'];
                $pheight = $params['default_height'];
            } else {
                $pwidth = $CONFIG['remote_video_movie_width'];
                $pheight = $CONFIG['remote_video_movie_height'] + $params['player_height'];
            }
            $CURRENT_PIC_DATA['pwidth'] = $pwidth;
            $CURRENT_PIC_DATA['pheight'] = $pheight;
        } else {
            $pheight += $params['player_height'];
        }
        if (isset($params['iframe'])) {
            $new_html = $params['iframe'];
            $new_html = str_replace("{MATCH_1}", $video_id[1], $new_html);
            $new_html = str_replace("{MATCH_2}", $video_id[2], $new_html);
            $new_html = str_replace("{WIDTH}", $pwidth, $new_html);
            $new_html = str_replace("{HEIGHT}", $pheight, $new_html);
            $new_html = str_replace("{AUTOPLAY}", $CONFIG['media_autostart'], $new_html);
            if ($CURRENT_PIC_DATA['extension'] == "vine") {
                $vine_mode = strlen($CONFIG['remote_video_vine_mode']) > 0 ? $CONFIG['remote_video_vine_mode'] : 'simple';
                $vine_audio = $CONFIG['remote_video_vine_autoaudio'] ? $CONFIG['remote_video_vine_autoaudio'] : 0;
                $new_html = str_replace("{VINE_MODE}", $vine_mode, $new_html);
                $new_html = str_replace("{VINE_AUDIO}", $vine_audio, $new_html);
            }
        } else {
            $params['player'] = str_replace("{MATCH_1}", $video_id[1], $params['player']);
            $params['player'] = str_replace("{MATCH_2}", $video_id[2], $params['player']);
            $params['player'] = str_replace("{WIDTH}", $pwidth, $params['player']);
            $params['player'] = str_replace("{HEIGHT}", $pheight, $params['player']);
            $new_html  = "<object type=\"{$CURRENT_PIC_DATA['mime']}\" width=\"{$pwidth}\" height=\"{$pheight}\" data=\"{$params['player']}\">";
            $new_html .= "<param name=\"movie\" value=\"{$params['player']}\" />";
            $new_html .= "<param name=\"allowfullscreen\" value=\"true\" />";
            if (isset($params['extra_params'])) {
                $params['extra_params'] = str_replace("{MATCH_1}", $video_id[1], $params['extra_params']);
                $params['extra_params'] = str_replace("{MATCH_2}", $video_id[2], $params['extra_params']);
                $params['extra_params'] = str_replace("{THUMBURL}", "&thumbUrl=", $params['extra_params']); // TODO
                $new_html .= $params['extra_params'];
            }
            $new_html .= "</object>";
        }
    } else {
        $new_html = "Error: invalid video id";
    }
    $search = '(<object.*</object>)';
    $pic_html = preg_replace($search, $new_html, $pic_html);
    return $pic_html;
}


function remote_videos_other_media($pic_html) {
    global $CURRENT_PIC_DATA;
    switch($CURRENT_PIC_DATA['extension']) {

        case 'youtube':
            $params = array(
                'search_pattern' => '/http(?:s)?:\/\/(?:www\.)?(?:youtube\.com\/watch(?:_private)?\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/',
                'default_width'  => 640,
                'default_height' => 360,
              //'player'         => 'http://www.youtube.com/v/{MATCH_1}',
                'player_height'  => 0,
                'iframe'         => '<iframe width="{WIDTH}" height="{HEIGHT}" src="https://www.youtube.com/embed/{MATCH_1}?autoplay={AUTOPLAY}" frameborder="0" allowfullscreen></iframe>',
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'myvideo':
            $params = array(
                'search_pattern' => '/http:\/\/www\.myvideo\.de\/watch\/([0-9]+)\/?/',
                'default_width'  => 613,
                'default_height' => 383,
                'player'         => 'http://www.myvideo.de/movie/{MATCH_1}',
                'player_height'  => 19,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'vimeo':
            $params = array(
                'search_pattern' => '/http(?:s)?:\/\/(?:www\.)?vimeo\.com\/([0-9]+)/',
                'default_width'  => 640,
                'default_height' => 360,
                'player'         => 'http://vimeo.com/moogaloop.swf?clip_id={MATCH_1}',
                'player_height'  => 0,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'yahoo':
            $params = array(
                'search_pattern' => '/http:\/\/video\.yahoo\.com\/watch\/([0-9]+)\/([0-9]+)/',
                'default_width'  => 576,
                'default_height' => 357,
                'player'         => 'http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.40',
                'player_height'  => 34,
                'extra_params'   => '<param name="flashVars" value="id={MATCH_2}&vid={MATCH_1}{THUMBURL}" />',
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'metacafe':
            $params = array(
                'search_pattern' => '/http:\/\/www\.metacafe\.com\/watch\/([0-9]+)\/([a-z0-9_-])/',
                'default_width'  => 565,
                'default_height' => 458,
                'player'         => 'http://www.metacafe.com/fplayer/{MATCH_1}/{MATCH_2}.swf',
                'player_height'  => 32,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'google':
            $params = array(
                'search_pattern' => '/http:\/\/video\.google\.[\w]+\/videoplay\?docid=([0-9]+)/',
                'default_width'  => 640,
                'default_height' => 385,
                'player'         => 'http://video.google.com/googleplayer.swf?docid={MATCH_1}',
                'player_height'  => 27,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'myspace':
            $params = array(
                'search_pattern' => '/http:\/\/vids\.myspace\.com\/index\.cfm\?fuseaction=vids\.individual&videoid=([0-9]+)/',
                'default_width'  => 640,
                'default_height' => 400,
                'player'         => 'http://mediaservices.myspace.com/services/media/embed.aspx/m={MATCH_1}',
                'player_height'  => 40,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

         case 'sevenload':
            $params = array(
                'search_pattern' => '/http:\/\/([\w]+)\.sevenload\.com\/videos\/([A-Za-z0-9]{7})/',
                'default_width'  => 445,
                'default_height' => 334,
                'player'         => 'http://{MATCH_1}.sevenload.com/pl/{MATCH_2}/{WIDTH}x{HEIGHT}/swf',
                'player_height'  => 0,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;    

        case 'clipfish':
            $params = array(
                'search_pattern' => '/http:\/\/www\.clipfish\.de\/video\/([0-9]+)/',
                'default_width'  => 464,
                'default_height' => 380,
                'player'         => 'http://www.clipfish.de/videoplayer.swf?vid={MATCH_1}&r=1',
                'player_height'  => 31,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'dailymotion':
            $params = array(
                'search_pattern' => '/http:\/\/www\.dailymotion\.com\/video\/([a-z0-9]{6})/',
                'default_width'  => 608,
                'default_height' => 356,
                'player'         => 'http://www.dailymotion.com/swf/{MATCH_1}',
                'player_height'  => 0,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'gametrailers':
            $params = array(
                'search_pattern' => '/http:\/\/www\.gametrailers\.com\/video\/.*\/([0-9]+)/',
                'default_width'  => 480,
                'default_height' => 392,
                'player'         => 'http://www.gametrailers.com/remote_wrap.php?mid={MATCH_1}',
                'player_height'  => 32,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'megavideo':
            $params = array(
                'search_pattern' => '/http:\/\/(?:www\.)?megavideo\.com\/\?v=([A-Z0-9]{8})/',
                'default_width'  => 640,
                'default_height' => 480,
                'player'         => 'http://www.megavideo.com/v/{MATCH_1}',
                'player_height'  => 0,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'spike':
            $params = array(
                'search_pattern' => '/http:\/\/www\.spike\.com\/video\/.*\/([0-9]+)/',
                'default_width'  => 640,
                'default_height' => 384,
                'player'         => 'http://www.spike.com/efp',
                'extra_params'   => '<param name="flashVars" value="flvbaseclip={MATCH_1}" />',
                'player_height'  => 31,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'current':
            $params = array(
                'search_pattern' => '/http:\/\/current\.com\/items\/([0-9]+)_.*/',
                'default_width'  => 560,
                'default_height' => 420,
                'player'         => 'http://current.com/e/{MATCH_1}',
                'player_height'  => 0,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'collegehumor':
            $params = array(
                'search_pattern' => '/http:\/\/www\.collegehumor\.com\/video:([0-9]+)/',
                'default_width'  => 640,
                'default_height' => 360,
                'player'         => 'http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id={MATCH_1}',
                'player_height'  => 0,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'stickam':
            $params = array(
                'search_pattern' => '/http:\/\/(?:www\.)?stickam\.com\/viewMedia.do\?mId=([0-9]+)/',
                'default_width'  => 448,
                'default_height' => 336,
                'player'         => 'http://player.stickam.com/flashVarMediaPlayer/{MATCH_1}',
                'player_height'  => 0,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'revver':
            $params = array(
                'search_pattern' => '/http:\/\/(?:www\.)?revver\.com\/video\/([0-9]+)\/.*/',
                'default_width'  => 480,
                'default_height' => 392,
                'player'         => 'http://flash.revver.com/player/1.0/player.swf',
                'extra_params'   => '<param name="flashVars" value="mediaId={MATCH_1}" />',
                'player_height'  => 31,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

        case 'vine':
            $params = array(
                'search_pattern'         => '/http(?:s)?:\/\/(?:www\.)?vine\.co\/v\/([A-Za-z0-9]+)/',
                'default_width'          => 600,
                'default_height'         => 600,
                'player'                 => '',
                'extra_params'           => '',
                'iframe'                 => '<iframe class="vine-embed" src="//vine.co/v/{MATCH_1}/embed/{VINE_MODE}?audio={VINE_AUDIO}" width="{WIDTH}" height="{HEIGHT}" frameborder="0" style="border: 1px #000 solid;"></iframe><script async src="//platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>',
                'player_height'          => 0,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

/*
        case '':
            $params = array(
                'search_pattern' => '',
                'default_width'  => ,
                'default_height' => ,
                'player'         => '{MATCH_1}',
                'player_height'  => ,
            );
            return remote_videos_html_replace($params, $pic_html);
        break;

    TODO
    * 6.cn -- derivation not possible -> need to enter parts from provided embed code
    * Apple trailers -- no embed code provided
    * Blip.tv -- derivation not possible -> need to enter parts from provided embed code
    * MyShows -- derivation not possible -> need to enter parts from provided embed code
    * Break -- derivation not possible -> need to enter parts from provided embed code
    * Jumpcut -- As of June 15, 2009 the Jumpcut.com site has been officially closed.
    * FreeVideoBlog (now Vidiac) -- derivation not possible -> need to enter parts from provided embed code
    * StreetFire -- derivation not possible -> need to enter parts from provided embed code
    * DropShots -- no embed code provided
    * Bofunk -- derivation not possible -> need to enter parts from provided embed code
    * Virb.com -- derivation not possible -> need to enter parts from provided embed code
    * TED.com -- no embed code provided

*/

        default: return $pic_html;
    }
    return $pic_html;
}


?>
