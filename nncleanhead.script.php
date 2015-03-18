<?php
/**
 * @version 1.0.0
 * @package NNCleanhead
 * @copyright 2015 Niels Nübel
 * @license This software is licensed under the MIT license: http://opensource.org/licenses/MIT
 * @link http://www.niels-nuebel.de
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');


/**
 * Class PlgSystemNNCleanheadInstallerScript
 *
 * @since 1.0.0
 */
class PlgSystemNNCleanheadInstallerScript
{
    /**
     * Called before any type of action
     *
     * @param  string  $type  type of current action
     *
     * @return  boolean  True on success
     */
    public function preflight($type)
    {
        // make version check only when installing the plugin
        if ($type != "discover_install" && $type != "install")
        {
            return true;
        }

        $version = new JVersion;

        // Abort if the current Joomla release is older
        if (version_compare($version->getShortVersion(), "3", 'lt'))
        {
            Jerror::raiseWarning(null, 'Cannot install NNCleanhead in a Joomla release prior to 3');

            return false;
        }

        return true;
    }
}