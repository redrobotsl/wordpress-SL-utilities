<?php
/**
 * utilities for Second Life
 *
 * @package       UTILITIESF
 * @author        Nolan Perry, LLC
 * @license       gplv2
 * @version       1.0.0
 *
 * @wordpress-plugin
 * Plugin Name:   utilities for Second Life
 * Plugin URI:    https://darknebula.world/software-plugins/
 * Description:   Various Utilities for Second Life, a amazing Metaverse and Virtual World. 
 * Version:       1.0.0
 * Author:        Nolan Perry, LLC
 * Author URI:    https://darknebula.world
 * Text Domain:   utilities-for-second-life
 * Domain Path:   /languages
 * License:       GPLv2
 * License URI:   https://www.gnu.org/licenses/gpl-2.0.html
 *
 * You should have received a copy of the GNU General Public License
 * along with utilities for Second Life. If not, see <https://www.gnu.org/licenses/gpl-2.0.html/>.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;
// Plugin name
define( 'UTILITIESF_NAME',			'utilities for Second Life' );

// Plugin version
define( 'UTILITIESF_VERSION',		'1.0.0' );

// Plugin Root File
define( 'UTILITIESF_PLUGIN_FILE',	__FILE__ );

// Plugin base
define( 'UTILITIESF_PLUGIN_BASE',	plugin_basename( UTILITIESF_PLUGIN_FILE ) );

// Plugin Folder Path
define( 'UTILITIESF_PLUGIN_DIR',	plugin_dir_path( UTILITIESF_PLUGIN_FILE ) );

// Plugin Folder URL
define( 'UTILITIESF_PLUGIN_URL',	plugin_dir_url( UTILITIESF_PLUGIN_FILE ) );

/**
 * Load the main class for the core functionality
 */
require_once UTILITIESF_PLUGIN_DIR . 'core/class-utilities-for-second-life.php';

/**
 * The main function to load the only instance
 * of our master class.
 *
 * @author  Nolan Perry, LLC
 * @since   1.0.0
 * @return  object|Utilities_For_Second_Life
 */
function UTILITIESF() {
	return Utilities_For_Second_Life::instance();
}

UTILITIESF();
