<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Näytä kenttä gallerian jokaisella sivulla paikalla olevista käyttäjistä ja vierailijoista.';
$lang_plugin_onlinestats['name'] = 'Kuka on paikalla?';
$lang_plugin_onlinestats['config_extra'] = 'Ottaaksesi lisäosan käyttöön (jotta se näyttää tilastokentän), merkkijono "onlinestats" (erotettuna kauttaviivalla) on lisätty "etusivun sisältöön" <a href="admin.php">Copperminen asetuksissa</a> kohdassa "Albumilistaus näkymä". Asetuksen pitäisi näyttää tämän kaltaiselta: "breadcrumb/catlist/alblist/onlinestats". Muuttaaksesi kentän siajaintia, siirrä merkkijonoa "onlinestats" asetuskentän sisällä';
$lang_plugin_onlinestats['config_install'] = 'Lisäosa suorittaa ylimääräisiä kyselyitä tietokantaan jokaisella sivulatauksella kasvattaen suorittimen ja muistin kulutusta. Jos Coppermine-galleriasi on hidas tai jos sillä on paljon käyttäjiä, sinun tulisi poistaa lisäosa pois käytöstä.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Paikalla on %s rekisteröityt käyttäjä';
$lang_plugin_onlinestats['we_have_reg_members'] = 'Paikalla on %s rekisteröitynyttä käyttäjää';
$lang_plugin_onlinestats['most_recent'] = 'Uusin rekisteröitynyt käyttäjä on %s';
$lang_plugin_onlinestats['is'] = 'Paikalla on yhteensä %s käyttäjä';
$lang_plugin_onlinestats['are'] = 'Paikalla on yhteensä %s käyttäjää';
$lang_plugin_onlinestats['and'] = 'ja';
$lang_plugin_onlinestats['reg_member'] = '%s rekisteröitynyt käyttäjä';
$lang_plugin_onlinestats['reg_members'] = '%s rekisteröitynyttä käyttäjää';
$lang_plugin_onlinestats['guest'] = '%s vieras';
$lang_plugin_onlinestats['guests'] = '%s vierasta';
$lang_plugin_onlinestats['record'] = 'Eniten käyttäjiä paikalla koskaan: %s (%s)';
$lang_plugin_onlinestats['since'] = 'Sisäänkirjautuneet käyttäjät viimeisen %s minuutin aikana: %s';
$lang_plugin_onlinestats['config_text'] = 'Kuinka kauan käyttäjää pidetään paikalla olevien listassa ennen kuin hänet katsotaan poistuneen sivustolta?';
$lang_plugin_onlinestats['minute'] = 'minuuttia';
$lang_plugin_onlinestats['remove'] = 'Poista taulu, jota käytettiin online datan säilytykseen?';
