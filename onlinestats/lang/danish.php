<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Tilføj en blok på hver galleri side der viser hvilke bruger og gæster der er online.';
$lang_plugin_onlinestats['name'] = 'Hvem er online?';
$lang_plugin_onlinestats['config_extra'] = 'For at enable dette plugin (Får det til og vise onlinestats blokken), the string "onlinestats" (adskildt a et slash) er tilføjet til "indholdet af hovedsiden" i <a href="admin.php">Coppermine\'s config</a> i sektionen "Vis Albums ". Settings skulle nu ligne "breadcrumb/catlist/alblist/onlinestats" eller lignende. For at ændre position af blokken, flyt strengen "onlinestats" rundt inde i config feltet.';
$lang_plugin_onlinestats['config_install'] = 'Dette plugin kører ekstra forespørgsler til databsen hver gang det bliver afviklet, og bruger CPU ressourcer. Hvis dit Coppermine gallery er langsom eller har mange bruger, skulle du ikke bruge det.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Der er %s registreret bruger';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Der er %s registrerede brugere';
$lang_plugin_onlinestats['most_recent'] = 'Seneste registreret bruger er %s';
$lang_plugin_onlinestats['is'] = 'I alt er der %s besøg online';
$lang_plugin_onlinestats['are'] = 'I alt er der %s besøgende online';
$lang_plugin_onlinestats['and'] = 'og';
$lang_plugin_onlinestats['reg_member'] = '%s registreret bruger';
$lang_plugin_onlinestats['reg_members'] = '%s registrerede brugere';
$lang_plugin_onlinestats['guest'] = '%s gæst';
$lang_plugin_onlinestats['guests'] = '%s gæster';
$lang_plugin_onlinestats['record'] = 'Højst antal bruger online: %s på %s';
$lang_plugin_onlinestats['since'] = 'Registrerede brugere der har været online de seneste %s minuter: %s';
$lang_plugin_onlinestats['config_text'] = 'Hvor længe ønsker du at beholde brugere listet online før de skal betragtes som værende væk igen?';
$lang_plugin_onlinestats['minute'] = 'minuter';
$lang_plugin_onlinestats['remove'] = 'Fjern tabel der var brugt til at gemme online data?';
