<?php
/**
 *
 * @package phpBB.de External Images as link
 * @copyright (c) 2016 phpBB.de
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbbde\externalimgaslink\migrations;

use phpbbde\externalimgaslink\constants;

class add_filter_config extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array(
			'\phpbb\db\migration\data\v32x\v324',
		);
	}

	public function update_data()
	{
		return array(
			array('config.add', array('extimgaslink_config', constants::SERVER_ONLY)),
		);
	}
}
