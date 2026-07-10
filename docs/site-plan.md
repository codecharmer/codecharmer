# Code Charmer — Site Plan (Shape)

Information architecture, navigation, and page-level wireframes for the full site. Planning artifact only — no code yet. Reads on top of [PRODUCT.md](../PRODUCT.md) (strategy) and [DESIGN.md](../DESIGN.md) (visual system). Every section is specified as a reusable **Gutenberg block** so the static build converts cleanly to a WordPress theme.

## Scope & confirmed decisions

- **Register/platform:** brand · web (WordPress-block-ready).
- **Navigation:** compact header with a **Services mega-menu** + persistent **Book a consultation** CTA; Contact via CTA + footer.
- **Services:** a **Services hub** + **4 dedicated pillar pages**.
- **Portfolio:** a **Work index** + **individual case-study pages**, with previews on Home.
- **Conversion:** **qualifying form** (primary) + **scheduling option** on Contact; a consultation CTA band closes every page.

## Sitemap

```
/                          Home
/services                  Services hub (overview of the 4 pillars)
  /services/ai-strategy        AI Strategy & Architecture
  /services/wordpress          WordPress Engineering
  /services/custom-software    Custom Software
  /services/ai-automation      AI Automation
/work                      Work index (case-study list)
  /work/[slug]                 Case study (Problem→Approach→Architecture→Solution→Outcome)
/process                   Process (Discovery → … → Growth)
/about                     About (engineering philosophy)
/contact                   Contact (qualifying form + scheduling)
/privacy                   Privacy (footer/legal — minimal)
```

9 primary templates: Home, Services hub, Service detail (×4, one template), Work index, Case study (template), Process, About, Contact.

## Navigation

**Header** (sticky; condenses to a slimmer bar on scroll):
`[Logo]  Services▾   Work   Process   About        [Book a consultation]`

- **Services mega-menu** (on hover/focus): the 4 pillars, each with icon + one-line descriptor, arranged as a 2×2 or 4-up panel (not a plain dropdown list). Includes a quiet footer row: "How we work → Process" and "See our work → Work". Escapes the header stacking context via `<dialog>`/popover or a portal (per DESIGN.md interaction rule).
- **Primary CTA** ("Book a consultation") is cyan-filled, dark-ink text, always visible — the conversion goal lives in the chrome.
- **Mobile:** hamburger → full-screen overlay menu; Services expands inline; CTA pinned to the bottom.

**Footer** (deep-ink band):
- Brand mark + one-line positioning ("Digital systems that create business value.").
- Columns — **Services** (4 pillars), **Company** (About, Process, Work), **Get started** (Contact, Book a consultation, email).
- Repeat CTA, contact email, GitHub/social.
- Legal row: © Code Charmer, Privacy.

## Shared block inventory (WordPress-ready)

Each becomes a Gutenberg block with editable fields, repeaters, image slots, CTA options, and background/layout variations (light | ink) — specified in detail at craft time.

| Block | Purpose | Key editable fields |
|---|---|---|
| **Header / Mega-menu** | Global nav + services panel | logo, nav items, pillar list, CTA label/href |
| **Footer** | Global footer | positioning line, link columns, socials, legal |
| **Hero** | Page opener (variants: home-dark, page-light) | eyebrow?, headline, subhead, CTAs, media/diagram slot, bg=light\|ink |
| **Value Statement** | Positioning / differentiator prose | heading, body, up-to-3 proof points |
| **Pillar Grid** | The 4 services as differentiated cards | repeater: icon, name, descriptor, href; layout variation |
| **Feature / Icon List** | Capability lists on service pages | repeater: icon, label, blurb; columns |
| **Split Content + Media** | Alternating text/visual rows | heading, body, media slot, media side (L/R) |
| **Process / Timeline** | Ordered stages | repeater: stage, what-happens, deliverable |
| **Statistics** | Outcome metrics | repeater: value, label, note |
| **Case Study Preview** | Work teaser | client/sector, problem, outcome, metric, href, thumbnail |
| **Case Study Body** | Full story | problem, approach, architecture (+diagram), solution, outcome |
| **Logo Cloud** | Social proof (when real logos exist) | repeater: logo, alt |
| **Testimonial** | Quote (when real quotes exist) | quote, attribution, role |
| **FAQ** | Objection handling | repeater: Q, A |
| **Engagement Models** | How we work / fit (in place of fixed pricing) | repeater: model, best-for, what's-included |
| **CTA Band** | Closing conversion prompt | headline, subhead, primary+secondary CTA, bg=ink |
| **Contact Form** | Qualifying lead capture | fields config, success/error states, scheduling toggle |

Ban-aware: Pillar Grid and case previews must be **differentiated** (varied size/rhythm), never identical icon+heading+text boxes; no eyebrow above every section; no `01/02/03` scaffolding except where a real sequence earns it (Process).

## Page-by-page wireframes

Rhythm convention: **[ink]** = deep-ink art-directed band, **[light]** = home-base. Alternation is intentional, not decorative.

### Home `/`
1. **[ink] Hero** — confident headline off the core message ("We build digital systems that create business value" → reworked, cliché-free), subhead, primary CTA *Book a consultation* + secondary *See our work*. Cyan "charm" underline draws under one key word; abstract cyan line-art system diagram as the hero visual (no stock).
2. **[light] Value Statement** — why not-a-commodity: systems that generate revenue, automate work, and that clients own. 3 proof points.
3. **[light] Pillar Grid** — the 4 services, differentiated cards → each links to its detail page.
4. **[ink] Why us / principles** — the core beliefs as differentiators (AI solves real problems · WordPress as an asset not a burden · clients own their platform · good architecture lowers future cost).
5. **[light] Process teaser** — condensed Discovery→Growth → links to /process.
6. **[light] Selected work** — 2–3 Case Study Previews (Problem→Outcome). The credibility engine.
7. **[light] Social proof** — Logo Cloud / Testimonial (design now, populate when real; omit gracefully until then).
8. **[ink] CTA Band** — strong consultation close.

### Services hub `/services`
1. **[light] Hero** — framing: services as *systems*, not features.
2. **[light] Pillar sections** — each pillar as a Split Content + Media row (icon, name, what it is, outcomes, link). Alternate media side for rhythm.
3. **[ink] How we work teaser** → /process.
4. **[light] Engagement Models** — how a project fits together (discovery-first, partner/retainer, fixed-scope) — replaces fixed pricing.
5. **[ink] CTA Band**.

### Service detail template `/services/[pillar]` (×4)
1. **[ink] Hero** — pillar name, the problem it solves, primary CTA.
2. **[light] Thesis** — the pillar's POV (AI: *prepare for AI, don't just bolt it on* · WP: *enterprise-grade engineering* · Custom: *software that improves operations* · Automation: *practical outcomes, not hype*).
3. **[light] What's included** — Feature/Icon List from the brief's topic lists (below).
4. **[light] Approach** — mini-process / architecture explanation, with an abstract diagram.
5. **[light] Proof** — related Case Study Preview.
6. **[light] FAQ** — pillar-specific objections (optional per pillar).
7. **[ink] CTA Band**.

Pillar content sources (from brief):
- **AI Strategy & Architecture** — AI-ready architecture, knowledge organization, data structure, internal workflows, AI integrations, automation strategy.
- **WordPress Engineering** — custom themes, Gutenberg/block dev, ACF, headless, performance, accessibility, SEO foundations, security, maintainability, editorial workflows.
- **Custom Software** — internal dashboards, business portals, CRM integrations, APIs, automation, membership systems, booking systems, custom apps.
- **AI Automation** — content workflows, internal assistants, customer support, business-process automation, integrations, retrieval systems, AI-powered search.

### Work index `/work`
1. **[light] Hero** — framed on outcomes, not screenshots.
2. **[light] Case study list** — Case Study Preview blocks; simple service filter later.
3. **[ink] CTA Band**.

### Case study template `/work/[slug]`
1. **[ink] Hero** — sector, one-line outcome, headline metric.
2. **[light] Problem** → 3. **Approach** → 4. **Architecture** (abstract cyan diagram) → 5. **Solution** → 6. **[light] Business outcome** (Statistics block).
7. **[light] Next case study** + **[ink] CTA Band**.

### Process `/process`
1. **[ink] Hero** — engineering-philosophy framing.
2. **[light] Timeline** — the 7 stages (Discovery, Architecture, Design, Development, Testing, Launch, Growth): what happens · what the client gets · why it matters. This is a *real* sequence, so numbering is earned here.
3. **[ink] Principles callout** — "good architecture reduces future cost", "simplicity over complexity".
4. **[ink] CTA Band**.

### About `/about`
1. **[light] Hero** — philosophy statement (engineering-led, not company-history).
2. **[light] Beliefs** — the core principles as narrative.
3. **[ink] How we think** — craft, ownership, long-term maintainability.
4. **[light] Team** — optional; philosophy-led, populate if/when there are people to show.
5. **[ink] CTA Band**.

### Contact `/contact`
1. **[light] Hero** — simple, professional, reassuring.
2. **[light] Qualifying form** — name, company, email, **project type** (AI strategy / WordPress / Custom software / Automation / Not sure), **budget range**, timeline, message. States: default, inline validation, submitting, success, error.
3. **[light] Prefer to talk?** — scheduling embed/link for ready-to-go prospects.
4. **[light] What happens next** — set expectations (response time, no obligation) + alt email.

## Conversion strategy

- Persistent header CTA + a closing CTA Band on every page — the consultation is never more than one scroll away.
- Case studies + Process do the *convincing*; the CTA does the *asking*. Belief before request.
- Qualifying fields (project type, budget) filter for the premium, quality-over-cost client in PRODUCT.md; scheduling captures the already-convinced.
- Secondary CTAs ("See our work") route hesitant visitors to proof, not away.

## SEO approach

Per-page specifics (H1, title tag, meta description, heading hierarchy) are written during craft. Pattern:
- One `<h1>` per page; strict h2/h3 nesting; semantic landmarks.
- Service pages target intent like "WordPress engineering / custom theme development", "AI automation for business", etc.
- Case studies target outcome/sector queries; Process/About build brand + E-E-A-T.
- Fast, accessible, semantic markup is itself the SEO foundation (and the pitch).

## Responsive & motion

- Mobile-first; mega-menu → full-screen overlay; grids collapse to `auto-fit` rows; ink bands hold contrast at every breakpoint; test headline copy for overflow per DESIGN.md.
- Motion per DESIGN.md: one orchestrated hero load + the cyan "charm" underline; restrained scroll reveals that enhance already-visible content; `prefers-reduced-motion` fallbacks mandatory.

## Recommended build sequence & references

Build order (each via `/impeccable craft <page>`), so shared blocks are established early:
1. **Home** — establishes Hero, Pillar Grid, CTA Band, Case Study Preview, Footer/Header.
2. **Services hub + one service detail** — locks the service template.
3. **Remaining 3 service pages** — reuse the template.
4. **Work index + one case study** — locks the case template.
5. **Process, About, Contact**.
6. **`/impeccable extract`** — consolidate emergent tokens/components into a formal system; **`/impeccable audit`** + **`/impeccable polish`** before ship.

Most valuable references during build: `craft.md`, `layout.md` (architectural grids), `animate.md` (hero + charm move), `typeset.md` (Bricolage display system), `harden.md` + `clarify.md` (Contact form states & copy).

## Asserted defaults (override anytime)

- **No fixed pricing** — consultative; "Engagement Models" block instead.
- **Logos/testimonials** — blocks designed now, populated when real assets exist; omitted gracefully until then.
- **Blog/Resources** — out of scope for v1; sitemap leaves room to add later.
- **Team section** — optional; philosophy-led About stands on its own.

## Open questions (genuinely unresolved)

1. **Case-study content** — real client stories, or fully fictional-but-realistic placeholders for v1? (Assumed: realistic placeholders, clearly structured.)
2. **Scheduling tool** — which one (Cal.com / Calendly / other)? Affects the embed on Contact.
3. **Domain specifics** — any existing brand assets beyond the logo (icon set, real photography of work) to fold in?
