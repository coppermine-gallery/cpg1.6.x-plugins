<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Zobrziť blok na každej stránke galérie zobrazujúci užívateľov a návštevníkov ktorí sú aktuálne on-line.';
$lang_plugin_onlinestats['name'] = 'Kto je on-line?';
$lang_plugin_onlinestats['config_extra'] = 'To enable this plugin (make it actually display the onlinestats block), the string "onlinestats" (separated with a slash) has been added to "the content of the main page" in <a href="admin.php">Coppermine\'s config</a> in the section "Album list view". The setting should now look like "breadcrumb/catlist/alblist/onlinestats" or similar. To change the position of the block, move the string "onlinestats" around inside that config field.';
$lang_plugin_onlinestats['config_install'] = 'The plugin runs additional queries on the database each time it is being executed, burning CPU cycles and using resources. If your Coppermine gallery is slow or has got a lot of users, you shouldn\'t use it.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'There is %s registered user';
$lang_plugin_onlinestats['we_have_reg_members'] = ' There are %s registered users';
$lang_plugin_onlinestats['most_recent'] = 'Posledný registrovaný užívateľ je %s';
$lang_plugin_onlinestats['is'] = 'Celkovo je %s návštevníkov on-line';
$lang_plugin_onlinestats['are'] = 'Celkovo je %s návštevníkov on-line';
$lang_plugin_onlinestats['and'] = 'a';
$lang_plugin_onlinestats['reg_member'] = '%s registrovaný úžívateľ';
$lang_plugin_onlinestats['reg_members'] = '%s registrovaných užívateľov';
$lang_plugin_onlinestats['guest'] = '%s návštevník';
$lang_plugin_onlinestats['guests'] = '%s návštevníkov';
$lang_plugin_onlinestats['record'] = 'Väčšina užívateľov on-line: %s na %s';
$lang_plugin_onlinestats['since'] = ' Registrovaných užívateľov, ktorí boli on-line v posledných %s minútach: %s';
$lang_plugin_onlinestats['config_text'] = 'Ako dlho chcete aby boli užívatelia braní ako on-line, pokým sa pokladajú za to že odišli?';
$lang_plugin_onlinestats['minute'] = 'minút';
$lang_plugin_onlinestats['remove'] = 'Odstrániť tabuľku, ktorá bola použitá na uloženie on-line dát?';
