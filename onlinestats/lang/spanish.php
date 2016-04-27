<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Muestra un bloque de texto en cada página mostrando cuántos usuarios y visitantes hay conectados en ese momento.';
$lang_plugin_onlinestats['name'] = '¿Quién está conectado?';
$lang_plugin_onlinestats['config_extra'] = 'Para habilitar el plugin (hacer que muestre el bloque de estadísticas online), se ha añadido la cadena "onlinestats" (separada con una barra invertida) al "contenido de la página principal" en la <a href="admin.php">configuración de Coppermine</a>, sección "Vista de la lista de álbumes". Este parámetro será algo parecido a "breadcrumb/catlist/alblist/onlinestats". Para cambiar la posición del bloque de texto, mueve la cadena "onlinestats" en el campo, y ten cuidado con las barras invertidas.';
$lang_plugin_onlinestats['config_install'] = 'El plugin ejecuta consultas adicionales en la base de datos para cada página, consumiendo recursos y ciclos de CPU. Si tu galería coppermine es lenta o tiene muchos usuarios no deberías usarlo.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Hay %s usuario registrado';
$lang_plugin_onlinestats['we_have_reg_members'] = 'Hay %s usuarios registrados';
$lang_plugin_onlinestats['most_recent'] = 'El último usuario registrado es %s';
$lang_plugin_onlinestats['is'] = 'En total hay %s visitante conectados';
$lang_plugin_onlinestats['are'] = 'En total hay %s visitantes conectados';
$lang_plugin_onlinestats['and'] = 'y';
$lang_plugin_onlinestats['reg_member'] = '%s usuario registrado';
$lang_plugin_onlinestats['reg_members'] = '%s usuarios registrados';
$lang_plugin_onlinestats['guest'] = '%s invitado';
$lang_plugin_onlinestats['guests'] = '%s invitados';
$lang_plugin_onlinestats['record'] = 'Máximos usuarios conectados: %s en %s';
$lang_plugin_onlinestats['since'] = 'Usuarios registrados conectados en los últimos %s minutos: %s';
$lang_plugin_onlinestats['config_text'] = '¿Cuánto tiempo debe pasar antes de considerar que un usuario se ha ido?';
$lang_plugin_onlinestats['minute'] = 'minutos';
$lang_plugin_onlinestats['remove'] = '¿Borrar la tabla usada para las estadísticas online?';
