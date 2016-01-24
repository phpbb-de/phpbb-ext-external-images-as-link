<?php
/**
 *
 * @package phpBB.de External Images as link
 * @copyright (c) 2016 phpBB.de
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace phpbbde\externalimgaslink;

class constants
{
	// Flags, so please use powers of 2 for any additional values
	// SERVER_ONLY is special, because it should be always included
	const SERVER_ONLY = 0;
	const SECURE_SITES = 1;
}
