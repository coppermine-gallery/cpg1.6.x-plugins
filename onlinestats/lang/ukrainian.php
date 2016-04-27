<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Показувати блок на кожній сторінці галереї, який відображає користувачів та гостей онлайн.';
$lang_plugin_onlinestats['name'] = 'Хто присутній?';
$lang_plugin_onlinestats['config_extra'] = 'Щоб включити це плагін (тобтовідображати насправді його блок з онлайн інформацією), рядок &quot;onlinestats&quot; (відокремлена косою рискою) повинна бути додана настроку &quot;Зміст головної сторінки&quot; в <a href="admin.php">конфігурації Coppermine</a> в секції &quot;Відображення списку альбомів&quot;.Налаштування тепер має виглядати як &quot;breadcrumb/catlist/alblist/onlinestats&quot; або щось схоже. Щоб змінити розташування блоку, ведіть рядок &quot;onlinestats&quot; всередині цього налаштування.';
$lang_plugin_onlinestats['config_install'] = 'Модуль виконує додаткові запити до бази даних кожен раз коли він виконується, навантажуючи процесор і використовуючи ресурси. Якщо Ваша галерея Coppermine працює повільно або в ній багато користувачів, Ви не повинні використовувати цей плагін. ';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Зареєстрованих користувачів %s';
$lang_plugin_onlinestats['we_have_reg_members'] = 'Зареєстрованих користувачів %s';
$lang_plugin_onlinestats['most_recent'] = 'Останній зареєстрований користувач %s';
$lang_plugin_onlinestats['is'] = 'Всього %s онлайн користувач';
$lang_plugin_onlinestats['are'] = 'Всього %s онлайн користувачів';
$lang_plugin_onlinestats['and'] = 'і';
$lang_plugin_onlinestats['reg_member'] = '%s зареєстрований користувач';
$lang_plugin_onlinestats['reg_members'] = '%s зареєстрованих користувачів';
$lang_plugin_onlinestats['guest'] = '%s гість';
$lang_plugin_onlinestats['guests'] = '%s гостей';
$lang_plugin_onlinestats['record'] = 'Більше всього користувачів онлайн %s було %s';
$lang_plugin_onlinestats['since'] = 'Зареєстровані користувачі, які були онлайн за останні %s хвилин: %s';
$lang_plugin_onlinestats['config_text'] = 'Як довго Ви хочете, щоб Ваші користувачі відображалися онлайн перш ніж вважалося, що вони покинули галерею?';
$lang_plugin_onlinestats['minute'] = 'хвилин';
$lang_plugin_onlinestats['remove'] = 'Видалити таблицю, яка використовувалася для зберігання даних?';
