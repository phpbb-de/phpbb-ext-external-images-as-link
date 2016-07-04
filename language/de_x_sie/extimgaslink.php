<?php
/**
*
* External Image as link [German (Formal Honorifics)]
*
* @package language
* @version 1.0.0
* @copyright (c) 2015 phpbb.de
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

$lang = array_merge($lang, array(
	'EXTIMGASLINK_CONFIG'			=> 'Zulässige Bilder',
	'EXTIMGASLINK_CONFIG_EXPLAIN'	=> 'Bilder, die über eine gesicherte Verbindung verfügbar sind, können zusätzlich zugelassen werden. Alle übrigen Bilder werden durch Links ersetzt. Bilder, die unter der selben Domain wie dieses Board verfügbar sind, sind immer zugelassen.',
	'EXTIMGASLINK_INVALID_CONFIG'	=> 'Die angegebene Bildherkunft ist ungültig.',
	'EXTIMGASLINK_SECURE_SITES'		=> 'nur Bilder von sicheren Webseiten und dieser Domain',
	'EXTIMGASLINK_SERVER_ONLY'		=> 'nur Bilder von dieser Domain',

	'EXTIMGLINK'	=> '[ externes Bild ]',
));
