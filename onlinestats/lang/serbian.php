<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Prikazuje blok na svakoj strani galerije u koji je upisan broj korisnika i gostiju trenutno prisutnih.';
$lang_plugin_onlinestats['name'] = 'Ko je prisutan?';
$lang_plugin_onlinestats['config_extra'] = 'Kako bi se uključio ovaj dodatak (da stvarno prikazuje statistiku prisutnih), pojam "onlinestats" (odvojen kosom crtom) je dodat u "sadržaj glavne strane" u <a href="admin.php">Coppermine podešavanjima</a> u sekciji "Prikaz liste albuma". Ovo podešavanje sad otprilike izgleda ovako "breadcrumb/catlist/alblist/onlinestats". Da biste promenili položaj ovog bloka, pomerajte pojam "onlinestats" unutar ovog polja.';
$lang_plugin_onlinestats['config_install'] = 'Ovaj dodatak postavlja dodatne zahteve bazi podataka pri svakom izvršenju, pri čemu koristi CPU i zauzima resurse. Ako je vaša Coppermine galerija spora ili ima mnogo korisnika, ne bi trebalo da ga koristite.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Prisutan je %s registrovani korisnik';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Prisutno je %s registrovanih korisnika';
$lang_plugin_onlinestats['most_recent'] = 'Poslednji registrovan korisnik je %s';
$lang_plugin_onlinestats['is'] = 'Ukupno je prisutan %s korisnik';
$lang_plugin_onlinestats['are'] = 'Ukupno je prisutno %s korisnika';
$lang_plugin_onlinestats['and'] = 'i';
$lang_plugin_onlinestats['reg_member'] = '%s registrovani korisnik';
$lang_plugin_onlinestats['reg_members'] = '%s registrovanih korisnika';
$lang_plugin_onlinestats['guest'] = '%s gost';
$lang_plugin_onlinestats['guests'] = '%s gosta';
$lang_plugin_onlinestats['record'] = 'Najviše ikad prisutnih korisnika odjednom: %s, %s';
$lang_plugin_onlinestats['since'] = 'Registrovani korisnici koji su bili prisutni u poslednjih %s minuta: %s';
$lang_plugin_onlinestats['config_text'] = 'Koliko dugo hoćete da prikazujete korisnike kao prisutne pre nego što budu prikazani kao odsutni?';
$lang_plugin_onlinestats['minute'] = 'minuta';
$lang_plugin_onlinestats['remove'] = 'Obrisati tabelu koja je korišćena da bi se sačuvali podaci o prisutnima?';
