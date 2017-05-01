<?php
/**
*
* External Image as link [Spanish]
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
	'EXTIMGASLINK_CONFIG'			=> 'Imágenes permitidas',
	'EXTIMGASLINK_CONFIG_EXPLAIN'	=> 'Puede permitir sólo las imágenes servidas desde el dominio de este foro, o de ambos, de este foro y sitios web externos seguros para mostrar. Todas las otras imágenes serán reemplazadas por enlaces.',
	'EXTIMGASLINK_INVALID_CONFIG'	=> 'El origen de imágenes que ha especificado no es válido.',
	'EXTIMGASLINK_SECURE_SITES'		=> 'Sólo las imágenes de sitios web seguros y este dominio',
	'EXTIMGASLINK_SERVER_ONLY'		=> 'Sólo imágenes de este dominio',

	'EXTIMGLINK'	=> '[ Imagen Externa ]',
));
