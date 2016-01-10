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
	'EXTIMGASLINK_CONFIG'			=> 'Allowed origin from images used in posts',
	'EXTIMGASLINK_CONFIG_EXPLAIN'	=> 'Other images are replaced with links.',
	'EXTIMGASLINK_INVALID_CONFIG'	=> 'The origin you specified is not valid.',
	'EXTIMGASLINK_SECURE_SITES'		=> 'only images from secure websites and the server',
	'EXTIMGASLINK_SERVER_ONLY'		=> 'only images from the server',

	'EXTIMGLINK'	=> '[ external image ]',
));
