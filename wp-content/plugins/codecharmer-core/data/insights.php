<?php
/**
 * Brand layer: insight articles as Gutenberg block grammar.
 *
 * Seeded as DRAFTS: publishing is an editorial decision made in wp-admin
 * after owner review, never a side effect of seeding. Copy follows the
 * content-rewriter register (no em dashes, no marketing clichés). Excerpts
 * feed the hub cards and meta descriptions.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cc_insights = array();

// -------------------------------------- how-to-audit-a-content-operation -- //
$cc_insights['how-to-audit-a-wordpress-content-operation'] = array(
	'title'   => 'How to Audit a WordPress Content Operation',
	'status'  => 'draft',
	'excerpt' => 'The working method behind our ten-day operations audit: map the workflow before touching the code, rank by cost, and write a plan any competent team could execute.',
	'meta'    => array(
		'cc_seo_title'       => 'How to Audit a WordPress Content Operation | Code Charmer',
		'cc_seo_description' => 'A working method for auditing WordPress operations: map the real workflow, review the platform against it, rank opportunities by cost, and write an executable plan.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:paragraph -->
<p>This is the method behind our ten-day operations audit, written out in full. It is not a secret. The value of a paid audit is the time, the access, and the accountability, not the checklist. If your team can run this yourselves, you should.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The core mistake we see in WordPress audits is starting with the software. Plugin lists, PageSpeed scores, and PHP versions are easy to collect and mostly beside the point. A content operation fails in the space between people and systems, so that is where the audit has to start.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Step one: map the workflow as it actually runs</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Sit with the people who do the work, not their managers, and trace one real item end to end: one article, one product, one order. Write down every tool it touches, every person who handles it, and every place it waits. The waits matter most. A publishing workflow that takes four days of calendar time usually contains about forty minutes of actual work.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Two questions expose most of the cost:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>Where does anyone re-type or copy-paste information that already exists in another system?</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Where does an item wait for a person whose only contribution is forwarding it?</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Every yes is a cost you can estimate: people multiplied by minutes multiplied by frequency. In our audits this table, not the technical findings, is what changes the buying decision. When a client sees that their team spends roughly ten hours a week moving order data from WooCommerce into a spreadsheet by hand, the conversation stops being about technology.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Step two: review the platform against the map, not against best practice</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Now look at the WordPress install, and only now. The question is never "is this set up well" in the abstract. It is "does this setup explain the waits and the re-typing we just mapped". A technically messy install that supports a smooth workflow is a lower priority than a clean install that forces staff through five tools to publish a page.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>What we actually check, in order of how often it turns out to matter:</p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>The editing experience. Can a non-technical person compose a real page from the blocks they are given, or do they file a ticket? Count the tickets.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The integrations. For each connected system: what happens when it fails, who notices, and how long has it been silently broken before? Almost every operation has one integration nobody trusts.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The content model. Structured content in fields the team understands, or one giant page builder blob per page? This decides how expensive every future change is.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Release safety. Can they deploy or update without fear? A team that avoids updating anything is telling you the platform owns them.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Performance and reliability, measured, not assumed. Field data where it exists, lab data where it does not, and never a score without the metric behind it.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Step three: rank by cost, and show your reasoning</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every finding gets the same treatment: what it costs today, what fixing it costs, and how confident we are in both numbers. Then sort. The output is deliberately boring, a ranked table with the reasoning visible, because the reader has to be able to disagree with it. An audit whose ranking cannot be argued with is hiding its assumptions.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Honesty rules we hold ourselves to, and you should hold any auditor to:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>When a plugin or an off-the-shelf tool is the right fix, the plan says so. Custom code has to earn its place.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>When a number is an estimate, it is labeled as one, with the basis shown.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>When something is fine, the report says it is fine. A finding count is not a quality score.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Step four: write the plan for a team that is not you</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The last deliverable is a 90-day implementation plan written so that any competent team could execute it, including one that is not ours. That constraint is not generosity, it is quality control. A plan that only its author can execute is a proposal wearing a costume.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Sequence it by dependency and by payback: the first two weeks should remove a visible, daily irritation, because momentum is an engineering resource like any other. End with the measurement: for each change, the number you expect to move and when you will check it.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>That is the whole method. Map the work, review the platform against the map, rank by cost with the reasoning showing, and write a plan you would be comfortable handing to a competitor. It takes us ten business days because the conversations take what they take. The thinking, as you can see, fits on one page.</p>
<!-- /wp:paragraph -->
BLOCKS
	,
);

// ------------------------------- human-approval-patterns-ai-publishing -- //
$cc_insights['human-approval-patterns-for-ai-assisted-wordpress-publishing'] = array(
	'title'   => 'Human Approval Patterns for AI-Assisted WordPress Publishing',
	'status'  => 'draft',
	'excerpt' => 'What we learned building Praxis: provenance tagging, approval as the publish action, an audit ledger, and a cost meter. The patterns, the failure modes, and the decisions behind them.',
	'meta'    => array(
		'cc_seo_title'       => 'Human Approval Patterns for AI-Assisted WordPress Publishing | Code Charmer',
		'cc_seo_description' => 'First-hand architecture notes from building Praxis: provenance tagging, approval as the publish action, audit ledgers, and metered AI drafting for WordPress content.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:paragraph -->
<p>We build and run Praxis, a content orchestration platform that sits over WordPress and adds AI drafting to a real editorial operation. This article is the part of that build most teams get wrong: the approval layer. Everything here is running in production; nothing is speculative.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The premise is blunt. A language model's draft is a draft, not a decision. The moment machine output can reach your published site without a person saying yes, you no longer have an editorial operation, you have a liability with a CMS attached. The interesting engineering is in making the human yes cheap, fast, and impossible to skip.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Pattern one: provenance is a first-class field</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every content item in Praxis carries its origin: authored in WordPress, created on the platform, or drafted by a model and not yet reviewed by anyone. That last state is explicit and visible everywhere the item appears. The failure mode this prevents is subtle and common: AI drafts that look finished get treated as finished. Two weeks into any AI rollout, nobody remembers which paragraphs a person actually read.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The implementation decision that matters: provenance is set by the system at creation time and is not editable. If users can relabel an AI draft as human-authored, they will, with good intentions, on a deadline.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Pattern two: approval is the publish action</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>We do not have a review step and a publish step. Approving is publishing; there is no second lever to pull, and no path to the live site that routes around the review. Rejection requires a written reason, which sounds bureaucratic and is actually the cheapest training signal you will ever collect: three months of rejection reasons tell you exactly what your prompts and your model choice are getting wrong.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>An AI draft opens its own review automatically. Nobody has to remember to request one, because a safeguard that depends on remembering is not a safeguard. The review queue is sorted so that machine drafts awaiting a first human read surface above everything else: they are the highest-uncertainty items in the system.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Pattern three: the ledger</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every review decision is recorded: who, when, approved or sent back, and what they wrote. This is not surveillance, it is institutional memory. When a published piece turns out to be wrong, the question "how did this get through" has an answer in seconds, and the answer is about process, not blame. Teams that skip the ledger end up reconstructing it from chat logs, badly, during an incident.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Pattern four: meter the drafting</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every generation is costed, in integer micro-cents to avoid floating-point drift in financial arithmetic, against a per-organization daily budget, with the prompt version recorded alongside the spend. Two reasons. The obvious one is that unmetered API spend is a surprise invoice waiting to happen. The less obvious one is editorial: when drafting has a visible cost, people write better briefs, and better briefs produce drafts that survive review. The meter is a quality tool wearing an accounting costume.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The failure modes we designed against</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>Approval fatigue. If reviewers approve everything, the gate is theater. The rejection-reason requirement and the queue ordering keep the decision honest; the ledger makes rubber-stamping visible in aggregate.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The side door. Every integration that can create content must route through the same review states. The first bypass anyone builds "just for migrations" becomes the permanent hole in the fence.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Silent model changes. Prompts are versioned and the version travels with each draft. When output quality shifts, you can tell whether the model, the prompt, or the briefs changed.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Trust by interface. A clean UI makes machine text feel edited. Provenance labels fight the instinct to trust typography over process.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">What we would tell a team starting today</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Build the approval layer before you build the drafting layer. It feels backwards, because the drafting is the demo and the approval is the chore. But drafting bolted onto an approval system inherits its discipline, while approval bolted onto a drafting system inherits its shortcuts. We have watched both orders play out; only one of them survives contact with a deadline.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>And keep WordPress. The instinct to replatform because AI arrived is usually wrong: your editors' muscle memory, your content history, and your workflows live there. Praxis treats WordPress as the authoring surface and holds the canonical model, the review states, and the meters itself. The machine drafts. A person approves. The system remembers. That order is the whole design.</p>
<!-- /wp:paragraph -->
BLOCKS
	,
);

return $cc_insights;
