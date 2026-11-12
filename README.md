# Theme B2Bware Kontor

**Kontor** is a free, classic commerce theme for B2Bware storefronts. It is built on top of the
B2Bware default theme and keeps every store setting in control: colours, fonts, logo, contact
details and feature switches all come from the store, not from the theme.

- Theme files: [`theme/`](theme/)
- What the theme changes, written for shop owners: [`theme/README.md`](theme/README.md)
- Authoring contract: [`theme/docs/`](theme/docs/)

## How it is built

Kontor is an **override theme**. It ships only what differs from the default theme:

| File | What it does |
| --- | --- |
| `theme/assets/css/storefront.css` | Default tokens (inside `@layer theme-defaults`) and layout rules |
| `theme/partials/header.blade.php` | Search with submit button, Quick Order shortcut |
| `theme/partials/nav.blade.php` | Category bar in the primary colour |
| `theme/components/product-card.blade.php` | Default card plus stock line and quantity selector on the grid tile. A fork: re-sync it when the default card changes |
| `theme/pages/home.blade.php` | Optional home page (`/home`) |

Everything else falls back to the platform default theme and keeps receiving its updates.

## Store settings stay in control

Rules for every change to this theme:

1. Colour, font and radius **defaults** go inside `@layer theme-defaults` in
   `storefront.css`. Never in a plain `:root`, never with `!important`.
2. Layout rules read tokens through `var(--color-*)`. No hard-coded colours on selectors.
3. Blade reads store data from `$store` (logo, name, contact, legal links) and respects every
   feature flag. No store-specific text, links or images in the theme.
4. Use only utility classes that the default theme already uses; the platform stylesheet is
   prebuilt and unknown utilities silently do nothing.

See [`theme/docs/tokens.md`](theme/docs/tokens.md) section 11.8.1 and
[`theme/docs/view-data.md`](theme/docs/view-data.md).

## Install

1. Build the zip: `./scripts/build-zip.sh` creates `dist/kontor-<version>.zip`.
2. Upload it in the store admin under **Themes** and activate it.
3. Optional: set the store landing page to `/home` to use the Kontor home page.

Built zips are not committed (`dist/*.zip` is gitignored). On GitHub, every push to `main` runs
**Build theme zip**, bumps the patch version and attaches the zip to a new release.

## Keeping docs fresh

```bash
./scripts/update-theme-docs.sh
```

Live docs: https://b2bware.documentationai.com/advanced/storefront-themes
