<?php
namespace Mohsin\MagnificGallery;

use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Backend\Models\Preference as PreferenceModel;
use Backend\Controllers\Preferences as PreferencesController;

/**
 * Magnific Gallery Plugin Information File
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
        'name'        => 'mohsin.magnificgallery::lang.plugin.name',
        'description' => 'mohsin.magnificgallery::lang.plugin.description',
        'author'      => 'Saifur Rahman Mohsin',
        'icon'        => 'icon-picture-o'
      ];
  }

  public function boot()
  {
      PreferencesController::extendFormFields(function($form, $model, $context) {
            if(!$model instanceof PreferenceModel)
                return;

            if(!$model->exists)
              return;

            $form->addTabFields([
                'show_gallery_in_nav' => [
                    'label' => 'mohsin.magnificgallery::lang.preferences.show_gallery_in_nav_label',
                    'commentAbove' => 'mohsin.magnificgallery::lang.preferences.show_gallery_in_nav_comment',
                    'type' => 'switch',
                    'tab' => SettingsManager::CATEGORY_CMS,
                  ]
              ]);
      });
  }

  public function registerComponents()
  {
      return [
          'Mohsin\MagnificGallery\Components\Magnific' => 'magnific'
      ];
  }

  public function registerNavigation()
  {
      if(PreferenceModel::instance()->get('show_gallery_in_nav')) {
          return [
              'galleries' => [
                'label'       => 'mohsin.magnificgallery::lang.magnific.name',
                'url'         => Backend::url('mohsin/magnificgallery/galleries'),
                'description' => 'mohsin.magnificgallery::lang.plugin.description',
                'category'    => SettingsManager::CATEGORY_CMS,
                'icon'        => 'icon-film',
                'permissions' => ['mohsin.magnificgallery.*'],
                'order'       => 200
              ],
          ];
      }
  }

  public function registerSettings()
  {
      if(!PreferenceModel::instance()->get('show_gallery_in_nav')) {
          return [
              'galleries' => [
                'label'       => 'mohsin.magnificgallery::lang.magnific.name',
                'url'         => Backend::url('mohsin/magnificgallery/galleries'),
                'description' => 'mohsin.magnificgallery::lang.plugin.description',
                'category'    => SettingsManager::CATEGORY_CMS,
                'icon'        => 'icon-film',
                'permissions' => ['mohsin.magnificgallery.*'],
                'order'       => 200
              ],
          ];
      }
  }

  public function registerPermissions()
  {
      return [
          'mohsin.magnificgallery.manage_galleries' => [
              'label' => 'mohsin.magnificgallery::lang.permissions.manage_galleries',
              'tab'   => 'cms::lang.permissions.name'
          ],
      ];
  }

}
