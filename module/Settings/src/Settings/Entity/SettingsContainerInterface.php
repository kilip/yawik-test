<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013 Cross Solution (http://cross-solution.de)
 * @license   AGPLv3
 */

/** SettingsContainer.php */ 
namespace Settings\Entity;

use Core\Entity\EntityInterface;
/**
 * 
 */
interface SettingsContainerInterface extends EntityInterface
{
    public function get($key);
    public function getSettings();
    
    public function set($key, $value);
    public function setSettings(array $settings);
    
    public function enableWriteAccess();
}
