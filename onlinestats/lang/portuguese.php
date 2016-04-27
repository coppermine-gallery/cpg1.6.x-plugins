<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Apresenta um bloco em cada página da galeria que mostra os utilizadores e visitantes actualmente online.';
$lang_plugin_onlinestats['name'] = 'Quem está online?';
$lang_plugin_onlinestats['config_extra'] = 'Para activar este plugin (fazer com que mostre o bloco de estatísticas online), a cadeia de texto "onlinestats" (separada com uma barra invertida) foi adicionada ao "conteúdo da página principal" em <a href="admin.php">Configuração do Coppermine</a> na secção "Vista de lista de álbum". A configuração deverá agora estar com "breadcrumb/catlist/alblist/onlinestats" ou algo similar. Para alterar a posição do bloco, mova a cadeia de texto "onlinestats" no campo.';
$lang_plugin_onlinestats['config_install'] = 'O plugin executa consultas adicionais na base de dados de cada vez que é executado, gastando ciclos de CPU e usando recursos. Se a sua galeria é lenta o se tem demasiados utilizadores, não o deverá usar.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Existe %s utilizador registado';
$lang_plugin_onlinestats['we_have_reg_members'] = 'Existem %s utilizadores registados';
$lang_plugin_onlinestats['most_recent'] = 'O utilizador mais recente é %s';
$lang_plugin_onlinestats['is'] = 'No total, há %s visitante online';
$lang_plugin_onlinestats['are'] = 'No total, há %s visitantes online';
$lang_plugin_onlinestats['and'] = 'e';
$lang_plugin_onlinestats['reg_member'] = '%s utilizador registado';
$lang_plugin_onlinestats['reg_members'] = '%s utilizadores registados';
$lang_plugin_onlinestats['guest'] = '%s visitante';
$lang_plugin_onlinestats['guests'] = '%s visitantes';
$lang_plugin_onlinestats['record'] = 'Máximo de utilizadores online: %s em %s';
$lang_plugin_onlinestats['since'] = 'Utilizadores registados que estiveram online nos últimos %s minutos: %s';
$lang_plugin_onlinestats['config_text'] = 'Durante quanto tempo pretende manter os utilizadores listados como online antes de se assumir que já saíram?';
$lang_plugin_onlinestats['minute'] = 'minutos';
$lang_plugin_onlinestats['remove'] = 'Eliminar a tabela que foi usada para guardar as estatísticas online?';
