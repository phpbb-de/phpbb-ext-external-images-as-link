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
use phpbbde\externalimgaslink\helper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\DependencyInjection\Container;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var config */
	protected $config;

	/** @var Container */
	protected $container;

	/** @var helper */
	protected $helper;

	/** @var template */
	protected $template;

	/** @var string */
	protected $updated;

	/** @var user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbbde\externalimgaslink\helper	$helper
	 * @param \phpbb\template\template		$template
	 * @param \phpbb\user					$user
	 */
	public function __construct(config $config, Container $container, helper $helper, template $template, user $user)
	{
		$this->config = $config;
		$this->container = $container;
		$this->helper = $helper;
		$this->template = $template;
		$this->updated = '';
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
			'core.validate_config_variable'		=> 'validate_config_variable',
			// 3.2 TextFormatter event (will only trigger in >=3.2)
			'core.text_formatter_s9e_configure_after'	=> 'configure_textformatter',
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
				'validate' => 'extimgaslink_config',
				'type' => 'select',
				'function' => array($this->helper, 'extimgaslink_config_select'),
				'params' => array('{CONFIG_VALUE}'),
				'explain' => true
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

		$condition = 'starts-with(@src, \'' . generate_board_url(true) . '\')';
		$setting = ($this->updated) ? $this->updated : $this->config['extimgaslink_config'];
		$condition .= ($setting === 'SECURE_SITES') ? ' or starts-with(@src, \'https://\')' : '';

		$img_template = '<xsl:choose>'
			. '<xsl:when test="' . $condition . '"><img src="{IMAGEURL}" class="postimage" alt="{L_IMAGE}"/></xsl:when>' // Taken from \phpbb\textformatter\s9e\factory
			. '<xsl:otherwise>' . str_replace(array('{URL}', '{DESCRIPTION}'), array('@src', '{L_EXTIMGLINK}'), $configurator->tags['URL']->template) . '</xsl:otherwise>' // Do some hacking
			. '</xsl:choose>';

		$configurator->tags['IMG']->template = '<xsl:choose>'
			. '<xsl:when test="$S_VIEWIMG">' . $img_template . '</xsl:when>'
			. '<xsl:otherwise><xsl:apply-templates/></xsl:otherwise>'
			. '</xsl:choose>';
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

		if ($this->config['extimgaslink_config'] === 'SECURE_SITES')
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
	 * Validate the config value set in ACP
	 *
	 * @param \phpbb\event\data $event
	 * @return null
	 * @access public
	 */
	public function validate_config_variable($event)
	{
		if ($event['config_definition']['validate'] !== 'extimgaslink_config')
		{
			return;
		}

		$types = array(
			'SERVER_ONLY',
			'SECURE_SITES',
		);

		$data = $event['cfg_array'][$event['config_name']];

		if (!in_array($data, $types))
		{
			$error = $event['error'];
			$error[] = $this->user->lang('EXTIMGASLINK_INVALID_CONFIG');
			$event['error'] = $error;
		}
		// We successfully validated it, let's update the renderer (and don't break 3.1)
		else if ($this->container->has('text_formatter.s9e.factory'))
		{
			$this->updated = $data;
			$this->container->get('text_formatter.s9e.factory')->invalidate();
		}
	}
}
