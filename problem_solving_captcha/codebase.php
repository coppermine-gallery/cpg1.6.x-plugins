<?php
/**************************************************
  Coppermine 1.6.x Plugin - Problem Solving CAPTCHA
  *************************************************
  Copyright (c) 2013-2019 eenemeenemuu
**************************************************/

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

define('PSC_QUESTION_PREFIX', 'plugin_psc_q_');
define('PSC_ANSWER_PREFIX', 'plugin_psc_a_');

function psc_get_question_ids() {
    global $CONFIG;
    foreach ($CONFIG as $key => $value) {
        if (strpos($key, PSC_QUESTION_PREFIX) === 0) {
            $psc_question_ids[] = substr($key, strlen(PSC_QUESTION_PREFIX));
        }
    }
    return $psc_question_ids;
}

function psc_get_random_question() {
    global $CONFIG;
    $psc_question_ids = psc_get_question_ids();
    $rand_id = $psc_question_ids[mt_rand() % count($psc_question_ids)];
    return array('id' => $rand_id, 'text' => $CONFIG[PSC_QUESTION_PREFIX . $rand_id]);
}

function psc_check_captcha($name) {
    global $CONFIG;
    $superCage = Inspekt::makeSuperCage();
    if ($superCage->post->getRaw('comment') == '' && strtolower(trim($superCage->post->getRaw($name))) == strtolower(trim($CONFIG[PSC_ANSWER_PREFIX . $superCage->post->getInt('captcha_id')]))) {
        return true;
    } else {
        return false;
    }
}

$thisplugin->add_filter('captcha_contact_print', 'psc_captcha_print');
$thisplugin->add_filter('captcha_register_print', 'psc_captcha_print');
$thisplugin->add_filter('captcha_comment_print', 'psc_captcha_print');
$thisplugin->add_filter('captcha_ecard_print', 'psc_captcha_print');
function psc_captcha_print($captcha_print) {
    $question = psc_get_random_question();
    $additional_hidden_field = '<div style="display:none"><textarea class="textinput" id="comment" name="comment"></textarea></div>';
    $captcha_print = preg_replace('/maxlength="[0-9]+"/', '', $captcha_print);
    $captcha_print = str_replace('<img src="captcha.php" align="middle" border="0" alt="" />', $question['text'].'<input type="hidden" name="captcha_id" value="'.$question['id'].'" />'.$additional_hidden_field, $captcha_print);
    return $captcha_print;
}

$thisplugin->add_action('captcha_contact_validate', 'psc_captcha_contact_validate');
function psc_captcha_contact_validate() {
    if (!psc_check_captcha('captcha')) {
        global $lang_errors, $captcha_remark, $expand_array, $error;
        $captcha_remark = $lang_errors['captcha_error'];
        $expand_array[] = 'captcha_remark';
        $error++;
    }
}

$thisplugin->add_filter('captcha_register_validate', 'psc_captcha_register_validate');
function psc_captcha_register_validate($error) {
    if (!psc_check_captcha('confirmCode')) {
        global $lang_errors, $error;
        $error .= '<li style="list-style-image:url(images/icons/stop.png)">' . $lang_errors['captcha_error'] . '</li>';
    }
    return $error;
}

$thisplugin->add_action('captcha_comment_validate', 'psc_captcha_comment_validate');
function psc_captcha_comment_validate() {
    if (!psc_check_captcha('confirmCode')) {
        global $CONFIG, $USER_DATA, $hdr_ip, $lang_errors;
        if ($CONFIG['log_mode'] != 0) {
            log_write('Captcha authentication for comment failed for user '.$USER_DATA['user_name'].' at ' . $hdr_ip, CPG_SECURITY_LOG);
        }
        cpg_die(ERROR, $lang_errors['captcha_error'], __FILE__, __LINE__);
    }
}

$thisplugin->add_action('captcha_ecard_validate', 'psc_captcha_ecard_validate');
function psc_captcha_ecard_validate() {
    if (!psc_check_captcha('confirmCode')) {
        global $CONFIG, $USER_DATA, $hdr_ip, $lang_errors;
        if ($CONFIG['log_mode'] != 0) {
            log_write('Captcha authentication for ecard failed for user '.$USER_DATA['user_name'].' at ' . $hdr_ip, CPG_SECURITY_LOG);
        }
        cpg_die(ERROR, $lang_errors['captcha_error'], __FILE__, __LINE__);
    }
}

//EOF