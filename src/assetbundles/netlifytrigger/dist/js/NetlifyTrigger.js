/**
 * netlifytrigger plugin for Craft CMS
 *
 * netlifytrigger JS
 *
 * @author    Michael Pelletier
 * @copyright Copyright (c) 2023 Michael Pelletier
 * @package   Netlifytrigger
 * @since     1.0.0
 */

$('document').ready(function () {
  const $stagingButton = $('button#deploy-staging');
  const $productionButton = $('button#deploy-production');

  const $flashMessage = $('#netlify-trigger-flash-message');

  const clearFlashMessage = () => {
    $flashMessage.removeClass('success').removeClass('error');
    $flashMessage.html('');
  };

  const showSuccessMessage = () => {
    $flashMessage.addClass('success');
    $flashMessage.html('Success! The changes are being deployed now.');
  }

  const showErrorMessage = () => {
    $flashMessage.addClass('error');
    $flashMessage.html('Oh no! Something went wrong. Please try again.');
  }

  const showNoLinkMessage = () => {
    $flashMessage.addClass('error');
    $flashMessage.html('You don\'t have a webhook url set!');
  }

  $stagingButton.on('click', () => {
    clearFlashMessage();
    const stagingPath = $stagingButton.data('path');

    if (!stagingPath) {
      showNoLinkMessage();
      return;
    }

    $.post(stagingPath, {}, (data, status) => {
      if (status === 'success') {
        showSuccessMessage();
      } else {
        showErrorMessage();
      }
    });
  });

  $productionButton.on('click', () => {
    clearFlashMessage();

    const productionPath = $productionButton.data('path');
    if (!productionPath) {
      showNoLinkMessage();
      return;
    }

    const result = confirm("Are you sure you want to deploy Production? This cannot be undone.");
    if (result === true) {
      $.post(productionPath, {}, (data, status) => {
        if (status === 'success') {
          showSuccessMessage();
        } else {
          showErrorMessage();
        }
      });
    }
  });
});
