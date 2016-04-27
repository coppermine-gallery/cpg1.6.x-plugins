/**************************************************
  Coppermine 1.5.x Plugin - external_edit
  *************************************************
  Copyright (c) 2010 Joachim Mller
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 3 of the License, or
  (at your option) any later version.
  ********************************************
  $HeadURL: https://coppermine.svn.sourceforge.net/svnroot/coppermine/branches/cpg1.5.x/plugins/external_edit/readme.txt $
  $Revision: 7977 $
  $LastChangedBy: gaugau $
  $Date: 2010-10-15 17:08:34 +0200 (Fr, 15 Okt 2010) $

  Prepared for CPG 1.6 by ron4mac, 2016-04-26
  **************************************************/
  
Plugins for the Coppermine Photo Gallery are add-ons that use the plugin interface of Coppermine.
Read up the documentation that comes with Coppermine to find out more, e.g. how to install a plugin.

Coppermine version: cpg1.5.x
Plugin name: External Edit
Plugin author: Joachim Mller (GauGau)
Plugin announcement thread: http://forum.coppermine-gallery.net/index.php/topic,60173.0.html

Description:
This plugin allows you to edit the images in your gallery using the Flash-driven external online image editor from Fotoflexer.com

What it does:
After installing the plugin (using the plugin manager as suggested in the documentation that comes with coppermine), you will notice an extra button on the intermediate image display screen, right next to the buttons that enable you to crop & and rotate, edit file information and delete the file. The button is labelled "Edit file in Fotoflexer" and will show up for the admin and for the registered user if the user has got permissions to edit the file, i.e. if he's browsing an image that he/she uploaded. The button will only be displayed beneath files that the online image editor Fotoflexer is capable of editing.
After clicking on the button your image will be sent to the advanced web 2.0 image editor on the site of Fotoflexer.com, where you can perform all kinds of edits. When clicking the save-button there, the edited image will be sent back to your site, where some authentification checks are being performed and the file is being saved, overwriting the one on your server (without further prompts, so make sure you know what you're doing).
Right now, this plugin is experimental - there have been no tests performed how it performs and there are certainly bugs in it - use at your own risk.

Background:
Originally, I was trying to use the new API provided by http://aviary.com, but that turned out not to work yet, so I went for the API from fotoflexer.com. Please understand that I'm not affiliated with Fotoflexer and that I have no control over their services. Things may or may not work as expected. This plugin comes with absolutely no warranties.
Fotoflexer currently display a banner on the editor screen, so if that bothers you, you should not use the plugin. If you have privacy concerns, read the legal stuff on fotoflexer's home page (http://fotoflexer.com/).

Feedback:
There is still much room for improvements in this plugin, and I would love to hear your feedback, but please understand that there is no guarantee that I will be able to implement a particular feature. What I'm interessted in most is the security-related stuff (thhe token creation and token checking using a sort-of database driven session) - I'd love to hear feedback and code review from coders. Thanks in advance.

To-do:
Here are some ideas for potential future versions:
* Optionally rename files when saving to make sure that there won't be caching issues
* Try a second attempt for aviary.com once their advanced API is released
* Add more online editing services for similar APIs, but different file types (like online PDF editors or similar)
* Add a config screen for the plugin
* Possible options
  # Rename file on when saving
  # Allow editing of intermediate or thumbnail only
  # Add "External Edit"-button to other places (e.g. the editpics.php screen or the thumbnail view or right after the upload)
