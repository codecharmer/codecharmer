# Performance & Accessibility Budget

Lab baseline and remediation log for the conversion-critical pages. Field data
(CrUX / Search Console) should be reviewed monthly once volume exists; until
then this lab suite is the regression gate.

## Method

- Lighthouse 12.8.2, Chrome 148 headless, default mobile emulation with
  simulated throttling, run locally against production (`https://codecharmer.io`).
- Three runs per page, median reported. Accessibility re-checks run against a
  seeded wp-env build (deterministic, environment-independent).
- Command:
  `npx lighthouse <url> --chrome-flags="--headless=new" --output=json --only-categories=performance,accessibility,best-practices,seo`

## Budget (hard gate)

| Metric | Budget | Basis |
|---|---|---|
| LCP | ≤ 2.5 s | Google "good" threshold at p75 |
| TBT (lab proxy for INP) | ≤ 200 ms | INP ≤ 200 ms at p75 |
| CLS | ≤ 0.1 | Google "good" threshold at p75 |
| Lighthouse accessibility | 100 | WCAG 2.2 AA intent |

## Baseline: August 17, 2026 (production, pre-remediation)

| Page | Perf | A11y | BP | SEO | LCP | TBT | CLS |
|---|---:|---:|---:|---:|---:|---:|---:|
| / | 98 | 94 | 100 | 100 | 2.08 s | 67 ms | 0.000 |
| /pricing/ | 99 | 100 | 100 | 100 | 1.55 s | 0 ms | 0.000 |
| /wordpress-operations-audit/ | 100 | 96 | 100 | 100 | 1.53 s | 4 ms | 0.000 |
| /work/praxis/ | 100 | 94 | 100 | 100 | 1.50 s | 11 ms | 0.000 |

Every page is inside the performance budget. All remediation was
accessibility work.

## Remediation log: August 17, 2026

1. **Button and link colors silently hijacked by WordPress global styles.**
   theme.json's `elements.link.color: inherit` emits an *unlayered* rule
   (`a:where(:not(.wp-element-button)) { color: inherit }`) that out-cascades
   every `@layer` rule in the theme. Primary buttons inside ink bands rendered
   on-ink text on the cyan fill: 1.67:1. Fix: unlayered overrides at the end of
   `global.css` restoring `.btn--primary/secondary/ghost` colors and the
   `.prose a` / `a.link` cyan-underline treatment. Buttons now measure 9.8:1.
2. **Instrumented-rail queued stages dimmed below AA.** The process teaser
   faded queued stages to `opacity: 0.42`, blending 16 px labels to 2.6:1 and
   the small mono coordinates to 1.9:1. Fix: floor raised to 0.65 (computed:
   full-strength ink text blended at 0.65 measures 5.2:1) and queued
   coordinates/status drop their accent colors to full-strength ink while
   queued.
3. **Small mono dates under AA.** `.clentry__date` and the queued rail status
   used `--ink-faint` (4.38:1 at ~11.5 px). Both moved to `--ink-muted`
   (7.3:1).
4. **Logo accessible-name mismatch.** `aria-label="Code Charmer, home"` did
   not contain the visible text "codeCharmer" (the space breaks the match).
   Label is now "codeCharmer, home".
5. **Heading-order skips.** `value-point` cards render `h3` directly after the
   page `h1`. The value-statement lead is now an `h2` (visual unchanged; the
   `.value__lead` class already carries its own type styles).

Post-fix accessibility (wp-env, deterministic): **100 on all four pages**,
zero failing audits.

## Re-check procedure

After any change to theme CSS, block styles, templates, or theme.json:

1. `npm run build`, reseed wp-env, run the Lighthouse command above against
   the four pages (accessibility locally; performance against production
   after deploy).
2. Any budget breach or accessibility score below 100 blocks the change.
3. Watch for regressions of item 1 specifically: any new theme.json
   `styles.elements` entry emits unlayered CSS and can silently defeat
   layered theme rules. Verify button/link colors after touching it.
