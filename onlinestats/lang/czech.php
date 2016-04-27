<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Display a block on each gallery page that shows users and guests actually online.';
$lang_plugin_onlinestats['name'] = 'Kdo je online?';
$lang_plugin_onlinestats['config_extra'] = 'To enable this plugin (make it actually display the onlinestats block), the string "onlinestats" (separated with a slash) has been added to "the content of the main page" in <a href="admin.php">Coppermine\'s config</a> in the section "Album list view". The setting should now look like "breadcrumb/catlist/alblist/onlinestats" or similar. To change the position of the block, move the string "onlinestats" around inside that config field.';
$lang_plugin_onlinestats['config_install'] = 'The plugin runs additional queries on the database each time it is being executed, burning CPU cycles and using resources. If your Coppermine gallery is slow or has got a lot of users, you shouldn\'t use it.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Je zde %s registrovaný uživatel';
$lang_plugin_onlinestats['we_have_reg_members'] = 'Je zde %s registrovaných uživatelů';
$lang_plugin_onlinestats['most_recent'] = 'Nejnovější registrovaný uživatel je %s';
$lang_plugin_onlinestats['is'] = 'Celkem je zde %s uživatel online';
$lang_plugin_onlinestats['are'] = 'Celkem je zde %s uživatelů online';
$lang_plugin_onlinestats['and'] = 'a';
$lang_plugin_onlinestats['reg_member'] = '%s registrovaný uživatel';
$lang_plugin_onlinestats['reg_members'] = '%s registrovaných uživatelů';
$lang_plugin_onlinestats['guest'] = '%s návštěvník';
$lang_plugin_onlinestats['guests'] = '%s návštěvníků';
$lang_plugin_onlinestats['record'] = 'Nejvíce uživatelů online: %s dne %s';
$lang_plugin_onlinestats['since'] = 'Počet registrovaných uživatelů, kteří byli online v posledních %s minutách: %s';
$lang_plugin_onlinestats['config_text'] = 'How long do you want to keep users listed as online for before they are assumed to have gone?';
$lang_plugin_onlinestats['minute'] = 'minutes';
$lang_plugin_onlinestats['remove'] = 'Remove the table that was used to store online data?';
