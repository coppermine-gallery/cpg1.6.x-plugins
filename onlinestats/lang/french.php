<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

$lang_plugin_onlinestats['description'] = 'Affiche un bloc sur chaque page de la galerie pour montrer les invités et les utilisateurs actuellement en ligne.';
$lang_plugin_onlinestats['name'] = 'Qui est en ligne ?';
$lang_plugin_onlinestats['config_extra'] = 'Pour activer ce plugin (et afficher le bloc de statistiques onlinestats), il faut ajouter la chaine &quot;onlinestats&quot; (séparée par un slash \'/\') à "<a href="docs/en/configuration.htm#admin_Album_list_content">Le contenu de la page principale</a>" dans <a href="admin.php">la configuration de Coppermine</a> dans la section &quot;Affichage de la liste des albums&quot;. Le paramétrage devrait ressemble à ça &quot;breadcrumb/catlist/alblist/onlinestats&quot;. Pour changer la position du bloc, déplacez la chaîne &quot;onlinestats&quot; dans le champ de la configuration.';
$lang_plugin_onlinestats['config_install'] = 'Ce plugin ajoute des requêtes à chaque fois ou il est exécuté, utilisant des resources supplémentaires. Si votre galerie est lente ou si vous avez beaucoup d\'utilisateursn vous ne devriez pas l\'Utilisez.';
$lang_plugin_onlinestats['we_have_reg_member'] = 'Il y a %s utilisateur enregistré';
$lang_plugin_onlinestats['we_have_reg_members'] = 'Il y a %s utilisateurs enregistrés';
$lang_plugin_onlinestats['most_recent'] = 'L\'utilisateur enregistré le plus récent est %s';
$lang_plugin_onlinestats['is'] = 'Au total il y a %s visiteur en ligne';
$lang_plugin_onlinestats['are'] = 'Au total il y a %s visiteurs en ligne';
$lang_plugin_onlinestats['and'] = 'et';
$lang_plugin_onlinestats['reg_member'] = '%s visiteur enregistré';
$lang_plugin_onlinestats['reg_members'] = '%s visiteur enregistré';
$lang_plugin_onlinestats['guest'] = '%s invité';
$lang_plugin_onlinestats['guests'] = '%s invités';
$lang_plugin_onlinestats['record'] = 'Record du nombre d\'utilisateurs en ligne : %s le %s';
$lang_plugin_onlinestats['since'] = 'Utilisateurs enregistrés en ligne au cours les dernières %s minutes : %s';
$lang_plugin_onlinestats['config_text'] = 'Combien de temps voulez-vous laisser les visiteurs affichés comme en ligne avant de considérer qu\'ils sont partis ?';
$lang_plugin_onlinestats['minute'] = 'minutes';
$lang_plugin_onlinestats['remove'] = 'Effacez la table utilisée pour stocker les données du plugin ?';
