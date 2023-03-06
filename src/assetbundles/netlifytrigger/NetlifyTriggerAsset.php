<?php

/**
 * netlifytrigger plugin for Craft CMS 4.x
 *
 * Craft Netlify Trigger adds a way for editors to trigger a rebuild of a Netlify
 * static site when using Craft as a Headless CMS.
 *
 * @copyright Copyright (c) 2023 Michael Pelletier
 */

namespace upstatement\netlifytrigger\assetbundles\netlifytrigger;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Michael Pelletier
 * @package   Netlifytrigger
 * @since     1.0.0
 */
class NetlifyTriggerAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@upstatement/netlifytrigger/assetbundles/netlifytrigger/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/NetlifyTrigger.js',
        ];

        $this->css = [
            'css/NetlifyTrigger.css',
        ];

        parent::init();
    }
}
