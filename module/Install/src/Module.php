<?php
/**
 * YAWIK
 *
 * @filesource
 * @license MIT
 * @copyright  2013 - 2016 Cross Solution <http://cross-solution.de>
 */
  
/** */
namespace Install;

use Zend\ModuleManager\Feature;
use Zend\EventManager\EventInterface;
use Install\Listener\TracyListener;
use Install\Tracy as TracyService;

/**
 * Module "Install" initialization.
 *
 * @author Mathias Gelhausen <gelhausen@cross-solution.de>
 * @since 0.20
 */
class Module implements Feature\ConfigProviderInterface, Feature\BootstrapListenerInterface
{

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    /**
     * Listen to the bootstrap event.
     *
     * @param EventInterface|\Zend\Mvc\MvcEvent $e
     *
     * @return void
     */
    public function onBootstrap(EventInterface $e)
    {
        $application  = $e->getApplication();
        $eventManager = $application->getEventManager();
        $services     = $application->getServiceManager();

        $services->get('Install/Listener/LanguageSetter')
                 ->attach($eventManager);
	
	    $tracyConfig = $services->get('Config')['tracy'];
	
	    if ($tracyConfig['enabled']) {
		    (new TracyService())->register($tracyConfig);
		    (new TracyListener())->attach($eventManager);
	    }

    }
}
