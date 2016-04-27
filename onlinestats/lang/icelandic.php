<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Sýndu svæði á hverri síðu myndasafns sem sýnir notendur og gesti sem eru í virkir núna.';
$lang_plugin_onlinestats['name'] = 'Hver er virkur?';
$lang_plugin_onlinestats['config_extra'] = 'Til að virkja þessa viðbót (láta það sýna hverjir eru virkir), þá hefur strengnum "onlinestats" (aðskilið með skástriki) verið bætt við "Innihald aðalsíðu" í <a href="admin.php">stillingum Coppermine</a> undir "Sýn listunar myndasafns". Stillingin ætti að líta út svona "breadcrumb/catlist/alblist/onlinestats" eða svipað. Til að breyta staðsetningunni færðu bara "onlinestats" til í svæðinu.';
$lang_plugin_onlinestats['config_install'] = 'Viðbótin keyrir fyrirspurnir á gagnagrunninn í hvert skipti sem hún er keyrð, notar töluverðan örgjörvatíma(CPU) og fleira. Ef Coppermine myndasafnið þitt er hægt eða hefur marga notendur ættir þú ekki að nota þessa viðbót.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Það er %s skráður notandi';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Það eru %s skráðir notendur';
$lang_plugin_onlinestats['most_recent'] = 'Nýjasti notandinn er %s';
$lang_plugin_onlinestats['is'] = 'Í það heila er %s að skoða síðuna';
$lang_plugin_onlinestats['are'] = 'Í það heila eru %s að skoða síðuna';
$lang_plugin_onlinestats['and'] = 'og';
$lang_plugin_onlinestats['reg_member'] = '%s skráður notandi';
$lang_plugin_onlinestats['reg_members'] = '%s skráðir notendur';
$lang_plugin_onlinestats['guest'] = '%s gestur';
$lang_plugin_onlinestats['guests'] = '%s gestir';
$lang_plugin_onlinestats['record'] = 'Flestir notendur nokkurn tíma: %s þann %s';
$lang_plugin_onlinestats['since'] = 'Skráðir notendur sem hafa verið virkir seinustu %s mínúturnar: %s';
$lang_plugin_onlinestats['config_text'] = 'Hvað viltu halda notendum skráðum lengi sem virkum áður en álitið sé að þeir séu farnir?';
$lang_plugin_onlinestats['minute'] = 'mínútur';
$lang_plugin_onlinestats['remove'] = 'Fjarlægðu töfluna sem var notuð til að geyma gögn um virkni?';
