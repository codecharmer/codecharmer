# Code Charmer copy addendum

Repo-specific map for rewriting codecharmer.io copy. Read fully before editing any string.

## Voice constraints (from PRODUCT.md)

- **Calm confidence.** Short paragraphs. Strong headlines. Minimal fluff. Technical without becoming inaccessible.
- **Demonstrate expertise; never claim it.** Proof over promises, no claims without proof. The site must radiate "these people know exactly what they're doing" without saying it.
- **Audience:** decision-makers in evaluation mode, comparing partners, quality-over-cost. Their unspoken question: *"do these people actually know what they're doing?"*
- **Conversion goal:** a consultation request. Every page ultimately funnels there.
- **Positioning:** premium digital engineering studio, explicitly *not* a commodity web agency. Four pillars: AI Strategy & Architecture, WordPress Engineering, Custom Software, AI Automation.
- **PRODUCT.md's own banned list:** cutting-edge, revolutionary, next-generation, best-in-class, game-changing, and their kin (on top of the skill's general banned register).
- AI is a real service line here; mentioning AI in service/product copy is legitimate.
- **No em dashes anywhere in copy** (see SKILL.md banned register). The pre-2026 house style used them heavily; strip them from every string you touch. Curly apostrophes stay.

## Copy map: three tiers, three propagation paths

All plugin paths are under `wp-content/plugins/codecharmer-core/`.

### Tier 1: brand layer (`data/`), propagates ONLY via re-seed
`wp codecharmer install` (locally: `npm run env:install-content`). A production push alone does **not** propagate; seeding is guarded by a `.wp-content-seeded` marker on the VPS.

- `data/pages.php`: all page content as block-grammar heredocs. Shared fragments (`$cc_process_stages`, `$cc_flagship_band`, `$cc_beliefs_items`), the `$cc_services` array (descriptor/thesis/problem/cta/included/approach/faq per pillar), the `$cc_service_page()` closure, and hand-written bodies for home, services, work, process, about, contact, privacy, work/praxis, work/gramo. Each page's `excerpt` key becomes its `<meta name="description">` via `src/Seo/MetaTags.php`.
- `data/projects.php`: 5 project cards (`descriptor`, `tags`). **`name` keys are frozen.** Matching is `sanitize_title(name)`; a rename creates a duplicate post and orphans the image.
- `data/settings.php`: tagline, global CTA label, response-time phrase. **Trap:** `Installer.php` merges with stored options and *stored wins* on an already-seeded site. Changes here need the `codecharmer_settings` option deleted (or an admin edit) to land.

### Tier 2: block.json attribute defaults, propagate via `npm run build` + deploy
`build/` is gitignored and compiled in CI. **Edit only the source `src/blocks/*/block.json`.**

- `hero/block.json` holds the **entire homepage hero** (`kicker`, `titleBefore` + `charm`, `sub`, `primaryLabel`, `secondaryLabel`, `trust`); the home page invokes `<!-- wp:codecharmer/hero /-->` bare.
- Also bare-invoked with defaults: `value-statement` (lead), `services-grid`, `process-teaser`, `projects`, `proof` (on all four service pages), `partners`, `cta-band`, `beliefs`, `engagement-models`, `approach`, `faq`, plus eyebrow strings in `feature-list` / `stack` / `changelog` / `demo-access` / `flagship`.

### Tier 3: chrome & system strings, propagate by file deploy alone
- `src/blocks/contact-form/render.php`: the full contact form.
- `src/blocks/site-header/render.php`, `src/blocks/site-footer/render.php`: nav/footer labels.
- `src/Rest/InquiryController.php`: server-side validation errors, inquiry email subject.
- `wp-content/themes/codecharmer/assets/js/site.js`: client-side duplicates of the form strings.
- `wp-content/themes/codecharmer/templates/404.html`: 404 copy.
- `src/Render/Partials.php`: "Read the case study", "Visit the %s website", screenshot alt pattern.
- `src/Setup/Options.php`: runtime fallbacks mirroring `settings.php`.

## Duplicate-string registry (edit as one unit, grep-verify after)

- **Contact form strings, three locations:** `contact-form/render.php` (no-JS render), `assets/js/site.js` (client validation + mailto fallback), `InquiryController.php` (server errors + email subject). Example: "That email doesn't look right." exists in both site.js and InquiryController.php. Never rewrite one location alone.
- **Global CTA label, four locations:** `data/settings.php`, the `$cc_service_page()` closure in `data/pages.php`, `src/blocks/hero/block.json`, `src/Setup/Options.php`.
- **Settings strings** (tagline, response time): `data/settings.php` + `src/Setup/Options.php` fallbacks. The tagline also appears hardcoded in the `site-footer/render.php` legal line.

## Do-not-touch list

- Seed slugs / array keys (`home`, `services/ai-strategy`, `work/praxis`, …): they drive URLs and the `codecharmer_pages` ID map.
- Project `name` keys in `projects.php` (see above), attribute keys, post-meta keys (`cc_*`), block names.
- Deliberate lowercase mono register: `demo-access` `<dt>` labels (`url` / `email` / `password`), system-diagram node labels (`api`, `core`, `portal`, …), Praxis board labels (`~90 ms`, `draft`, `review`, …), `rail.css` pseudo-content (`'✓ done'`, `'· queued'`, `'▸ running'`).
- Factual data dressed as copy: stack items, changelog versions/dates, demo credentials, partner/collaborator lists, URLs, metrics.
- The two long SVG `aria-label` paragraphs in `src/Render/Partials.php`: they describe the diagrams; rewrite only if the graphic changes.
- Admin-only strings (block titles/descriptions in `block.json`, CPT labels, theme.json preset names) are out of scope for marketing passes.

## Technical hazards

- **Heredoc modes in `pages.php`:** home / services / work / process / about bodies are interpolating `<<<BLOCKS`, where `{$cc_*}` fragments expand and a stray `$` or `{$` **breaks the file**. contact / privacy / work-praxis / work-gramo are nowdoc `<<<'BLOCKS'`, where `$` is safe and `{$…}` would render literally.
- **Block-comment JSON:** attributes are hand-written JSON inside `<!-- wp:… {…} /-->`. Curly apostrophes (`’`) are house style and JSON-safe; an unescaped straight `"` inside a value **silently breaks the block**. After editing, machine-validate every touched comment (`json_decode` the `{…}` payload).
- **Escaping map:** markup (`<em>` etc.) survives only in `hero.sub`, `cta-band.body`, `value-statement.lead` (`wp_kses_post`). Headings, eyebrows, and proof fields render through `esc_html`; markup there ships as literal visible text.
- **`hero.titleBefore` + `hero.charm`:** a deliberate two-part split; `charm` receives the fixed-width animated SVG underline. The split must survive and `charm` must stay short.
- **Flagship `tagline`** renders inline after the product name inside the `<h2>` with a space joint; it needs a leading separator that tolerates a preceding space (the mono middot `·` is the house choice, never an em dash).

## Length bounds (from DESIGN.md)

- Prose line length ≤ 68ch; display headings capped (~5.25–6rem clamp max).
- Hard ban on text overflowing its container at any breakpoint. Check rewritten headlines at ~375px and ~768px; when in doubt, prefer the shorter variant.

## Verification checklist

1. `php -l` on every edited `data/*.php`; `json_decode` every edited block-comment payload.
2. `jq .` (or `python3 -m json.tool`) on every edited `block.json`; `npm run build` must pass.
3. Parity grep for every duplicated string: exact expected occurrence count per file.
4. `composer run lint` (exit 0), `npm run lint`.
5. Local render: `npm run env:start`, then `npm run build`, delete the `codecharmer_settings` option if settings changed, then `npm run env:install-content`. Browse every page, submit the form invalid and valid, view-source the meta descriptions.
6. `git diff` review: only string *values* changed. No keys, slugs, URLs, dates, credentials.
7. Em-dash sweep: `grep -n '—'` over every copy file in scope; user-facing strings must come back clean (code comments and non-copy data may keep theirs).
8. Handoff note: production needs a manual re-seed after deploy (marker guard), and re-seeding overwrites admin-made Gutenberg edits; confirm none exist first.
