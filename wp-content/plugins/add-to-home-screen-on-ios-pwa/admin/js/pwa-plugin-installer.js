jQuery(function ($) {
    $('.addtohos-install-plugin').on('click', function (event) {
        event.preventDefault();
        var $button = $(this);

        if ($button.hasClass('updating-message')) {
            return;
        }

        $button.addClass('updating-message').html(addtohos_importer_params.installing_text);

        $button.data('installing', true);

        wp.updates.installPlugin({
            slug: $button.data('slug')
        });
    });

    $(document).on('click', '.addtohos-activate-plugin', function (event) {
        event.preventDefault();
        var $button = $(this);
        $button.addClass('updating-message').html(addtohos_importer_params.activating_text);
        addtohos_activate_plugin($button);
    });

    $(document).on('wp-plugin-install-success', function (event, response) {
        event.preventDefault();

        var $button = $('.addtohos-install-plugin').filter(function () {
            return $(this).data('slug') === response.slug;
        });

        if ($button.length) {
            $button.html(addtohos_importer_params.activating_text);

            $button.removeData('installing');

            setTimeout(function () {
                addtohos_activate_plugin($button);
            }, 1000);
        }
    });

    function addtohos_activate_plugin($button) {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'addtohos_public_action',
                page: 'addtohos_backendajax',
                function: 'activate_plugin',
                slug: $button.data('slug'),
                file: $button.data('filename'),
                _wpnonce: addtohos_importer_params.wpnonce,
            },
        }).done(function (result) {
            if (result.success && addtohos_importer_params.success_redirect === '1') {
                window.location.href = addtohos_importer_params.importer_url;
            } else if (result.success) {
                $button.parent().append('<button type="button" class="button button-disabled" disabled="disabled">'+addtohos_importer_params.success_import+'</button>');
                $button.remove();
            } else {
                $button.removeClass('updating-message').html(addtohos_importer_params.error);
            }
        }); 
    }
});
