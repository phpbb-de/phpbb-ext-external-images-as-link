<?php
/**
*
* External Image as Link extension for the phpBB Forum Software package.
* French translation by Galixte (http://www.galixte.com)
* @version 1.1.0
* @copyright (c) 2016 phpbb.de
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'EXTIMGASLINK_CONFIG'			=> 'Images acceptées',
	'EXTIMGASLINK_CONFIG_EXPLAIN'	=> 'Permet d’afficher uniquement les images provenant du nom de domaine de ce forum ou depuis des sites Web externes au forum mais sécurisés. L’affichage des autres images sera remplacé par des liens.',
	'EXTIMGASLINK_INVALID_CONFIG'	=> 'L’origine de l’image indiquée est invalide.',
	'EXTIMGASLINK_SECURE_SITES'		=> 'Seulement les images provenant de sites Web sécurisés et depuis ce nom de domaine',
	'EXTIMGASLINK_SERVER_ONLY'		=> 'Seulement les images provenant de ce nom de domaine',

	'EXTIMGLINK'	=> '[ image externe ]',
));
