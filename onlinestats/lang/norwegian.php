<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');


$lang_plugin_onlinestats['description'] = 'Tilføy en blokk som viser brukere og gjester som er online.';
$lang_plugin_onlinestats['name'] = 'Hvem er online?';
$lang_plugin_onlinestats['config_extra'] = 'For å aktivere plugin-modulen (gjøre slik at den faktisk viser en blokk med onlinestatistikk), så har teksten "onlinestats" (adskilt med skråstrek) blitt lagt til i "hovedsidens innehold" i <a href="admin.php">Copperminekonfigurasjonen</a> i avsnittet "Vis album". Innstillingen bør nå se ut som  "breadcrumb/catlist/alblist/onlinestats" eller lignende. For å endre posisjon på blokken, flytt rundt teksten "onlinestats" i konfigurasjonsfeltet.';
$lang_plugin_onlinestats['config_install'] = 'Pluginnmodulen kjører mange komandoer mot datasbasen og krever mye resjurser. Hvis ditt Coppermine galleri er langsomt eller har mange brukere, så bør du ikke bruke det.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Det finnes %s registrerte brukere';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Det finnes %s registrerte brukere';
$lang_plugin_onlinestats['most_recent'] = 'Sist registrerte bruker er %s';
$lang_plugin_onlinestats['is'] = 'Totalt er %s gjester online';
$lang_plugin_onlinestats['are'] = 'Totalt er %s hjester online';
$lang_plugin_onlinestats['and'] = 'og';
$lang_plugin_onlinestats['reg_member'] = '%s registrerte brukere';
$lang_plugin_onlinestats['reg_members'] = '%s registrerte brukere';
$lang_plugin_onlinestats['guest'] = '%s gjester';
$lang_plugin_onlinestats['guests'] = '%s gjester';
$lang_plugin_onlinestats['record'] = 'Flest brukere online var: %s den %s';
$lang_plugin_onlinestats['since'] = 'Registrerte brukere de siste %s minuterna: %s';
$lang_plugin_onlinestats['config_text'] = 'Hvor lang tid kan en bruker være online før han/henne skal anses ha logget ut?';
$lang_plugin_onlinestats['minute'] = 'minuter';
$lang_plugin_onlinestats['remove'] = 'Fjern tabellen som brukes for å lagre online data?';
