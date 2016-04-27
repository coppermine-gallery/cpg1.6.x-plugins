<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Display a block on each gallery page that shows users and guests actually online.';
$lang_plugin_onlinestats['name'] = 'Who is online?';
$lang_plugin_onlinestats['config_extra'] = 'To enable this plugin (make it actually display the onlinestats block), the string "onlinestats" (separated with a slash) has been added to "the content of the main page" in <a href="admin.php">Coppermine\'s config</a> in the section "Album list view". The setting should now look like "breadcrumb/catlist/alblist/onlinestats" or similar. To change the position of the block, move the string "onlinestats" around inside that config field.';
$lang_plugin_onlinestats['config_install'] = 'The plugin runs additional queries on the database each time it is being executed, burning CPU cycles and using resources. If your Coppermine gallery is slow or has got a lot of users, you shouldn\'t use it.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'There is %s registered user';
$lang_plugin_onlinestats['we_have_reg_members'] = ' There are %s registered users';
$lang_plugin_onlinestats['most_recent'] = 'The newest registered user is %s';
$lang_plugin_onlinestats['is'] = 'In total there is %s visitor online';
$lang_plugin_onlinestats['are'] = 'In total there are %s visitors online';
$lang_plugin_onlinestats['and'] = 'and';
$lang_plugin_onlinestats['reg_member'] = '%s registered user';
$lang_plugin_onlinestats['reg_members'] = '%s registered users';
$lang_plugin_onlinestats['guest'] = '%s guest';
$lang_plugin_onlinestats['guests'] = '%s guests';
$lang_plugin_onlinestats['record'] = 'Most users ever online: %s on %s';
$lang_plugin_onlinestats['since'] = 'Registered users who have been online in the past %s minutes: %s';
$lang_plugin_onlinestats['config_text'] = 'How long do you want to keep users listed as online for before they are assumed to have gone?';
$lang_plugin_onlinestats['minute'] = 'minutes';
$lang_plugin_onlinestats['remove'] = 'Remove the table that was used to store online data?';
