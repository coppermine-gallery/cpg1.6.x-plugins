<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Näidata igal galerii lehel plokki, kus on kirjas hetkel online\'is olevad kasutajad ja külalised.';
$lang_plugin_onlinestats['name'] = 'Kes on online?';
$lang_plugin_onlinestats['config_extra'] = 'Plugina lubamiseks (teha onlinestats plokk tegelikult nähtavaks) lisati string "onlinestats" (kaldkriipsuga eraldatult) <a href="admin.php">Coppermine\'i konfi</a> "põhilehe sisusse" sektsiooni "Albumi nimekirja vaade". Seadetes peaks praegu kirjas olema "breadcrumb/catlist/alblist/onlinestats" või midagi sarnast. Ploki asukoha muutmiseks tuleb konfi väljal string "onlinestats" ringi tõsta.';
$lang_plugin_onlinestats['config_install'] = 'Plugin jooksutab igakordsel käivitamisel andmebaasis täiendavaid päringuid, hõivates protsessori tsükleid ja kasutades ressursse. Kui sinu Coppermine\'i galerii on aeglane või kasutajate hulk on suur, siis sa ei peaks seda pluginat kasutama.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Siin on %s registreeritud kasutaja';
$lang_plugin_onlinestats['we_have_reg_members'] = 'Siin on %s registreeritud kasutajat';
$lang_plugin_onlinestats['most_recent'] = 'Uusim registreeritud kasutaja on %s';
$lang_plugin_onlinestats['is'] = 'Hetkel on siin %s külaline';
$lang_plugin_onlinestats['are'] = 'Kokku on siin hetkel %s külalist';
$lang_plugin_onlinestats['and'] = 'ja';
$lang_plugin_onlinestats['reg_member'] = '%s registreeritud kasutaja';
$lang_plugin_onlinestats['reg_members'] = '%s registreeritud kasutajat';
$lang_plugin_onlinestats['guest'] = '%s külaline';
$lang_plugin_onlinestats['guests'] = '%s külalist';
$lang_plugin_onlinestats['record'] = 'Seni kõige rohkem kasutajaid: %s %s-st';
$lang_plugin_onlinestats['since'] = 'Registreeritud kasutajad, kes on olnud hiljuti online\'is %s minutit: %s';
$lang_plugin_onlinestats['config_text'] = 'Kui kaua sa soovid hoida kasutajaid online\'i nimekirjas (enne, kui oletada, et nad on ära läinud)?';
$lang_plugin_onlinestats['minute'] = 'minutit';
$lang_plugin_onlinestats['remove'] = 'Eemaldada tabel, mida kasutati online andmete säilitamiseks?';
