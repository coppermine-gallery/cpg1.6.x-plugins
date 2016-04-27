<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Apresenta um bloco em cada página da galeria que mostra os usuários e visitantes online.';
$lang_plugin_onlinestats['name'] = 'Quem está online?';
$lang_plugin_onlinestats['config_extra'] = 'Para usar este plugin (fazer com que mostre o bloco de estatísticas online), um bloco de texto "onlinestats" (separada com uma barra invertida) foi adicionada ao "conteúdo da página principal" em <a href="admin.php">Configuração do Coppermine</a> na seção "Vista de lista de álbum". A configuração deverá agora estar com "breadcrumb/catlist/alblist/onlinestats" ou algo similar. Para alterar a posição do bloco, mova a cadeia de texto "onlinestats" no campo.';
$lang_plugin_onlinestats['config_install'] = 'Este plugin executa consultas adicionais na base de dados cada vez que é executado, forçando muito o uso da CPU. Se a galeria é lenta ou se tem  muitos usuários, remomenda-se não usar o plugin';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Temos %s usuário registrado';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Temos %s usuários registrados';
$lang_plugin_onlinestats['most_recent'] = 'O mais novo usuário registrado é %s';
$lang_plugin_onlinestats['is'] = 'No total temos %s visitantes online';
$lang_plugin_onlinestats['are'] = 'No total temos %s visitantes online';
$lang_plugin_onlinestats['and'] = 'e';
$lang_plugin_onlinestats['reg_member'] = '%s usuários registrados';
$lang_plugin_onlinestats['reg_members'] = '%s usuários registrados';
$lang_plugin_onlinestats['guest'] = '%s Visitante online';
$lang_plugin_onlinestats['guests'] = '%s Visitantes online';
$lang_plugin_onlinestats['record'] = 'Máximo de usuários online: %s em %s';
$lang_plugin_onlinestats['since'] = 'Usuários registados que estiveram online nos últimos %s minutos: %s';
$lang_plugin_onlinestats['config_text'] = 'Listar por quanto tempo os usuários como online antes de se assumir que já saíram?';
$lang_plugin_onlinestats['minute'] = 'minutos';
$lang_plugin_onlinestats['remove'] = 'Remover a tabela que foi usada para guardar as estatísticas online?';
