<?php

/**
 * netlifytrigger plugin for Craft CMS 4.x
 *
 * Craft Netlify Trigger adds a way for editors to trigger a rebuild of a Netlify
 * static site when using Craft as a Headless CMS.
 *
 * @copyright Copyright (c) 2023 Michael Pelletier
 */

namespace upstatement\netlifytrigger;

use upstatement\netlifytrigger\variables\NetlifyTriggerVariable;
use upstatement\netlifytrigger\models\Settings;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\events\RegisterUrlRulesEvent;
use craft\helpers\UrlHelper;
use craft\web\twig\variables\CraftVariable;
use craft\web\UrlManager;

use craft\events\RegisterCpNavItemsEvent;
use craft\web\twig\variables\Cp;


use yii\base\Event;

/**
 * Class Netlifytrigger
 *
 * @author    Michael Pelletier
 * @package   Netlifytrigger
 * @since     1.0.0
 *
 */
class NetlifyTrigger extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var NetlifyTrigger
     */
    public static NetlifyTrigger $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        $this->name = $this->getName();

        // Register CP routes
        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_CP_URL_RULES,
            [$this, 'registerCpUrlRules']
        );

        // Register variables
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (Event $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('netlifyTrigger', NetlifyTriggerVariable::class);
            }
        );

        // Plugin Install event
        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            [$this, 'afterInstallPlugin']
        );

        // Add shortcuts to the Sidebar
        Event::on(
            Cp::class,
            Cp::EVENT_REGISTER_CP_NAV_ITEMS,
            function (RegisterCpNavItemsEvent $event) {
                if ($this->getSettings()->productionWebhook) {
                    $event->navItems[] = [
                        'url' => 'netlifytrigger',
                        'label' => 'Publish Production',
                    ];
                }

                if ($this->getSettings()->stagingWebhook) {
                    $event->navItems[] = [
                        'url' => 'netlifytrigger',
                        'label' => 'Publish Staging',
                    ];
                }
            }
        );

        Craft::info(
            Craft::t(
                'netlifytrigger',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    /**
     * Returns the user-facing name of the plugin, which can override the name
     * in composer.json
     *
     * @return string
     */
    public function getName(): string
    {
        return Craft::t('netlifytrigger', 'Netlify Trigger');
    }

    public function registerCpUrlRules(RegisterUrlRulesEvent $event)
    {
        $rules = [
            'netlifytrigger/<netlifyTriggerPath:([a-zéñåA-Z0-9\-\_\/]+)?>' => ['template' => 'netlifytrigger/index'],
        ];

        $event->rules = array_merge($event->rules, $rules);
    }

    public function afterInstallPlugin(PluginEvent $event)
    {
        $isCpRequest = Craft::$app->getRequest()->isCpRequest;

        if ($event->plugin === $this && $isCpRequest) {
            Craft::$app->controller->redirect(UrlHelper::cpUrl('settings/plugins/netlifytrigger/'))->send();
        }
    }

    // Protected Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): ?string
    {
        $options = [[
            'label' => '',
            'value' => '',
        ]];
        foreach (Craft::$app->sections->getAllSections() as $section) {
            $siteSettings = Craft::$app->sections->getSectionSiteSettings($section['id']);
            $hasUrls = false;
            foreach ($siteSettings as $siteSetting) {
                if ($siteSetting->hasUrls) {
                    $hasUrls = true;
                }
            }

            if (!$hasUrls) {
                continue;
            }
            $options[] = [
                'label' => $section['name'],
                'value' => $section['id'],
            ];
        }

        // Get override settings from config file.
        $overrides = Craft::$app->getConfig()->getConfigFromFile(strtolower($this->handle));

        return Craft::$app->view->renderTemplate(
            'netlifytrigger/settings',
            [
                'settings' => $this->getSettings(),
                'overrides' => array_keys($overrides),
                'options' => $options,
                'siteTemplatesPath' => Craft::$app->getPath()->getSiteTemplatesPath(),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getSettings(): ?Model
    {
        $settings = parent::getSettings();
        $config = Craft::$app->config->getConfigFromFile('netlify-trigger');

        foreach ($settings as $settingName => $settingValue) {
            $settingValueOverride = null;
            foreach ($config as $configName => $configValue) {
                if ($configName === $settingName) {
                    $settingValueOverride = $configValue;
                }
            }
            $settings->$settingName = $settingValueOverride ?? $settingValue;
        }

        return $settings;
    }
}
