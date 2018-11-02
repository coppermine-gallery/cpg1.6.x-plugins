/**************************************************
  CPG MiniCMS Plugin for Coppermine Photo Gallery
  *************************************************
  CPGMiniCMS version: 1.0 - 1.6 - 1.81
  Copyright (c) 2005-2006 Donovan Bray <donnoman@donovanbray.com>
  *************************************************
  1.3.0  eXtended miniCMS
  Copyright (C) 2004 Michael Trojacher <m.trojacher@webtips.at>
  Original miniCMS Code (c) 2004 by Tarique Sani <tarique@sanisoft.com>,
  Amit Badkas <amit@sanisoft.com>
  *************************************************
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.
  *************************************************
  Coppermine version: 1.4.25
  CPGMiniCMS version: 1.81
  $Source: /cvsroot/cpg-contrib/minicms/README,v $
  $Revision: 8015 $
  $Author: eenemeenemuu $
  $Date: 2010-11-08 04:43:26 -0500 (Mon, 08 Nov 2010) $
***************************************************/

What it is
----------

A minimalistic Content Mangement System which allows the gallery admin to
add / edit / delete pages. Typically this will be used by people who just want
to add a few pages like About, Contact etc to their installs of coppermine but
do not want full fledged CMS like Nuke.

It is also possible to include a category info page, which can be shown when a
user visits a specific category in your gallery.

It has FCKEditor WYSIWYG editor which works in IE and Mozilla, and respects the
admin rights from Coppermine.


INSTALL
-------

* Unpack the archive and upload the "minicms" directory structure to your Coppermine
  gallery's plugins folder.
* Coppermine should be 1.4.9 or above to work with CPG MiniCMS 1.6.
* Login as an admin, go to config, then "Manage Plugins"
* Find the CPG MiniCMS entry in the available plugins and click install.
* You can adjust the placment on the main page by moving the token named "minicms"
  in the "Content of the Main Page" field in the config.
* When logged in as admin you will have an option to edit the content block if it
  already has content.
* When logged in as admin you will be shown an empty block with an edit button when
  the category has no content.
* To review your MiniCMS click on the "MiniCMS Admin" button on the "admin menu".
* To change your MiniCMS configuration use the "MiniCMS Config" button on the
  "Plugin Manager" page.
* You can include any article in its own page to be used as a hyperlink by using
  it's ID i.e.: http://www.donovanbray.com/index.php?file=minicms/cms&id=13
