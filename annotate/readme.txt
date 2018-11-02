/**************************************************
  Coppermine 1.5.x Plugin - Picture Annotation (annotate)
  *************************************************
  Copyright (c) 2003-2009 Coppermine Dev Team
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL$
  $Revision$
  $LastChangedBy$
  $Date$
  **************************************************/

What it does:
=============
Add text annotations to your images like on Flickr or Amazon.

Announcement thread:
====================
http://forum.coppermine-gallery.net/index.php/topic,60622.0.html

Install:
========
No particular install instructions: install exactly as any other plugin. Refer to the documentation for details.

Changelog
=========
[A] = Added new feature
[B] = Bugfix (fix something that wasn't working as expected)
[C] = Cosmetical fix (layout, typo etc.)
[D] = Documentation improvements
[M] = Maintenance works
[O] = Optimization of code
[S] = Security fix (issues that are related to security)
*********************************************

2011-05-03 [B] Fixed display of annotation buttons for pictures of other users if rapid annotation is enabled and displayed {eenemeenemuu}
2010-12-19 [A] Added French translation (Translation by FBleu){François Keller}
2010-04-14 [B] Fixed issue with IE {eenemeenemuu}
2010-04-14 [B] Fixed button display for regular users {eenemeenemuu}
2010-03-12 [C] Adjusted plugin to integrate to new file menu (buttonlist) {eenemeenemuu}
2010-03-12 [A] Adjusted plugin to populate valid_meta_albums array (thread ID 63977) {eenemeenemuu}
2010-01-24 [A] Added minimum version info {GauGau}
2010-01-05 [M] Counted plugin version up to v2.4 {eenemeenemuu}
2010-01-05 [B] Fixed typo that prevented adding new annotations {eenemeenemuu}
2009-12-22 [B] Fixed timestamp in meta album 'lastnotes' {eenemeenemuu}
2009-12-22 [A] Added ajax live search to filter drop-down list {eenemeenemuu}
2009-12-18 [M] Counted plugin version up to v2.3 {GauGau}
2009-12-18 [C] Silenced notices {GauGau}
2009-12-18 [A] Streamlined plugin config panel {GauGau}
2009-12-18 [O] Removed needless queries {GauGau}
2009-12-17 [B] Fixed bug when batch delete/rename annotations with '#' and '&' {eenemeenemuu}
2009-11-30 [A] Added annotation statistics of the currently viewed album {eenemeenemuu}
2009-11-26 [A] Added annotator name and profile link to annotation output {eenemeenemuu}
2009-11-26 [B] Fixed several issues with apostrophe and quote signs {eenemeenemuu}
2009-11-26 [A] Added import function to copy annotations from old 'notes' table {eenemeenemuu}
2009-11-25 [A] Added annotation manager (batch rename, batch delete) {eenemeenemuu}
2009-11-25 [A] Added check for empty annotations {eenemeenemuu}
2009-11-25 [C] Moved 'on this pic' annotations above the picture {eenemeenemuu}
2009-11-25 [C] Moved rapid annotation button to buttons section {eenemeenemuu}
2009-11-25 [A] Made annotation text clickable (go to meta album and show all pictures with the same annotation) {eenemeenemuu}
2009-11-25 [S] Added permission check to meta albums {eenemeenemuu}
2009-11-25 [O] Added function to save config values {eenemeenemuu}
2009-11-13 [A] Added configuration options for displaying buttons/links above/below pictures {eenemeenemuu}
2009-11-13 [A] Added configuration option for annotation type (free text, drop-down list) {eenemeenemuu}
2009-11-06 [B] Fixed bug 'users cannot edit/delete their own annotations' {eenemeenemuu}
2009-11-06 [B] Replaced textarea with input field (annotations don't load if there are multi-line annotations) {eenemeenemuu}
2009-11-06 [C] Moved textarea from bottom to right {eenemeenemuu}
2009-11-06 [A] List existing annotations of the currently viewed album for easier/faster annotation {eenemeenemuu}
2009-11-06 [A] View all pictures of the same annotation {eenemeenemuu}
2009-11-06 [A] New permission system configuration (enable detailed settings for all user groups) {eenemeenemuu}
2009-11-05 [A] Added timestamp and database update function {eenemeenemuu}
2009-11-05 [B] Fixed language display on plugin uninstall {eenemeenemuu}
2009-11-04 [B] Typo in german language file {eenemeenemuu}
2009-10-27 [A] Added registration promotion {GauGau}
2009-10-27 [A] Added viewing permissions {GauGau}
2009-10-27 [A] Added more icons {GauGau}
2009-10-27 [B] Removed silly line in database schema that disabled more than one annotation per image. {GauGau}
2009-10-27 [M] Counted plugin version up to v2.1 {GauGau}
2009-10-13 [A] Added config screen {GauGau}
2009-10-13 [O] Dumped some of the extra stylesheets in favor of existing classes {GauGau}
2009-10-13 [A] Added icons to buttons {GauGau}
2009-10-13 [A] Converted <input>-buttons to "real" <button>s {GauGau}
2009-10-12 [M] Counted plugin version up to v2.0 {GauGau}
2009-10-12 [A] Added icons {GauGau}
2009-10-12 [A] Added i18n of plugin manager section {GauGau}
2009-10-12 [M] Counted plugin version up to v1.8 {GauGau}
2009-10-12 [A] Moved annotation button into buttons section {GauGau}
2009-10-12 [C] Moved JS includes down for safer fallback {GauGau}
2009-10-12 [A] Added i18n {GauGau}
2009-10-12 [O] Indentation for CSS file {GauGau}
2009-10-12 [M] Added file headers to all plugin files {GauGau}
2009-10-12 [M] Started readme file with changelog (plugin version 1.7) {GauGau}

Credits:
========
Plugin created by Nibbler for cpg1.4.x
Ported to cpg1.5.x by eenemeenemuu
JavaScript library by Dusty Davidson
Portions of the JavaScript library also by Angus Turnbull

Todo:
=====
Implement permission system (done?)
Move embedded JS into separate file
Fix JS errors in IE
Test in bridging mode (especially configuration and permission level detection)
Avoid getRaw() if possible