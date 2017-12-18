HTML5slideshow plugin for Coppermine Photo Gallery
==================================================

Release Notes:
----------------------------
Users of prior versions of this plugin should uninstall those versions before installing this one.

An extra field is added to both the 'albums' and 'users' database tables to allow storage of slideshow settings. 
A plugin configuration item determines whether users may set their own album's slideshow settings. If enabled, when 
a user runs their slide show, there will be a 'gear' icon in the upper right of the slideshow screen. Clicking that 
icon will allow them to set various parameters for that particular slideshow, as well as their own default slideshow 
parameters.

Order of precedence for slideshow parameters is:
CPG Site Settings  <--  User Default Settings  <--  Album Specific Settings

When uninstalling this plugin, an option will be provided to keep user and album settings in the database.

Version 1.4.2 Release Notes:
----------------------------
Overlay title/caption with choice of font size
Change of storage method for configurations (JSON)

Version 1.4 Release Notes:
----------------------------
Compatible only with CPG 1.6.x+

Version 1.3.9 Release Notes:
----------------------------
Correction for failure when used with PHP7.

Version 1.3.8 Release Notes:
----------------------------
Made changes to correct conflict with onlinestats plugin
Polish language updated

Version 1.3.7 Release Notes:
----------------------------
Modifications to Internet Explorer detection for IE11+

Version 1.3.6 Release Notes:
----------------------------
Added option to start slideshow(s) from album list view
When allowed, users can configure their own slideshow options when viewing any slideshow
Made compatible with and aware of CPG 1.6 (CPG 1.6 ready)

Version 1.3.5 Release Notes:
----------------------------
Added compatibilty with picture url masking

Version 1.3.4 Release Notes:
----------------------------
General code maintenance
Dutch and Polish language translations added
Configuration help files added
Firefox image load issue corrected

Version 1.3.2 Release Notes:
----------------------------
Repaired image size adjust on window resize/rotate
Made more friendly to mobile device orientation change
Added control bar changes for small devices

Version 1.3 Release Notes:
----------------------------
Corrected a slideshow error for albums with less than 3 images.
Improved touch/swipe events.
Added configurable image transition (dissolve or slide left/right).

Version 1.2.1 Release Notes:
----------------------------
Corrected an error in image sizing/positioning.
Added touch/swipe events (not fully tested/implemented)
	left/right = next/previous
	down/up = stop/start

Version 1.2 Release Notes:
----------------------------
A significant re-write was done on the client javascript slideshow engine.
A simple CSS3 transition was added between slides.
Added the option to shuffle the order of images for the slideshow.
Uses an un-minified version of the client javascript when CPG is in debug mode.
