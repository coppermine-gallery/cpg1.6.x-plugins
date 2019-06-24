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

Version 1.4.6 Release Notes:
----------------------------
Begin slideshow from selected image

Version 1.4.5 Release Notes:
----------------------------
Do not provide slideshow to unlogged users if prevented in configuration.

Version 1.4.4 Release Notes:
----------------------------
Correct issue causing failure to create new albums when using mySQL 5.7

Version 1.4.3 Release Notes:
----------------------------
Play some videos as part of slideshow
Improved touch swipe actions

Version 1.4.2 Release Notes:
----------------------------
Overlay title/caption with choice of font size
Change of storage method for configurations (JSON)

Version 1.4 Release Notes:
----------------------------
Compatible only with CPG 1.6.x+
