<?php

/**
 * netlifytrigger plugin for Craft CMS 4.x
 *
 * Craft Netlify Trigger adds a way for editors to trigger a rebuild of a Netlify
 * static site when using Craft as a Headless CMS.
 *
 * @copyright Copyright (c) 2023 Michael Pelletier
 */

/**
 * netlifytrigger config.php
 *
 * This file exists only as a template for the netlify settings.
 * It does nothing on its own.
 *
 * Don't edit this file, instead copy it to 'craft/config' as 'netlify-trigger.php'
 * and make your changes there to override default settings.
 *
 * Once copied to 'craft/config', this file will be multi-environment aware as
 * well, so you can have different settings groups for each environment, just as
 * you do for 'general.php'
 */

return [
    'productionWebhook' => null,
    'stagingWebhook' => null,
];
