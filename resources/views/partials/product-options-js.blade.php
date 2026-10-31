<script>
    window.PRODUCT_OPTIONS = @json($optionData);

    $(function () {
        var D = window.PRODUCT_OPTIONS,
            G = D.groups,
            TYPES = ['price', 'image', 'stock', 'sku'],
            byCa = {},
            cur = { price: D.base.price, mrp: D.base.mrp },
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

        function render() {
            var p = find('price'), s = find('stock'), k = find('sku'), im = find('image');

            cur.price = p ? p.price : D.base.price;
            cur.mrp = p ? p.mrp : D.base.mrp;
            paintPrice();

            var stock = s ? s.stock : D.base.stock,
                inStock = s ? s.ok : stock > 0,
                low = inStock && stock > 0 && stock <= D.lowStock,
                $sl = $('#stockLine').toggleClass('is-out', !inStock);
            $sl.find('b').text(inStock ? 'In Stock' : 'Out of Stock');
            $sl.find('em').text(low ? 'Only ' + stock + ' left' : '').toggle(low);
            $('.act-btns .btn, .sb-actions .btn')
                .toggleClass('disabled', !inStock)
                .attr('aria-disabled', !inStock);

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

        $(document).on('change', '.opt-group input[name^="attr["]', update);
        $(document).on('change', 'input[name="addons[]"]', paintPrice);
        $(document).on('change', '#customColour', function () {
            toggleCustomColour();
            paintPrice();
        });

        toggleCustomColour();
        update();
    });
</script>