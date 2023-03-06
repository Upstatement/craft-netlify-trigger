<?php

/**
 * netlifytrigger plugin for Craft CMS 4.x
 *
 * Craft Netlify Trigger adds a way for editors to trigger a rebuild of a Netlify
 * static site when using Craft as a Headless CMS.
 *
 * @copyright Copyright (c) 2023 Michael Pelletier
 */

namespace upstatement\netlifytrigger\models;

use upstatement\netlifytrigger\NetlifyTrigger;

use Craft;
use craft\base\Model;

/**
 * @author    Michael Pelletier
 * @package   Netlifytrigger
 * @since     1.0.0
 */
class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $productionWebhook;

    /**
     * @var string
     */
    public $stagingWebhook;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['productionWebhook', 'stagingWebhook'], 'string']
        ];
    }
}
