<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Εμφάνιση ενός τμήματος σε κάθε σελίδα της γκαλερί που θα εμφανίζει τους συνδεδεμένους χρήστες και επισκέπτες σε πραγματικό χρόνο.';
$lang_plugin_onlinestats['name'] = 'Ποιος είναι συνδεδεμένος;';
$lang_plugin_onlinestats['config_extra'] = 'Για να ενεργοποιήσετε αυτό το βοήθημα (ώστε να δείχνει πραγματικά το τμήμα στατιστικών), η ακολουθία "onlinestats" (χωρισμένη με κάθετο) πρέπει να προστεθεί στο "περιεχόμενο της κύριας σελίδας" στις <a href="admin.php">ρυθμίσεις του Coppermine</a> στο τμήμα "Εμφάνιση λίστας άλμπουμς". Η ρύθμιση θα πρέπει τάρα να φαίνεται ως "breadcrumb/catlist/alblist/onlinestats" ή παρόμοια. Για να αλλάξετε την θέση του τμήματος, μετακινήστε την ακολουθία "onlinestats" μέσα σε αυτό το πεδίο ρυθμίσεων.';
$lang_plugin_onlinestats['config_install'] = 'Το βοήθημα κάνει επιπρόσθετες αιτήσεις από την βάση δεδομένων κάθε φορά που εκτελείται, καταναλώνοντας κύκλους της κεντρινκής μονάδας επεξεργασίας (CPU) και χρησιμοποιώντας πόρους του συστήματος. Εάν η γκαλερί Coppermine είναι αργή ή εάν υπάρχουν αρκετοί χρήστες, δεν θα έπρεπε να το χρησιμοποιήσετε.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Υπάρχει %s εγγεγραμμένος χρήστης';
$lang_plugin_onlinestats['we_have_reg_members'] = ' Υπάρχουν %s εγγεγραμμένοι χρήστες';
$lang_plugin_onlinestats['most_recent'] = 'Ο πιο πρόσφατα εγγεγραμμένος χρήστης είναι ο/η %s';
$lang_plugin_onlinestats['is'] = 'Συνολικά υπάρχει %s συνδεδεμένος επισκέπτης';
$lang_plugin_onlinestats['are'] = 'Συνολικά υπάρχουν %s συνδεδεμένοι επισκέπτες';
$lang_plugin_onlinestats['and'] = 'και';
$lang_plugin_onlinestats['reg_member'] = '%s εγγεγραμμένος χρήστης';
$lang_plugin_onlinestats['reg_members'] = '%s εγγεγραμμένοι χρήστης';
$lang_plugin_onlinestats['guest'] = '%s επισκέπτης';
$lang_plugin_onlinestats['guests'] = '%s επισκέπτες';
$lang_plugin_onlinestats['record'] = 'Περισσότεροι συνδεδεμένοι χρήστες μέχρι τώρα: %s στις %s';
$lang_plugin_onlinestats['since'] = ' Εγγεγραμμένοι χρήστες οι οποίοι συνδεθήκανε τα τελευταία %s λεπτά: %s';
$lang_plugin_onlinestats['config_text'] = 'Για πόσο χρόνο θέλετε να φαίνονται οι χρήστες ως συνδεδεμένοι πριν καταστούν ως αποσυνδεδεμένοι;';
$lang_plugin_onlinestats['minute'] = 'λεπτά';
$lang_plugin_onlinestats['remove'] = 'Διαγραφή του πίνακα που χρησιμοποιήθηκε για την αποθήκευση των δεδομένων για τους συνδεδεμένους χρήστες;';
