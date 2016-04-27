<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Mostra un blocco in ogni pagina della galleria che visualizza utenti e visitatori attualmente in linea.';
$lang_plugin_onlinestats['name'] = 'Chi &egrave; in linea?';
$lang_plugin_onlinestats['config_extra'] = 'Per abilitare questo plugin (far s&igrave; che mostri effettivamente il blocco onlinestats), la stringa "onlinestats" (separata da una /) &egrave; stata aggiunta "al contenuto della pagina principale" nella sezione "Visualizzazione elenco album" della <a href="admin.php">Configurazione di Coppermine</a>. Le impostazioni adesso dovrebbero somigliare a "breadcrumb/catlist/alblist/onlinestats" o analoghe. Per cambiare la posizione del blocco, sposta la stringa "onlinestats" all\'interno di quel campo della configurazione.';
$lang_plugin_onlinestats['config_install'] = 'Il plugin esegue interrogazioni aggiuntive al database ogni volta che viene eseguito, consumando cicli di CPU e utilizzando risorse. Se la tua galleria Coppermine &egrave; lenta o ha molti utenti, non dovresti usarlo.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'C\'&egrave; %s utente registrato';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Ci sono %s utenti registrati';
$lang_plugin_onlinestats['most_recent'] = 'L\'ultimo utente registrato &egrave; %s';
$lang_plugin_onlinestats['is'] = 'In totale c\'&egrave; %s visitatore on-line';
$lang_plugin_onlinestats['are'] = 'In totale ci sono %s visitatori on-line';
$lang_plugin_onlinestats['and'] = 'e';
$lang_plugin_onlinestats['reg_member'] = '%s utente registrato';
$lang_plugin_onlinestats['reg_members'] = '%s utenti registrati';
$lang_plugin_onlinestats['guest'] = '%s visitatore';
$lang_plugin_onlinestats['guests'] = '%s visitatori';
$lang_plugin_onlinestats['record'] = 'Record di utenti in linea: %s il %s';
$lang_plugin_onlinestats['since'] = 'Utenti registrati che sono stati in linea negli ultimi %s minuti: %s';
$lang_plugin_onlinestats['config_text'] = 'Per quanto tempo vuoi mantenere gli utenti elencati come in linea prima che vengano considerati usciti?';
$lang_plugin_onlinestats['minute'] = 'minuti';
$lang_plugin_onlinestats['remove'] = 'Rimuovi la tabella che era stata usata per immagazzinare i dati degli utenti in linea?';
