<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Отображать блок на каждой странице галереи, который отображает пользователей и гостей онлайн.';
$lang_plugin_onlinestats['name'] = 'Кто присутствует?';
$lang_plugin_onlinestats['config_extra'] = 'Чтобы включить данный плагин (т.е. отображать на самом деле его блок с онлайн информацией), переменная "onlinestats" (отделенная косой чертой) должна быть добавлена в настройку "Содержание главной страницы" в <a href="admin.php">конфигурации Coppermine</a> в секции "Отображение списка альбомов". Настройка теперь должна выглядеть как "breadcrumb/catlist/alblist/onlinestats" или что-то похожее. Чтобы изменить расположение блока, перемещайте строку "onlinestats" внутри данной настройки.';
$lang_plugin_onlinestats['config_install'] = 'Плагин выполняет дополнительные запросы в базу данных каждый раз когда он выполняется, нагружая процессор и используя ресурсы. Если Ваша галерея Coppermine работает медленно или в ней много пользователей, Вы не должны использовать данный плагин.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Зарегистрированных пользователей %s';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Зарегистрированных пользователей %s';
$lang_plugin_onlinestats['most_recent'] = 'Последний зарегистрированный пользователь %s';
$lang_plugin_onlinestats['is'] = 'Всего %s онлайн пользователь';
$lang_plugin_onlinestats['are'] = 'Всего %s онлайн пользователей';
$lang_plugin_onlinestats['and'] = 'и';
$lang_plugin_onlinestats['reg_member'] = '%s зарегистрированный пользователь';
$lang_plugin_onlinestats['reg_members'] = '%s зарегистрированных пользователей';
$lang_plugin_onlinestats['guest'] = '%s гость';
$lang_plugin_onlinestats['guests'] = '%s гостей';
$lang_plugin_onlinestats['record'] = 'Больше всего пользователей онлайн %s было %s';
$lang_plugin_onlinestats['since'] = ' Зарегистрированные пользователи, которые были онлайн за последние %s минут: %s';
$lang_plugin_onlinestats['config_text'] = 'Как долго Вы хотите, чтобы Ваши пользователи отображались онлайн прежде чем считалось, что они покинули галерею?';
$lang_plugin_onlinestats['minute'] = 'минут';
$lang_plugin_onlinestats['remove'] = 'Удалить таблицу, которая использовалась для хранения данных?';
