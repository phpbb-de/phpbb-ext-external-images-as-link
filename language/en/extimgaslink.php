<?php
/**
*
* External Image as link [English]
*
* @package language
* @copyright (c) 2016-2018 phpbb.de
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
	'EXTIMGASLINK_CONFIG_EXPLAIN'	=> 'You can allow images served from this board’s domain only, or from both this board and external secure websites to be shown. All other images will be replaced with links.',
	'EXTIMGASLINK_INVALID_CONFIG'	=> 'The image origin you specified is invalid.',
	'EXTIMGASLINK_SECURE_SITES'		=> 'Only images from secure websites and this domain',
	'EXTIMGASLINK_SERVER_ONLY'		=> 'Only images from this domain',

	'EXTIMGLINK'	=> '[ external image ]',
));
