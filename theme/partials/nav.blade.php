{{-- Kontor category bar. A full-width bar in the store's primary colour:
     the "Categories" entry on the left, then the top-level categories.

     The left entry follows $store['category_ui_type'] exactly like the default
     theme, so the store setting keeps deciding the behaviour:
       list (default): a link to the categories index.
       mega_menu:      a disclosure of the depth window in $megaMenuCategories.
     Colours come from the tokens (see .kontor-nav in assets/css/storefront.css). --}}
<nav class="storefront-nav kontor-nav" aria-label="@t('Categories')" data-category-ui-type="{{ ($store['category_ui_type'] ?? 'list') === 'mega_menu' ? 'mega_menu' : 'list' }}">
    <div class="storefront-nav__bar kontor-nav__bar mx-auto w-full max-w-desktop px-4">
        @if(($store['category_ui_type'] ?? 'list') === 'mega_menu')
            <details class="storefront-nav__mega kontor-nav__mega" data-storefront-dropdown="categories">
                <summary class="kontor-nav__all">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" aria-hidden="true">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                    <span>@t('Categories')</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="kontor-nav__chevron h-4 w-4" aria-hidden="true">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </summary>
                <div class="storefront-nav__panel kontor-nav__panel absolute inset-x-0 top-full z-20 mt-1 max-h-96 overflow-auto rounded border border-border-subtle bg-surface-card p-4 shadow" data-mega-menu>
                    @if($megaMenuCategories->isEmpty())
                        <p class="m-0 text-sm text-body">@t('No categories')</p>
                    @else
                        <input type="search" data-mega-menu-search autocomplete="off"
                            placeholder="@t('Search categories')"
                            aria-label="@t('Search categories')"
                            class="mb-4 w-full rounded border border-surface-input-stroke bg-surface-input px-3 py-2 text-body outline-none focus:border-primary">
                        <div class="columns-1 gap-6 lg:columns-3">
                            @foreach($megaMenuCategories as $category)
                                <div class="mb-3 break-inside-avoid" data-mega-menu-group>
                                    @if(data_get($category, 'menu_path'))
                                        <a href="@routeUrl('store.category', ['slug' => data_get($category, 'menu_path')])"
                                            data-mega-menu-item
                                            data-mega-menu-name="{{ mb_strtolower((string) $category->name) }}"
                                            class="mb-1 block rounded px-2 py-1 font-semibold text-headings hover:bg-surface-hover hover:no-underline">{{ $category->name }}</a>
                                    @endif
                                    @foreach($category->children as $child)
                                        @if(data_get($child, 'menu_path'))
                                            <a href="@routeUrl('store.category', ['slug' => data_get($child, 'menu_path')])"
                                                data-mega-menu-item
                                                data-mega-menu-name="{{ mb_strtolower((string) $child->name) }}"
                                                class="ml-3 block rounded px-2 py-1 text-sm text-body hover:bg-surface-hover hover:no-underline">{{ $child->name }}</a>
                                        @endif
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                        <p hidden data-mega-menu-no-matches class="m-0 text-sm text-body">@t('No categories')</p>
                    @endif
                </div>
            </details>
        @else
            <a href="@routeUrl('store.categories')" class="kontor-nav__all">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5" aria-hidden="true">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
                <span>@t('Categories')</span>
            </a>
        @endif

        {{-- Top-level categories from the store's own catalog. Scrolls sideways
             on narrow screens instead of wrapping. --}}
        <div class="kontor-nav__links">
            @foreach(($rootCategories ?? collect())->take(8) as $category)
                <a href="@routeUrl('store.category', ['slug' => data_get($category, 'seo.slug') ?: data_get($category, 'slug', '')])" class="kontor-nav__link">{{ $category->name }}</a>
            @endforeach
            <a href="@routeUrl('store.products')" class="kontor-nav__link kontor-nav__link--end">@t('All products')</a>
        </div>
    </div>
</nav>

@if(($store['category_ui_type'] ?? 'list') === 'mega_menu')
    <script type="module">
        for (const panel of document.querySelectorAll('[data-mega-menu]')) {
            const input = panel.querySelector('[data-mega-menu-search]');
            const empty = panel.querySelector('[data-mega-menu-no-matches]');
            if (!(input instanceof HTMLInputElement)) {
                continue;
            }

            const apply = () => {
                const query = input.value.trim().toLowerCase();
                let visible = 0;

                for (const group of panel.querySelectorAll('[data-mega-menu-group]')) {
                    let groupVisible = 0;
                    for (const item of group.querySelectorAll('[data-mega-menu-item]')) {
                        const name = item.getAttribute('data-mega-menu-name') || '';
                        const show = query === '' || name.includes(query);
                        item.hidden = !show;
                        if (show) {
                            groupVisible += 1;
                        }
                    }
                    group.hidden = groupVisible === 0;
                    visible += groupVisible;
                }

                if (empty) {
                    empty.hidden = visible !== 0;
                }
            };

            input.addEventListener('input', apply);
        }
    </script>
@endif
