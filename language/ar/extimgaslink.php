<?php
/**
*
* External Image as link [Arabic]
*
* @package language
* @version 1.1.0
* @copyright (c) 2016 phpbb.de
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*
* Translated By : Bassel Taha Alhitary - www.alhitary.net
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
	'EXTIMGASLINK_CONFIG'			=> 'الصور المسموح بها ',
	'EXTIMGASLINK_CONFIG_EXPLAIN'	=> 'تستطيع السماح بعرض الصور الموجودة في موقعك فقط , أو من موقعك والمواقع الخارجية الموثوق بها. جميع الصور الأخرى ستظهر على شكل روابط فقط.',
	'EXTIMGASLINK_INVALID_CONFIG'	=> 'رابط الصورة التي حددتها غير صالح.',
	'EXTIMGASLINK_SECURE_SITES'		=> 'الصور من المواقع الآمنة وهذا الموقع فقط ',
	'EXTIMGASLINK_SERVER_ONLY'		=> 'الصور من هذا الموقع فقط ',

	'EXTIMGLINK'	=> '[ صورة خارجية ]',
));
