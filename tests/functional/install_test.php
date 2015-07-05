<?php

/**
*
* @package phpBB.de External Images as link
* @copyright (c) 2015 phpBB.de
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace phpbbde\externalimgaslink\tests\functional;

/**
* @group functional
*/
class install_test extends \phpbb_functional_test_case
{
	static protected function setup_extensions()
	{
		return array('phpbbde/externalimgaslink');
	}

	public function test_validate_externalimgaslink()
	{
		$crawler = self::request('GET', 'viewtopic.php?t=1');
		$this->assertContains('phpBB3', $crawler->filter('h3')->text());
	}
}
