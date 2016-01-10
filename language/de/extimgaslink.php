<?php
/**
*
* External Image as link [German (Casual Honorifics)]
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
	'EXTIMGASLINK_CONFIG'			=> 'Erlaubte Herkunft von in Beiträgen verwendeten Bildern',
	'EXTIMGASLINK_CONFIG_EXPLAIN'	=> 'Alle anderen Bilder werden durch Links ersetzt.',
	'EXTIMGASLINK_INVALID_CONFIG'	=> 'Die angegebene Bildherkunft ist ungültig.',
	'EXTIMGASLINK_SECURE_SITES'		=> 'nur Bilder von sicheren Webseiten und dem Server',
	'EXTIMGASLINK_SERVER_ONLY'		=> 'nur Bilder vom Server',

	'EXTIMGLINK'	=> '[ externes Bild ]',
));
