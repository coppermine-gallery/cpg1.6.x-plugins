<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Toon een blok in iedere galerijpagina dat toont welke gebruikers en gasten momenteel online zijn.';
$lang_plugin_onlinestats['name'] = 'Wie is online?';
$lang_plugin_onlinestats['config_extra'] = 'Om deze plugin in te schakelen (laat het momenteel de blok met onlinestats tonen), de string "onlinestats" (gescheiden door een slash) is toegevoegd aan "de inhoud van de hoofdpagina" in <a href="admin.php">Coppermine\'s config</a> in de sectie "Album lijst". De instelling zou nu moeten uitzien als "breadcrumb/catlist/alblist/onlinestats" of iets dergelijk. Om de positie van de blok te veranderen, verplaats de string "onlinestats" ergens in dat configuratieveld.';
$lang_plugin_onlinestats['config_install'] = 'De plugin start bijkomende queries in de database iedere keer dat de hij uitgevoerd wordt, hij verbruikt hierbij CPU-cyclussen en resources. Als jouw Coppermine galerij langzaam is of veel gebruikers heeft, kan je dat beter niet gebruiken.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Er is %s geregistreerd gebruiker';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Er zijn %s geregistreerde gebruikers';
$lang_plugin_onlinestats['most_recent'] = 'De nieuwste geregistreerde gebruiker is %s';
$lang_plugin_onlinestats['is'] = 'In totaal is er %s bezoeker online';
$lang_plugin_onlinestats['are'] = 'In totaal zijn er %s bezoekers online';
$lang_plugin_onlinestats['and'] = 'en';
$lang_plugin_onlinestats['reg_member'] = '%s geregistreerde gebruiker';
$lang_plugin_onlinestats['reg_members'] = '%s geregistreerde gebruikers';
$lang_plugin_onlinestats['guest'] = '%s gast';
$lang_plugin_onlinestats['guests'] = '%s gasten';
$lang_plugin_onlinestats['record'] = 'Hoogst aantal gebruikers ooit online: %s op %s';
$lang_plugin_onlinestats['since'] = 'Geregistreerde gebruikers die online geweest zijn in det laatste %s minuten: %s';
$lang_plugin_onlinestats['config_text'] = 'Hoe lang wil je gebruikers in de lijst houden van \'gebruikers online\' voordat ze verondersteld worden de galerij verlaten te hebben?';
$lang_plugin_onlinestats['minute'] = 'minuten';
$lang_plugin_onlinestats['remove'] = 'Verwijder de tabel die gebruikt werd om de online gegevens op te slaan?';
