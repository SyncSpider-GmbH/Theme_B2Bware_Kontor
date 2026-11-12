# Agent instructions (any AI tool)

This is **Kontor**, a free B2Bware storefront theme built as an override of the default
theme. Only a few files exist on purpose; everything else comes from the platform default.

1. Start at [`theme/docs/README.md`](theme/docs/README.md) (load matrix).
2. Always read [`theme/docs/hard-rules.md`](theme/docs/hard-rules.md).
3. Store settings must stay in control. Token defaults go inside `@layer theme-defaults`
   in `theme/assets/css/storefront.css`; never declare `--brand-*` tokens or fonts in a plain
   `:root`, never hard-code colours on selectors, never use `!important` on tokens.
4. Read store data from `$store` and respect every feature flag. No store-specific text,
   links or images.
5. Never invent directives, form types, `$store` keys, tokens or utility classes. Use only
   utilities the default theme already uses.
6. Add a Blade file only when CSS cannot do the job; a copied file stops receiving
   default-theme updates.
7. Update `theme/README.md` and `theme/CHANGELOG.md` with every change, then build with
   `./scripts/build-zip.sh`.
