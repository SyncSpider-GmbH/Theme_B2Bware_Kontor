@extends('layouts.shop')

{{-- Kontor home page (/{locale}/home). To use it, set the store's landing
     page to /home in the store settings.

     The page itself stays neutral: the hero and both content regions are
     filled by the shop owner in the Theme Editor, and the category tiles come
     from the store's own catalog. Nothing here is store-specific. --}}

@section('title', $store['name'])

{{-- Owner-editable, full-width hero, rendered above the content. Renders
     nothing until a banner is assigned to the 'hero' slot. --}}
@section('hero')
    @storefrontSlot('hero')
@endsection

{{-- No breadcrumb trail on the landing page. --}}
@section('breadcrumbs')
@endsection

@section('content')
    <div class="page page--home flex flex-col gap-6">
        {{-- Owner-editable content region (top of page). --}}
        @storefrontSlot('content-top')

        @if(($rootCategories ?? collect())->isNotEmpty())
            <section class="flex flex-col gap-4" aria-label="@t('Categories')">
                <div class="kontor-home__head">
                    <h2 class="font-primary text-2xl font-semibold text-headings m-0">@t('Categories')</h2>
                    <a href="@routeUrl('store.categories')" class="font-medium text-primary">@t('View all')</a>
                </div>
                <ul class="kontor-home__tiles">
                    @foreach(($rootCategories ?? collect())->take(12) as $category)
                        <li>
                            <a
                                href="@routeUrl('store.category', ['slug' => data_get($category, 'seo.slug') ?: data_get($category, 'slug', '')])"
                                class="category-card flex h-full flex-col overflow-hidden rounded-xl border border-border-subtle bg-surface-card transition-colors hover:border-primary hover:no-underline"
                            >
                                <span class="category-card__image flex w-full items-center justify-center overflow-hidden bg-surface">
                                    @if(data_get($category, 'resolved_main_media.media_url') ?? data_get($category, 'media.0.media_url') ?? data_get($category, 'seo.image.public_url') ?? data_get($category, 'seo.seo_image.public_url'))
                                        <img
                                            src="@storefrontImage(data_get($category, 'resolved_main_media.media_url') ?? data_get($category, 'media.0.media_url') ?? data_get($category, 'seo.image.public_url') ?? data_get($category, 'seo.seo_image.public_url'), 320, 320, 85)"
                                            alt="{{ data_get($category, 'name', '') }}"
                                            class="h-full w-full object-contain"
                                            loading="lazy"
                                        >
                                    @else
                                        @include('partials.__image-placeholder', ['size' => 'h-12 w-12'])
                                    @endif
                                </span>
                                <span class="category-card__name block px-3 py-4 text-center font-medium text-headings break-words">{{ data_get($category, 'name', '') }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        @endif

        <div>
            <a href="@routeUrl('store.products')" class="inline-flex items-center justify-center rounded bg-primary px-4 py-2 font-medium text-primary-content transition-colors hover:bg-primary-600 hover:no-underline">@t('All products')</a>
        </div>

        {{-- Owner-editable content region (bottom of page). --}}
        @storefrontSlot('content-bottom')
    </div>
@endsection
