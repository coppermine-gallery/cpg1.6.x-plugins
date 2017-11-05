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
$lang_plugin_enlargeit['update_success'] = 'Hodnoty byli úspěšne aktualizovány';
$lang_plugin_enlargeit['main_title'] = 'EnlargeIt! PlugIn';
$lang_plugin_enlargeit['pluginmanager'] = 'Plugin Manager';
$lang_plugin_enlargeit['yes'] = 'ano';
$lang_plugin_enlargeit['no'] = 'ne';
$lang_plugin_enlargeit['submit_button'] = 'Odoslat';
$lang_plugin_enlargeit['pictype'] = 'Zvětšit na ';
$lang_plugin_enlargeit['normalsize'] = 'střední náhled';
$lang_plugin_enlargeit['fullsize'] = 'plná velikost';
$lang_plugin_enlargeit['forcenormal'] = 'vynoutit střední náhled';
$lang_plugin_enlargeit['ani'] = 'Animace';
$lang_plugin_enlargeit['noani'] = 'nejsou';
$lang_plugin_enlargeit['fade'] = 'zesílit / zeslabit';
$lang_plugin_enlargeit['glide'] = 'klouzet';
$lang_plugin_enlargeit['bumpglide'] = 'nárazové klouzání';
$lang_plugin_enlargeit['smoothglide'] = 'plynulé klouzání';
$lang_plugin_enlargeit['expglide'] = 'tvrdé klouzání';
$lang_plugin_enlargeit['speed'] = 'Čas mezi krokmi animace';
$lang_plugin_enlargeit['maxstep'] = 'Počet kroků animace';
$lang_plugin_enlargeit['brd'] = 'Používat rámeček';
$lang_plugin_enlargeit['brdsize'] = 'Hroubka rámečka';
$lang_plugin_enlargeit['brdbck'] = 'Textura rámečka';
$lang_plugin_enlargeit['brdcolor'] = 'Farba rámečka';
$lang_plugin_enlargeit['brdround'] = 'Zaoblený rámeček (iba v Mozilla/Safari)';
$lang_plugin_enlargeit['enl_shadow'] = 'Používat stín';
$lang_plugin_enlargeit['shadowsize'] = 'Velikost rámečka vpravo/dolů';
$lang_plugin_enlargeit['shadowcolor'] = 'Barva rámečka (obvykle černý)';
$lang_plugin_enlargeit['shadowintens'] = 'Neprůhlednost rámečka';
$lang_plugin_enlargeit['titlebar'] = 'Používat řádek nadpisu, když tlačítka nejsou aktivní';
$lang_plugin_enlargeit['titletxtcol'] = 'Barva nadpisu';
$lang_plugin_enlargeit['ajaxcolor'] = 'Barva pozadí AJAX oblasti';
$lang_plugin_enlargeit['center'] = 'Vycentrovat zvětšený obrázek';
$lang_plugin_enlargeit['dark'] = 'Ztmavit pozadí při zvětšení obrázku (jenom jeden obrázek najednou)';
$lang_plugin_enlargeit['darkprct'] = 'Síla ztmavení';
$lang_plugin_enlargeit['buttonpic'] = 'Zobrazit tlačítko \'Zobrazit obrázek\'';
$lang_plugin_enlargeit['tooltippic'] = 'Ukázat obrázek';
$lang_plugin_enlargeit['buttoninfo'] = 'Zobrazit tlačítko \'Info\'';
$lang_plugin_enlargeit['buttoninfoyes1'] = 'ano (otevři AJAX snippet)';
$lang_plugin_enlargeit['buttoninfoyes2'] = 'ano (otevři stránku středního náhledu)';
$lang_plugin_enlargeit['tooltipinfo'] = 'Info';
$lang_plugin_enlargeit['buttonfav'] = 'Zobrazit tlačítko \'Oblíbené\'';
$lang_plugin_enlargeit['tooltipfav'] = 'Oblíbené';
$lang_plugin_enlargeit['buttoncomment'] = 'Zobrazit tlačítko \'Komentáře\'';
$lang_plugin_enlargeit['tooltipcomment'] = 'Komentáře';
$lang_plugin_enlargeit['buttondownload'] = 'Zobrazit tlačítko \'Stáhnout\'';
$lang_plugin_enlargeit['tooltipdownload'] = 'Stáhnout obrázek';
$lang_plugin_enlargeit['clickdownload'] = 'Klikněte tady pro stáhnutí souboru';
$lang_plugin_enlargeit['buttonhist'] = 'Zobrazit tlačítko \'Histogram\'';
$lang_plugin_enlargeit['tooltiphist'] = 'Histogram';
$lang_plugin_enlargeit['buttonbbcode'] = 'Zobrazit tlačítko \'BBCode\'';
$lang_plugin_enlargeit['tooltipbbcode'] = 'BBCode';
$lang_plugin_enlargeit['buttonecard'] = 'Zobrazit tlačítko \'e-Pohlednice\'';
$lang_plugin_enlargeit['tooltipecard'] = 'e-Pohlednice';
$lang_plugin_enlargeit['buttonvote'] = 'Zobrazit tlačítko \'Hodnotit\'';
$lang_plugin_enlargeit['tooltipvote'] = 'Hodnotit';
$lang_plugin_enlargeit['buttonmax'] = 'Zobrazit tlačítko \'Plná velikost\'';
$lang_plugin_enlargeit['tooltipmax'] = 'Plná velikost';
$lang_plugin_enlargeit['maxforreg'] = 'ano, ale ne pro anonymní uživatele';
$lang_plugin_enlargeit['maxpopup'] = 'ano, jako pop-up okno';
$lang_plugin_enlargeit['enl_maxpopupforreg'] = 'ano, jako pop-up okno, ale ne pro anonymy';
$lang_plugin_enlargeit['buttonclose'] = 'Zobrazit tlačítko \'Zavřít\'';
$lang_plugin_enlargeit['tooltipclose'] = 'Zavřít [Esc]';
$lang_plugin_enlargeit['buttonnav'] = 'Zobrazit tlačítko \'Navigace\'';
$lang_plugin_enlargeit['tooltipprev'] = 'Předchozí [levá šipka kláv.]';
$lang_plugin_enlargeit['tooltipnext'] = 'Další [pravá šipka kláv.]';
$lang_plugin_enlargeit['adminmode'] = 'Povol EnlargeIt! v admin módě';
$lang_plugin_enlargeit['registeredmode'] = 'Povol EnlargeIt! pro registrované uživatele';
$lang_plugin_enlargeit['guestmode'] = 'Povol EnlargeIt! pro hosty';
$lang_plugin_enlargeit['sefmode'] = 'Povol SEF podporu';
$lang_plugin_enlargeit['addedtofav'] = 'Obrázek byl přidán mezi oblíbené';
$lang_plugin_enlargeit['removedfromfav'] = 'Obrázek byl odebrán z oblíbených';
$lang_plugin_enlargeit['showfav'] = 'Ukaž mé oblíbené';
$lang_plugin_enlargeit['dragdrop'] = 'Drag & drop zvětšených obrázků';
$lang_plugin_enlargeit['darkensteps'] = 'Kroky ztmavení (1 = okamžitě)';
$lang_plugin_enlargeit['cantcomment'] = 'Nenacházejí se tady žádné komentáře, nemáte oprávnění na přidání komentáře!';
$lang_plugin_enlargeit['cantecard'] = 'Promiňte, nemáte oprávnění na odeslání e-Pohlednice!';
$lang_plugin_enlargeit['wheelnav'] = 'Navigace myší';
$lang_plugin_enlargeit['canceltext'] = 'Klikněte pro zrušení stahování';
$lang_plugin_enlargeit['noflashfound'] = 'Pro prohlížení tohto souboru je potřebné mít v prohlížeči plugin Adobe Flash Player!';
$lang_plugin_enlargeit['flvplayer'] = 'Zvol, který FLV přehrávač';
$lang_plugin_enlargeit['copytoclipbrd'] = 'Kopírovat';
$lang_plugin_enlargeit['opaglide'] = 'Průhlednost při zvětšování klouzáním';
$lang_plugin_enlargeit['mousecursors'] = 'Používat přesípací hodiny, když je prohlížeč podporuje';
