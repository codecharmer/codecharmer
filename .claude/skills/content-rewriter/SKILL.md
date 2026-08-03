---
name: content-rewriter
description: Use when the user wants to rewrite, sharpen, tighten, punch up, de-fluff, or otherwise edit existing website or marketing copy. Covers headlines, heroes, service pages, case studies, CTAs, meta descriptions, microcopy, form labels, error messages, and email subjects. Preserves meaning and every factual claim while raising clarity, persuasion, scannability, and rhythm. Not for writing net-new pages from scratch, and not for code or layout changes.
version: 1.1.0
user-invocable: true
argument-hint: "[target: a page, file, section, string, or 'all site copy']"
license: Apache 2.0
---

Rewrites existing copy into exceptional marketing copy without changing what it says. The objective is not longer text or a more "professional" register. It is every sentence clearer, more persuasive, easier to scan, and more emotionally engaging, with the facts exactly as they were.

## Setup

You MUST do these steps before rewriting anything:

1. If the project has a `PRODUCT.md`, read its voice/audience/banned-copy sections. If it has a `DESIGN.md`, read its typography constraints: copy length is bounded by layout (headline clamps, line-length caps, overflow bans).
2. **If working in this repository (Code Charmer / codecharmer.io), read `reference/codecharmer.md`. Non-optional.** It maps where every string lives, how each propagates to the live site, which strings are duplicated across files, and which must never be touched.
3. Read the copy you're rewriting *in situ*: the surrounding section, not the isolated string. A headline only works relative to the subhead under it.

## Prime directives

1. **Meaning is inviolable.** Never invent features, statistics, testimonials, awards, customers, years of experience, certifications, or capabilities. Never upgrade a hedge into a claim ("about 90 ms" stays approximate; "not yet shipped" stays unshipped). If the copy is weak because information is missing, improve the writing, not the facts.
2. **Rewrite ≠ replace.** Classify every string keep / tighten / rewrite before touching it. If a sentence already works, keep it; "keep" is an expected outcome, not a failure to add value. An editorial pass earns its changes.

## Banned register

Match-and-refuse. If you're about to write any of these, stop and rewrite the thought with concrete language:

- **Cliché verbs & frames:** unlock, elevate, empower, leverage, supercharge, transform your business, take X to the next level, unleash.
- **Cliché adjectives:** cutting-edge, revolutionary, next-generation, best-in-class, game-changing, world-class, state-of-the-art, robust, seamless/seamlessly, innovative, holistic, and their kin. The ban is on the register, not just these tokens.
- **AI-tell scaffolding:** "In today's digital landscape…", "In today's fast-paced world…", "Whether you're X or Y…", the reflexive triad ("It's not just X, it's Y"), rhetorical-question openers, "Look no further."
- **Em dashes.** Never use an em dash (—) in copy, in any position. Where one would join clauses, use a period, comma, colon, or parentheses instead; usually the period is the stronger choice. This is a hard ban, and it applies to existing copy being edited: strip em dashes from every string you touch.
- Anything that sounds like marketing automation software wrote it.

The test for a replacement: could a competitor paste this sentence onto their site unchanged? If yes, it says nothing. Make it specific to this business.

## Craft rules

- **Rhythm.** Mix short and long sentences. A paragraph where every sentence has the same shape reads like a list wearing a costume. Create momentum.
- **Fluff test.** Every sentence must do at least one of: communicate value, answer a question, remove doubt, encourage action. Delete anything that does none of these.
- **Specificity.** Replace vague wording with concrete detail *already present in the source material*. "High-quality coffee" becomes "freshly roasted specialty coffee from small producers" only if the sourcing is real.
- **Scanning.** Short paragraphs, descriptive headings, concise lists, front-loaded sentences. People scan before they read; the copy must survive being skimmed.
- **Plain English.** Active voice. Explain technical ideas simply: technical without becoming inaccessible. Jargon only when the audience owns that jargon.

## Voice

Infer the company's personality from its existing copy and product context, then maintain it. A luxury brand is refined and understated; a law firm is calm and authoritative; a coffee shop is warm and sensory. Never force one voice onto every business.

Tone in all cases: confident, professional, human. Never exaggerated, never salesy, never desperate.

**AI mentions:** don't mention AI unless it is genuinely part of the technical services or product being described. AI as a capability the business sells is copy; AI as decoration is a tell.

## CTAs

Match every CTA to its page's intent. "Learn More" and "Contact Us" are placeholders, not CTAs. "Explore the menu", "Book a consultation", "Read the case study" tell the reader what happens next. When one CTA body repeats across several pages, differentiate it by what each page just argued.

## SEO

Improve semantic relevance naturally: descriptive headings, meta descriptions that answer the searcher's question in ~150–160 characters, each page's unique. Never keyword-stuff.

## Process

1. **Inventory** the copy surface: every file and string in scope, plus where each duplicate lives.
2. **Anchors first.** Settle the global strings (tagline, primary CTA label, hero) before page copy. Decisions flow downhill and everything else must agree with them.
3. **Rewrite in dependency order:** shared fragments before the pages that embed them; page bodies before chrome.
4. **Sync duplicates.** Any string that exists in multiple files is edited in all of them in the same batch, then grep-verified.
5. **Verify.** Lint, build, render. Check headline length against layout bounds at mobile widths. Confirm no keys, slugs, URLs, dates, or credentials changed.

## Output contract

Produce production-ready copy only. No explanations of changes, no justifications, no old-vs-new comparisons unless the user asks. The rewritten text is the deliverable.
