<?php

/**
 * netlifytrigger plugin for Craft CMS 4.x
 *
 * Craft Netlify Trigger adds a way for editors to trigger a rebuild of a Netlify
 * static site when using Craft as a Headless CMS.
 *
 * @copyright Copyright (c) 2023 Michael Pelletier
 */

namespace upstatement\netlifytrigger\variables;

use upstatement\netlifytrigger\NetlifyTrigger;

use Craft;
use craft\base\Model;

/**
 * @author    Michael Pelletier
 * @package   Netlifytrigger
 * @since     1.0.0
 */
class NetlifyTriggerVariable
{
    // Public Methods
    // =========================================================================

    public function getName(): string
    {
        return NetlifyTrigger::$plugin->getName();
    }

    public function getSettings(): ?Model
    {
        return NetlifyTrigger::$plugin->getSettings();
    }
}
