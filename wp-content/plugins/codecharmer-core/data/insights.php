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

// ----------------------- when-wordpress-should-become-application-platform -- //
$cc_insights['when-wordpress-should-become-an-application-platform'] = array(
	'title'   => 'When WordPress Should Become an Application Platform',
	'status'  => 'draft',
	'excerpt' => 'Three signals that a website has quietly become an application, the architecture boundaries that keep the build sane, and the honest cases where WordPress is the wrong engine.',
	'meta'    => array(
		'cc_seo_title'       => 'When WordPress Should Become an Application Platform | Code Charmer',
		'cc_seo_description' => 'A decision framework from production builds: the signals that justify WordPress as an application platform, the architecture boundaries that keep it maintainable, and when to say no.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:paragraph -->
<p>The question usually arrives as "can WordPress do this". It almost always can, which is exactly why that is the wrong question. The right question is whether it should, and the answer depends on the shape of your operation, not on the software. We run WordPress as a full application platform in production, and we have also talked clients out of it. This is the framework we actually use.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The three signals</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A website becomes an application the day one of these becomes true. Most teams notice about a year later.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>More than one surface needs the same data. A storefront and a point of sale. A site and a mobile app. The moment two systems hold their own copy of the catalog, the prices, or the customers, you are paying for a sync job forever, and sync jobs are where data goes to quietly diverge.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>People log in to do work, not to publish. When staff open the admin to fulfill orders, check in members, or approve requests, you have users and roles, which means you have an application with an application's security and workflow needs.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>A workflow has outgrown forms and email. When the process is "the form emails Maria and Maria types it into the other system", the website has become the front door of an operation it does not actually serve.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>None of the three is about traffic. Small operations cross these lines constantly; that is the point of the framework.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Why WordPress earns the job more often than engineers expect</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Our clearest example is a bakery. Pacífica Panadería runs its reserve-and-pickup storefront, its customer app with Apple Wallet loyalty, and the tablet point of sale at the counter on one WordPress engine. The alternative was three products from three vendors plus the integration work to keep them agreeing about inventory and customers. For a small operation, the sync work alone would have cost more than the platform.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The reasoning generalizes. If the operation already lives partly in WordPress, the catalog, the accounts, the content, then extending WordPress means one system of record, one admin your staff already knows, and one deployment to operate. Those are operational advantages, not technical ones, and operations is where small and mid-size organizations actually lose money.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The same engine later became a second business. Haramara Café runs the identical commerce core, re-branded end to end. That is the quiet payoff of treating WordPress as a platform instead of a theme with plugins: the second deployment costs a fraction of the first.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The boundaries that keep it sane</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every WordPress-as-platform build we have seen fail failed at the boundaries, not at the center. The rules we build by:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>Domain data gets real tables. Posts and meta are for content. Orders, loyalty balances, and check-ins get custom tables with real schemas, or they get slow and unqueryable together.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Every surface talks through the REST layer. The app, the POS, and any future surface consume the same authenticated API. No surface reaches into the database sideways, because the second one that does ends the platform and starts the archaeology.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Logic lives in a plugin, presentation in a theme. The engine has to survive a redesign untouched. If rebranding the site would touch business logic, the boundary is already broken.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Background work leaves the request. Anything slow, an export, a notification fan-out, a third-party call, runs from a queue, not inside a page load. PHP request lifecycles are not a job system, and pretending otherwise produces the timeouts your staff will describe as "the site is down".</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">When the answer is no</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>WordPress is the wrong engine when the honest requirements fight its nature. We say no when:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>The core of the product is realtime. Live collaboration, streaming state, sub-second fan-out to many clients: that is a different runtime, and bolting it on costs more than building beside it.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>There is no content or editorial dimension at all. If nobody will ever use the admin, the CMS is dead weight and a plain application framework is simpler.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Compliance demands what the ecosystem cannot promise. Some regulated data should not live in a general-purpose CMS database, full stop.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The team plans to hire a large product-engineering org. Past a certain team size, the conventions that make WordPress productive for a small team start to chafe, and the calculus genuinely changes.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The decision, in one pass</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ask these in order and stop at the first no.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>Does part of the operation already live in WordPress, and will editors keep using it? If no, use something else.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Can the new capability respect the boundaries above without heroics? If no, build it as a separate service beside WordPress and integrate through the API.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Is the team that will operate it comfortable operating WordPress? The platform you can actually run beats the platform that benchmarks well in someone else's blog post.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Three yeses and WordPress stops being a website and becomes what it quietly is for thousands of operations: the cheapest reliable application platform their team already knows how to use. Anything less than three, and the most senior thing an engineer can say is no.</p>
<!-- /wp:paragraph -->
BLOCKS
	,
);

// --------------------------------------- wordpress-automation-decision-guide -- //
$cc_insights['wordpress-automation-decision-guide'] = array(
	'title'   => 'Plugin, Zapier, or Custom Code? A WordPress Automation Decision Guide',
	'status'  => 'draft',
	'excerpt' => 'The three honest ways to automate a WordPress workflow, what each really costs at month twelve rather than day one, and the questions that pick the right one.',
	'meta'    => array(
		'cc_seo_title'       => 'Plugin, Zapier, or Custom Code? A WordPress Automation Decision Guide | Code Charmer',
		'cc_seo_description' => 'An honest comparison of plugins, Zapier/Make, and custom code for WordPress automation: total cost of ownership, failure behavior, and a decision checklist from production experience.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:paragraph -->
<p>We write custom automation code for a living, and we still tell clients to install a plugin or wire up Zapier more often than you would guess. Each of the three options is correct somewhere. The expensive mistakes come from comparing them on day-one price instead of month-twelve behavior, so this guide compares them where it matters: what happens over a year, and what happens when they fail.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Option one: a plugin</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Right when the problem is a commodity. Sending order notifications, basic form routing, scheduled posts: problems thousands of sites share, solved by plugins that are actively maintained and widely deployed. A well-chosen plugin is the cheapest option on every time horizon, and choosing custom code here is engineering vanity.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The real costs, the ones the pricing page does not show:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>Configuration is code you cannot review. Forty settings screens across twelve plugins is a program nobody can read, with its logic spread across a database.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The plugin's data model becomes your data model. Migrating away later means migrating data, and that cost lands on whoever inherits the site.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Every plugin is a dependency with its own update cadence, security history, and business model. The question is not "does it work" but "who maintains it, and what happens to my workflow if they stop".</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Our selection bar, which disqualifies most of the directory: actively maintained, popular enough that bugs are found by someone else first, and doing one thing. A plugin that wants to be a platform inside your platform is a future migration project.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Option two: Zapier or Make</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Right for prototyping and for genuinely low-stakes glue. Connecting a form to a spreadsheet to see whether anyone even uses the form, piping form entries into Slack, syncing a newsletter list: if the workflow failing silently for two days would be an annoyance rather than a loss, the connector tools are honest value.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The costs that arrive at month twelve:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>Per-task pricing scales with your success. The zap that cost almost nothing at fifty orders a month has a real invoice at five thousand, and by then the workflow is load-bearing.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Failure is silent by default. Connector platforms retry a little and then drop. Nobody is alerted, nothing is queued for replay, and the missing records are discovered weeks later during reconciliation. In audits, this is the single most common wound we find.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The workflow logic lives in a vendor's UI, outside version control, outside review, and outside your backups. The person who built the zaps leaving the company is a genuine operational incident.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Your data transits a third party. For a lead form that may be fine. For customer or health or minors' data, it is a compliance question someone must actually answer, not assume.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Option three: custom code</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Right when the workflow is core to the operation, when volume is real, or when failure must be handled rather than hoped against. Custom automation is the only option of the three where you can have retries with backoff, a dead-letter queue, logging you control, and behavior that is reviewed and versioned like the asset it is.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>It is also the only option with an honest ownership cost, which is exactly why it is often quoted dishonestly. Custom code must be maintained: PHP versions move, APIs deprecate, requirements drift. Our rule is that a custom automation quote that does not mention ownership, who maintains it, how it is monitored, what documentation exists, is a quote for half a system. When we build these, the runbook and the failure alerts are part of the deliverable, not an upsell, because we have inherited too many automations that ran unobserved until they mattered.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The threshold is lower than most owners think, though. An automation that a connector platform would run for a growing per-task fee, forever, with silent failure, often pays for its custom replacement within the first year or two, and the replacement fails loudly instead. We run SMS-driven order operations for a coffee brand this way precisely because a missed message there is a missed sale, not an annoyance.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The decision guide</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Ask in order; the first answer that fires decides.</p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>Is this a commodity problem with a maintained, focused plugin? Use the plugin. Custom code here buys you maintenance duty and nothing else.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Would silent failure for two days be acceptable? If genuinely yes, a connector tool is fine. Write down that answer, because it is the assumption the whole choice rests on, and volume growth revokes it.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Does the workflow touch money, inventory, customer records, or anything with a reconciliation step? Then it needs retries, replay, and alerts, and that means custom code, regardless of today's volume.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Is the per-task bill trending toward the cost of building it properly? Do the two-year arithmetic while the choice is still cheap to change.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>And one meta-rule that outranks the other four: whatever you choose, someone must be able to answer "how would we know if this broke last Tuesday". If the answer is "a customer would eventually tell us", you have not chosen an automation. You have chosen a liability with a monthly fee.</p>
<!-- /wp:paragraph -->
BLOCKS
	,
);

// ----------------------------------------- the-real-cost-of-headless-wordpress -- //
$cc_insights['the-real-cost-of-headless-wordpress'] = array(
	'title'   => 'The Real Cost of Headless WordPress',
	'status'  => 'draft',
	'excerpt' => 'We run a headless WordPress build in production and a block-theme build in production. A ledger of what headless actually costs to operate, and the cases where it still earns it.',
	'meta'    => array(
		'cc_seo_title'       => 'The Real Cost of Headless WordPress | Code Charmer',
		'cc_seo_description' => 'First-hand operating costs of headless WordPress: two deployables, rebuilt plumbing, publish latency, and a doubled skill set. When decoupling earns its keep and when a block theme wins.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:paragraph -->
<p>We operate both architectures in production. Gramo Café, a coffee brand with eight locations, runs headless: WordPress for editing, Gatsby for the front end. This site runs the opposite way, as a server-rendered block theme. Having paid the bills for both, we can write the article we wished existed before the first build: not advocacy in either direction, just the ledger.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">What headless genuinely buys</h2>
<!-- /wp:heading -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>Front-end freedom. The design is not negotiating with a theme layer. For Gramo's bilingual, art-directed front end, that freedom was the point.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>A performance ceiling that is hard to hit any other way. Static output served from a CDN is effectively unbeatable on first paint, and it stays fast without anyone tending a cache.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>A smaller attack surface. The public site is files. WordPress itself can live behind access controls, which shrinks the most common attack paths against it to near zero.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Real content reuse. When the same content genuinely feeds a site, an app, and other surfaces, the API-first shape stops being overhead and starts being the architecture.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The costs nobody budgets</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every item below is something we have paid for, not something we read about.</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>You now operate two systems. Two codebases, two deploy pipelines, two sets of dependencies aging at different speeds. Every WordPress update is now tested against a front end WordPress knows nothing about. The maintenance surface roughly doubles, permanently.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Publish latency is real and editors feel it. A price change or a typo fix triggers a build, and builds take minutes, not seconds. Editors who came from "update, refresh, done" experience this as a regression, because for them it is one.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Preview is a project, not a checkbox. "See the draft as it will look" is free in a theme and an engineering effort in a decoupled front end. Budget it, or watch editors publish to see their work.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The plugin economy assumes the theme layer. SEO output, forms, redirects, sitemaps, e-commerce rendering: the ecosystem delivers these through the front end you just removed. Each one gets rebuilt or wired through APIs, and together they usually outweigh the build you planned.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The team needs two skill sets for the life of the site. Not two people necessarily, but two disciplines: WordPress and a JavaScript build toolchain. Whoever maintains it after you must have both, and that narrows the market noticeably.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The 2019 argument has expired</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Part of headless's reputation was earned against an older WordPress. The block editor, block themes, and modern core have since absorbed a lot of the pitch. This site is the measurement we can publish first-hand: a designed, animated front end, server-rendered from thirty-six custom blocks, scoring 98 to 100 on Lighthouse performance and 100 on accessibility across its funnel pages, with none of the operating costs above. One system, instant publishing, native preview, the whole plugin ecosystem intact.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>If the reason for going headless is "WordPress front ends are slow and ugly", that reason is out of date. The remaining good reasons are structural, not aesthetic.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The decision</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Go headless when at least one of these is true and you have accepted the ledger above in writing:</p>
<!-- /wp:paragraph -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>Multiple real surfaces consume the same content today, not hypothetically.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The design or interaction requirements genuinely exceed what a block theme can render, and that quality is a business requirement rather than a preference.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The security posture requires the public site to be static output.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Otherwise, build a proper block theme. We say this as a studio that runs a headless build happily: Gramo earns its architecture through its design ambitions and its operational model. Most sites we audit that went headless did not need it, and are paying the doubled maintenance bill for a performance number a block theme now matches.</p>
<!-- /wp:paragraph -->
BLOCKS
	,
);

// ------------------------------- connect-wordpress-to-a-crm-without-a-data-mess -- //
$cc_insights['connect-wordpress-to-a-crm-without-creating-a-data-mess'] = array(
	'title'   => 'How to Connect WordPress to a CRM Without Creating a Data Mess',
	'status'  => 'draft',
	'excerpt' => 'The mess is never the API call. Field ownership, stable identifiers, an outbox with retries, sync observability, and consent that travels with the record.',
	'meta'    => array(
		'cc_seo_title'       => 'How to Connect WordPress to a CRM Without Creating a Data Mess | Code Charmer',
		'cc_seo_description' => 'Five principles for WordPress-to-CRM integration that survives month three: per-field ownership, stable identifiers, outbox queues with retries, observability, and privacy by design.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:paragraph -->
<p>Connecting a WordPress form to a CRM takes an afternoon. That is precisely the problem: the afternoon version works on day one, and the mess appears around month three, when marketing asks why the CRM has four copies of the same customer and nobody can say which one is real. The mess is never the API call. It is five decisions that the afternoon version skips, so here they are.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Decide who owns each field, in writing</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>For every piece of data that exists in both systems, exactly one system is the source of truth, per field, not per record. The email preferences might belong to the CRM while the purchase history belongs to WooCommerce, and that is fine, as long as it is written down and the sync only ever flows in the owning direction. Two-way sync of the same field is how both copies become wrong. Most "CRM data quality projects" we encounter are archaeology on a system where nobody made this decision.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">An email address is not an identity</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>People change addresses, share addresses, and typo addresses. Matching records by email is why the CRM has four copies of one human. The fix is boring and absolute: when a record first syncs, store the CRM's ID on the WordPress side and the WordPress ID in the CRM. Every later update addresses the record by ID. Email becomes a field like any other, editable without consequence, instead of the thread everything hangs from.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Never call the CRM inside the request</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The visitor who just submitted your form should never be waiting on your CRM vendor's API, and a CRM outage should never cost you a lead. The pattern that fixes both is an outbox: the form handler validates, stores the inquiry locally, and returns success. A separate worker delivers to the CRM afterward, retrying with backoff on failure. The outbox row needs only a handful of columns: the payload, the attempt count, when to try next, and a status that can be pending, delivered, or failed.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>The rule this enforces is worth stating on its own: the lead is captured the moment it is stored locally, and delivery to the CRM is a background concern with its own error budget. Our own inquiry endpoint on this site works exactly this way, validates and stores first, with rate limiting and spam checks at the front door, precisely because the form handler is the one component that is not allowed to fail.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Assume it is broken and prove otherwise</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Every integration we have ever audited has been silently broken at least once without anyone noticing, and the record was discovered weeks later. So: log every delivery attempt with its outcome, alert when the failed count rises or the oldest pending item gets stale, and reconcile on a schedule, comparing counts between systems weekly. A five-minute reconciliation query catches the drift that alerts miss. If you cannot answer "did last Tuesday's leads all arrive", you do not have an integration, you have a hope.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Consent travels with the record</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The moment personal data flows between systems, privacy stops being a checkbox on the form and becomes a property of the pipeline. Three rules cover most of it: record the consent basis and its timestamp as fields that sync with the record, so the CRM can prove why it holds each contact; propagate deletion, so removing a person from one system queues their removal from the other; and keep personal data out of your analytics and your logs entirely. Log record IDs, never names or addresses. A debug log full of PII is a breach with timestamps.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">The checklist</h2>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true} -->
<ol class="wp-block-list"><!-- wp:list-item -->
<li>A field-ownership table exists, and every sync flows in the owning direction only.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Records reference each other by stored IDs, never matched by email after first contact.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>The form handler stores locally and returns; delivery happens from an outbox with retries and a failure state someone is alerted about.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Attempts are logged, staleness is alerted, and counts are reconciled weekly.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Consent basis syncs with the record, deletions propagate, and PII appears in no log and no analytics event.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>None of this is exotic engineering. It is a few days of deliberate work at the start, against months of archaeology later. The afternoon version is only cheaper if your leads are worthless, and if they were, you would not be connecting a CRM.</p>
<!-- /wp:paragraph -->
BLOCKS
	,
);

// ------------------------------ what-a-serious-support-retainer-should-include -- //
$cc_insights['what-a-serious-wordpress-support-retainer-should-include'] = array(
	'title'   => 'What a Serious WordPress Support Retainer Should Include',
	'status'  => 'draft',
	'excerpt' => 'Support is the vaguest word in WordPress services. The six components a real retainer names in writing, the pricing drivers behind them, and the offers to walk away from.',
	'meta'    => array(
		'cc_seo_title'       => 'What a Serious WordPress Support Retainer Should Include | Code Charmer',
		'cc_seo_description' => 'A buyer\'s guide to WordPress support retainers: monitoring, tested releases, security practice, performance budgets, honest SLAs, roadmap capacity, and what drives the price.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:paragraph -->
<p>"Support" is the vaguest word in WordPress services, which is convenient for sellers and expensive for buyers. A serious retainer is not an insurance policy or a bucket of hours. It is an operations contract with named deliverables, and you can evaluate one in ten minutes by checking it against the six components below. We operate retainers on the systems we build, so this list is what we hold ourselves to, written from the buyer's side of the table.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Monitoring, because you cannot support what you cannot see</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The retainer should name what is watched: uptime, error logs, form and integration health, and real-user performance, not just a monthly lab test. The test question for any provider: "when my checkout breaks at 2 a.m., how do you find out?" If the honest answer is "you tell us", you are the monitoring system, and you are paying them for the privilege.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Releases, on a cadence, with a way back</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Updates applied on a stated schedule, tested somewhere that is not production, with backups verified by actually restoring them, and a rollback path that has been exercised. A team that avoids updating anything is telling you they are afraid of the site, and fear compounds: every skipped update makes the next one riskier. The retainer's job is to make updates boring.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Security as practice, not as plugin</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A security plugin is not a security practice. The practice is: least-privilege accounts reviewed on a schedule, a stated response window when a vulnerability in your stack is disclosed, and an incident procedure that names who does what. Ask to see the procedure. The providers who have one will show it; the providers who improvise will change the subject.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Performance as a budget, not a one-time fix</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Performance decays by default: every added plugin, script, and campaign page pushes it. A serious retainer states a budget, checks the site's real-user numbers against it on a cadence, and treats regressions as work items rather than surprises. A one-time speed-up without regression checks is a haircut, and it grows back.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">SLAs that are honest about size</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Response classes should be few and truthful: what counts as an emergency, what response an emergency gets, what everything else gets, and during which hours. A small studio promising fifteen-minute response around the clock is either lying or about to burn out, and both end the same way for you. We would rather publish a modest number we always hit than an impressive one we sometimes miss, and you should hold every provider to the same standard.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Roadmap capacity, or it is just insurance</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The difference between a maintenance contract and a real retainer is that the real one moves the site forward. Some portion of the engagement should be engineering time against a prioritized backlog, reviewed together on a cadence, so that a year of retainer leaves you with a measurably better system rather than a preserved one. If every improvement requires a separate proposal, you have bought insurance, and insurance never ships anything.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">What actually drives the price</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>Retainers price on risk surface and reserved capacity, and a provider should be able to say so plainly. The honest drivers:</p>
<!-- /wp:paragraph -->

<!-- wp:list -->
<ul class="wp-block-list"><!-- wp:list-item -->
<li>Surface area: how much custom code, how many plugins, how many integrations can break.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Criticality: a brochure site and a store that takes orders all day carry different consequences per hour of downtime.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Response class: tighter windows mean reserved attention, and reserved attention is the real commodity being sold.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Roadmap share: how much of the retainer is forward engineering versus operations.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:paragraph -->
<p>Billed in advance, because the provider is reserving capacity whether or not you call. That part is fair. What is not fair, and what you should walk away from: "unlimited requests" (a queue wearing a marketing costume), hour banks that quietly expire, contracts with no named deliverables, and any retainer whose monthly report you could not distinguish from last month's. If the report does not say what was monitored, updated, fixed, and shipped, the retainer is a subscription to a feeling.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Print the six components, hand them to any provider, and ask them to mark what is included in writing. The serious ones will have answers before you finish asking. That is rather the point of the exercise.</p>
<!-- /wp:paragraph -->
BLOCKS
	,
);

return $cc_insights;
