/**
 * WC module
 */

(($, Themify, doc, win, fwVars,und) => {
    'use strict';
    let isLoading = false,
            isVariationChange = false,
            v_select = doc.querySelector('form.variations_form select'),
            _clickedItems = [];
    const   wcVer=fwVars.wc_version,
            variantionURL = fwVars.wc_js['wc-add-to-cart-variation'],
            variantionImagesUrl = fwVars.wc_js.wc_additional_variation_images_script,
            order = doc.tfClass('woocommerce-ordering')[0],
            change = function () {
                this.closest('form').submit();
            },
            n_inputs = doc.querySelectorAll('input.qty[min]'),
            getVersion =src=>{
                return src.includes('ver=', 12) ? false:wcVer;
            },
            phottoSwipe = async e=> {
                if (fwVars.photoswipe) {
                    e.preventDefault();
                    e.stopImmediatePropagation();
                    const el=e.currentTarget;
                    await  Promise.all([Themify.loadCss(fwVars.photoswipe.main,null, wcVer), Themify.loadCss(fwVars.photoswipe.skin, null,wcVer)]);
                    setTimeout(() => {
                        el.click();
                    }, 5);//jquery ready has delay
                }
            },
                load = async(e, fragments, cart_hash, $button) => {
                    const jsFiles = fwVars.wc_js,
                    loadAll = e && e !== true,
                    checkLoad = k => {
                        delete jsFiles[k];
                        if (Object.keys(jsFiles).length === 0) {
                            Themify.body.off('click.tf_wc_click').off('added_to_cart removed_from_cart', addRemoveEvent);
                            if (order) {
                                order.tfOff('change', change, {passive: true, once: true});
                            }
                            setTimeout(() => {
                                if (e && e !== true && e !== 'load') {
                                    if (e.type === 'click') {
                                        for (let i = 0, len = _clickedItems.length; i < len; ++i) {
                                            if (_clickedItems[i].isConnected) {
                                                _clickedItems[i].click();
                                            }
                                        }
                                    } else {
                                        Themify.body.triggerHandler(e.type, [fragments, cart_hash, $button]);
                                    }
                                }
                                _clickedItems = null;
                                Themify.trigger('tf_wc_js_load');
                            }, 5);//jquery ready has delay
                        }
                    },
                    loadWc = async () => {
                        if (jsFiles.woocommerce) {
                            await Themify.loadJs(jsFiles.woocommerce, $.scroll_to_notices !== und, getVersion(jsFiles.woocommerce));
                        }
                        checkLoad('woocommerce');
                    },
                    loadVariantions = async () => {
                        const forms = doc.tfClass('variations_form');
                        if (forms[0] || doc.tfClass('wcpa_form_outer').length > 0) {
                            if (variantionImagesUrl) {
                                Themify.loadJs(variantionImagesUrl, $.wc_additional_variation_images_frontend !== und, getVersion(variantionImagesUrl));
                            }
                            await Themify.loadJs(Themify.includesURL + 'js/underscore.min', ('undefined' !== typeof win._), fwVars.wp);
                            await Promise.all([Themify.loadJs(Themify.includesURL + 'js/wp-util.min', (win.wp !== und && und !== win.wp.template), fwVars.wp),Themify.loadJs(variantionURL, ('undefined' !== typeof $.fn.wc_variation_form), getVersion(variantionURL))]);
                            for (let i = forms.length - 1; i > -1; --i) {
                                $(forms[i]).wc_variation_form();
                            }
                            if (v_select && isVariationChange) {
                                Themify.triggerEvent(v_select, 'change');
                            }
                            v_select = isVariationChange = null;
                        }
                    };
                    if (loadAll === true) {

                        if (jsFiles['jquery-blockui']) {
                            Themify.loadJs(jsFiles['jquery-blockui'], $.blockUI === und, getVersion(jsFiles['jquery-blockui'])).then(() => {
                                checkLoad('jquery-blockui');
                            });
                        }

                        if (jsFiles['wc-add-to-cart']) {
                            Themify.loadJs(jsFiles['wc-add-to-cart'], fwVars.wc_js_normal !== und, getVersion(jsFiles['wc-add-to-cart'])).then(() => {
                                checkLoad('wc-add-to-cart');
                                loadVariantions();
                            });
                        } else {
                            loadVariantions();
                        }

                        if (jsFiles['wc-single-product'] && !$.fn.wc_product_gallery && typeof wc_single_product_params !== 'undefined') {
                            Themify.loadJs(jsFiles['wc-single-product'], $.fn.wc_product_gallery !== und, getVersion(jsFiles['wc-single-product'])).then(() => {
                                checkLoad('wc-single-product');
                                Themify.trigger('tf_init_photoswipe');
                            });
                        } else {
                            delete jsFiles['wc-single-product'];
                        }
                    }

                    if (jsFiles['js-cookie']) {
                        await Themify.loadJs(jsFiles['js-cookie'], !!win.Cookies, getVersion(jsFiles['js-cookie']));
                        if (jsFiles['wc-cart-fragments']) {
                            await Themify.loadJs(jsFiles['wc-cart-fragments'], fwVars.wc_js_normal !== und, getVersion(jsFiles['wc-cart-fragments']));
                        }
                        checkLoad('js-cookie');
                        checkLoad('wc-cart-fragments');
                        if (loadAll === true) {
                            loadWc();
                        }
                    }
                    else {
                        loadWc();
                    }
        },
        addRemoveEvent = (e, fragments, cart_hash, $button) => {
            if (isLoading === false) {
                isLoading = true;
                load(e, fragments, cart_hash, $button);
            }
        },
        wcAccTabs = async () => {
            const accordion = doc.tfClass('tf_wc_accordion')[0];
            if (accordion) {
                await Themify.loadJs('wc-accordion-tabs');
                Themify.trigger('tf_wc_acc_tabs_init', [accordion]);
            }
        };

    Themify.body.one('added_to_cart removed_from_cart', addRemoveEvent)
    .on('click.tf_wc_click', '.ajax_add_to_cart,.remove_from_cart_button',e=> {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (!e.target.classList.contains('loading')) {
            _clickedItems.push(e.target);
            e.target.classList.add('loading');
        }
        if (isLoading === false) {
            isLoading = true;
            load(e);
        }
    });
    // Load Variation JS only on select variable
    if (v_select !== null) {
        const variationCallback = e => {
            if (!isVariationChange) {
                const ev = Themify.isTouch ? 'touchstart' : 'mousemove';
                win.tfOff('scroll '+ev, variationCallback, {once: true, passive: true});
                v_select.tfOff('change', variationCallback, {once: true, passive: true});
                if (e && e.type === 'change') {
                    e.stopImmediatePropagation();
                }
                if (isLoading === false) {
                    isLoading = isVariationChange = true;
                    load('load');
                }
            }
        };
        win.tfOn('scroll '+(Themify.isTouch ? 'touchstart' : 'mousemove'), variationCallback, {once: true, passive: true});
        v_select.tfOn('change', variationCallback, {once: true, passive: true});
        if(v_select.value){
            Themify.requestIdleCallback(variationCallback, 1500);
        }
    }

    if (order) {
        order.tfOn('change', change, {passive: true, once: true});
    }

    for (let k = n_inputs.length - 1; k > -1; --k) {
        let min = parseFloat(n_inputs[k].min);
        if (min >= 0 && parseFloat(n_inputs[k].value) < min) {
            n_inputs[k].value = min;
        }
    }
    delete fwVars.wc_js['wc-add-to-cart-variation'];
    delete fwVars.wc_js.wc_additional_variation_images_script;

    Themify.on('tf_wc_init', force => {
        if (force === true || doc.querySelector('.woocommerce-input-wrapper,.woocommerce-store-notice') !== null) {
            load('load');
        } else {
            load(true);
        }
        wcAccTabs();
        Themify.trigger('tf_init_photoswipe');
    })
    .on('tf_init_photoswipe', el => {
                if (!$.fn.wc_product_gallery || typeof wc_single_product_params === 'undefined') {
                    return;
                }
                if (!wc_single_product_params.photoswipe_enabled) {
                    Themify.off('tf_init_photoswipe');
                    return;
                }
                if (!el) {
                    el = doc;
                }
                const items = el.tfClass('woocommerce-product-gallery');
                for (let i = items.length - 1; i > -1; --i) {
                    let wrap = $(items[i]),
                        item = items[i].tfClass('woocommerce-product-gallery__trigger')[0];
                        if (!wrap.data('product_gallery')) {
                            wrap.wc_product_gallery(wc_single_product_params);
                            let fSlider = wrap.data('flexslider');
                            if (fSlider) {
                                setTimeout(()=>{
                                    fSlider.resize();
                                }, 100);
                            }
                        }
                        if (item) {
                            item.tfOn('click', phottoSwipe, {once: true});
                        }
                        let images = items[ i ].tfClass('woocommerce-product-gallery__image'),
                                flexslider_enabled = 'function' === typeof $.fn.flexslider && wc_single_product_params.flexslider_enabled && images.length > 1;

                        if (!flexslider_enabled && images.length === 1) {
                            let link = images[0].tfTag('a')[0];
                            if (link) {
                                link.tfOn('click', phottoSwipe, {once: true});
                            }
                        }

                }
            }).trigger('tf_init_photoswipe');

})(jQuery, Themify, document, window, themify_vars,undefined);
