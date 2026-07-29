<?php
/**
 * Brand layer: every page as Gutenberg block grammar.
 *
 * Keyed by seed slug; children use "parent/child" keys and are created after
 * their parents. All copy is verbatim from the original build. Excerpts feed
 * the meta description tags.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$cc_process_stages = <<<'BLOCKS'
<!-- wp:codecharmer/process-stage {"name":"Discovery","weight":3.6,"body":"Understand the business, the users, and the real problem before proposing anything. We ask more questions than most agencies do — it’s cheaper than building the wrong thing.","deliverable":"A shared understanding of the problem and what success looks like."} /-->
<!-- wp:codecharmer/process-stage {"name":"Architecture","weight":4.4,"body":"Design the system — data, structure, and integrations — so everything downstream is cheaper. This is where the biggest costs are won or lost.","deliverable":"A system design and a plan you can budget against."} /-->
<!-- wp:codecharmer/process-stage {"name":"Design","weight":2.8,"body":"Interface and experience that serve the workflow and the brand, not decoration. Every screen earns its place.","deliverable":"Interfaces and flows, ready to build."} /-->
<!-- wp:codecharmer/process-stage {"name":"Development","weight":2.2,"body":"Production-grade engineering: maintainable, accessible, and fast by default. Tested as it’s written, not bolted on at the end.","deliverable":"Working software you can actually read and extend."} /-->
<!-- wp:codecharmer/process-stage {"name":"Testing","weight":1.5,"body":"Verify against real conditions and edge cases before anything ships. Empty states, error states, the messy middle — all of it.","deliverable":"Confidence it holds up under real use."} /-->
<!-- wp:codecharmer/process-stage {"name":"Launch","weight":1.1,"body":"Deploy with confidence, hand over the keys, and make sure the team can drive. Documentation and workflows included.","deliverable":"A live platform and a team that can run it."} /-->
<!-- wp:codecharmer/process-stage {"name":"Growth","weight":1.4,"body":"Measure, iterate, and extend — the platform compounds instead of stalling. We stay as long as we’re adding value, and no longer.","deliverable":"A roadmap and the data to prioritize it."} /-->
BLOCKS;

$cc_beliefs_items = <<<'BLOCKS'
<!-- wp:codecharmer/belief-item {"title":"AI should solve real business problems","body":"Not a demo bolted onto a homepage. Automation earns its place by removing manual work and creating leverage."} /-->
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
				'body'    => "Tell us what you're trying to do. A short conversation is usually enough to know whether we're the right team.",
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
		'descriptor' => 'Prepare the business for AI — not just bolt features onto it.',
		'thesis'     => 'AI-ready architecture, knowledge organization, and data structure that make intelligent automation possible.',
		'problem'    => 'Most AI projects start with a tool and go looking for a use. That’s backwards — and expensive.',
		'included'   => array( 'AI-ready architecture', 'Knowledge organization', 'Data structure & modeling', 'Internal workflow mapping', 'AI integration planning', 'Automation strategy' ),
		'approach'   => array(
			array( 'Map the real workflows', 'Find where time and money actually go before proposing any technology.' ),
			array( 'Organize the knowledge', 'Structure the data and documents AI needs to be useful and reliable.' ),
			array( 'Design the architecture', 'Integrations, guardrails, and a path to scale — built to last, not to demo.' ),
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
		'thesis'     => 'Custom themes, Gutenberg block development, performance, and security built to last — WordPress as an asset, not a burden.',
		'problem'    => 'Off-the-shelf WordPress becomes technical debt the moment your needs outgrow the theme.',
		'included'   => array( 'Custom theme development', 'Gutenberg block development', 'ACF & structured content', 'Headless / API solutions', 'Performance & Core Web Vitals', 'Accessibility', 'SEO foundations', 'Security & maintainability', 'Editorial workflows' ),
		'approach'   => array(
			array( 'Architect the content model', 'Design the blocks and fields your team will actually edit, day to day.' ),
			array( 'Engineer the theme', 'Fast, accessible, and maintainable by default — not bolted on at the end.' ),
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
		'thesis'     => 'Internal dashboards, portals, APIs, and integrations that remove manual work and give teams leverage.',
		'problem'    => 'When the business runs on five disconnected tools and a lot of spreadsheets, the software is the bottleneck.',
		'included'   => array( 'Internal dashboards', 'Business portals', 'CRM integrations', 'APIs & integrations', 'Process automation', 'Membership systems', 'Booking systems', 'Custom applications' ),
		'approach'   => array(
			array( 'Understand the operation', 'The real workflow, not the org chart — where the friction actually lives.' ),
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
		'descriptor' => 'Practical automation with measurable outcomes — not hype.',
		'thesis'     => 'Content workflows, internal assistants, retrieval systems, and process automation that pay for themselves.',
		'problem'    => 'Most “AI automation” is a demo. The value is in the unglamorous, repetitive work it quietly removes.',
		'included'   => array( 'Content workflows', 'Internal assistants', 'Customer support automation', 'Business process automation', 'AI integrations', 'Retrieval systems (RAG)', 'AI-powered search' ),
		'approach'   => array(
			array( 'Find the repetitive work', 'The tasks that eat hours and add no human judgment — those come first.' ),
			array( 'Build the automation', 'Reliable and observable, with a human in the loop wherever it matters.' ),
			array( 'Measure the payoff', 'Hours saved, errors avoided, throughput gained — automation should pay for itself.' ),
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
<!-- wp:codecharmer/value-point {"title":"Revenue, not just presence","body":"Sites and tools designed to convert, automate, and compound — not just look the part."} /-->
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
<!-- wp:codecharmer/page-hero {"eyebrow":"Services","title":"Systems, not features.","intro":"Four disciplines — AI strategy, WordPress engineering, custom software, and automation — engineered to work as one system. Most projects touch more than one.","primaryLabel":"Book a consultation","primaryUrl":"/contact","secondaryLabel":"See our work","secondaryUrl":"/work"} /-->

<!-- wp:codecharmer/services-showcase /-->

<!-- wp:codecharmer/process-teaser {"tone":"ink"} -->
{$cc_process_stages}
<!-- /wp:codecharmer/process-teaser -->

<!-- wp:codecharmer/engagement-models -->
<!-- wp:codecharmer/engagement-model {"bestFor":"A defined outcome","name":"Fixed-scope project","body":"A clear deliverable, timeline, and price. Best when you know what needs building and want certainty."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"An unclear problem","name":"Discovery & architecture","body":"A focused engagement to map the workflow and design the system before committing to a full build."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"A growing platform","name":"Ongoing partnership","body":"A retained team that knows your systems and keeps improving them — without rebuilding the relationship each time."} /-->
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
	'excerpt' => 'Real projects, live in the world: capoeira communities, an apparel brand, and an editorial portfolio — plus the platforms and teams we work with.',
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"eyebrow":"Selected work","title":"Built, shipped, and live.","intro":"A sample of what we’ve put into the world — brands, communities, and portfolios that had to work as well as they look.","primaryLabel":"Start a project","primaryUrl":"/contact"} /-->

<!-- wp:codecharmer/projects {"variant":"grid","count":0} /-->

<!-- wp:codecharmer/partners /-->

<!-- wp:codecharmer/cta-band {"heading":"Your project could be the next one here.","body":"Tell us what you’re building. A short conversation is usually enough to know whether we’re the right team."} /-->
BLOCKS
	,
);

// ------------------------------------------------------------- process -- //
$cc_pages['process'] = array(
	'title'   => 'Process',
	'order'   => 3,
	'excerpt' => 'Seven stages, each one making the next cheaper: discovery, architecture, design, development, testing, launch, growth.',
	'content' => <<<BLOCKS
<!-- wp:codecharmer/page-hero {"tone":"ink","eyebrow":"Process","title":"Architecture before code.","intro":"Seven stages, each one making the next cheaper. It’s deliberately front-loaded — the thinking that happens early is what keeps the whole project on budget.","primaryLabel":"Start a project","primaryUrl":"/contact"} /-->

<!-- wp:codecharmer/process-timeline -->
{$cc_process_stages}
<!-- /wp:codecharmer/process-timeline -->

<!-- wp:codecharmer/beliefs {"heading":"Three things that don’t change.","columns":3} -->
<!-- wp:codecharmer/belief-item {"title":"Architecture before code","body":"The most expensive mistakes are made before the first line is written. We spend the time there."} /-->
<!-- wp:codecharmer/belief-item {"title":"Simplicity beats complexity","body":"The best system is the smallest one that solves the problem. Less to build, less to break, less to maintain."} /-->
<!-- wp:codecharmer/belief-item {"title":"You own the result","body":"We build so your team can run it. The goal is leverage, not a dependency on us."} /-->
<!-- /wp:codecharmer/beliefs -->

<!-- wp:codecharmer/cta-band {"heading":"Ready to start with discovery?","body":"The first conversation is exactly that — understanding the problem before anyone talks solutions."} /-->
BLOCKS
	,
);

// --------------------------------------------------------------- about -- //
$cc_pages['about'] = array(
	'title'   => 'About',
	'order'   => 4,
	'excerpt' => 'A studio built around a simple idea: the best digital systems are the ones clients own and understand. Engineering philosophy over company history.',
	'content' => <<<BLOCKS
<!-- wp:codecharmer/page-hero {"eyebrow":"About","title":"Engineering, on purpose.","intro":"Too much of the web is built to be sold, not to be run. We build the other kind — and this is how we think about it."} /-->

<!-- wp:group {"tagName":"section","className":"section"} -->
<section class="wp-block-group section"><!-- wp:columns {"className":"container manifesto"} -->
<div class="wp-block-columns container manifesto"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"manifesto__lead"} -->
<p class="manifesto__lead">Most agencies optimize for the pitch. We optimize for the <em>two years after launch</em>.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:paragraph {"className":"manifesto__p"} -->
<p class="manifesto__p">The best software is quiet. It does its job, it doesn’t break at renewal season, and the team that owns it understands how it works. That’s harder to build than a demo — and it’s the only thing worth building.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"manifesto__p"} -->
<p class="manifesto__p">AI, WordPress, and custom software aren’t separate practices here. They’re tools for the same job: making a business run better. Most real projects need more than one, which is why we don’t sell them as silos.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"manifesto__p"} -->
<p class="manifesto__p">We measure our work by whether it keeps paying off after we’re gone — architecture that lowers next year’s costs, automation that removes real work, a platform your team can actually run. If it doesn’t do that, it wasn’t worth building.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></section>
<!-- /wp:group -->

<!-- wp:codecharmer/beliefs {"intro":"They’re why clients bring us the projects that matter, and why the results tend to outlast us."} -->
{$cc_beliefs_items}
<!-- /wp:codecharmer/beliefs -->

<!-- wp:codecharmer/cta-band {"heading":"If that sounds like the team you want, let’s talk.","body":"Tell us what you’re trying to build. A short conversation is usually enough to know whether we’re the right fit."} /-->
BLOCKS
	,
);

// ------------------------------------------------------------- contact -- //
$cc_pages['contact'] = array(
	'title'   => 'Contact',
	'order'   => 5,
	'excerpt' => "Tell us what you're building. A short, qualifying conversation — no pitch deck, no obligation.",
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"eyebrow":"Contact","title":"Tell us what you’re building.","intro":"A short, qualifying conversation — project type, scope, and budget. No pitch deck, no obligation. We’ll tell you honestly whether we’re the right team."} /-->

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
<p>We collect only what you choose to share with us — typically your name, email address, and whatever you tell us about your project through the contact form. We use it to reply to you, and for nothing else.</p>
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

return $cc_pages;
