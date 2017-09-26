<?php
/**
 *
 * @package phpBB.de External Images as link
 * @copyright (c) 2015-2016 phpBB.de
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbbde\externalimgaslink\event;

/**
* @ignore
*/
use phpbb\config\config;
use phpbb\template\template;
use phpbb\user;
use phpbbde\externalimgaslink\constants;
use phpbbde\externalimgaslink\helper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var helper */
	protected $helper;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param config		$config
	 * @param Container 	$container
	 * @param helper		$helper
	 * @param template		$template
	 * @param user			$user
	 */
	public function __construct(config $config, helper $helper, template $template, user $user)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;

		$this->user->add_lang_ext('phpbbde/externalimgaslink', 'extimgaslink');
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
			'core.acp_board_config_edit_add'	=> 'acp_add_config',
			'core.bbcode_cache_init_end'		=> 'modify_case_img',
			// 3.2 TextFormatter events (will only trigger in >=3.2)
			'core.text_formatter_s9e_configure_after'	=> 'configure_textformatter',
			'core.text_formatter_s9e_renderer_setup'	=> 'setup_textformatter_renderer',
		);
	}

	/**
	 * Adds settings for this extension to the ACP
	 *
	 * @param \phpbb\event\data $event
	 * @return null
	 * @access public
	 */
	public function acp_add_config($event)
	{
		if ($event['mode'] !== 'post')
		{
			return;
		}

		$own_vars = array(
			'extimgaslink_config'	=> array(
				'lang' => 'EXTIMGASLINK_CONFIG',
				'validate' => 'int:0',
				'type' => 'select',
				'function' => array($this->helper, 'extimgaslink_config_select'),
				'params' => array('{CONFIG_VALUE}'),
				'explain' => true,
			),
		);

		$vars = $event['display_vars'];
		$vars['vars'] = helper::array_insert($vars['vars'], 'allow_post_links', $own_vars);
		$event['display_vars'] = $vars;
	}

	/**
	 * Configures the textformatter
	 *
	 * @param \phpbb\event\data $event
	 * @return null
	 * @access public
	 */
	public function configure_textformatter($event)
	{
		/** @var \s9e\TextFormatter\Configurator $configurator */
		$configurator = $event['configurator'];

		$condition = 'starts-with(@src, \'' . generate_board_url(true) . '\') or ($S_IMG_SECURE_URLS and starts-with(@src, \'https://\'))';

		// Prepare URL template
		$url_template = str_replace(array('@url', '<xsl:apply-templates/>'), array('@src', '<xsl:value-of select="$L_EXTIMGLINK"/>'), $configurator->tags['URL']->template);

		$configurator->tags['IMG']->template = '<xsl:choose>'
				. '<xsl:when test="' . $condition . '">' . $configurator->tags['IMG']->template . '</xsl:when>'
				. '<xsl:otherwise>' . $url_template . '</xsl:otherwise>'
			. '</xsl:choose>';

		// Fix behaviour when [img] tag is within [url] tag
		$configurator->tags['URL']->rules->allowChild('IMG');
		$configurator->tags['URL']->rules->allowDescendant('IMG');
	}

	/**
	 * Changes the regex replacement for second pass
	 *
	 * @param \phpbb\event\data $event
	 * @return null
	 * @access public
	 */
	public function modify_case_img($event)
	{
		$bbcode_id = 4; // [img] has bbcode_id 4 hardcoded
		$bbcode_cache = $event['bbcode_cache'];

		if (!isset($bbcode_cache[$bbcode_id]) || !$this->user->optionget('viewimg'))
		{
			return;
		}

		$this->template->set_filenames(array('bbcode.html' => 'bbcode.html'));

		$bbcode = new \bbcode();
		// We need these otherwise we cannot use $bbcode->bbcode_tpl()
		$bbcode->template_bitfield = new \bitfield($this->user->style['bbcode_bitfield']);
		$bbcode->template_filename = $this->template->get_source_file_for_handle('bbcode.html');

		$bbcode_cache[$bbcode_id] = array(
			'preg' => array(
				// display only images from own board url
				'#\[img:$uid\]('. preg_quote(generate_board_url(true) . '/', '#') . '.*?)\[/img:$uid\]#s'	=> $bbcode->bbcode_tpl('img', $bbcode_id),
			),
		);

		if (($this->config['extimgaslink_config'] & constants::SECURE_SITES) === constants::SECURE_SITES)
		{
			$bbcode_cache[$bbcode_id]['preg'] += array(
				// also display images from secure sites
				'#\[img:$uid\](https://.*?)\[/img:$uid\]#s'	=> $bbcode->bbcode_tpl('img', $bbcode_id),
			);
		}

		$bbcode_cache[$bbcode_id]['preg'] += array(
			// every other external image will be replaced
			'#\[img:$uid\](.*?)\[/img:$uid\]#s'	=> str_replace('$2', $this->user->lang('EXTIMGLINK'), $bbcode->bbcode_tpl('url', $bbcode_id, true)),
		);

		$event['bbcode_cache'] = $bbcode_cache;
	}

	/**
	 * Setup the TextFormatter Renderer
	 *
	 * @param \phpbb\event\data $event
	 * @return null
	 * @access public
	 */
	public function setup_textformatter_renderer($event)
	{
		/** @var \s9e\TextFormatter\Renderer $renderer */
		$renderer = $event['renderer']->get_renderer();
		$renderer->setParameter('S_IMG_SECURE_URLS', ($this->config['extimgaslink_config'] & constants::SECURE_SITES) === constants::SECURE_SITES);
	}
}
