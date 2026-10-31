<script>
    window.PRODUCT_OPTIONS = @json($optionData);

    $(function () {
        var D = window.PRODUCT_OPTIONS,
            G = D.groups,
            TYPES = ['price', 'image', 'stock', 'sku'],
            CART_URL = @json(route('cart.add')),
            CHECKOUT_URL = @json(route('checkout')),
            CSRF = @json(csrf_token()),
            byCa = {},
            cur = { price: D.base.price, mrp: D.base.mrp, stock: D.base.stock },
            busy = false,
            redirecting = false,
            lastImgKey = D.base.images.map(function (i) { return i.full; }).join('|');

        G.forEach(function (g) {
            g.show_when = (g.show_when || []).map(Number);
            byCa[g.ca_id] = g;
        });

        function fmt(n) {
            return Math.round(n).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function groupEl(g) {
            return $('.opt-group[data-group="' + g.attribute_id + '"]');
        }

        function raw(g) {
            var v = groupEl(g).find('input:checked').val();
            return v ? parseInt(v, 10) : null;
        }

        // over = { attributeId: valueId } hypothetical selection
        function sel(g, over) {
            if (over && over[g.attribute_id] !== undefined) return over[g.attribute_id];
            return raw(g);
        }

        function visible(g, over) {
            if (!g.parent) return true;
            var p = byCa[g.parent];
            if (!p) return true;
            if (!visible(p, over)) return false;
            if (!g.show_when.length) return true;
            return g.show_when.indexOf(sel(p, over)) !== -1;
        }

        function keyFor(type, over) {
            var ids = [];
            G.forEach(function (g) {
                if (!g.dep[type] || !visible(g, over)) return;
                var v = sel(g, over);
                if (v) ids.push(v);
            });
            return ids.sort(function (a, b) { return a - b; }).join('-');
        }

        function find(type, over) {
            var k = keyFor(type, over);
            return k === '' ? null : (D.variants[type][k] || null);
        }

        function hasVariants(type) {
            return Object.keys(D.variants[type] || {}).length > 0;
        }

        // is value pe click karne par combination available rahegi?
        function valueOk(g, vId) {
            var over = {}, ok = true;
            over[g.attribute_id] = vId;

            TYPES.forEach(function (t) {
                if (!g.dep[t] || !hasVariants(t)) return;
                var v = find(t, over);
                if (t === 'stock') {
                    if (!v || !v.ok) ok = false;
                } else if (v && !v.ok) {
                    ok = false;
                }
            });
            return ok;
        }

        function refreshGroups() {
            G.forEach(function (g) {
                var $g = groupEl(g), vis = visible(g);
                $g.toggle(vis).find('input').prop('disabled', !vis);
                if (!vis) return;

                var firstOk = null;
                g.values.forEach(function (v) {
                    var ok = valueOk(g, v.id);
                    $g.find('input[value="' + v.id + '"]')
                        .prop('disabled', !ok)
                        .closest('label').toggleClass('is-disabled', !ok);
                    if (ok && firstOk === null) firstOk = v.id;
                });

                var $c = $g.find('input:checked');
                if ((!$c.length || $c.prop('disabled')) && firstOk !== null) {
                    $g.find('input[value="' + firstOk + '"]').prop('checked', true);
                }
                $g.find('.opt-value').text($g.find('input:checked').data('name') || '');
            });
        }

        function setImages(list) {
            var $main = $('.product-gallery-swiper .swiper-wrapper').empty(),
                $thumb = $('.product-thumb-swiper .swiper-wrapper').empty();

            list.forEach(function (im, i) {
                $main.append(
                    $('<div class="swiper-slide"><div class="gallery-img"></div></div>').find('.gallery-img').append(
                        $('<a>', { href: im.full, 'class': 'glightbox', 'data-gallery': 'product' }).append(
                            $('<img>', { src: im.full, alt: D.name + ' - image ' + (i + 1) })
                        )
                    ).end()
                );
                $thumb.append(
                    $('<div class="swiper-slide"></div>').append(
                        $('<img>', { src: im.thumb, alt: D.name + ' thumbnail ' + (i + 1), loading: 'lazy' })
                    )
                );
            });

            var g = window.productGallery, t = window.productThumbs;
            if (t) t.update();
            if (g) {
                g.update();
                g.slideTo(0, 0);
                if (g.pagination && g.pagination.render) { g.pagination.render(); g.pagination.update(); }
                if (g.thumbs && g.thumbs.update) g.thumbs.update(true);
            }
            if (window.productLightbox) window.productLightbox.reload();
            $('.sb-product img').attr('src', list[0].thumb);
        }

        // Add-ons + colour customization (dye) charge, per unit
        function addonsSum() {
            var add = 0;
            $('input[name="addons[]"]:checked, input[name="custom_colour"]:checked').each(function () {
                add += parseFloat($(this).data('price')) || 0;
            });
            return add;
        }

        // Big price = variant price + checked add-ons/dye (per unit).
        // Extras are not discounted, so MRP moves up by the same amount;
        // "You save" stays equal to the variant's own saving.
        function paintPrice() {
            var add = addonsSum(),
                price = cur.price + add,
                mrp = cur.mrp + add,
                off = mrp > price ? Math.round((mrp - price) / mrp * 100) : 0,
                save = cur.mrp - cur.price;

            $('#priceNow').text('₹' + fmt(price));
            $('#priceOld').text('₹' + fmt(mrp)).toggle(off > 0);
            $('#priceOff').text(off + '% OFF').toggle(off > 0);
            $('#priceSave').text(save > 0 ? ' · You save ₹' + fmt(save) : '');

            $('.sb-text strong').text('₹' + fmt(price));
            var $em = $('.sb-text em');
            if (!$em.length) $em = $('<em>').appendTo('.sb-text > span');
            $em.text(off + '% OFF').toggle(off > 0);
        }

        // ── Quantity (main + sticky bar share one value) ──
        function qtyVal() {
            return parseInt($('.qty-input').first().val(), 10) || D.minQty;
        }

        function setQty(v) {
            $('.qty-input').val(v);
        }

        function render() {
            var p = find('price'), s = find('stock'), k = find('sku'), im = find('image');

            cur.price = p ? p.price : D.base.price;
            cur.mrp = p ? p.mrp : D.base.mrp;
            paintPrice();

            var stock = s ? s.stock : D.base.stock,
                // stock-type variants exist: a combination without a row is unavailable
                inStock = hasVariants('stock') ? !!(s && s.ok) : stock > 0,
                low = inStock && stock > 0 && stock <= D.lowStock,
                $sl = $('#stockLine').toggleClass('is-out', !inStock);

            cur.stock = inStock ? stock : 0;

            $sl.find('b').text(inStock ? 'In Stock' : 'Out of Stock');
            $sl.find('em').text(low ? 'Only ' + stock + ' left' : '').toggle(low);
            $('.act-btns .btn, .sb-actions .btn')
                .toggleClass('disabled', !inStock)
                .attr('aria-disabled', !inStock);

            // stock dropped below the chosen quantity
            if (cur.stock > 0 && qtyVal() > cur.stock) setQty(Math.max(D.minQty, cur.stock));

            var sku = k && k.sku ? k.sku : D.base.sku;
            $('#infoSku').text(sku ? 'SKU: ' + sku : '').toggle(!!sku);

            var imgs = im && im.images && im.images.length ? im.images : D.base.images,
                ik = imgs.map(function (i) { return i.full; }).join('|');
            if (ik !== lastImgKey) {
                lastImgKey = ik;
                setImages(imgs);
            }
        }

        function update() {
            refreshGroups();
            refreshGroups(); // doosri pass: parent change ke baad child state settle
            render();
        }

        // Colour customization: show/hide fields, disable them when unchecked
        function toggleCustomColour() {
            var on = $('#customColour').is(':checked');
            $('#customColourFields').toggle(on)
                .find('input').prop('disabled', !on);
            $('.custom-colour-group .opt-value').text(on ? 'Selected' : 'Optional');
        }

        // ── Cart ──
        function showMsg(text, ok) {
            var $m = $('#cartMsg');
            $m.stop(true, true).text(text).css('color', ok ? '' : '#b22222').show();
            if (ok) setTimeout(function () { $m.fadeOut(); }, 4000);
        }

        function payload() {
            var data = {
                _token: CSRF,
                product_id: D.id,
                quantity: qtyVal(),
                selected_values: [],
                addon_ids: []
            };

            // hidden / unavailable groups are disabled, so they are skipped
            $('.opt-group input[name^="attr["]:checked:not(:disabled)').each(function () {
                data.selected_values.push(parseInt(this.value, 10));
            });

            TYPES.forEach(function (t) {
                var v = find(t);
                if (v && v.id) data[t + '_variant_id'] = v.id;
            });

            $('input[name="addons[]"]:checked').each(function () {
                data.addon_ids.push(parseInt(this.value, 10));
            });

            if ($('#customColour').is(':checked')) {
                var hex = $('#customColourHex').val(),
                    note = $.trim($('#customColourNote').val());
                data.custom_colour_code = (hex + (note ? ' - ' + note : '')).substring(0, 50);
            }

            return data;
        }

        // Swap mini cart + counts. Selectors are the hooks the layout needs to have.
        function applyCart(r) {
            if (r.mini_cart_html) $('#miniCart, [data-mini-cart]').first().html(r.mini_cart_html);
            if (r.cart_count !== undefined) $('.cart-count, [data-cart-count]').text(r.cart_count);
        }

        function openMiniCart(msg) {
            var $t = $('[data-model=".cart-pop"]').not('.js-add-cart, .js-buy-now').first();
            if ($t.length) {
                $('#cartMsg').hide();
                $t.trigger('click');
            } else {
                showMsg(msg || 'Added to your bag.', true);
            }
        }

        function failMessage(xhr) {
            var m = 'Could not add to bag right now. Please try again.';
            if (xhr.status === 419) m = 'Your session expired. Please refresh the page and try again.';
            else if (xhr.status === 429) m = 'Too many attempts. Please try again in a minute.';
            else if (xhr.responseJSON) {
                m = xhr.responseJSON.message || m;
                if (xhr.responseJSON.errors) m = Object.values(xhr.responseJSON.errors)[0][0];
            }
            return m;
        }

        function addToCart($btn, buyNow) {
            if (busy || $btn.hasClass('disabled')) return;

            busy = true;
            var label = $btn.html();
            $btn.addClass('is-loading').text(buyNow ? 'Please wait...' : 'Adding...');
            $('#cartMsg').hide();

            $.ajax({ url: CART_URL, method: 'POST', data: payload(), dataType: 'json' })
                .done(function (r) {
                    applyCart(r);
                    $(document).trigger('cart:added', [r]);

                    if (buyNow) {
                        redirecting = true;
                        window.location.href = CHECKOUT_URL;
                        return;
                    }
                    openMiniCart(r.message);
                })
                .fail(function (xhr) {
                    showMsg(failMessage(xhr), false);
                })
                .always(function () {
                    busy = false;
                    if (!redirecting) $btn.removeClass('is-loading').html(label);
                });
        }

        $(document).on('change', '.opt-group input[name^="attr["]', update);
        $(document).on('change', 'input[name="addons[]"]', paintPrice);
        $(document).on('change', '#customColour', function () {
            toggleCustomColour();
            paintPrice();
        });

        $(document).on('click', '.qty-plus, .qty-minus', function () {
            var v = qtyVal();
            if ($(this).hasClass('qty-plus')) {
                if (cur.stock && v + 1 > cur.stock) {
                    return showMsg('Only ' + cur.stock + ' units available.', false);
                }
                v++;
            } else {
                v = Math.max(D.minQty, v - 1);
            }
            setQty(v);
        });

        $(document).on('click', '.js-add-cart', function () { addToCart($(this), false); });
        $(document).on('click', '.js-buy-now', function () { addToCart($(this), true); });

        setQty(D.minQty);
        toggleCustomColour();
        update();
    });
</script>