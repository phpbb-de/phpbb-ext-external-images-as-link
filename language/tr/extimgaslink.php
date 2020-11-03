<?php
/**
*
* External Image as link [Turkish]
*
* @package language
* @copyright (c) 2016-2018 phpbb.de
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Translated into Turkish: O Belde
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
	'TRANSLATION_INFO'	=> '<br />Tercüme: <a href="https://obelde.com/">O Belde</a> <a href="https://forum.obelde.com/">Forum</a>',
	'EXTIMGASLINK_CONFIG'			=> 'İzin verilen resimler',
	'EXTIMGASLINK_CONFIG_EXPLAIN'	=> 'Yalnızca bu forumun etki alanından veya hem bu forumdan hem harici güvenli İnternet sitelerinden sunulan görüntülerin gösterilmesine izin verebilirsiniz. Diğer tüm resimler bağlantılarla değiştirilecektir.',
	'EXTIMGASLINK_INVALID_CONFIG'	=> 'Belirttiğiniz görüntü kaynağı geçersiz.',
	'EXTIMGASLINK_SECURE_SITES'		=> 'Yalnızca güvenli İnternet sitelerinden ve bu alandan gelen resimler',
	'EXTIMGASLINK_SERVER_ONLY'		=> 'Yalnızca bu etki alanından resimler',

	'EXTIMGLINK'	=> '[ Harici Görsel ]',
));
