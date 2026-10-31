<div class="product-options">

    @foreach ($optionGroups as $g)
        <div class="opt-group" data-group="{{ $g['attribute_id'] }}">
            <div class="opt-head">
                <span>{{ $g['name'] }}:</span><b class="opt-value">{{ $g['values'][0]['name'] }}</b>
            </div>

            @if ($g['type'] === 'color_swatch')
                <div class="opt-swatches">
                    @foreach ($g['values'] as $v)
                        <label class="opt-swatch" title="{{ $v['name'] }}">
                            <input type="radio" name="attr[{{ $g['attribute_id'] }}]" value="{{ $v['id'] }}"
                                data-name="{{ $v['name'] }}" {{ $loop->first ? 'checked' : '' }} />
                            <span style="--c: {{ $v['hex'] ?: '#cccccc' }}"></span>
                        </label>
                    @endforeach
                </div>
            @else
                <div class="opt-chips">
                    @foreach ($g['values'] as $v)
                        <label class="opt-chip">
                            <input type="radio" name="attr[{{ $g['attribute_id'] }}]" value="{{ $v['id'] }}"
                                data-name="{{ $v['name'] }}" {{ $loop->first ? 'checked' : '' }} />
                            <span>{{ $v['name'] }}</span>
                        </label>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach

    @if ($product->colour_customization)
        <div class="opt-group custom-colour-group">
            <div class="opt-head">
                <span>Colour Customization:</span><b class="opt-value">Optional</b>
            </div>
            <div class="opt-addons">
                <label class="opt-check">
                    <input type="checkbox" name="custom_colour" value="1" id="customColour"
                        data-price="{{ (float) $product->dye_price }}" />
                    <span class="oc-text">
                        <b>Get it dyed in your colour</b>
                        <em>Pick your shade and we will dye it for you.</em>
                    </span>
                    <strong>
                        {{ $product->dye_price > 0 ? '+ ₹' . number_format($product->dye_price) : 'Free' }}
                    </strong>
                </label>
            </div>

            <div class="custom-colour-fields" id="customColourFields" style="display:none">
                <div class="cc-row">
                    <label for="customColourHex">Choose colour</label>
                    <input type="color" id="customColourHex" name="custom_colour_hex" value="#b3203c" disabled />
                </div>
                <div class="cc-row">
                    <label for="customColourNote">Shade name / note</label>
                    <input type="text" id="customColourNote" name="custom_colour_note" maxlength="38"
                        placeholder="e.g. Deep wine" disabled />
                </div>
                <p class="opt-note">
                    Dyed products are made to order and cannot be returned or exchanged.
                    Actual shade may vary slightly from your screen.
                </p>
            </div>
        </div>
    @endif

    @if (!empty($sizeChart))
        <div class="opt-group sizechart-group">
            <div class="opt-head">
                <span>Size Chart</span>
                <button type="button" class="size-guide" data-model=".size-pop">
                    <i class="fa-solid fa-ruler"></i> View Size Chart
                </button>
            </div>
        </div>
    @endif

    @if ($product->addons->isNotEmpty())
        <div class="opt-group">
            <div class="opt-head">
                <span>Add-ons:</span><b class="opt-value">Optional</b>
            </div>
            <div class="opt-addons">
                @foreach ($product->addons as $addon)
                    <label class="opt-check">
                        <input type="checkbox" name="addons[]" value="{{ $addon->id }}"
                            data-price="{{ (float) $addon->price }}" />
                        <span class="oc-text">
                            <b>{{ $addon->detail }}</b>
                            @if (!empty($addon->description))
                                <em>{{ $addon->description }}</em>
                            @endif
                        </span>
                        <strong>
                            {{ $addon->price > 0 ? '+ ₹' . number_format($addon->price) : 'Free' }}
                        </strong>
                    </label>
                @endforeach
            </div>
        </div>
    @endif
</div>