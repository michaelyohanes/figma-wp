jQuery(function ($) {
    $('.direcade-install-activate-plugin').on('click', function (event) {
        event.preventDefault();
        var $button = $(this);
        var success = true;
    
        var slugString = $button.data('slug');  
        var pluginsRequired = typeof slugString === "string" ? slugString.split(',') : [];
        const { __ } = wp.i18n; 
        
        if ($button.hasClass('direcade_btn_load_indicator')) {
            return;
        }
        $button.html(direcade_importer_params.activating_text).addClass('direcade_btn_load_indicator');

        // step 1 — get all installed plugins
        wp.apiFetch({ path: '/wp/v2/plugins' }).then(plugins => {
    
            let chain = Promise.resolve();
           
            pluginsRequired.forEach(slug => {
    
                chain = chain.then(() => {
                    console.log('Processing:', slug);
    
                    const pluginObj = plugins.find(p => p.plugin === slug + '/' + slug);
    
                    if (pluginObj) {
                        console.log('FOUND plugin:', pluginObj.plugin);
    
                        if (pluginObj.status !== 'active') {
                            return ActivateViaRest(pluginObj.plugin).then(() => {
                                console.log(`Activated: ${pluginObj.plugin}`);
                                $('.data-plugin-status[data-plugin="'+slug+'"]').html( `<span class="label label-success">${__('Activated', 'wpdirectorykit')}</span>`)
                            });
                        } else {
                            console.log('Already active');
                            return Promise.resolve();
                        }
    
                    } else {
                        return installViaRest(slug).then(() => {
                            console.log(`Installed + activated: ${slug}`);
                            $('.data-plugin-status[data-plugin="'+slug+'"]').html( `<span class="label label-success">${__('Activated', 'directorykit-car-dealer-addon')}</span>`)
                        });
                    }
                });
    
            });
    
            //  end
            chain.then(() => {
                console.log('All plugins done');
                if (success && direcade_importer_params.success_redirect == '1') {
                    setInterval(() => {
                        window.location.href = direcade_importer_params.importer_url;
                    }, 10000);
                } else if (success) {
                    $button.parent().append('<a href="'+direcade_importer_params.importer_url+'" class="button button-primary">'+direcade_importer_params.importer_page+'</a>')
                    $button.remove();
                } else {
                    $button.removeClass('direcade_btn_load_indicator').html(direcade_importer_params.error);
                }
            });
    
        });
    });
    
    function installViaRest(slug) {
        const { __ } = wp.i18n; 
        
        return wp.apiFetch({
            path: '/wp/v2/plugins',
            method: 'POST',
            data: { slug: slug }
        })
        .then(plugin => {
            $('.data-plugin-status[data-plugin="'+slug+'"]').html( `<span class="label label-success">${__('Installed', 'directorykit-car-dealer-addon')}</span>`)
            return ActivateViaRest(plugin.plugin);
        })
        .catch(err => {
            console.error('Install REST error:', err);
        });
    }
    
    function ActivateViaRest(pluginFile, retry = false) {
        return $.post(ajaxurl, {
            action: 'direcade_activate_plugin',
            plugin: pluginFile,
            _wpnonce: direcade_importer_params.wpnonce,
        }).then(r => {

            // If return html, based on elementor redirect on install
            if (typeof r === 'string' && r.startsWith("<")) {
                console.warn('HTML detected during activation');

                if (!retry) {
                    console.log('Retrying activation for:', pluginFile);
                    return ActivateViaRest(pluginFile, true);
                }

                console.error('Second HTML response — aborting.');
                return false;
            }
            console.log('AJAX activate result:', r);
            return r;
        });
    }

});