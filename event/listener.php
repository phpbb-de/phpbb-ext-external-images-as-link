<?php
/**
 *
 * @package phpBB.de External Images as link
 * @copyright (c) 2015 phpBB.de, BlackHawk87
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbbde\externalimgaslink\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/**
	* Constructor
	*
	* @param \phpbb\controller\helper			$helper			Controller helper object
	*/
	public function __construct(\phpbb\user $user, \phpbb\template\template $template)
	{
		$this->user = $user;
		$this->template = $template;
	}

	/**
	* Assign functions defined in this class to event listeners in the core
	*
	* @return array
	* @static
	* @access public
	*/
	static public function getSubscribedEvents()
	{
		return array(
			'core.bbcode_cache_init_end'	=> 'modify_case_img',
		);
	}

	/**
	* Add configuration items for ppp-extension to ACP
	*
	* @param object	$event The event object
	* @return null
	* @access public
	*/
	public function modify_case_img($event)
	{
		$this->user->add_lang_ext('phpbbde/externalimgaslink', 'extimgaslink');

		$bbcode_cache = $event['bbcode_cache'];

		$bbcode_id = 4 ; // [img] is case 4

		$bbcode = new \bbcode();

		$bbcode->template_bitfield = new \bitfield($this->user->style['bbcode_bitfield']);

		$this->template->set_filenames(array('bbcode.html' => 'bbcode.html'));

		$bbcode->template_filename = $this->template->get_source_file_for_handle('bbcode.html');

		if ($this->user->optionget('viewimg'))
		{
			$bbcode_cache[$bbcode_id] = array(
				'preg' => array(
				//nur Bilder von phpBB.de direkt anzeigen
				'#\[img:$uid\](https://www\.phpbb\.de/.*?)\[/img:$uid\]#s'	=> $bbcode->bbcode_tpl('img', $bbcode_id),
				//alle anderen durch [ externes Bild ] ersetzen
				'#\[img:$uid\](.*?)\[/img:$uid\]#s' 	=> str_replace('$2', '[ externes Bild ]', $bbcode->bbcode_tpl('url', $bbcode_id, true)),
				)
			);
		}

		$event['bbcode_cache'] = $bbcode_cache;
	}
}
