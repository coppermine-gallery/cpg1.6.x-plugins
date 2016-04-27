<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Zeige einen Block auf jeder Galerie-Seite, der anzeigt, wieviele Benutzer und Gäste tatsächlich online sind.';
$lang_plugin_onlinestats['name'] = 'Wer ist online?';
$lang_plugin_onlinestats['config_extra'] = 'Um dieses Plugin zu aktivieren (damit es tatsächlich den onlinestats-Block anzeigt) muss die Zeichenfolge "onlinestats" (getrennt mit einem Schrägstrich) zu der Zeichenfolge "<a href="docs/de/configuration.htm#admin_album_list_content">Inhalt der Hauptseite</a>" in den <a href="admin.php">Einstellungen</a> unter dem Abschnitt "Ansicht Albenliste" eingetragen sein. Die Einstellung sollte dann wie folgt aussehen: "breadcrumb/catlist/alblist/onlinestats" oder vergleichbar. Um die Position des Blocks auf der Seite zu verschieben kann einfach die Position innerhalb der Zeichenkette verschoben werden.';
$lang_plugin_onlinestats['config_install'] = 'Dieses Plugin verursacht zusätzliche Datenbankabfragen bei jedem Lauf und verbraucht daher zusätzliche Resourcen auf dem Server. Wenn Deine Galerie bereits langsam läuft und Du eine große Menge von Benutzern hast sollte dieses Plugin nicht installiert werden.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Es gibt %s registrierten Benutzer';
$lang_plugin_onlinestats['we_have_reg_members'] = 'Es gibt %s registrierte Benutzer';
$lang_plugin_onlinestats['most_recent'] = 'Der neueste registrierte Benutzer ist %s';
$lang_plugin_onlinestats['is'] = 'Insgesamt ist %s Besucher online';
$lang_plugin_onlinestats['are'] = 'Insgesamt sind %s Besucher online';
$lang_plugin_onlinestats['and'] = 'und';
$lang_plugin_onlinestats['reg_member'] = '%s registrierter Benutzer';
$lang_plugin_onlinestats['reg_members'] = '%s registrierte Benutzer';
$lang_plugin_onlinestats['guest'] = '%s Gast';
$lang_plugin_onlinestats['guests'] = '%s Gäste';
$lang_plugin_onlinestats['record'] = 'Am meisten jemals online: %s am %s';
$lang_plugin_onlinestats['since'] = 'Registrierte Benutzer, die in den letzten %s Minuten online waren: %s';
$lang_plugin_onlinestats['config_text'] = 'Wie lange sollen Besucher als online gezählt werden, bevor davon auszugehen ist, dass sie die Seite verlassen haben?';
$lang_plugin_onlinestats['minute'] = 'Minuten';
$lang_plugin_onlinestats['remove'] = 'Tabelle entfernen, in der die Online-Daten gespeichert wurden?';
