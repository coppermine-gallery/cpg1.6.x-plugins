<?php

if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Visa ett block på varje gallerisida som visare användare och gäster som är online.';
$lang_plugin_onlinestats['name'] = 'Vem är online?';
$lang_plugin_onlinestats['config_extra'] = 'För att aktivera insticksmodulen (göra så att den faktistk visar ett block med onlinestatistik), så har texten "onlinestats" (snedstrecksavgränsad) lagts till i "huvudsidans innehåll" i <a href="admin.php">Copperminekonfigurationen</a> i avsnittet "Album listvy". Inställning bör nu se ut som  "breadcrumb/catlist/alblist/onlinestats" eller liknande. För att ändra position på blocket, flytta runt texten "onlinestats" i konfigurationsfältet.';
$lang_plugin_onlinestats['config_install'] = 'Insticksmodulen kör ytterligare frågor mot datasbasen när den exekveras, och kräver extra resurser. Om ditt Coppermine galleri är långsamt eller har många användare, så bör du inte använda det.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Det finns %s registrerade användare';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Det finns %s registrerade användare';
$lang_plugin_onlinestats['most_recent'] = 'Senast registrerade användare är %s';
$lang_plugin_onlinestats['is'] = 'Totalt är %s besökare online';
$lang_plugin_onlinestats['are'] = 'Totalt är %s besökare online';
$lang_plugin_onlinestats['and'] = 'och';
$lang_plugin_onlinestats['reg_member'] = '%s registrerade användare';
$lang_plugin_onlinestats['reg_members'] = '%s registrerade användare';
$lang_plugin_onlinestats['guest'] = '%s gäster';
$lang_plugin_onlinestats['guests'] = '%s gäster';
$lang_plugin_onlinestats['record'] = 'Flest användare online någonsin: %s den %s';
$lang_plugin_onlinestats['since'] = 'Registrerade användare som varit online de senaste %s minuterna: %s';
$lang_plugin_onlinestats['config_text'] = 'Hur lång tid kan en användare vara online innan han/hon ska anses ha loggat ut?';
$lang_plugin_onlinestats['minute'] = 'minuter';
$lang_plugin_onlinestats['remove'] = 'Radera tabellen som använts för att lagra online data?';
