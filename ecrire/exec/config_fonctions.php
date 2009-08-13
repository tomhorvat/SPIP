<?php

/***************************************************************************\
 *  SPIP, Systeme de publication pour l'internet                           *
 *                                                                         *
 *  Copyright (c) 2001-2009                                                *
 *  Arnaud Martin, Antoine Pitrou, Philippe Riviere, Emmanuel Saint-James  *
 *                                                                         *
 *  Ce programme est un logiciel libre distribue sous licence GNU/GPL.     *
 *  Pour plus de details voir le fichier COPYING.txt ou l'aide en ligne.   *
\***************************************************************************/

if (!defined("_ECRIRE_INC_VERSION")) return;

include_spip('inc/presentation');

// http://doc.spip.org/@exec_config_fonctions_dist
function exec_config_fonctions_dist()
{
	if (!autoriser('configurer', 'fonctions')) {
		include_spip('inc/minipres');
		echo minipres();
	} else {

	$config = charger_fonction('config', 'inc');
	$config();

	pipeline('exec_init',array('args'=>array('exec'=>'config_fonctions'),'data'=>''));
	$commencer_page = charger_fonction('commencer_page', 'inc');
	echo $commencer_page(_T('titre_page_config_fonctions'), "configuration", "configuration");

	echo gros_titre(_T('titre_config_fonctions'),'', false);
	echo barre_onglets("configuration", "fonctions");

	echo debut_gauche('', true);
	echo pipeline('affiche_gauche',array('args'=>array('exec'=>'config_fonctions'),'data'=>''));
	echo creer_colonne_droite('', true);
	echo pipeline('affiche_droite',array('args'=>array('exec'=>'config_fonctions'),'data'=>''));
	echo debut_droite('', true);

	$reducteur = charger_fonction('reducteur', 'configuration');
	$avertisseur = charger_fonction('avertisseur', 'configuration');
	$previsualiseur = charger_fonction('previsualiseur', 'configuration');
	$relayeur = charger_fonction('relayeur', 'configuration');

	echo 

	  $reducteur(), // Creation automatique de vignettes

	  $avertisseur(), // Notification de modification des articles

	  $previsualiseur(), // Previsualisation sur le site public

	  $relayeur(_request('retour_proxy')), // Proxy pour syndication & doc


	'';

//
// Choix supplementaires proposees par les plugins
//
	$res = pipeline('affiche_milieu',array('args'=>array('exec'=>'config_fonctions'),'data'=>''));
	if ($res)
		echo $res;

	echo fin_gauche(), fin_page();
	}
}

?>