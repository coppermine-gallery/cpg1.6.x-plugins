<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Mostra un bloc de text en cada pàgina mostrant quants usuaris i visitants hi ha connectats en aquest moment.';
$lang_plugin_onlinestats['name'] = 'Qui està connectat?';
$lang_plugin_onlinestats['config_extra'] = 'Per habilitar el connector (fer que mostri el bloc d\'estadístiques en línia), s\'ha afegit la cadena "onlinestats" (separada amb una barra invertida) al "contingut de la pàgina principal" a la <a href=" admin.php">configuració del Coppermine</a>, secció "Vista de la llista d\'àlbums". Aquest paràmetre serà una cosa semblant a "breadcrumb/catlist/alblist/onlinestats". Per canviar la posició del bloc de text, mou la cadena "onlinestats" al camp, i vés amb compte amb les barres invertides.';
$lang_plugin_onlinestats['config_install'] = 'El Plugin executa consultes addicionals a la base de dades per a cada pàgina, consumint recursos i cicles de CPU. Si la teva galeria Coppermine és lenta o té molts usuaris no hauries usar-lo.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Hi ha %s usuari registrat';
$lang_plugin_onlinestats['we_have_reg_members'] = 'Hi ha %s usuaris registrats';
$lang_plugin_onlinestats['most_recent'] = 'El darrer usuari registrat és %s';
$lang_plugin_onlinestats['is'] = 'En total hi ha %s visitant connectats';
$lang_plugin_onlinestats['are'] = 'En total hi ha %s visitants connectats';
$lang_plugin_onlinestats['and'] = 'i';
$lang_plugin_onlinestats['reg_member'] = '%s usuari registrat';
$lang_plugin_onlinestats['reg_members'] = '%s usuaris registrats';
$lang_plugin_onlinestats['guest'] = '%s convidat';
$lang_plugin_onlinestats['guests'] = '%s convidats';
$lang_plugin_onlinestats['record'] = 'Màxims usuaris connectats :%s a %s';
$lang_plugin_onlinestats['since'] = 'Usuaris registrats connectats en els últims %s minuts: %s';
$lang_plugin_onlinestats['config_text'] = 'Quant de temps ha de passar abans de considerar que un usuari s\'ha desconectat?';
$lang_plugin_onlinestats['minute'] = 'minuts';
$lang_plugin_onlinestats['remove'] = 'Esborrar la taula usada per les estadístiques en línia?';
