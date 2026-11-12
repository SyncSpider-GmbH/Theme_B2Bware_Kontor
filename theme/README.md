# Kontor

## Purpose

Kontor is a free, classic online-shop look for any B2Bware store. It gives the store a familiar
shop header with a large search and a coloured category bar, and it takes its colours, fonts and
logo from your own store settings.

## What this theme changes

- Header: larger logo area, a wide search field with a search button, and a highlighted cart link.
- Top bar: adds a "Quick Order" shortcut for signed-in customers, only when Quick Order is switched
  on for the store.
- Category bar: a full-width bar in your primary colour with "Categories", your top-level
  categories and "All products". The store setting "Category UI type" still decides whether
  "Categories" opens the mega menu or links to the category overview.
- Home page: an optional landing page at `/home` with a hero area and two content areas you fill
  in the Theme Editor, plus tiles for your top-level categories. Set the store landing page to
  `/home` to use it.
- Product tiles: a quantity selector sits next to "Add to cart", and the stock level is shown
  when the store tracks stock. Minimum quantities and order multiples are respected.
- Product and category tiles: images are shown in full on a 4:3 tile instead of being cropped,
  and buttons are slightly taller.
- Page width: content is 1360 px wide on large screens.
- Colours and fonts: green and navy with the fonts Space Grotesk and Poppins are only the
  starting look. As soon as you set colours or fonts in Store setup, Appearance, your settings
  are used everywhere. Light and dark mode both keep working.

## Scripts and libraries

- Google Fonts (Space Grotesk and Poppins) for the starting look. They are loaded from Google
  servers; choose your own fonts in Store setup, Appearance to replace them.
- No other scripts or libraries. The header keeps the small built-in scripts of the default theme
  for the light/dark switch, the live search and the category search in the mega menu.

## Still on the default theme

- Product list layout and filters, product page, category pages.
- Cart, checkout, order confirmation and proposals.
- Account area, favorites, Quick Order and catalog export.
- Sign-in, registration and password pages.
- Footer, error pages and all other pages and sections.

## For developers

Kontor is an override theme: it ships `assets/css/storefront.css`, `partials/header.blade.php`,
`partials/nav.blade.php`, `components/product-card.blade.php` and `pages/home.blade.php`. Every other file comes from the platform
default theme and keeps receiving its updates.

One rule keeps the store settings in control. In `assets/css/storefront.css`, every colour, font
and radius default sits inside `@layer theme-defaults`, and every layout rule reads the tokens
through `var(--color-*)`. Do not declare `--brand-*` tokens or fonts in a plain `:root` and do
not hard-code colours on selectors; either would switch the Appearance settings off.

`components/product-card.blade.php` is a copy of the default card with two additions in the grid
layout (stock line, quantity selector). When the default theme updates its product card, compare
the two files and carry the changes over.

The authoring guide is in [`docs/`](docs/); start at [`docs/README.md`](docs/README.md).
Current version online: https://b2bware.documentationai.com/advanced/storefront-themes
