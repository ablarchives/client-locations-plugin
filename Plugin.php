<?php namespace AlbrightLabs\ClientLocations;

use Event;
use Backend;
use AlbrightLabs\Client\Models\Client;
use AlbrightLabs\Client\Controllers\Clients;
use System\Classes\PluginBase;

/**
 * ClientLocations Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Client Locations',
            'description' => 'Replaces single client address with multiple addresses.',
            'author'      => 'Albright Labs LLC',
            'icon'        => 'icon-map-pin'
        ];
    }

    /**
     * Returns required plugins.
     *
     * @return array
     */
    public $require = [
        'AlbrightLabs.Client',
    ];

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        // Add relation to AlbrightLabs.Client Client model
        Client::extend(function($model) {
            $model->hasMany['locations'] = ['AlbrightLabs\ClientLocations\Models\Location', 'delete' => true];
        });

        // Add relation config to AlbrightLabs.Client Clients controller
        Clients::extend(function($controller){
            // Only for the Clients controller
            if (!$controller instanceof Clients) {
                return;
            }
            if (!isset($controller->relationConfig)) {
                $controller->addDynamicProperty('relationConfig');
            }
            $myConfigPath = '$/albrightlabs/clientlocations/controllers/locations/config_relation.yaml';
            $controller->relationConfig = $controller->mergeConfig(
                $controller->relationConfig,
                $myConfigPath
            );
        });

        // Extend all backend form usage
        Event::listen('backend.form.extendFields', function($widget) {

            // Only for the Clients controller
            if (!$widget->getController() instanceof Clients) {
                return;
            }

            // Only for the Client model
            if (!$widget->model instanceof Client) {
                return;
            }

            // Add the loctions list field
            $widget->addTabFields([
                'locations' => [
                    'type'  => 'partial',
                    'path'  => '$/albrightlabs/clientlocations/controllers/locations/_field_locations.htm',
                    'tab'   => 'Locations',
                    'context'    => [
                        'preview',
                    ],
                ],
            ]);

            // Remove the single address fields
            $widget->removeField('street');
            $widget->removeField('city');
            $widget->removeField('state');
            $widget->removeField('zip');
        });

        // Extend all backend list usage
        Event::listen('backend.list.extendColumns', function($widget) {

            // Only for the User controller
            if (!$widget->getController() instanceof \AlbrightLabs\Client\Controllers\Clients) {
                return;
            }

            // Only for the User model
            if (!$widget->model instanceof \AlbrightLabs\Client\Models\Client) {
                return;
            }

            // Remove the single address column
            $widget->removeColumn('location');

            // Add the default location
            $widget->addColumns([
                'location' => [
                    'label'      => 'Location',
                    'type'       => 'partial',
                    'path'       => '$/albrightlabs/clientlocations/controllers/locations/_column_location.htm',
                    'select'     => 'concat(street, city, state, zip)',
                    'searchable' => true,
                ],
            ]);

        });
    }
}
