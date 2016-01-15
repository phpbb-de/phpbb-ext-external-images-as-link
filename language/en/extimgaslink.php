<?php
/**
*
* External Image as link [English]
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
	'EXTIMGASLINK_CONFIG'			=> 'Permitted images',
	'EXTIMGASLINK_CONFIG_EXPLAIN'	=> 'Images, that are available through a secure connection, can be additionally permitted. Any other images are replaced with links. Images, that are available on the same domain as this board, are always permitted.',
	'EXTIMGASLINK_INVALID_CONFIG'	=> 'The image origin you specified is invalid.',
	'EXTIMGASLINK_SECURE_SITES'		=> 'only images from secure websites and this domain',
	'EXTIMGASLINK_SERVER_ONLY'		=> 'only images from this domain',

	'EXTIMGLINK'	=> '[ external image ]',
));
