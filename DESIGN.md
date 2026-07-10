# Design

Visual system for Code Charmer. Anchored on the logo's cyan; deep-ink neutrals tinted toward that hue (never warm/cream). Register: **brand**. Direction: technical-elegant, pushed **bolder** than the default clean-SaaS look — its own identity, not a Linear/Stripe clone.

## Theme & Direction

**Scene:** a skeptical founder, mid-morning at their desk, comparing three agencies — they need to feel in five seconds that these engineers are the real thing: precise, calm, worth the premium.

That scene drives a **dual-surface system**, which is the core differentiator:

- **Light is home base** — off-white, deep-ink text, generous whitespace. Clarity and legibility (matches the brief's "generous whitespace, sophisticated typography"). This is where most content lives.
- **Deep-ink bands are art direction** — the hero and a few pivotal moments (a key statement, the process, the closing CTA) drop to near-black, where the **cyan glows**. Gravitas + signature color.

All-dark would be the Vercel/Linear reflex; all-light would be Stripe. Alternating with intent is neither — that's the "push bolder, own identity" call in [PRODUCT.md](PRODUCT.md).

## Color

OKLCH throughout. Cyan is a **committed single accent** (restrained strategy, but the accent is loud where it lands). Neutrals carry a faint cyan tint (chroma ~0.01–0.02 toward hue 220) so nothing reads as flat gray or warm cream.

**Cyan behaves by surface** — this is the one rule that keeps it accessible:
- On **dark** surfaces, bright cyan (`--brand`) is the accent/glow — it pops and passes contrast.
- On **light** surfaces, cyan appears as **fills, borders, and underlines** (with dark-ink text on cyan fills). Cyan *text* on light must darken to `--brand-ink` (≥4.5:1) or always carry an underline. Never bright-cyan body text on white.

```css
:root {
  /* Light surfaces (home base) */
  --bg:            oklch(0.980 0.004 214);  /* off-white, faint cool tint (NOT cream) */
  --surface:       oklch(0.997 0.002 214);  /* cards / raised */
  --surface-sunk:  oklch(0.955 0.006 214);  /* insets, code wells */
  --border:        oklch(0.905 0.008 214);  /* hairlines */
  --border-strong: oklch(0.845 0.010 214);

  /* Ink (text on light) */
  --ink:        oklch(0.225 0.020 232);  /* primary — ~15:1 on --bg */
  --ink-muted:  oklch(0.450 0.018 232);  /* secondary — ~5:1 on --bg */
  --ink-faint:  oklch(0.560 0.014 232);  /* labels/meta — large/careful use only */

  /* Deep-ink surfaces (art-directed bands) */
  --ink-bg:     oklch(0.190 0.025 236);  /* near-black, blue-black */
  --ink-bg-2:   oklch(0.245 0.026 236);  /* raised on dark */
  --on-ink:     oklch(0.965 0.005 214);  /* primary text on dark */
  --on-ink-mut: oklch(0.720 0.015 216);  /* muted text on dark */

  /* Brand cyan */
  --brand:       oklch(0.790 0.120 202);  /* signature cyan (logo) — accent on dark, fills */
  --brand-glow:  oklch(0.830 0.130 200);  /* brighter, for glow/hover on dark */
  --brand-ink:   oklch(0.480 0.100 216);  /* cyan-as-text on light (≥4.5:1) */
  --on-brand:    oklch(0.200 0.020 236);  /* dark ink placed on a cyan fill */
}
```

- **Gradients:** permitted but subtle (brief) — a faint cyan-glow radial behind the hero mark, or a `--ink-bg → --ink-bg-2` wash. **No gradient text** (banned). No loud multi-hue gradients.
- **Focus rings:** `--brand` at 2px offset on light, `--brand-glow` on dark. Always visible.

## Typography

**Display — Bricolage Grotesque** (variable): hero, section headings. Characterful, confident, a little editorial edge — the identity face.
**Body/UI — Hanken Grotesk** (variable): paragraphs, nav, UI. Clean, neutral, highly legible — deliberately calmer than the display so the pairing contrasts on the *character* axis, not two lookalike sans.
**Mono — Geist Mono** (or Commit Mono): code snippets, real technical labels, metrics, terminal touches. **Legit here because they ship code — but deliberate, never decorative.** Not an eyebrow above every section.

Self-host all three as woff2 (performance is part of the pitch; also future-proofs the WordPress theme).

```css
:root {
  --font-display: "Bricolage Grotesque", system-ui, sans-serif;
  --font-body:    "Hanken Grotesk", system-ui, sans-serif;
  --font-mono:    "Geist Mono", ui-monospace, monospace;

  /* Fluid scale — ratio ≥1.25, display capped ≤6rem */
  --t-display: clamp(2.5rem, 1.2rem + 5.5vw, 5.25rem);   /* hero */
  --t-h1:      clamp(2.1rem, 1.3rem + 3.4vw, 3.5rem);
  --t-h2:      clamp(1.6rem, 1.1rem + 2.2vw, 2.5rem);
  --t-h3:      clamp(1.3rem, 1.05rem + 1.1vw, 1.65rem);
  --t-body-lg: 1.1875rem;   /* 19px lead paragraphs */
  --t-body:    1rem;        /* 16px, line-height 1.6 */
  --t-small:   0.8125rem;   /* mono labels, tracked +0.06em */
}
```

- Display letter-spacing `-0.02em` (floor −0.04em — never tighter). `text-wrap: balance` on h1–h3; `text-wrap: pretty` on prose.
- Body line-height 1.6; **prose max 68ch**. Light-on-dark bands: add +0.05 line-height.
- Weights: Bricolage 600–800 for display; Hanken 400 body / 500 UI / 600 emphasis. Avoid all-caps body (labels only).

## Spacing & Layout

4px base grid. Fluid section rhythm — vary it (tight groupings, generous separations), don't apply one uniform gap everywhere.

```css
:root {
  --sp-1: 0.25rem; --sp-2: 0.5rem;  --sp-3: 0.75rem; --sp-4: 1rem;
  --sp-6: 1.5rem;  --sp-8: 2rem;    --sp-12: 3rem;   --sp-16: 4rem;
  --sp-24: 6rem;   --sp-32: 8rem;
  --section-y: clamp(4rem, 2rem + 9vw, 9rem);  /* vertical section padding */
  --gutter:    clamp(1.25rem, 5vw, 3rem);      /* page side padding */
  --maxw:      75rem;   /* 1200px content container */
  --maxw-prose: 68ch;
}
```

- **Grid:** 12-column, architectural/structured — a visible blueprint rhythm is on-brand. Asymmetric compositions allowed for emphasis. Responsive card rows: `repeat(auto-fit, minmax(280px, 1fr))`.
- Flexbox for 1D, Grid for 2D. Semantic z-index scale (dropdown → sticky → backdrop → modal → toast → tooltip); never `9999`.

## Depth & Radius

"Soft depth" per brief — but **no glassmorphism as default** (banned), no nested cards.

```css
:root {
  --radius-sm: 0.5rem; --radius: 0.75rem; --radius-lg: 1.25rem; --radius-pill: 999px;
  --shadow-sm: 0 1px 2px oklch(0.20 0.02 236 / 0.06);
  --shadow:    0 4px 16px -4px oklch(0.20 0.02 236 / 0.10), 0 1px 3px oklch(0.20 0.02 236 / 0.06);
  --shadow-lg: 0 24px 48px -12px oklch(0.20 0.02 236 / 0.16);
}
```

- On light: hairline border + soft ambient shadow. On dark: elevation via `--ink-bg-2` + a faint cyan inner glow on key elements only.
- Radii precise, moderate — not pill-rounded everywhere (avoids the template look).

## Motion

Elegant and restrained; motion is designed in, not sprinkled on. **One orchestrated page-load beats fade-on-scroll-every-section.**

- Easing: ease-out-expo / quart. No bounce, no elastic. UI 180–320ms; hero reveals up to ~700ms.
- **Signature move — "the charm":** a cyan underline/spark draws beneath one key hero word, and the brand mark carries a subtle cyan glow on entrance/hover. Ties to the charmer concept without literal wands or sparkle spam.
- Reveals **enhance an already-visible default** — never gate content visibility on a scroll class (ships blank in headless/hidden-tab renders).
- Stagger *within* one list is fine; the uniform whole-section reflex is the tell.
- Library: **Motion** (or GSAP) for orchestration; optional **Lenis** for restrained smooth-scroll.
- **`prefers-reduced-motion: reduce` is mandatory** — every animation gets a crossfade/instant fallback.

## Iconography & Imagery

- **Icons:** consistent line set, 1.5px stroke, geometric (Lucide or Phosphor line). The `{ }` brace and a subtle wand/spark are recurring brand devices — used sparingly, never decoration on every heading.
- **Imagery = abstract & engineered, not stock** (brief bans generic smiling people). Modern illustration, abstract geometric graphics, architectural/blueprint motifs, node & data-flow diagrams, code-block vignettes, isometric-lite system diagrams. Cyan line-art glowing on deep ink is the house style. **No colored-`<div>` placeholders where a real graphic belongs.**

## Component Inventory → WordPress blocks

Every section is built as a reusable, editable Gutenberg block from day one (see PRODUCT.md's architectural constraint). Master inventory — each gets full field/variation specs at build time:

Hero · Feature Grid · Logo Cloud · Statistics · Testimonials · Process/Timeline · Case Study Preview · Pricing · FAQ · CTA band · Cards · Content Blocks · Icon Lists · Team · Forms · Navigation · Footer.

Design principle: **think in blocks with editable fields, repeaters, image slots, CTA options, and background/layout variations — not static pages.**

## Non-negotiables (from the register + general rules)

Bans that override any local temptation: side-stripe borders · gradient text · default glassmorphism · the hero-metric SaaS template · identical card grids · tiny uppercase tracked eyebrow above *every* section · numbered `01/02/03` markers as default scaffolding · text that overflows its container at any breakpoint · warm cream/sand body backgrounds · stock smiling-people photography.
