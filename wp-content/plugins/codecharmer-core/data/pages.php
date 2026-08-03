<?php
/**
 * Brand layer: every page as Gutenberg block grammar.
 *
 * Keyed by seed slug; children use "parent/child" keys and are created after
 * their parents. Copy follows the content-rewriter skill's register (no em
 * dashes, no marketing clichés). Excerpts feed the meta description tags.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cc_process_stages = <<<'BLOCKS'
<!-- wp:codecharmer/process-stage {"name":"Discovery","weight":3.6,"body":"Understand the business, the users, and the real problem before proposing anything. We ask more questions than most agencies do. It’s cheaper than building the wrong thing.","deliverable":"A shared understanding of the problem and what success looks like."} /-->
<!-- wp:codecharmer/process-stage {"name":"Architecture","weight":4.4,"body":"Design the data, the structure, and the integrations so everything downstream is cheaper. This is where the biggest costs are won or lost.","deliverable":"A system design and a plan you can budget against."} /-->
<!-- wp:codecharmer/process-stage {"name":"Design","weight":2.8,"body":"Interface and experience that serve the workflow and the brand, not decoration. Every screen earns its place.","deliverable":"Interfaces and flows, ready to build."} /-->
<!-- wp:codecharmer/process-stage {"name":"Development","weight":2.2,"body":"Production-grade engineering: maintainable, accessible, and fast by default. Tested as it’s written, not bolted on at the end.","deliverable":"Working software you can actually read and extend."} /-->
<!-- wp:codecharmer/process-stage {"name":"Testing","weight":1.5,"body":"Verify against real conditions and edge cases before anything ships. Empty states, error states, the messy middle: all of it.","deliverable":"Confidence it holds up under real use."} /-->
<!-- wp:codecharmer/process-stage {"name":"Launch","weight":1.1,"body":"Go live, hand over the keys, and make sure the team can drive. Documentation and workflows included.","deliverable":"A live platform and a team that can run it."} /-->
<!-- wp:codecharmer/process-stage {"name":"Growth","weight":1.4,"body":"Measure, iterate, and extend. The platform compounds instead of stalling. We stay as long as we’re useful, and no longer.","deliverable":"A roadmap and the data to prioritize it."} /-->
BLOCKS;

$cc_flagship_band = <<<'BLOCKS'
<!-- wp:codecharmer/flagship {"name":"Praxis","tagline":"· the control room for a company’s content.","description":"Our own product, built the way we tell clients to build: an AI-native orchestration layer that connects WordPress, metered AI drafting, and enterprise search on one board. Live right now on a single VPS. Architected for many.","stackLine":"Laravel · FrankenPHP · Next.js 16 · React 19 · RabbitMQ · OpenSearch · Redis · MariaDB · MinIO · Traefik · Docker Compose","primaryLabel":"Open the live demo","primaryUrl":"https://praxis.codecharmer.io","secondaryLabel":"Read the case study","secondaryUrl":"/work/praxis"} -->
<!-- wp:codecharmer/feature-item {"text":"Mixed provenance on one board: WordPress-authored, platform, and AI-drafted content, each tagged with its origin"} /-->
<!-- wp:codecharmer/feature-item {"text":"The machine drafts, a human approves: AI output opens its own review, and nothing publishes without a person saying yes"} /-->
<!-- wp:codecharmer/feature-item {"text":"AI drafting with a meter: every generation costed in integer micro-cents against a budget, prompts versioned"} /-->
<!-- wp:codecharmer/feature-item {"text":"Search as a read model: an event-driven OpenSearch pipeline returning highlighted results in about 90 ms"} /-->
<!-- /wp:codecharmer/flagship -->
BLOCKS;

$cc_beliefs_items = <<<'BLOCKS'
<!-- wp:codecharmer/belief-item {"title":"AI should solve real business problems","body":"Not a demo bolted onto a homepage. Automation earns its place by taking real, repetitive work off your team’s plate."} /-->
<!-- wp:codecharmer/belief-item {"title":"WordPress is an asset, not a burden","body":"Engineered properly, it stops being technical debt and becomes a platform your team can actually run."} /-->
<!-- wp:codecharmer/belief-item {"title":"Clients own their platform","body":"You should understand and control what you paid for. No lock-in, no dependency, no black boxes."} /-->
<!-- wp:codecharmer/belief-item {"title":"Good architecture lowers future cost","body":"Decisions made early compound. We build so the next change is cheaper, not more expensive."} /-->
BLOCKS;

/**
 * Build a service page's content from its parts.
 *
 * @param array<string,mixed> $service Service definition.
 * @return string Block markup.
 */
$cc_service_page = static function ( array $service ): string {
	$hero = sprintf(
		'<!-- wp:codecharmer/page-hero %s /-->',
		wp_json_encode(
			array(
				'tone'           => 'ink',
				'eyebrow'        => $service['name'],
				'title'          => $service['problem'],
				'intro'          => $service['thesis'],
				'primaryLabel'   => 'Book a consultation',
				'primaryUrl'     => '/contact',
				'secondaryLabel' => 'See our work',
				'secondaryUrl'   => '/work',
			),
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
		)
	);

	$features = sprintf(
		"<!-- wp:codecharmer/feature-list %s -->\n%s\n<!-- /wp:codecharmer/feature-list -->",
		wp_json_encode(
			array( 'heading' => sprintf( 'What %s includes.', $service['name'] ) ),
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
		),
		implode(
			"\n",
			array_map(
				static fn( string $item ): string => sprintf(
					'<!-- wp:codecharmer/feature-item %s /-->',
					wp_json_encode( array( 'text' => $item ), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
				),
				$service['included']
			)
		)
	);

	$approach = sprintf(
		"<!-- wp:codecharmer/approach -->\n%s\n<!-- /wp:codecharmer/approach -->",
		implode(
			"\n",
			array_map(
				static fn( array $step ): string => sprintf(
					'<!-- wp:codecharmer/approach-step %s /-->',
					wp_json_encode(
						array(
							'title' => $step[0],
							'body'  => $step[1],
						),
						JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
					)
				),
				$service['approach']
			)
		)
	);

	$faq = sprintf(
		"<!-- wp:codecharmer/faq -->\n%s\n<!-- /wp:codecharmer/faq -->",
		implode(
			"\n",
			array_map(
				static fn( array $qa ): string => sprintf(
					'<!-- wp:codecharmer/faq-item %s /-->',
					wp_json_encode(
						array(
							'question' => $qa[0],
							'answer'   => $qa[1],
						),
						JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
					)
				),
				$service['faq']
			)
		)
	);

	$cta = sprintf(
		'<!-- wp:codecharmer/cta-band %s /-->',
		wp_json_encode(
			array(
				'heading' => sprintf( 'Let’s talk about %s.', $service['name'] ),
				'body'    => $service['cta'],
			),
			JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
		)
	);

	return implode( "\n\n", array( $hero, $features, $approach, '<!-- wp:codecharmer/proof /-->', $faq, $cta ) );
};

$cc_services = array(
	'ai-strategy'     => array(
		'order'      => 1,
		'name'       => 'AI Strategy & Architecture',
		'icon'       => 'architecture',
		'descriptor' => 'Prepare the business for AI, not just bolt features onto it.',
		'thesis'     => 'AI-ready architecture, knowledge organization, and data structure that make intelligent automation possible.',
		'problem'    => 'Most AI projects start with a tool and go looking for a use. That’s backwards, and expensive.',
		'cta'        => 'Tell us where the hours actually go. A short conversation is usually enough to see whether AI has a real job to do in your business.',
		'included'   => array( 'AI-ready architecture', 'Knowledge organization', 'Data structure & modeling', 'Internal workflow mapping', 'AI integration planning', 'Automation strategy' ),
		'approach'   => array(
			array( 'Map the real workflows', 'Find where time and money actually go before proposing any technology.' ),
			array( 'Organize the knowledge', 'Structure the data and documents AI needs to be useful and reliable.' ),
			array( 'Design the architecture', 'Integrations, guardrails, and a path to scale: built to last, not to demo.' ),
		),
		'faq'        => array(
			array( 'Do we even need AI?', 'Sometimes the honest answer is no, and we’ll tell you. AI earns its place only by removing real work.' ),
			array( 'Isn’t our data too messy for this?', 'That messiness is exactly the work. Organizing knowledge so AI has something reliable to stand on is most of the value.' ),
		),
	),
	'wordpress'       => array(
		'order'      => 2,
		'name'       => 'WordPress Engineering',
		'icon'       => 'blocks',
		'descriptor' => 'Enterprise-grade engineering, not another off-the-shelf theme.',
		'thesis'     => 'Custom themes, Gutenberg block development, performance, and security built to last: WordPress as an asset, not a burden.',
		'problem'    => 'Off-the-shelf WordPress becomes technical debt the moment your needs outgrow the theme.',
		'cta'        => 'Tell us what your site should be doing for you. A short conversation is usually enough to know what to keep, refactor, or rebuild.',
		'included'   => array( 'Custom theme development', 'Gutenberg block development', 'ACF & structured content', 'Headless / API solutions', 'Performance & Core Web Vitals', 'Accessibility', 'SEO foundations', 'Security & maintainability', 'Editorial workflows' ),
		'approach'   => array(
			array( 'Architect the content model', 'Design the blocks and fields your team will actually edit, day to day.' ),
			array( 'Engineer the theme', 'Fast, accessible, and maintainable by default, not bolted on at the end.' ),
			array( 'Hand over the keys', 'Documentation and editorial workflows your team owns without depending on us.' ),
		),
		'faq'        => array(
			array( 'Can you work with our existing site?', 'Usually yes. We audit first, then decide together what to keep, refactor, or rebuild.' ),
			array( 'Will our team be able to manage it?', 'That’s the whole point. We build editing experiences your team controls, so you’re never locked in.' ),
		),
	),
	'custom-software' => array(
		'order'      => 3,
		'name'       => 'Custom Software',
		'icon'       => 'terminal',
		'descriptor' => 'Software that improves how the business actually operates.',
		'thesis'     => 'Internal dashboards, portals, APIs, and integrations that remove manual work and let a small team operate like a bigger one.',
		'problem'    => 'When the business runs on five disconnected tools and a lot of spreadsheets, the software is the bottleneck.',
		'cta'        => 'Tell us how the work actually flows. A short conversation is usually enough to see where software would remove the friction.',
		'included'   => array( 'Internal dashboards', 'Business portals', 'CRM integrations', 'APIs & integrations', 'Process automation', 'Membership systems', 'Booking systems', 'Custom applications' ),
		'approach'   => array(
			array( 'Understand the operation', 'The real workflow, not the org chart. That’s where the friction actually lives.' ),
			array( 'Design the system', 'Data, integrations, and an interface that serves the work instead of fighting it.' ),
			array( 'Build and integrate', 'Production software that connects the tools you already rely on.' ),
		),
		'faq'        => array(
			array( 'Do we have to replace our current tools?', 'Rarely. We integrate with what works and replace only what’s genuinely holding you back.' ),
			array( 'How do we avoid another system nobody uses?', 'By designing around the actual workflow. Adoption is a design problem, not a training problem.' ),
		),
	),
	'ai-automation'   => array(
		'order'      => 4,
		'name'       => 'AI Automation',
		'icon'       => 'flow',
		'descriptor' => 'Practical automation with measurable outcomes, not hype.',
		'thesis'     => 'Content workflows, internal assistants, retrieval systems, and process automation that pay for themselves.',
		'problem'    => 'Most “AI automation” is a demo. The value is in the unglamorous, repetitive work it quietly removes.',
		'cta'        => 'Tell us which tasks eat your team’s hours. A short conversation is usually enough to see what automation would give back.',
		'included'   => array( 'Content workflows', 'Internal assistants', 'Customer support automation', 'Business process automation', 'AI integrations', 'Retrieval systems (RAG)', 'AI-powered search' ),
		'approach'   => array(
			array( 'Find the repetitive work', 'The tasks that eat hours and add no human judgment come first.' ),
			array( 'Build the automation', 'Reliable and observable, with a human in the loop wherever it matters.' ),
			array( 'Measure the payoff', 'Hours saved, errors avoided, throughput gained: automation should pay for itself.' ),
		),
		'faq'        => array(
			array( 'Will this replace our people?', 'No. It removes the busywork so your people spend time on the work that needs judgment.' ),
			array( 'How do you stop AI from making things up?', 'Retrieval over your own structured knowledge, with guardrails and human review where it counts.' ),
		),
	),
);

$cc_pages = array();

// ---------------------------------------------------------------- home -- //
$cc_pages['home'] = array(
	'title'   => 'Home',
	'order'   => 0,
	'excerpt' => 'A digital engineering studio building AI-first architecture, WordPress systems, and custom software that generate revenue and stay yours to run.',
	'content' => <<<BLOCKS
<!-- wp:codecharmer/hero /-->

<!-- wp:codecharmer/value-statement -->
<!-- wp:codecharmer/value-point {"title":"Revenue, not just presence","body":"Sites and tools designed to convert, automate, and compound, not just look the part."} /-->
<!-- wp:codecharmer/value-point {"title":"Leverage from automation","body":"We remove the manual, repetitive work so your team spends its time where it actually matters."} /-->
<!-- wp:codecharmer/value-point {"title":"Ownership by default","body":"You understand and control everything we deliver. No lock-in, no dependency, no black boxes."} /-->
<!-- /wp:codecharmer/value-statement -->

<!-- wp:codecharmer/services-grid /-->

<!-- wp:codecharmer/beliefs {"intro":"They’re why clients bring us the projects that matter, and why the results tend to outlast us."} -->
{$cc_beliefs_items}
<!-- /wp:codecharmer/beliefs -->

<!-- wp:codecharmer/process-teaser -->
{$cc_process_stages}
<!-- /wp:codecharmer/process-teaser -->

{$cc_flagship_band}

<!-- wp:codecharmer/projects /-->

<!-- wp:codecharmer/cta-band /-->
BLOCKS
	,
);

// ------------------------------------------------------------ services -- //
$cc_pages['services'] = array(
	'title'   => 'Services',
	'order'   => 1,
	'excerpt' => 'Four disciplines engineered to work as one system: AI strategy, WordPress engineering, custom software, and AI automation.',
	'content' => <<<BLOCKS
<!-- wp:codecharmer/page-hero {"eyebrow":"Services","title":"Systems, not features.","intro":"Four disciplines engineered to work as one system: AI strategy, WordPress engineering, custom software, and automation. Most projects touch more than one.","primaryLabel":"Book a consultation","primaryUrl":"/contact","secondaryLabel":"See our work","secondaryUrl":"/work"} /-->

<!-- wp:codecharmer/services-showcase /-->

<!-- wp:codecharmer/process-teaser {"tone":"ink"} -->
{$cc_process_stages}
<!-- /wp:codecharmer/process-teaser -->

<!-- wp:codecharmer/engagement-models -->
<!-- wp:codecharmer/engagement-model {"bestFor":"A defined outcome","name":"Fixed-scope project","body":"A clear deliverable, timeline, and price. Best when you know what needs building and want certainty."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"An unclear problem","name":"Discovery & architecture","body":"A focused engagement to map the workflow and design the system before committing to a full build."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"A growing platform","name":"Ongoing partnership","body":"A retained team that knows your systems and keeps improving them, without rebuilding the relationship each time."} /-->
<!-- /wp:codecharmer/engagement-models -->

<!-- wp:codecharmer/cta-band {"heading":"Not sure which one you need?","body":"Most engagements start with a conversation about the problem, not the technology. That’s usually enough to point you the right way."} /-->
BLOCKS
	,
);

// ------------------------------------------------------- service pages -- //
foreach ( $cc_services as $cc_slug => $cc_service ) {
	$cc_pages[ 'services/' . $cc_slug ] = array(
		'title'   => $cc_service['name'],
		'order'   => $cc_service['order'],
		'excerpt' => $cc_service['thesis'],
		'content' => $cc_service_page( $cc_service ),
		'meta'    => array(
			'cc_icon'       => $cc_service['icon'],
			'cc_descriptor' => $cc_service['descriptor'],
			'cc_thesis'     => $cc_service['thesis'],
			'cc_caps'       => array_slice( $cc_service['included'], 0, 3 ),
		),
	);
}

// ---------------------------------------------------------------- work -- //
$cc_pages['work'] = array(
	'title'   => 'Work',
	'order'   => 2,
	'excerpt' => 'Praxis, our flagship AI orchestration platform, plus real client projects live in the world: communities, a brand store, and an editorial portfolio.',
	'content' => <<<BLOCKS
<!-- wp:codecharmer/page-hero {"eyebrow":"Selected work","title":"Built, shipped, and live.","intro":"Our flagship product and a sample of client work: brands, communities, and portfolios that had to work as well as they look.","primaryLabel":"Start a project","primaryUrl":"/contact"} /-->

{$cc_flagship_band}

<!-- wp:codecharmer/projects {"variant":"grid","count":0} /-->

<!-- wp:codecharmer/partners /-->

<!-- wp:codecharmer/cta-band {"heading":"Your project could be the next one here.","body":"You’ve seen how we build. Tell us what you’re building. One short conversation is enough to know whether it’s a fit."} /-->
BLOCKS
	,
);

// ------------------------------------------------------------- process -- //
$cc_pages['process'] = array(
	'title'   => 'Process',
	'order'   => 3,
	'excerpt' => 'Seven stages, each one making the next cheaper: discovery, architecture, design, development, testing, launch, growth.',
	'content' => <<<BLOCKS
<!-- wp:codecharmer/page-hero {"tone":"ink","eyebrow":"Process","title":"Architecture before code.","intro":"Seven stages, each one making the next cheaper. It’s deliberately front-loaded: the thinking that happens early is what keeps the whole project on budget.","primaryLabel":"Start a project","primaryUrl":"/contact"} /-->

<!-- wp:codecharmer/process-timeline -->
{$cc_process_stages}
<!-- /wp:codecharmer/process-timeline -->

<!-- wp:codecharmer/beliefs {"heading":"Three things that don’t change.","columns":3} -->
<!-- wp:codecharmer/belief-item {"title":"Architecture before code","body":"The most expensive mistakes are made before the first line is written. We spend the time there."} /-->
<!-- wp:codecharmer/belief-item {"title":"Simplicity beats complexity","body":"The best system is the smallest one that solves the problem. Less to build, less to break, less to maintain."} /-->
<!-- wp:codecharmer/belief-item {"title":"You own the result","body":"We build so your team can run it. The goal is independence, not dependence on us."} /-->
<!-- /wp:codecharmer/beliefs -->

<!-- wp:codecharmer/cta-band {"heading":"Ready to start with discovery?","body":"The first conversation is exactly that: understanding the problem before anyone talks solutions."} /-->
BLOCKS
	,
);

// --------------------------------------------------------------- about -- //
$cc_pages['about'] = array(
	'title'   => 'About',
	'order'   => 4,
	'excerpt' => 'A studio built around a simple idea: the best digital systems are the ones clients own and understand. Engineering philosophy over company history.',
	'content' => <<<BLOCKS
<!-- wp:codecharmer/page-hero {"eyebrow":"About","title":"Engineering, on purpose.","intro":"Too much of the web is built to be sold, not to be run. We build the other kind. This is how we think about it."} /-->

<!-- wp:group {"tagName":"section","className":"section"} -->
<section class="wp-block-group section"><!-- wp:columns {"className":"container manifesto"} -->
<div class="wp-block-columns container manifesto"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"manifesto__lead"} -->
<p class="manifesto__lead">Most agencies optimize for the pitch. We optimize for the <em>two years after launch</em>.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"manifesto__p"} -->
<p class="manifesto__p">The best software is quiet. It does its job, it doesn’t break at renewal season, and the team that owns it understands how it works. That’s harder to build than a demo, and it’s the only thing worth building.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"manifesto__p"} -->
<p class="manifesto__p">AI, WordPress, and custom software aren’t separate practices here. They’re tools for the same job: making a business run better. Most real projects need more than one, which is why we don’t sell them as silos.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"manifesto__p"} -->
<p class="manifesto__p">We measure our work by whether it keeps paying off after we’re gone: architecture that lowers next year’s costs, automation that removes real work, a platform your team can actually run. If it doesn’t do that, it wasn’t worth building.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

<!-- wp:codecharmer/beliefs {"intro":"They’re why clients bring us the projects that matter, and why the results tend to outlast us."} -->
{$cc_beliefs_items}
<!-- /wp:codecharmer/beliefs -->

<!-- wp:codecharmer/cta-band {"heading":"If that sounds like the team you want, let’s talk.","body":"You’ve read how we think. Tell us what you’re trying to build, and we’ll tell you plainly whether we’re the right fit."} /-->
BLOCKS
	,
);

// ------------------------------------------------------------- contact -- //
$cc_pages['contact'] = array(
	'title'   => 'Contact',
	'order'   => 5,
	'excerpt' => "Tell us what you're building. A short, qualifying conversation: no pitch deck, no obligation.",
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"eyebrow":"Contact","title":"Tell us what you’re building.","intro":"A short, qualifying conversation: project type, scope, and budget. No pitch deck, no obligation. We’ll tell you honestly whether we’re the right team."} /-->

<!-- wp:codecharmer/contact-form /-->
BLOCKS
	,
);

// ------------------------------------------------------------- privacy -- //
$cc_pages['privacy'] = array(
	'title'   => 'Privacy',
	'order'   => 6,
	'excerpt' => 'How Code Charmer handles the information you share with us.',
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"eyebrow":"Legal","title":"Privacy.","intro":"How Code Charmer handles the information you share with us. The full policy is being finalized."} /-->

<!-- wp:group {"tagName":"section","className":"section"} -->
<section class="wp-block-group section"><!-- wp:group {"className":"container prose"} -->
<div class="wp-block-group container prose"><!-- wp:paragraph -->
<p>We collect only what you choose to share with us: typically your name, email address, and whatever you tell us about your project through the contact form. We use it to reply to you, and for nothing else.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>We don’t sell your information, we don’t share it with third parties for marketing, and we don’t run invasive analytics. Inquiries are delivered to our inbox and kept only as long as the conversation is useful.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Questions about your data? Email us at codecharmer@codecharmer.io and we’ll answer plainly.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->
BLOCKS
	,
);

// ------------------------------------------------------- work/praxis -- //
$cc_pages['work/praxis'] = array(
	'title'   => 'Praxis',
	'order'   => 0,
	'excerpt' => 'Praxis: an AI-native orchestration layer for digital operations. WordPress connected, AI metered, search in about 90 ms. Our flagship product, live at praxis.codecharmer.io.',
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"tone":"ink","eyebrow":"Praxis · flagship product","title":"The control room for a company’s content.","intro":"An AI-native orchestration layer for digital operations. Praxis connects the systems an organization already runs, starting with WordPress, and adds a canonical content model, metered AI drafting, and enterprise search behind one API.","primaryLabel":"Open the live demo","primaryUrl":"https://praxis.codecharmer.io","note":"v0.2 · The machine drafts, a human approves. Thirteen services on one VPS."} /-->

<!-- wp:codecharmer/value-statement {"lead":"Most platforms ask you to migrate. Praxis <em>connects</em>: WordPress stays where the authors are, the platform holds the canonical model, and AI and search operate on that."} -->
<!-- wp:codecharmer/value-point {"title":"Provenance first","body":"Every item is tagged by origin: WordPress, platform, or an AI draft nobody has reviewed yet. A machine’s draft is never mistaken for a decision."} /-->
<!-- wp:codecharmer/value-point {"title":"AI with a meter","body":"Every generation is costed in integer micro-cents against a budget, with versioned prompts. AI spend is never a surprise."} /-->
<!-- wp:codecharmer/value-point {"title":"Search that keeps up","body":"OpenSearch consumes the platform’s event stream: highlighted full-text in about 90 ms, edge-ngram autocomplete, zero-downtime reindexes."} /-->
<!-- /wp:codecharmer/value-statement -->

<!-- wp:codecharmer/feature-list {"eyebrow":"Shipped and verified","heading":"What it does today, end to end.","intro":"Each capability verified against the live public endpoints, not a demo reel."} -->
<!-- wp:codecharmer/feature-item {"text":"Register, log in, session: RS256 JWTs in httpOnly cookies"} /-->
<!-- wp:codecharmer/feature-item {"text":"AI drafts land in review, metered per generation: the OpenAI provider runs live"} /-->
<!-- wp:codecharmer/feature-item {"text":"Submit → approve or send back, with a written reason: approval is the publish"} /-->
<!-- wp:codecharmer/feature-item {"text":"Every review decision recorded in an audit ledger: who, when, and what they said"} /-->
<!-- wp:codecharmer/feature-item {"text":"WordPress post → webhook → board → searchable, automatically"} /-->
<!-- wp:codecharmer/feature-item {"text":"Full-text search with highlights across every origin"} /-->
<!-- wp:codecharmer/feature-item {"text":"Health endpoint with every dependency reporting green"} /-->
<!-- wp:codecharmer/feature-item {"text":"One-command Docker Compose deploy behind Traefik TLS"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/beliefs {"heading":"Engineering that shows its work.","intro":"The same standards we sell to clients, applied to our own product and documented as it was decided.","columns":4} -->
<!-- wp:codecharmer/belief-item {"title":"A monolith with discipline","body":"Modular monolith with domain-driven layering and architecture tests that enforce the module boundaries. Twelve ADRs record every consequential decision."} /-->
<!-- wp:codecharmer/belief-item {"title":"Events you can trust","body":"Transactional outbox, RabbitMQ topic exchange, CQRS-style read models: the search index can always be rebuilt from the source of truth."} /-->
<!-- wp:codecharmer/belief-item {"title":"Tenancy that can’t leak","body":"Multi-tenant from day one with non-bypassable global-scope isolation, because bolting isolation on later never ends well."} /-->
<!-- wp:codecharmer/belief-item {"title":"Security as a posture","body":"Rotating refresh tokens with reuse detection, HMAC-signed webhooks, breach-checked passwords, stored-XSS prevention."} /-->
<!-- /wp:codecharmer/beliefs -->

<!-- wp:codecharmer/stack {"eyebrow":"Under the hood","heading":"The stack, plainly.","intro":"Chosen for operational honesty: every piece runs today on one 8 GB machine, and every piece scales past it."} -->
<!-- wp:codecharmer/stack-group {"label":"Backend","items":"Laravel\nFrankenPHP\nHorizon\nEloquent\nphp-amqplib\npredis\nopensearch-php\nFlysystem S3"} /-->
<!-- wp:codecharmer/stack-group {"label":"Frontend","items":"Next.js 16 (App Router)\nReact 19 Server Components\nTypeScript (strict)\nTailwind CSS v4\nTanStack Query\nZustand\nZod\nRadix UI"} /-->
<!-- wp:codecharmer/stack-group {"label":"Data · search · messaging","items":"MariaDB\nRedis\nRabbitMQ\nOpenSearch\nMinIO"} /-->
<!-- wp:codecharmer/stack-group {"label":"Infrastructure","items":"Docker Compose\nTraefik\nGitHub Actions\nTurborepo + pnpm\nPrometheus\nGrafana"} /-->
<!-- wp:codecharmer/stack-group {"label":"AI","items":"OpenAI API behind a provider port\nInteger micro-cent cost metering\nPrompt versioning"} /-->
<!-- wp:codecharmer/stack-group {"label":"API · contract","items":"OpenAPI 3.1 as source of truth\nGenerated TS types + CI drift gate\nRFC 9457 Problem Details\nHMAC-signed webhooks"} /-->
<!-- wp:codecharmer/stack-group {"label":"Quality","items":"Pest / PHPUnit\nPHPStan level 6\nLaravel Pint\nVitest + Testing Library\nESLint\nArchitecture tests"} /-->
<!-- /wp:codecharmer/stack -->

<!-- wp:codecharmer/changelog {"heading":"Release by release.","intro":"Semantic versions, Keep-a-Changelog format, and the bugs admitted alongside the features: the way a changelog should read."} -->
<!-- wp:codecharmer/changelog-entry {"version":"v0.2.0","date":"2026-07-30","title":"Review, and real AI.","summary":"Content now moves through an explicit approval step before it can publish, and the OpenAI provider runs live: production-tested, no longer leaning on the deterministic fake outside development.","items":"Review & approval workflow: nothing reaches WordPress without a person saying yes; approving is the publish, and every decision lands in a review ledger\nA review queue: anything awaiting a decision surfaces as the highest-acuity obligation, with an In-review filter\nAI drafts open their own review: “a model wrote this and nobody has checked it” is an explicit, surfaced state\nThe OpenAI provider tested against a faked HTTP client: every error mapping covered with no key and no network\nFixed: the AI cost table read ten times too high, corrected against real pricing and re-pinned in the tests"} /-->
<!-- wp:codecharmer/changelog-entry {"version":"v0.1.0","date":"2026-07-28","title":"Foundation.","summary":"The complete walking skeleton, deployable to a single VPS with docker compose: authenticate, generate with AI, sync WordPress, search it, observe the system.","items":"Identity and multi-tenancy: RS256 cookies, rotating refresh tokens with reuse detection, non-bypassable organization scoping from the first migration\nCanonical content model with WordPress as an authoring adapter behind a repository port: signed webhooks, hash-based drift detection\nAI gateway with integer-precise cost metering, per-organization daily budgets, and prompt versioning\nOpenSearch as a rebuildable read model: outbox → RabbitMQ → indexer, edge-ngram type-ahead, alias-swap reindexes\nObservability, contract-first OpenAPI 3.1 types with a CI drift gate, and twelve Architecture Decision Records"} /-->
<!-- /wp:codecharmer/changelog -->

<!-- wp:codecharmer/demo-access {"heading":"Walk the board yourself.","intro":"A demo organization with clearly labelled demonstration content, including an AI draft sitting in review, exactly as an operations lead would find it.","url":"https://praxis.codecharmer.io","email":"demo@praxis.codecharmer.io","password":"ward-board-praxis-2026","note":"Shared demo credentials for a sandbox organization. It is reset from time to time, so anything you add may disappear."} /-->

<!-- wp:codecharmer/faq {"heading":"Straight answers."} -->
<!-- wp:codecharmer/faq-item {"question":"Why put WordPress under an AI platform?","answer":"Because organizations have years of content and workflow there. Praxis treats WordPress as an authoring adapter behind a port: the canonical model lives in the platform, so AI and search never depend on any one CMS’s schema. That decision is written down as ADR 0002."} /-->
<!-- wp:codecharmer/faq-item {"question":"Is the RAG / embeddings layer live?","answer":"Not yet, and we won’t claim it before it ships. The architecture reserves the seams (provider ports, a vector-search slot); v0.2 spent its effort on the review workflow and hardening the live OpenAI provider instead. Everything listed on this page is verified against the live endpoints."} /-->
<!-- wp:codecharmer/faq-item {"question":"Can it really run a company’s content operation?","answer":"It’s a foundation, not a finished ops suite. What it proves is the hard part: the event-driven spine, tenant isolation, cost metering, CMS integration. And as of v0.2, an approval workflow where a human decision gates every publish."} /-->
<!-- /wp:codecharmer/faq -->

<!-- wp:codecharmer/cta-band {"heading":"Want a platform with this kind of spine?","body":"Praxis is how we build when nobody is constraining us. A short conversation is usually enough to see whether your project deserves the same treatment."} /-->
BLOCKS
	,
);

// -------------------------------------------------------- work/gramo -- //
$cc_pages['work/gramo'] = array(
	'title'   => 'Gramo Café',
	'order'   => 1,
	'excerpt' => 'Gramo Café: a bilingual headless WordPress + Gatsby build for a specialty coffee brand with eight cafés. Block-composed editing, pay-on-delivery commerce, SMS-driven operations.',
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"tone":"ink","eyebrow":"Case study · Gramo Café","title":"Quiet luxury, engineered underneath.","intro":"Gramo is a specialty coffee brand from Cuernavaca with eight cafés across two cities. Its digital home is a bilingual, statically rendered storefront with WordPress behind it: every page composed from custom blocks, every order and inquiry reaching staff by SMS.","primaryLabel":"Visit gramo.cafe","primaryUrl":"https://gramo.cafe","note":"es-MX / EN · headless WordPress + Gatsby · WooCommerce, pay on delivery"} /-->

<!-- wp:codecharmer/value-statement {"lead":"The brand register is quiet luxury. The engineering underneath is anything but quiet: <em>editors own every word</em>, and the storefront ships as static pages."} -->
<!-- wp:codecharmer/value-point {"title":"Blocks in, React out","body":"Pages are composed from a curated set of custom Gutenberg blocks and rendered through a block→React map. Editors compose in WordPress; Gatsby ships static, fast, safe pages."} /-->
<!-- wp:codecharmer/value-point {"title":"Bilingual by structure","body":"Spanish and English live as linked translation pairs on every content surface. A missing translation is omitted, never silently swapped for the other language."} /-->
<!-- wp:codecharmer/value-point {"title":"Commerce that fits the counter","body":"WooCommerce in MXN with pay-on-delivery, and Twilio SMS alerts so orders and inquiries reach staff where they actually work: on their phones."} /-->
<!-- /wp:codecharmer/value-statement -->

<!-- wp:codecharmer/feature-list {"eyebrow":"Shipped","heading":"What the platform carries.","intro":"Thirteen page types in two languages, and the structured content behind them, all editable from WordPress by non-technical staff."} -->
<!-- wp:codecharmer/feature-item {"text":"Coffees with origin, roast, tasting notes and brew guidance"} /-->
<!-- wp:codecharmer/feature-item {"text":"Eight café locations with hours, amenities, maps and galleries"} /-->
<!-- wp:codecharmer/feature-item {"text":"Menu with prices, journal, team, testimonials and events"} /-->
<!-- wp:codecharmer/feature-item {"text":"Pay-on-delivery checkout in MXN through WooCommerce"} /-->
<!-- wp:codecharmer/feature-item {"text":"Subscription and wholesale inquiry pipelines"} /-->
<!-- wp:codecharmer/feature-item {"text":"A careers flow with a real CV pipeline"} /-->
<!-- wp:codecharmer/feature-item {"text":"Twilio SMS / WhatsApp alerts for orders and inquiries"} /-->
<!-- wp:codecharmer/feature-item {"text":"Idempotent content seeding: wp gramo install"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/beliefs {"heading":"Engineering that shows its work.","intro":"Gramo is where our commerce engine methodology lives: the documented engine-versus-brand split our WordPress builds share.","columns":4} -->
<!-- wp:codecharmer/belief-item {"title":"Plugin decides, theme presents","body":"All business logic lives in the gramo-core plugin: CPTs, blocks, GraphQL, ordering, SMS, SEO. The theme is a minimal admin shell; the public frontend is Gatsby."} /-->
<!-- wp:codecharmer/belief-item {"title":"Content seeded from code","body":"One idempotent command installs pages, products, locations and translations. The brand layer is data files; re-running never destroys an editor’s work."} /-->
<!-- wp:codecharmer/belief-item {"title":"The contract is GraphQL","body":"WPGraphQL feeds static builds, and publishing content triggers a frontend rebuild automatically. Editors never think about deploys."} /-->
<!-- wp:codecharmer/belief-item {"title":"Performance in the brief","body":"Lighthouse-100 targets, WCAG AA contrast, reduced-motion support. Written into the product record, not bolted on."} /-->
<!-- /wp:codecharmer/beliefs -->

<!-- wp:codecharmer/stack {"eyebrow":"Under the hood","heading":"The stack, plainly."} -->
<!-- wp:codecharmer/stack-group {"label":"Frontend","items":"Gatsby 5\nReact\nTypeScript\nSCSS Modules\nGSAP (sparing)"} /-->
<!-- wp:codecharmer/stack-group {"label":"Backend","items":"Headless WordPress\nWPGraphQL\nWooCommerce (COD, MXN)\ngramo-core plugin\nCustom meta boxes (no ACF)"} /-->
<!-- wp:codecharmer/stack-group {"label":"Operations","items":"Twilio SMS / WhatsApp\nInquiry pipelines\nAdmin ops dashboard\nProduction calendar\nReports"} /-->
<!-- wp:codecharmer/stack-group {"label":"Quality","items":"PHPCS (WordPress-Core + Extra)\nPHPStan level 6\nJS + SCSS linting\nCI on every push"} /-->
<!-- wp:codecharmer/stack-group {"label":"Infrastructure","items":"GitHub Actions\nwp-env local\ncPanel VPS\nScoped rsync deploys\nContent-triggered rebuilds"} /-->
<!-- /wp:codecharmer/stack -->

<!-- wp:codecharmer/faq {"heading":"Straight answers."} -->
<!-- wp:codecharmer/faq-item {"question":"Why headless here?","answer":"The brand demanded total design control and speed: a quiet-luxury register that no theme could deliver. Headless keeps WordPress for the editors and gives the storefront to a static frontend that hits performance targets by construction."} /-->
<!-- wp:codecharmer/faq-item {"question":"Why pay-on-delivery?","answer":"Because that’s how this market buys at launch. Card payments, gift cards and loyalty are architected-for, deliberately not built yet. The checkout doesn’t block them, and we don’t claim them."} /-->
<!-- wp:codecharmer/faq-item {"question":"Can the café’s staff really run it?","answer":"That’s the point of the build. Every page is composed from blocks in WordPress, structured content uses purpose-built meta boxes, and publishing triggers the rebuild. No developer in the loop for content."} /-->
<!-- /wp:codecharmer/faq -->

<!-- wp:codecharmer/cta-band {"heading":"Want a brand site with this much under the hood?","body":"Tell us what you’re building and the standard it has to meet. One conversation is enough to know whether we’re the right team."} /-->
BLOCKS
	,
);

return $cc_pages;
