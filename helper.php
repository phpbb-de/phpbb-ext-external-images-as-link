<?php
/**
 *
 * @package phpBB.de External Images as link
 * @copyright (c) 2016 phpBB.de
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbbde\externalimgaslink;

class helper
{
	/** @var \phpbb\user */
	protected $user;

	/**
	 * Constructor
	 *
	 * @param \phpbb\user $user
	 */
	public function __construct(\phpbb\user $user)
	{
		$this->user = $user;
	}

	/**
	 * Inserts an array into an array at a specified offset and keeps the keys.
	 * (array_splice wouldn't allow keeping the keys)
	 * See: http://php.net/manual/en/function.array-splice.php#56794
	 *
	 * @param array		$input			The input array.
	 * @param string	$search_key		Specifies the key after which the array should be inserted at.
	 * @param array		$insert_array	The array which should be inserted.
	 * @return array
	 * @access public
	 */
	public static function array_insert($input, $search_key, $insertion)
	{
		$offset = array_search($search_key, array_keys($input)) + 1;
		$first_array = array_splice($input, 0, $offset);
		return array_merge($first_array, $insertion, $input);
	}

	/**
	 * Select image filter type
	 */
	public function extimgaslink_config_select($selected_type)
	{
		$types = array(
			constants::SERVER_ONLY	=> 'SERVER_ONLY',
			constants::SECURE_SITES	=> 'SECURE_SITES',
		);

		$options = '';

		foreach ($types as $key => $value)
		{
			$selected = ($selected_type === $key) ? ' selected="selected"' : '';
			$options .= '<option value="' . $key . '"' . $selected . '>' . $this->user->lang('EXTIMGASLINK_' . $value) . '</option>';
		}

		return $options;
	}
}
