<?php
/**
 * Coppermine Photo Gallery
 * Coppermine version: 1.5.xx
 *
 * Picture Download Link
 * Version 1.4
 *
 * Plugin Written by Joe Carver - http://photos-by.joe-carver.com/ - http://gallery.josephcarver.com/natural/ - http://i-imagine.net/artists/
 * 08 August 2010
*/
    // language file for plugin - submit changes to the Support thread for inclusion in
    // the next release of this plugin

// plugin manager text
    $pic_link['display_name'] = 'Tilføj Billede Downloadlink';
    $pic_link['plugin_documentation'] = 'Plugin Dokumentation';
    $pic_link['announcement_thread'] = 'Plugin Support Tråd';
    $pic_link['description'] = 'Dette plugin vil tilføje et downloadlink til billedsiden';

// admin + confguation
    $pic_link['configure_plugin_x'] = 'Konfigurer plugin %s';
    $pic_link['page_heading'] = 'Konfigurer Downloadlink plugin.';
    $pic_link['page_head'] = 'Konfigurer indstillingerne for dit Downloadlink plugin.';
    $pic_link['span_attr'] = 'HTML attributer for omgivende kant element';
	$pic_link['enabled_categories_regex'] = 'Vis downloadlink i kategorier, der matcher dette almindelige udtryk';
    $pic_link['link_user'] = 'Vis kun downloadlink til brugere der er logget ind';
    $pic_link['link_locate'] = 'Hvor på billedsiden vil du placerer link til at hente billede?';
    $pic_link['link_locate_0'] = 'over billedet';
    $pic_link['link_locate_1'] = 'under billedet';
    $pic_link['link_locate_2'] = 'under titlen/beskrivelsen';
    $pic_link['link_locate_3'] = 'i fil info boksen';
    $pic_link['use_content_disposition'] = 'Brug Indholdsdisposition for Gem Som';
    $pic_link['hideprefix'] = 'Skjul præfiks fra den hentede fils navn';
    $pic_link['whichone'] = 'Link til hvilken billedstørrelse?';
    $pic_link['whichone_0'] ='Fuldstørrelsebillede';
    $pic_link['whichone_1'] ='Mellemstørrelsebillede';
    $pic_link['submit_change'] = 'Send Ændringer';
    $pic_link['update_success'] = 'Opdatering succesfuld';
    $pic_link['no_changes'] = 'Ingen ændringer tilføjet';

	// visitor - user text for the button and title of link
	$pic_link['link_table'] = 'Downloadlink til billede';
	$pic_link['link_title'] = 'Åben billede i nyt vindue';
	$pic_link['link_save_title'] = 'Gem Billede';
	$pic_link['link_text'] = 'Hent Billede';
	$pic_link['link_null'] = 'Kun for registrerede brugere';
?>