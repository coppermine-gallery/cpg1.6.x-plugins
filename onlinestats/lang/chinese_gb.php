<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = '显示在每个展厅再线用户和访客的实际在线.';
$lang_plugin_onlinestats['name'] = '谁在线?';
$lang_plugin_onlinestats['config_extra'] = '要启用此插件(用来显示在线状态), 字符 "onlinestats" (（以斜线隔开) 已被添加到 "<a href="docs/en/configuration.htm#admin_album_list_content">联系首页</a>" in <a href="admin.php">Coppermine\'s config</a> in the section "Album list view". 该设置现在应该像 "breadcrumb/catlist/alblist/onlinestats" 或类似。 要改变块的位置，将字符串 "onlinestats" 的范围配置';
$lang_plugin_onlinestats['config_install'] = '该插件每次运行数据库查询时，消耗大量CPU资源。 如果您的Coppermine慢或很多用户， 您应该不用它。';
$lang_plugin_onlinestats['we_have_reg_member'] = '有 %s 上注册为用户';
$lang_plugin_onlinestats['we_have_reg_members'] = ' 有 %s 上注册为用户';
$lang_plugin_onlinestats['most_recent'] = '最新注册用户 %s';
$lang_plugin_onlinestats['is'] = '总共有 %s  在线';
$lang_plugin_onlinestats['are'] = '总共有 %s 在线';
$lang_plugin_onlinestats['and'] = '与';
$lang_plugin_onlinestats['reg_member'] = '%s 注册用户';
$lang_plugin_onlinestats['reg_members'] = '%s 注册用户';
$lang_plugin_onlinestats['guest'] = '%s 访客';
$lang_plugin_onlinestats['guests'] = '%s 访客';
$lang_plugin_onlinestats['record'] = '最高在线: %s on %s';
$lang_plugin_onlinestats['since'] = '用户在过去 %s 分钟在线: %s';
$lang_plugin_onlinestats['config_text'] = '设定用户再线时长?';
$lang_plugin_onlinestats['minute'] = '分钟';
$lang_plugin_onlinestats['remove'] = '删除了用来存储在线数据表？';
