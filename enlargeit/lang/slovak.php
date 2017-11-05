<?php
/**************************************************
  Coppermine 1.6.x Plugin - EnlargeIt!
  *************************************************
  Copyright (c) 2010 Timos-Welt (www.timos-welt.de)
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
 **************************************************/

if (!defined('IN_COPPERMINE')) { 
	die('Not in Coppermine...'); 
}

$lang_plugin_enlargeit['display_name'] = 'EnlargeIt! PlugIn';
$lang_plugin_enlargeit['update_success'] = 'Hodnoty boli úspešne aktualizované';
$lang_plugin_enlargeit['main_title'] = 'EnlargeIt! PlugIn';
$lang_plugin_enlargeit['pluginmanager'] = 'Plugin Manager';
$lang_plugin_enlargeit['yes'] = 'áno';
$lang_plugin_enlargeit['no'] = 'nie';
$lang_plugin_enlargeit['submit_button'] = 'Odoslať';
$lang_plugin_enlargeit['pictype'] = 'Zväčšiť na ';
$lang_plugin_enlargeit['normalsize'] = 'stredný náhľad';
$lang_plugin_enlargeit['fullsize'] = 'plná veľkosť';
$lang_plugin_enlargeit['forcenormal'] = 'vynútiť stredný náhľad';
$lang_plugin_enlargeit['ani'] = 'Animácia';
$lang_plugin_enlargeit['noani'] = 'žiadne';
$lang_plugin_enlargeit['fade'] = 'zosíliť / zoslabiť';
$lang_plugin_enlargeit['glide'] = 'kĺzať';
$lang_plugin_enlargeit['bumpglide'] = 'nárazové kĺzanie';
$lang_plugin_enlargeit['smoothglide'] = 'plynulé kĺzanie';
$lang_plugin_enlargeit['expglide'] = 'tvrdé kĺzanie';
$lang_plugin_enlargeit['speed'] = 'Čas medzi krokmi animácie';
$lang_plugin_enlargeit['maxstep'] = 'Počet krokov animácie';
$lang_plugin_enlargeit['brd'] = 'Používať rámček';
$lang_plugin_enlargeit['brdsize'] = 'Hrúbka rámčeka';
$lang_plugin_enlargeit['brdbck'] = 'Textúra rámčeka';
$lang_plugin_enlargeit['brdcolor'] = 'Farba rámčeka';
$lang_plugin_enlargeit['brdround'] = 'Zaoblený rámček (iba v Mozilla/Safari)';
$lang_plugin_enlargeit['enl_shadow'] = 'Používať tieň';
$lang_plugin_enlargeit['shadowsize'] = 'Veľkosť rámčeka vpravo/dole';
$lang_plugin_enlargeit['shadowcolor'] = 'Farba rámčeka (zvyčajne čierny)';
$lang_plugin_enlargeit['shadowintens'] = 'Nepriehľadnosť rámčeka';
$lang_plugin_enlargeit['titlebar'] = 'Používať riadok nadpisu, keď tlačidlá nie sú aktívne';
$lang_plugin_enlargeit['titletxtcol'] = 'Farba nadpisu';
$lang_plugin_enlargeit['ajaxcolor'] = 'Farba pozadia AJAX oblasti';
$lang_plugin_enlargeit['center'] = 'Vycentrovať zväčšený obrázok';
$lang_plugin_enlargeit['dark'] = 'Stmaviť pozadie pri zväčšení obrázku (iba jeden obrázok naraz)';
$lang_plugin_enlargeit['darkprct'] = 'Sila stmavenia';
$lang_plugin_enlargeit['buttonpic'] = 'Zobraziť tlačidlo \'Zobraziť obrázok\'';
$lang_plugin_enlargeit['tooltippic'] = 'Ukázať obrázok';
$lang_plugin_enlargeit['buttoninfo'] = 'Zobraziť tlačidlo \'Info\'';
$lang_plugin_enlargeit['buttoninfoyes1'] = 'áno (otvor AJAX snippet)';
$lang_plugin_enlargeit['buttoninfoyes2'] = 'áno (otvor stránku stredného náhľadu)';
$lang_plugin_enlargeit['tooltipinfo'] = 'Info';
$lang_plugin_enlargeit['buttonfav'] = 'Zobraziť tlačidlo \'Obľúbené\'';
$lang_plugin_enlargeit['tooltipfav'] = 'Obľúbené';
$lang_plugin_enlargeit['buttoncomment'] = 'Zobraziť tlačidlo \'Komentáre\'';
$lang_plugin_enlargeit['tooltipcomment'] = 'Komentáre';
$lang_plugin_enlargeit['buttondownload'] = 'Zobraziť tlačidlo \'Stiahnuť\'';
$lang_plugin_enlargeit['tooltipdownload'] = 'Stiahnuť obrázok';
$lang_plugin_enlargeit['clickdownload'] = 'Kliknite tu pre stiahnutie súboru';
$lang_plugin_enlargeit['buttonhist'] = 'Zobraziť tlačidlo \'Histogram\'';
$lang_plugin_enlargeit['tooltiphist'] = 'Histogram';
$lang_plugin_enlargeit['buttonbbcode'] = 'Zobraziť tlačidlo \'BBCode\'';
$lang_plugin_enlargeit['tooltipbbcode'] = 'BBCode';
$lang_plugin_enlargeit['buttonecard'] = 'Zobraziť tlačidlo \'e-Pohľadnica\'';
$lang_plugin_enlargeit['tooltipecard'] = 'e-Pohľadnica';
$lang_plugin_enlargeit['buttonvote'] = 'Zobraziť tlačidlo \'Hodnotiť\'';
$lang_plugin_enlargeit['tooltipvote'] = 'Hodnotiť';
$lang_plugin_enlargeit['buttonmax'] = 'Zobraziť tlačidlo \'Plná veľkosť\'';
$lang_plugin_enlargeit['tooltipmax'] = 'Plná veľkosť';
$lang_plugin_enlargeit['maxforreg'] = 'áno, ale nie pre anonymných užívateľov';
$lang_plugin_enlargeit['maxpopup'] = 'áno, ako pop-up okno';
$lang_plugin_enlargeit['enl_maxpopupforreg'] = 'áno, ako pop-up okno, ale nie pre anonymov';
$lang_plugin_enlargeit['buttonclose'] = 'Zobraziť tlačidlo \'Zavrieť\'';
$lang_plugin_enlargeit['tooltipclose'] = 'Zavrieť [Esc]';
$lang_plugin_enlargeit['buttonnav'] = 'Zobraziť tlačidlo \'Navigácia\'';
$lang_plugin_enlargeit['tooltipprev'] = 'Späť [ľavá šípka kláv.]';
$lang_plugin_enlargeit['tooltipnext'] = 'Ďalej [pravá šípka kláv.]';
$lang_plugin_enlargeit['adminmode'] = 'Povoľ EnlargeIt! v admin móde';
$lang_plugin_enlargeit['registeredmode'] = 'Povoľ EnlargeIt! pre registrovaných užívateľov';
$lang_plugin_enlargeit['guestmode'] = 'Povoľ EnlargeIt! pre hostí';
$lang_plugin_enlargeit['sefmode'] = 'Povoľ SEF podporu';
$lang_plugin_enlargeit['addedtofav'] = 'Obrázok bol pridaný medzi obľúbené';
$lang_plugin_enlargeit['removedfromfav'] = 'Obrázok bol odobratý z obľúbených';
$lang_plugin_enlargeit['showfav'] = 'Ukáž moje obľúbené';
$lang_plugin_enlargeit['dragdrop'] = 'Drag & drop [chyť a pusť] zväčšených obrázkov';
$lang_plugin_enlargeit['darkensteps'] = 'Kroky stmavenia (1 = okamžite)';
$lang_plugin_enlargeit['cantcomment'] = 'Nenachádzajú sa tu žiadne komentáre, nemáte oprávnenie na pridanie komentára!';
$lang_plugin_enlargeit['cantecard'] = 'Prepáčte, nemáte oprávnenie na poslanie e-Pohľadnice!';
$lang_plugin_enlargeit['wheelnav'] = 'Navigácia myškou';
$lang_plugin_enlargeit['canceltext'] = 'Kliknite pre zrušenie sťahovania';
$lang_plugin_enlargeit['noflashfound'] = 'Pre pozeranie tohto súboru potrebujete v prehliadači plugin Adobe Flash Player!';
$lang_plugin_enlargeit['flvplayer'] = 'Zvoľ, ktorý FLV prehrávač';
$lang_plugin_enlargeit['copytoclipbrd'] = 'Kopírovať';
$lang_plugin_enlargeit['opaglide'] = 'Priehľadnosť pri zväčšovaní kĺzaním';
$lang_plugin_enlargeit['mousecursors'] = 'Používať presípacie hodiny, ak ich prehliadač podporuje';
