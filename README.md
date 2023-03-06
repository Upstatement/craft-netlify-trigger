# Craft Netlify Trigger plugin for Craft CMS 4.x

Craft Netlify Trigger allows developers & content editors who are using Craft in a headless manner with a static site on Netlify, to press a button within the control panel and deploy the latest content to either a Staging or Production environment.

## Requirements

This plugin requires Craft CMS 4.0.0 or later.

## Installation

### Craft 4
To install the plugin in your Craft 4 project, follow these instructions.

1. Open your terminal and go to your Craft project:

        cd /path/to/project

2. Then tell Composer to load the plugin:

        composer require upstatement/craft-netlify-trigger

3. In the Control Panel, go to Settings → Plugins and click the “Install” button for Netlify Trigger.

4. In Plugin settings, enter the webhooks you're plannng to use.

5. Click the **Netlify Trigger** link in the CP nav.

## Configuration

* All settings may be optionally configured using a [config file](http://buildwithcraft.com/docs/plugins/plugin-settings#config-file). The values, contained in [`config.php`](https://github.com/upstatement/craft-netlify-trigger/blob/main/src/config.php), are described below:

<a id="config-settings-productionWebhook"></a>
### productionWebhook (optional)
Enter the URL that we should fire a Post request to that will kick off the build process for the Production environment.

<a id="config-settings-stagingWebhook"></a>
### stagingWebhook (optional)
Enter the URL that we should fire a Post request to that will kick off the build process for the Staging environment.

## Releases
* **1.0.0** - Initital release of Craft Netlify Trigger.

## Contributing

We welcome all contributions to our projects! Filing bugs, feature requests, code changes, docs changes, or anything else you'd like to contribute are all more than welcome!

## Code of Conduct

Upstatement strives to provide a welcoming, inclusive environment for all users. To hold ourselves accountable to that mission, we have a strictly-enforced [code of conduct](CODE_OF_CONDUCT.md).

## About Upstatement

[Upstatement](https://www.upstatement.com/) is a digital transformation studio headquartered in Boston, MA that imagines and builds exceptional digital experiences. Make sure to check out our [services](https://www.upstatement.com/services/), [work](https://www.upstatement.com/work/), and [open positions](https://www.upstatement.com/jobs/)!
