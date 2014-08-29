<?php

/**
 * YAWIK
 * Configuration file of the Applications module
 * 
 * @copyright (c) 2013-2104 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

return array(
    'doctrine' => array(
       'driver' => array(
            'odm_default' => array(
                'drivers' => array(
                    'Applications\Entity' => 'annotation',
                ),
            ),
            'annotation' => array(
               /*
                * All drivers (except DriverChain) require paths to work on. You
                * may set this value as a string (for a single path) or an array
                * for multiple paths.
                * example https://github.com/doctrine/DoctrineORMModule
                */
               'paths' => array( __DIR__ . '/../src/Applications/Entity',
                                 __DIR__ . '/../../../module/Cv/src/Cv/Entity'),
           ),
        ),
        'eventmanager' => array(
            'odm_default' => array(
                'subscribers' => array(
                    '\Applications\Repository\Event\JobReferencesUpdateListener',
                    '\Applications\Repository\Event\UpdatePermissionsSubscriber',
                    '\Applications\Repository\Event\UpdateFilesPermissionsSubscriber',
                    '\Applications\Repository\Event\DeleteRemovedAttachmentsSubscriber',
                ),
            ),
        ),
    ),
    
    'Applications' => array(
        /*
         * Settings for the application form.
         */
        'form' =>array(
            'showCv' => true,              // show educations and work experiences in application form
            'showCarbonCopy' => true,      // show 'send me my data in CC' in application form
            'showSocialProfiles' => true,  // enables attaching social profiles to an application
            'showAttachments' => true,     // enables file uploads for an application
        ),
        'dashboard' => array(
            'enabled' => true,
            'widgets' => array(
                'recentApplications' => array(
                    'controller' => 'Applications\Controller\Index',
                ),
            ),
        ),
    
        'allowedMimeTypes' => array('image', 'applications/pdf'),
        'settings' => array(
            'entity' => '\Applications\Entity\Settings',
            'navigation_order' => 1, 
            'navigation_label' => /*@translate*/ "E-Mail Templates",
            'navigation_class' => 'yk-icon yk-icon-envelope'
        ),
    ),
    
    'service_manager' => array(
        'invokables' => array(
        ),
        'factories' => array(
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Applications\Controller\Index' => 'Applications\Controller\IndexController',
            'Applications\Controller\Apply' => 'Applications\Controller\ApplyController',
            'Applications\Controller\Manage' => 'Applications\Controller\ManageController',
            'Applications/CommentController' => 'Applications\Controller\CommentController',
            'Applications/Console' => 'Applications\Controller\ConsoleController',
            'Applications\Controller\MultiManage' => 'Applications\Controller\MultimanageController',
        ),
    ),
    
    'acl' => array(
        'rules' => array(
            'guest' => array(
                'allow' => array(
                    'Applications\Controller\Manage' => 'detail',
                    'Entity/Application' => array(
                        'read' => 'Applications/Access',
                    ),
                ),
            ),
            'user' => array(
                'allow' => array(
                    'route/lang/applications',
                    'Applications\Controller\Manage',
                    'Entity/Application' => array(
                        '__ALL__' => 'Applications/Access',
                        
                    ),
                ),
            ),
        ),
        'assertions' => array(
            'invokables' => array(
                'Applications/Access'      => 'Applications\Acl\ApplicationAccessAssertion',
            ),
        ),
    ),
    
    // Navigation
    'navigation' => array(
        'default' => array(
            'apply' => array(
                'label' => 'Applications',
                'route' => 'lang/applications',
                'order' => 20,
                'resource' => 'route/lang/applications',
                'query' => array(
                    'clear' => '1'
                ),
                'pages' => array(
                    'list' => array(
                        'label' => /*@translate*/ 'Overview',
                        'route' => 'lang/applications',
                    ),
                ),
            ),
        ),
    ),
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    // Configure the view service manager
    'view_manager' => array(
        'template_path_stack' => array(
            'Applications' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'applications/error/not-found' => __DIR__ . '/../view/error/not-found.phtml', 
            'layout/apply' => __DIR__ . '/../view/layout/layout.phtml',
            'applications/sidebar/manage' => __DIR__ . '/../view/sidebar/manage.phtml',
            'applications/index/disclaimer' => __DIR__ . '/../view/applications/index/disclaimer.phtml',
        )
    ),
    'view_helpers' => array(
        
    ),
    
    
    'view_helper_config' => array(
        'headscript' => array(
            'lang/applications' => array('Core/js/jquery.barrating.min.js'),
        ),
    ),
    'form_elements' => array(
        'invokables' => array(
             'Applications/Mail' => 'Applications\Form\Mail',
             'Applications/BaseFieldset' => 'Applications\Form\BaseFieldset', 
             'Applications/SettingsFieldset' => 'Applications\Form\SettingsFieldset',
             'Applications/CommentForm' => 'Applications\Form\CommentForm',
             'Applications/CommentFieldset' => 'Applications\Form\CommentFieldset',
             'Applications/Apply' => 'Applications\Form\Apply',
             'Applications/Contact' => 'Applications\Form\ContactContainer',
             'Applications/Base'  => 'Applications\Form\Base',
             'Applications/Attributes' => 'Applications\Form\Attributes',
             'Applications/Filter' => 'Applications\Form\FilterApplication',
             'href' => 'Applications\Form\Element\Ref',
         ),
        'factories' => array(
            'Applications/ContactImage' => 'Applications\Form\ContactImageFactory',
            'Applications/Attachments' => 'Applications\Form\AttachmentsFactory',
        ),
     ),

    'form_elements_config' => array(
        'Applications/Apply' => array(
            'disable_elements' => array('base' => array('base' => array('salary'))),
        ),
    ),
     
    'filters' => array(
        'invokables' => array(
            'Applications/ActionToStatus' => 'Applications\Filter\ActionToStatus',
        ),
        'factories'=> array(
            'Applications/PaginationQuery' => '\Applications\Repository\Filter\PaginationQueryFactory'
        ),
    ),
    
    'validators' => array(
        'invokables' => array(
            'Applications/Application' => 'Applications\Entity\Validator\Application',
        ),
    ),
     
    'mails' => array(
        'invokables' => array(
            'Applications/NewApplication' => 'Applications\Mail\NewApplication',
            'Applications/Confirmation'   => 'Applications\Mail\Confirmation',
            'Applications/StatusChange'   => 'Applications\Mail\StatusChange',
            'Applications/Forward'        => 'Applications\Mail\Forward',
            'Applications/CarbonCopy'     => 'Applications\Mail\ApplicationCarbonCopy',
        ),
    ),

);
