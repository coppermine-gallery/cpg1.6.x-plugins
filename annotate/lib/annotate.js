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

var loaded = false;

$(document).ready(function() {
    var alertTimerId = 0;
    $('#livesearch_input').keyup(function() {
        $('#livesearch_input').addClass('blue');
        clearTimeout(alertTimerId);
        alertTimerId = setTimeout(function () {
            $.post('index.php?file=annotate/reqserver', {livesearch:'1',q:$('#livesearch_input').val()}, function(data) { 
                $('#livesearch_output').html(data); 
                $('#livesearch_input').removeClass('blue');
            });
            loaded = true;
        }, 250);
    });

    /* create the Photo Note Container */
    container = document.getElementById('PhotoContainer');
    if (container) {
        if (js_vars.lang_on_this_pic) {
            $('#on_this_pic').append(js_vars.lang_on_this_pic + ': ');
            $('#on_this_pic').css('white-space', 'normal');
            $('#on_this_pic').css('cursor', 'default');
            $('#on_this_pic').css('padding-bottom', '4px');
        }
        notes = new PhotoNoteContainer(container);
        for (n = 0; n < js_vars.annotations.length; n++) {
            /* create a note */
            var size = new PhotoNoteRect(js_vars.annotations[n].posx, js_vars.annotations[n].posy, js_vars.annotations[n].width, js_vars.annotations[n].height);
            var note = new PhotoNote(stripslashes(js_vars.annotations[n].note), 'note' + n, size, js_vars.annotations[n].user_name, js_vars.annotations[n].user_id);
            /* implement the save/delete functions */
            note.onsave = function (note) { return ajax_save(note); };
            note.ondelete = function (note) { return ajax_delete(note); };
            /* assign the note id number */
            note.nid = js_vars.annotations[n].nid;
            if (js_vars.visitor_annotate_permission_level < 3 && js_vars.annotations[n].user_id != js_vars.visitor_annotate_user_id) note.editable = false;
            /* add it to the container */
            notes.AddNote(note);
            if (js_vars.lang_on_this_pic) {
                $('#on_this_pic').append("<button onclick=\"window.location.href='thumbnails.php?album=shownotes&amp;note=" + encodeURIComponent(js_vars.annotations[n].note) + "';\" class=\"admin_menu\" title=\"" + js_vars.lang_all_pics_of.replace(/%s/, stripslashes(js_vars.annotations[n].note)) + "\" onmouseover=\"notes.notes[" + n + "].ShowNote(); notes.notes[" + n + "].ShowNoteText();\" onmouseout=\"notes.notes[" + n + "].HideNote(); notes.notes[" + n + "].HideNoteText();\">" + stripslashes(js_vars.annotations[n].note) + "</button> ");
            }
        }
        notes.HideAllNotes();
        addEvent(container, 'mouseover', function() { notes.ShowAllNotes(); });
        addEvent(container, 'mouseout', function() { notes.HideAllNotes(); });
    }
});

function stripslashes(str) {
    str = str.replace(/\\'/g,'\'');
    str = str.replace(/\\"/g,'"');
    str = str.replace(/\\0/g,'\0');
    str = str.replace(/\\\\/g,'\\');
    return str;
}

function addnote(note_text){
    if (js_vars.visitor_annotate_permission_level < 2) {
        return false;
    }
    var newNote = new PhotoNote(note_text, 'note' + n, new PhotoNoteRect(10,10,50,50), '', '');
    newNote.onsave = function (note) { return ajax_save(note); };
    newNote.ondelete = function (note) { return ajax_delete(note); };
    notes.AddNote(newNote);
    newNote.Select();
    newNote.nid = 0;
    return false;
}

function ajax_save(note){
    var data = 'add=' + js_vars.pid + '&nid=' + note.nid + '&posx=' + note.rect.left + '&posy=' + note.rect.top + '&width=' + note.rect.width + '&height=' + note.rect.height + '&note=' + encodeURI(note.text);
    annotate_request(data, note);
    return true;
}

function ajax_delete(note){
    var data = 'remove=' + note.nid;
    annotate_request(data, note);
    return true;
}

function load_annotation_list() {
    if (loaded == false) {
        $('#livesearch_output').attr('disabled', 'disabled');
        $('#livesearch_output_loading').show();
        $.post('index.php?file=annotate/reqserver', { livesearch: '1', q: $('#livesearch_input').val() }, function(data) {
            $('#livesearch_output_loading').hide();
            $('#livesearch_output').html(data).removeAttr('disabled'); 
        });
        loaded = true;
    }
}

function annotate_request(data, note){

    if (window.XMLHttpRequest) { // Mozilla, Safari, ...
        var httpRequest = new XMLHttpRequest();
    } else if (window.ActiveXObject) { // IE
        try {
            var httpRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try {
                var httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e) {}
        }
    }

    httpRequest.onreadystatechange = function() { callback(httpRequest, note); };
    httpRequest.open('POST', 'index.php?file=annotate/reqserver', true);
    httpRequest.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    httpRequest.send(data);

    return true;
}

function callback(req, note){

    if (req.readyState == 4) {
        if (req.status == 200) {
            note.nid = req.responseText;
        }
    }
}