<script>
    $(function () {
        var CART_URL = @json(route('cart.add')),
            CSRF = @json(csrf_token()),
            busy = false;

        function toast(text, ok) {
            $('.cart-toast').remove();
            $('<div class="cart-toast">').text(text).css({
                position: 'fixed', left: '50%', bottom: 24, transform: 'translateX(-50%)',
                background: ok ? '#222' : '#b22222', color: '#fff', padding: '10px 18px',
                borderRadius: 6, zIndex: 99999, fontSize: 14
            }).appendTo('body').delay(2500).fadeOut(300, function () { $(this).remove(); });
        }

        function applyCart(r) {
            if (r.mini_cart_html) $('#miniCart, [data-mini-cart]').first().html(r.mini_cart_html);
            if (r.cart_count !== undefined) $('.cart-count, [data-cart-count]').text(r.cart_count);
        }

        function openMiniCart(msg) {
            var $t = $('[data-model=".cart-pop"]').not('.js-add-cart, .js-buy-now, .js-card-add').first();
            if ($t.length) $t.trigger('click');
            else toast(msg || 'Added to your bag.', true);
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

        // delegated, so cards from "Load More" / tab fetch / sliders all work
        $(document).on('click', '.js-card-add', function (e) {
            e.preventDefault();
            var $b = $(this);
            if (busy || $b.hasClass('is-loading')) return;

            busy = true;
            var label = $b.html();
            $b.addClass('is-loading').prop('disabled', true).text('Adding...');

            $.ajax({
                url: CART_URL, method: 'POST', dataType: 'json',
                data: { _token: CSRF, product_id: $b.data('id') }
            })
                .done(function (r) {
                    applyCart(r);
                    $(document).trigger('cart:added', [r]);
                    openMiniCart(r.message);
                })
                .fail(function (xhr) { toast(failMessage(xhr), false); })
                .always(function () {
                    busy = false;
                    $b.removeClass('is-loading').prop('disabled', false).html(label);
                });
        });

        // ── Wishlist toggle ──
        var WISH_URL = @json(route('wishlist.toggle'));

        $(document).on('click', '.wish-btn', function (e) {
            e.preventDefault();
            var $b = $(this), id = $b.data('id');
            if ($b.hasClass('is-loading')) return;

            $b.addClass('is-loading');

            $.ajax({
                url: WISH_URL, method: 'POST', dataType: 'json',
                data: { _token: CSRF, product_id: id }
            })
                .done(function (r) {
                    // same product can appear more than once on a page (sliders, tabs)
                    $('.wish-btn[data-id="' + id + '"]').each(function () {
                        $(this).toggleClass('is-active', r.added)
                            .attr({
                                'aria-pressed': r.added ? 'true' : 'false',
                                'aria-label': r.added ? 'Remove from wishlist' : 'Add to wishlist'
                            })
                            .find('i').toggleClass('fa-solid', r.added).toggleClass('fa-regular', !r.added);
                    });

                    // header badge (adjust the selector to yours)
                    $('.wishlist-count, [data-wishlist-count]').text(r.count);

                    $(document).trigger('wishlist:changed', [r]);
                    toast(r.message, true);
                })
                .fail(function (xhr) { toast(failMessage(xhr), false); })
                .always(function () { $b.removeClass('is-loading'); });
        });

    });
</script>