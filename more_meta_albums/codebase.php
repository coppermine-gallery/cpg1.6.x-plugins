<?php
/*********************************************
  Coppermine Plugin - More meta albums
  ********************************************
  Copyright (c) 2010-2018 eenemeenemuu
**********************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');


// Meta album titles
$thisplugin->add_action('page_start','mma_page_start');
function mma_page_start() {
    global $CONFIG, $lang_meta_album_names, $lang_plugin_more_meta_albums, $valid_meta_albums;

    require_once "./plugins/more_meta_albums/lang/english.php";
    if ($CONFIG['lang'] != 'english' && file_exists("./plugins/more_meta_albums/lang/{$CONFIG['lang']}.php")) {
        require_once "./plugins/more_meta_albums/lang/{$CONFIG['lang']}.php";
    }

    foreach($lang_plugin_more_meta_albums as $key => $value) {
        if (substr($key, -6) == "_title") {
            $meta_album_name = substr($key, 0, count($key)-7);
            $lang_meta_album_names[$meta_album_name] = $value;
            $valid_meta_albums[] = $meta_album_name;
        }
    }
}


// Add 'album' type
$thisplugin->add_filter('theme_thumbnails_album_types', 'mma_album_types');
function mma_album_types($album_types) {
    $album_types['albums'][] = 'newalb';
    $album_types['albums'][] = 'randalb';
    $album_types['albums'][] = 'randuseralb';
    $album_types['albums'][] = 'randpublicalb';

    return $album_types;
}


// Meta album get_pic_pos
$thisplugin->add_filter('meta_album_get_pic_pos','mma_get_pic_pos');
function mma_get_pic_pos($album) {

    if (is_numeric($album)) {
        return $album;
    }

    global $CONFIG, $pid, $RESTRICTEDWHERE;

    switch($album) {
        case 'image': // All pictures
        case 'movie': // All videos
        case 'audio': // All audio files
        case 'document': // All documents
            $filetypes = array();
            $filetypes_sql = "";
            $result = cpg_db_query("SELECT extension FROM {$CONFIG['TABLE_FILETYPES']} WHERE content = '$album'");
            while($row = cpg_db_fetch_assoc($result)) {
                $filetypes[] = $row['extension'];
            }
            foreach($filetypes as $filetype) {
                $filetypes_sql .= "filename LIKE '%.$filetype' OR ";
            }
            $filetypes_sql .= "0";

            $query = "SELECT COUNT(*) FROM {$CONFIG['TABLE_PICTURES']} AS p
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                $RESTRICTEDWHERE
                AND approved = 'YES'
                AND ($filetypes_sql)
                AND pid < $pid";

                $result = cpg_db_query($query);

                list($pos) = cpg_db_fetch_row($result);
                cpg_db_free_result($result);
            return strval($pos);
            break;

        case 'landscape': // Landscape format (height < width)
        case 'portrait': // Portrait format (width < height)
        case 'panorama': // Panorama format (width > height*2)
            $condition = array(
                'landscape' => 'AND pwidth > pheight',
                'portrait' => 'AND pwidth < pheight',
                'panorama' => 'AND pwidth > pheight * 2'
            );

            $query = "SELECT COUNT(*) FROM {$CONFIG['TABLE_PICTURES']} AS p
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                $RESTRICTEDWHERE
                AND approved = 'YES'
                AND pwidth > 0 
                AND pheight > 0
                {$condition[$album]}
                AND pid < $pid";

                $result = cpg_db_query($query);

                list($pos) = cpg_db_fetch_row($result);
                cpg_db_free_result($result);
            return strval($pos);
            break;

        case 'mostcom': // Most commented files
            $query = "SELECT p.pid, COUNT(*) AS count FROM {$CONFIG['TABLE_PICTURES']} AS p
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                INNER JOIN {$CONFIG['TABLE_COMMENTS']} AS c ON c.pid = p.pid
                $RESTRICTEDWHERE
                AND approved = 'YES'
                AND approval = 'YES'
                GROUP BY p.pid
                ORDER BY count DESC, p.pid ASC";

                $result = cpg_db_query($query);
                $pos = 0;
                while($row = cpg_db_fetch_assoc($result)) {
                    if ($row['pid'] == $pid) {
                        break;
                    }
                    $pos++;
                }
                cpg_db_free_result($result);

            return strval($pos);
            break;

        case 'mostvot': // Most voted files
            $query = "SELECT votes FROM {$CONFIG['TABLE_PICTURES']} WHERE pid = $pid";
            $result = cpg_db_query($query);
            $votes = cpg_db_result($result, 0);
            cpg_db_free_result($result);

            $query = "SELECT COUNT(*) FROM {$CONFIG['TABLE_PICTURES']} AS p
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                $RESTRICTEDWHERE
                AND approved = 'YES'
                AND (p.votes > $votes
                OR p.votes = $votes AND pid < $pid)";

                $result = cpg_db_query($query);

                list($pos) = cpg_db_fetch_row($result);
                cpg_db_free_result($result);
            return strval($pos);
            break;

        case 'lastcommented': // Last commented files
            $query = "SELECT msg_date FROM {$CONFIG['TABLE_COMMENTS']} WHERE pid = $pid ORDER BY msg_id DESC LIMIT 1";
            $result = cpg_db_query($query);
            $msg_date = cpg_db_result($result, 0);
            cpg_db_free_result($result);

            $query = "SELECT COUNT(*) FROM {$CONFIG['TABLE_COMMENTS']} AS c1 
                LEFT JOIN {$CONFIG['TABLE_COMMENTS']} AS c2 ON (c2.pid = c1.pid AND c2.msg_date > c1.msg_date)
                INNER JOIN {$CONFIG['TABLE_PICTURES']} AS p ON p.pid = c1.pid 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND c1.approval = 'YES'
                AND c2.pid IS NULL
                AND (c1.msg_date > '$msg_date'
                OR c1.msg_date = '$msg_date' AND c1.pid < $pid)";

                $result = cpg_db_query($query);

                list($pos) = cpg_db_fetch_row($result);
                cpg_db_free_result($result);
            return strval($pos);
            break;

        case 'toprateda': // Top rated pictures (accumulated)
            $query = "SELECT MAX(p.votes * p.pic_rating) FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND p.votes >= {$CONFIG['min_votes_for_rating']}";
            $result = cpg_db_query($query);
            $max_rating_points = cpg_db_result($result, 0);
            cpg_db_free_result($result);
            
            $query = "SELECT (votes * pic_rating / $max_rating_points * 10000) AS pic_rating FROM {$CONFIG['TABLE_PICTURES']} WHERE pid = $pid";
            $result = cpg_db_query($query);
            $pic_rating = cpg_db_result($result, 0);
            cpg_db_free_result($result);

            $query = "SELECT p.pid, (p.votes * p.pic_rating / $max_rating_points * 10000) AS pic_rating FROM {$CONFIG['TABLE_PICTURES']} AS p
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                $RESTRICTEDWHERE
                AND approved = 'YES'
                AND p.votes >= {$CONFIG['min_votes_for_rating']}
                ORDER BY pic_rating DESC, pid ASC";

                $result = cpg_db_query($query);
                $pos = 0;
                while($row = cpg_db_fetch_assoc($result)) {
                    if ($row['pid'] == $pid) {
                        break;
                    }
                    $pos++;
                }
                cpg_db_free_result($result);

            return strval($pos);
            break;

/*
        // TODO
        case 'topnday': // Most viewed files last 24 hours
        case 'topnweek': // Most viewed files last 7 days
        case 'topnmonth': // Most viewed files last 30 days
            $condition = array(
                'topnday' => 1,
                'topnweek' => 7,
                'topnmonth' => 30
            );
*/
        default: 
            return $album;
    }
}


// New meta albums
$thisplugin->add_filter('meta_album', 'mma_meta_album');
function mma_meta_album($meta) {
    global $CONFIG, $CURRENT_CAT_NAME, $RESTRICTEDWHERE, $lang_plugin_more_meta_albums;

    switch ($meta['album']) {
        case 'image': // All pictures
        case 'movie': // All videos
        case 'audio': // All audio files
        case 'document': // All documents
            $icons = array(
                'image' => 'picture_sort',
                'movie' => 'slideshow',
                'audio' => 'announcement',
                'document' => 'documentation'
            );

            $album_name = cpg_fetch_icon($icons[$meta['album']], 2)." ".$lang_plugin_more_meta_albums[$meta['album'].'_title'];
            if ($CURRENT_CAT_NAME) {
                $album_name .= " - $CURRENT_CAT_NAME";
            }

            $filetypes = array();
            $filetypes_sql = "";
            $result = cpg_db_query("SELECT extension FROM {$CONFIG['TABLE_FILETYPES']} WHERE content = '{$meta['album']}'");
            while($row = cpg_db_fetch_assoc($result)) {
                $filetypes[] = $row['extension'];
            }
            foreach($filetypes as $filetype) {
                $filetypes_sql .= "filename LIKE '%.$filetype' OR ";
            }
            $filetypes_sql .= "0";

            $query = "SELECT pid FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE
                AND approved = 'YES'
                AND ($filetypes_sql)";
            $result = cpg_db_query($query);
            $count = cpg_db_num_rows($result);
            cpg_db_free_result($result);
            if (!$count) {
                $rowset = array();
                break;
            }

            $query = "SELECT p.* FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND ($filetypes_sql)
                ORDER BY pid ASC 
                {$meta['limit']}";
            $result = cpg_db_query($query);
            $rowset = cpg_db_fetch_rowset($result);
            cpg_db_free_result($result);

            build_caption($rowset);
            break;

        case 'landscape': // Landscape format (height < width)
        case 'portrait': // Portrait format (width < height)
        case 'panorama': // Panorama format (width < height*2)
            $icons = array(
                'landscape' => 'searchnew',
                'portrait' => 'user_mgr',
                'panorama' => 'searchnew'
            );

            $condition = array(
                'landscape' => 'AND pwidth > pheight',
                'portrait' => 'AND pwidth < pheight',
                'panorama' => 'AND pwidth > pheight * 2'
            );

            $album_name = cpg_fetch_icon($icons[$meta['album']], 2)." ".$lang_plugin_more_meta_albums[$meta['album'].'_title'];
            if ($CURRENT_CAT_NAME) {
                $album_name .= " - $CURRENT_CAT_NAME";
            }

            $query = "SELECT pid FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE
                AND approved = 'YES'
                AND pwidth > 0
                AND pheight > 0
                {$condition[$meta['album']]}";
            $result = cpg_db_query($query);
            $count = cpg_db_num_rows($result);
            cpg_db_free_result($result);
            if (!$count) {
                $rowset = array();
                break;
            }

            $query = "SELECT p.* FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND pwidth > 0
                AND pheight > 0
                {$condition[$meta['album']]}
                ORDER BY pid ASC 
                {$meta['limit']}";
            $result = cpg_db_query($query);
            $rowset = cpg_db_fetch_rowset($result);
            cpg_db_free_result($result);

            build_caption($rowset);
            break;

        case 'mostcom': // Most commented files
            $album_name = cpg_fetch_icon('comment', 2)." ".$lang_plugin_more_meta_albums['mostcom_title'];
            if ($CURRENT_CAT_NAME) {
                $album_name .= " - $CURRENT_CAT_NAME";
            }

            $query = "SELECT DISTINCT c.pid FROM {$CONFIG['TABLE_COMMENTS']} AS c 
                INNER JOIN {$CONFIG['TABLE_PICTURES']} AS p ON c.pid = p.pid 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE
                AND approved = 'YES'
                AND approval = 'YES'";
            $result = cpg_db_query($query);
            $count = cpg_db_num_rows($result);
            cpg_db_free_result($result);
            if (!$count) {
                $rowset = array();
                break;
            }

            $query = "SELECT p.*, COUNT(c.pid) AS count FROM {$CONFIG['TABLE_COMMENTS']} c 
                INNER JOIN {$CONFIG['TABLE_PICTURES']} AS p ON p.pid = c.pid 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND approval = 'YES'
                GROUP BY p.pid 
                ORDER BY count DESC, p.pid ASC 
                {$meta['limit']}";
            $result = cpg_db_query($query);
            $rowset = cpg_db_fetch_rowset($result);
            cpg_db_free_result($result);
            
            $preVal = $CONFIG['display_comment_count'];
            $CONFIG['display_comment_count'] = 1;
            build_caption($rowset);
            $CONFIG['display_comment_count'] = $preVal;
            break;

        case 'mostvot': // Most voted files
            $album_name = cpg_fetch_icon('top_rated', 2)." ".$lang_plugin_more_meta_albums['mostvot_title'];
            if ($CURRENT_CAT_NAME) {
                $album_name .= " - $CURRENT_CAT_NAME";
            }

            $query = "SELECT pid FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND p.votes > 0";
            $result = cpg_db_query($query);
            $count = cpg_db_num_rows($result);
            cpg_db_free_result($result);
            if (!$count) {
                $rowset = array();
                break;
            }

            $query = "SELECT p.* FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND p.votes > 0
                ORDER BY p.votes DESC, pid ASC
                {$meta['limit']}";
            $result = cpg_db_query($query);
            $rowset = cpg_db_fetch_rowset($result);
            cpg_db_free_result($result);

            build_caption($rowset, array('pic_rating'));
            break;

        case 'lastcommented': // Last commented files
            $album_name = cpg_fetch_icon('comment', 2)." ".$lang_plugin_more_meta_albums['lastcommented_title'];
            if ($CURRENT_CAT_NAME) {
                $album_name .= " - $CURRENT_CAT_NAME";
            }

            $query = "SELECT DISTINCT c.pid FROM {$CONFIG['TABLE_COMMENTS']} AS c 
                INNER JOIN {$CONFIG['TABLE_PICTURES']} AS p ON c.pid = p.pid 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE
                AND approved = 'YES'
                AND approval = 'YES'";
            $result = cpg_db_query($query);
            $count = cpg_db_num_rows($result);
            cpg_db_free_result($result);
            if (!$count) {
                $rowset = array();
                break;
            }

            $query = "SELECT p.*, com1.*, UNIX_TIMESTAMP(com1.msg_date) AS msg_date FROM {$CONFIG['TABLE_COMMENTS']} AS com1 
                LEFT JOIN {$CONFIG['TABLE_COMMENTS']} AS com2 ON (com2.pid = com1.pid AND com2.msg_date > com1.msg_date)
                INNER JOIN {$CONFIG['TABLE_PICTURES']} AS p ON p.pid = com1.pid 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND com1.approval = 'YES'
                AND com2.pid IS NULL
                ORDER BY msg_date DESC 
                {$meta['limit']}";
            $result = cpg_db_query($query);
            $rowset = cpg_db_fetch_rowset($result);
            cpg_db_free_result($result);

            build_caption($rowset, array('msg_date'));
            break;

        case 'toprateda': // Top rated pictures (accumulated)
            $album_name = cpg_fetch_icon('top_rated', 2)." ".$lang_plugin_more_meta_albums['toprateda_title'];
            if ($CURRENT_CAT_NAME) {
                $album_name .= " - $CURRENT_CAT_NAME";
            }

            $query = "SELECT pid FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND p.votes >= {$CONFIG['min_votes_for_rating']}";
            $result = cpg_db_query($query);
            $count = cpg_db_num_rows($result);
            cpg_db_free_result($result);
            if (!$count) {
                $rowset = array();
                break;
            }

            $query = "SELECT MAX(p.votes * p.pic_rating) FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND p.votes >= {$CONFIG['min_votes_for_rating']}";
            $result = cpg_db_query($query);
            $max_rating_points = cpg_db_result($result, 0);
            cpg_db_free_result($result);

            $query = "SELECT p.*, (p.votes * p.pic_rating / $max_rating_points * 10000) AS pic_rating FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND p.votes >= {$CONFIG['min_votes_for_rating']}
                ORDER BY pic_rating DESC, pid ASC
                {$meta['limit']}";
            $result = cpg_db_query($query);
            $rowset = cpg_db_fetch_rowset($result);
            cpg_db_free_result($result);

            build_caption($rowset, array('pic_rating'));
            break;

        case 'newalb': // New albums
            $album_name = cpg_fetch_icon('last_created', 2)." ".$lang_plugin_more_meta_albums['newalb_title'];
            if ($CURRENT_CAT_NAME) {
                $album_name .= " - $CURRENT_CAT_NAME";
            }

            $query = "SELECT pid FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE 
                AND approved = 'YES'
                AND p.pid = r.thumb ";
            $result = cpg_db_query($query);
            $count = cpg_db_num_rows($result);
            cpg_db_free_result($result);
            if (!$count) {
                $rowset = array();
                break;
            }

            $query = "SELECT p.*, alb_hits AS hits  FROM {$CONFIG['TABLE_PICTURES']} AS p 
                INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid 
                $RESTRICTEDWHERE 
                AND approved = 'YES' 
                AND p.pid = r.thumb 
                ORDER BY ctime DESC
                {$meta['limit']}";
            $result = cpg_db_query($query);
            $rowset = cpg_db_fetch_rowset($result);
            cpg_db_free_result($result);

            build_caption($rowset, array('ctime'));
            break;

        case 'randalb': // Random albums
        case 'randuseralb': // Random albums in user categories
        case 'randpublicalb': // Random albums in public categories
            $condition = array(
                'randalb' => '',
                'randuseralb' => 'AND r.category > '.FIRST_USER_CAT,
                'randpublicalb' => 'AND r.category < '.FIRST_USER_CAT
            );

            $album_name = cpg_fetch_icon('alb_mgr', 2)." ".$lang_plugin_more_meta_albums[$meta['album'].'_title'];
            if ($CURRENT_CAT_NAME) {
                $album_name .= " - $CURRENT_CAT_NAME";
            }

            $query = "SELECT COUNT(*)
                    FROM {$CONFIG['TABLE_PICTURES']} AS p
                    INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                    $RESTRICTEDWHERE
                    AND approved = 'YES'
                    {$condition[$meta['album']]}
                    GROUP BY p.aid
                    HAVING COUNT(p.pid) > 0
                    ORDER BY RAND()";
            $result = cpg_db_query($query);
            $count = cpg_db_num_rows($result);
            cpg_db_free_result($result);
            if (!$count) {
                $rowset = array();
                break;
            }

            $query = "SELECT p.*, r.title
                    FROM {$CONFIG['TABLE_PICTURES']} AS p
                    INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                    $RESTRICTEDWHERE
                    AND approved = 'YES'
                    {$condition[$meta['album']]}
                    GROUP BY p.aid
                    HAVING COUNT(p.pid) > 0
                    ORDER BY RAND()
                    {$meta['limit']}";
            $result = cpg_db_query($query);
            $rowset = cpg_db_fetch_rowset($result);
            cpg_db_free_result($result);

            build_caption($rowset, array('ctime'));
            break;

        case 'topnday': // Most viewed files last 24 hours
        case 'topnweek': // Most viewed files last 7 days
        case 'topnmonth': // Most viewed files last 30 days
            $condition = array(
                'topnday' => 1,
                'topnweek' => 7,
                'topnmonth' => 30
            );

            $album_name = cpg_fetch_icon('most_viewed', 2)." ".$lang_plugin_more_meta_albums[$meta['album'].'_title'];
            if ($CURRENT_CAT_NAME) {
                $album_name .= " - $CURRENT_CAT_NAME";
            }

            $query = "SELECT NULL
                    FROM {$CONFIG['TABLE_PICTURES']} AS p
                    INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                    INNER JOIN {$CONFIG['TABLE_HIT_STATS']} AS s ON p.pid = s.pid
                    $RESTRICTEDWHERE
                    AND approved = 'YES'
                    AND s.sdate > ".(time() - (CPG_DAY * $condition[$meta['album']]))."
                    GROUP BY p.pid";
            $result = cpg_db_query($query);
            $count = cpg_db_num_rows($result);
            cpg_db_free_result($result);
            if (!$count) {
                $rowset = array();
                break;
            }

            $query = "SELECT p.*, r.title, COUNT(s.pid) as hits
                    FROM {$CONFIG['TABLE_PICTURES']} AS p
                    INNER JOIN {$CONFIG['TABLE_ALBUMS']} AS r ON r.aid = p.aid
                    INNER JOIN {$CONFIG['TABLE_HIT_STATS']} AS s ON p.pid = s.pid
                    $RESTRICTEDWHERE
                    AND approved = 'YES'
                    AND s.sdate > ".(time() - (CPG_DAY * $condition[$meta['album']]))."
                    GROUP BY p.pid
                    ORDER BY hits DESC, p.pid DESC
                    {$meta['limit']}";
            $result = cpg_db_query($query);
            $rowset = cpg_db_fetch_rowset($result);
            cpg_db_free_result($result);

            build_caption($rowset, array('hits'));
            break;

        default:
            return $meta;
    }
    
    $meta['album_name'] = $album_name;
    $meta['count'] = $count;
    $meta['rowset'] = $rowset;

    return $meta;
}

//EOF