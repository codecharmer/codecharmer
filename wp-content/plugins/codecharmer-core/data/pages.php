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
				'primaryLabel'   => 'Describe your project',
				'primaryUrl'     => '/contact',
				'secondaryLabel' => 'See our work',
				'secondaryUrl'   => '/work',
				'note'           => $service['price'],
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

	$parts = array( $hero, $features, $approach, '<!-- wp:codecharmer/proof /-->' );
	if ( ! empty( $service['extra'] ) ) {
		$parts[] = (string) $service['extra'];
	}
	$parts[] = $faq;
	$parts[] = $cta;

	return implode( "\n\n", $parts );
};

$cc_services = array(
	'ai-strategy'      => array(
		'order'           => 1,
		'name'            => 'AI Strategy & Architecture',
		'price'           => 'Strategy sprints run US$7,500 – 15,000 · A US$2,500 audit maps the opportunity first',
		'seo_title'       => 'Practical AI Strategy & Architecture for WordPress Operations | Code Charmer',
		'seo_description' => 'AI-ready architecture, knowledge organization, and data structure that make intelligent automation possible. Practical strategy, not a demo bolted onto a homepage.',
		'icon'            => 'architecture',
		'descriptor'      => 'Prepare the business for AI, not just bolt features onto it.',
		'thesis'          => 'AI-ready architecture, knowledge organization, and data structure that make intelligent automation possible.',
		'problem'         => 'Most AI projects start with a tool and go looking for a use. That’s backwards, and expensive.',
		'cta'             => 'Tell us where the hours actually go. A short conversation is usually enough to see whether AI has a real job to do in your business.',
		'included'        => array( 'AI-ready architecture', 'Knowledge organization', 'Data structure & modeling', 'Internal workflow mapping', 'AI integration planning', 'Automation strategy' ),
		'approach'        => array(
			array( 'Map the real workflows', 'Find where time and money actually go before proposing any technology.' ),
			array( 'Organize the knowledge', 'Structure the data and documents AI needs to be useful and reliable.' ),
			array( 'Design the architecture', 'Integrations, guardrails, and a path to scale: built to last, not to demo.' ),
		),
		'faq'             => array(
			array( 'Do we even need AI?', 'Sometimes the honest answer is no, and we’ll tell you. AI earns its place only by removing real work.' ),
			array( 'Isn’t our data too messy for this?', 'That messiness is exactly the work. Organizing knowledge so AI has something reliable to stand on is most of the value.' ),
		),
	),
	'wordpress'        => array(
		'order'           => 2,
		'name'            => 'Custom WordPress Platforms',
		'price'           => 'Implementations start at US$25,000 · typical range US$25k – 75k',
		'seo_title'       => 'Custom WordPress Platform Development | Code Charmer',
		'seo_description' => 'Custom themes, Gutenberg blocks, integrations, performance, and security engineered to last: WordPress as a business platform, not technical debt.',
		'icon'            => 'blocks',
		'descriptor'      => 'WordPress engineered as a business platform, not a theme.',
		'thesis'          => 'Custom themes, Gutenberg block development, integrations, performance, and security built to last: WordPress as a platform your team runs.',
		'problem'         => 'Off-the-shelf WordPress becomes technical debt the moment your needs outgrow the theme.',
		'cta'             => 'Tell us what your site should be doing for you. A short conversation is usually enough to know what to keep, refactor, or rebuild.',
		'included'        => array( 'Custom theme development', 'Gutenberg block development', 'ACF & structured content', 'Headless / API solutions', 'Performance & Core Web Vitals', 'Accessibility', 'SEO foundations', 'Security & maintainability', 'Editorial workflows' ),
		'approach'        => array(
			array( 'Architect the content model', 'Design the blocks and fields your team will actually edit, day to day.' ),
			array( 'Engineer the theme', 'Fast, accessible, and maintainable by default, not bolted on at the end.' ),
			array( 'Hand over the keys', 'Documentation and editorial workflows your team owns without depending on us.' ),
		),
		'faq'             => array(
			array( 'Can you work with our existing site?', 'Usually yes. We audit first, then decide together what to keep, refactor, or rebuild.' ),
			array( 'Will our team be able to manage it?', 'That’s the whole point. We build editing experiences your team controls, so you’re never locked in.' ),
		),
	),
	'custom-software'  => array(
		'order'           => 3,
		'name'            => 'Custom Software & Integrations',
		'price'           => 'Projects start at US$25,000 · complex operations platforms from US$60,000',
		'seo_title'       => 'Custom Software & System Integrations | Code Charmer',
		'seo_description' => 'Internal dashboards, portals, APIs, and integrations that remove manual work and connect the tools your business already runs on.',
		'icon'            => 'terminal',
		'descriptor'      => 'Software that improves how the business actually operates.',
		'thesis'          => 'Internal dashboards, portals, APIs, and integrations that remove manual work and let a small team operate like a bigger one.',
		'problem'         => 'When the business runs on five disconnected tools and a lot of spreadsheets, the software is the bottleneck.',
		'cta'             => 'Tell us how the work actually flows. A short conversation is usually enough to see where software would remove the friction.',
		'included'        => array( 'Internal dashboards', 'Business portals', 'CRM integrations', 'APIs & integrations', 'Process automation', 'Membership systems', 'Booking systems', 'Custom applications' ),
		'approach'        => array(
			array( 'Understand the operation', 'The real workflow, not the org chart. That’s where the friction actually lives.' ),
			array( 'Design the system', 'Data, integrations, and an interface that serves the work instead of fighting it.' ),
			array( 'Build and integrate', 'Production software that connects the tools you already rely on.' ),
		),
		'faq'             => array(
			array( 'Do we have to replace our current tools?', 'Rarely. We integrate with what works and replace only what’s genuinely holding you back.' ),
			array( 'How do we avoid another system nobody uses?', 'By designing around the actual workflow. Adoption is a design problem, not a training problem.' ),
		),
	),
	'content-workflow' => array(
		'order'           => 5,
		'name'            => 'Content Workflow Automation',
		'price'           => 'Praxis pilots: setup US$10k – 25k + US$1.5k – 5k/month · custom builds from US$25,000',
		'seo_title'       => 'Content Workflow Automation for WordPress | Code Charmer',
		'seo_description' => 'Editorial workflow, AI-assisted drafting with human approval, provenance, and enterprise search built around the WordPress your team already runs. Proven on Praxis.',
		'icon'            => 'spark',
		'descriptor'      => 'Editorial pipelines with AI drafting and human approval.',
		'thesis'          => 'Editorial workflow, AI-assisted drafting with human approval, provenance, and enterprise search built around the WordPress your team already runs.',
		'problem'         => 'Content operations drown in handoffs long before they run out of ideas.',
		'cta'             => 'Tell us how content actually moves through your team. A short conversation is usually enough to see which handoffs a workflow system would remove.',
		'included'        => array( 'Editorial workflow design', 'AI drafting with human approval', 'Content provenance & audit trails', 'Enterprise search over your content', 'Approval & review systems', 'Multi-channel publishing', 'Managed Praxis pilots' ),
		'approach'        => array(
			array( 'Map the editorial flow', 'Who writes, who approves, where items wait, and which handoffs add nothing but delay.' ),
			array( 'Build the approval spine first', 'Review states, provenance, and audit trails before any AI drafts a word. Discipline first, speed second.' ),
			array( 'Add the machine, metered', 'AI drafting with budgets, versioned prompts, and a human yes gating every publish.' ),
		),
		'faq'             => array(
			array( 'Is this just Praxis?', 'Praxis is the proof and often the fastest path: a managed pilot on our platform. When your operation needs something bespoke, we build it with the same patterns, on your infrastructure, owned by you.' ),
			array( 'Will AI write our content?', 'It will draft, when that helps. Nothing publishes without a person approving it, every draft is labeled as machine-drafted until reviewed, and every generation is metered. The discipline is the product; the drafting is a feature.' ),
		),
		'extra'           => $cc_flagship_band,
	),
	'ai-automation'    => array(
		'order'           => 4,
		'name'            => 'WordPress Workflow Automation',
		'price'           => 'Automation projects start at US$25,000 · a US$2,500 audit maps the opportunity first',
		'seo_title'       => 'WordPress Workflow Automation Services | Code Charmer',
		'seo_description' => 'Content workflows, internal assistants, retrieval systems, and process automation for WordPress operations: practical automation that pays for itself.',
		'icon'            => 'flow',
		'descriptor'      => 'Practical automation with measurable outcomes, not hype.',
		'thesis'          => 'Content workflows, internal assistants, retrieval systems, and process automation around WordPress that pay for themselves.',
		'problem'         => 'Most “AI automation” is a demo. The value is in the unglamorous, repetitive work it quietly removes.',
		'cta'             => 'Tell us which tasks eat your team’s hours. A short conversation is usually enough to see what automation would give back.',
		'included'        => array( 'Content workflows', 'Internal assistants', 'Customer support automation', 'Business process automation', 'AI integrations', 'Retrieval systems (RAG)', 'AI-powered search' ),
		'approach'        => array(
			array( 'Find the repetitive work', 'The tasks that eat hours and add no human judgment come first.' ),
			array( 'Build the automation', 'Reliable and observable, with a human in the loop wherever it matters.' ),
			array( 'Measure the payoff', 'Hours saved, errors avoided, throughput gained: automation should pay for itself.' ),
		),
		'faq'             => array(
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
	'meta'    => array(
		'cc_seo_title'       => 'WordPress Automation & Custom Platforms | Code Charmer',
		'cc_seo_description' => 'Code Charmer fixes and automates complex WordPress operations: connecting content, commerce, customer data, and internal workflows in systems your team owns.',
	),
	'content' => <<<BLOCKS
<!-- wp:codecharmer/hero /-->

<!-- OWNER INPUT REQUIRED: replace or extend these stats with stronger verified numbers (client metrics, years in practice) once confirmed. Every value below is already published elsewhere on this site. -->
<!-- wp:codecharmer/stats -->
<!-- wp:codecharmer/stat {"value":"7","label":"client platforms live in production","note":"every one linked from the work page"} /-->
<!-- wp:codecharmer/stat {"value":"~90 ms","label":"full-text search response on Praxis","note":"measured on the live demo"} /-->
<!-- wp:codecharmer/stat {"value":"3","label":"surfaces on one bakery engine: web, app, POS","note":"Pacífica Panadería case study"} /-->
<!-- wp:codecharmer/stat {"value":"2","label":"brands running the same commerce engine","note":"Pacífica and Haramara"} /-->
<!-- /wp:codecharmer/stats -->

<!-- wp:codecharmer/value-statement {"lead":"Your team shouldn’t need five tools and a spreadsheet to <em>publish, sell, or serve a customer</em>."} -->
<!-- wp:codecharmer/value-point {"title":"Publishing takes a project manager","body":"Content crawls through copy-paste, approvals live in chat threads, and nobody can say what’s stuck where."} /-->
<!-- wp:codecharmer/value-point {"title":"Systems that don’t talk","body":"Orders, customers, and content sit in tools that never agree, so someone reconciles them by hand."} /-->
<!-- wp:codecharmer/value-point {"title":"Manual work nobody chose","body":"Staff re-type data between systems because the integration was never built. Hours leak out quietly, every week."} /-->
<!-- /wp:codecharmer/value-statement -->

{$cc_flagship_band}

<!-- wp:codecharmer/services-grid {"eyebrow":"What we do about it","heading":"Three ways in, one system out.","intro":"WordPress platforms, workflow automation, and the custom software that connects them. Most engagements touch more than one, because the problem usually does."} /-->

<!-- wp:codecharmer/proof {"eyebrow":"The fixed first step","heading":"A WordPress Operations & Automation Audit.","intro":"Ten business days. A workflow map, technical findings, ranked opportunities, and a 90-day implementation plan you own either way. Starts at US$2,500, with scope and timeline fixed before payment.","ctaLabel":"Request the audit","ctaUrl":"/wordpress-operations-audit"} /-->

<!-- wp:codecharmer/projects /-->

<!-- wp:codecharmer/process-teaser -->
{$cc_process_stages}
<!-- /wp:codecharmer/process-teaser -->

<!-- OWNER INPUT REQUIRED: named, permissioned client testimonial (quote, name, role, company). The block renders nothing until the quote attribute is filled. -->
<!-- wp:codecharmer/testimonial /-->

<!-- OWNER INPUT REQUIRED: people/accountability section (founder name, photo, relevant track record, working model). Do not publish this section without real identity content. -->

<!-- wp:codecharmer/faq {"heading":"Straight answers."} -->
<!-- wp:codecharmer/faq-item {"question":"What does an engagement cost?","answer":"The audit starts at US$2,500. Implementations start at US$25,000, with most falling between US$25k and US$75k. Ongoing optimization starts at US$2,500 a month. Full ranges are on the pricing page."} /-->
<!-- wp:codecharmer/faq-item {"question":"How long does it take?","answer":"The audit takes 10 business days from access and kickoff. Implementations typically run 6 to 16 weeks depending on scope, and you get a timeline before anything is signed."} /-->
<!-- wp:codecharmer/faq-item {"question":"Can you work with our existing WordPress site?","answer":"Usually, yes. The audit tells us, and you, what is worth keeping, refactoring, or replacing. We don’t rebuild for the sake of it."} /-->
<!-- wp:codecharmer/faq-item {"question":"Who owns the work?","answer":"You do. Code, content, infrastructure, documentation: everything is handed over, and the audit findings are yours whether or not we implement them."} /-->
<!-- wp:codecharmer/faq-item {"question":"What happens after launch?","answer":"Optimization and support retainers start at US$2,500 a month, with monitoring, improvements, and a roadmap. Or your team runs it alone: that is exactly what the handoff is for."} /-->
<!-- /wp:codecharmer/faq -->

<!-- wp:codecharmer/cta-band {"heading":"Find out what WordPress is costing you.","body":"The audit starts at US$2,500, takes ten business days, and ends in a plan you own either way. The next step costs a form and nothing else.","primaryLabel":"Request an operations audit","primaryUrl":"/wordpress-operations-audit","secondaryLabel":"See the pricing","secondaryUrl":"/pricing"} /-->
BLOCKS
	,
);

// ----------------------------------------------------------- solutions -- //
$cc_pages['solutions'] = array(
	'title'   => 'Solutions',
	'order'   => 1,
	'excerpt' => 'Four disciplines engineered to work as one system: custom WordPress platforms, workflow automation, custom software, and practical AI strategy.',
	'meta'    => array(
		'cc_seo_title'       => 'WordPress Engineering & Automation Solutions | Code Charmer',
		'cc_seo_description' => 'Custom WordPress platforms, workflow automation, integrations, and practical AI: four disciplines engineered to work as one system your team owns.',
	),
	'content' => <<<BLOCKS
<!-- wp:codecharmer/page-hero {"eyebrow":"Solutions","title":"Systems, not features.","intro":"Four disciplines engineered to work as one system: custom WordPress platforms, workflow automation, custom software, and practical AI strategy. Most projects touch more than one.","primaryLabel":"Describe your project","primaryUrl":"/contact","secondaryLabel":"See our work","secondaryUrl":"/work"} /-->

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
	$cc_pages[ 'solutions/' . $cc_slug ] = array(
		'title'   => $cc_service['name'],
		'order'   => $cc_service['order'],
		'excerpt' => $cc_service['thesis'],
		'content' => $cc_service_page( $cc_service ),
		'meta'    => array(
			'cc_icon'            => $cc_service['icon'],
			'cc_descriptor'      => $cc_service['descriptor'],
			'cc_thesis'          => $cc_service['thesis'],
			'cc_caps'            => array_slice( $cc_service['included'], 0, 3 ),
			'cc_seo_title'       => $cc_service['seo_title'],
			'cc_seo_description' => $cc_service['seo_description'],
		),
	);
}

// ---------------------------------------------------------------- work -- //
$cc_pages['work'] = array(
	'title'   => 'Work',
	'order'   => 2,
	'excerpt' => 'Praxis, our flagship AI orchestration platform, plus real client projects live in the world: communities, a brand store, and an editorial portfolio.',
	'meta'    => array(
		'cc_seo_title'       => 'WordPress & Automation Case Studies | Code Charmer',
		'cc_seo_description' => 'Live client platforms: commerce and POS operations, bilingual publishing, loyalty systems, and AI content workflows. Real systems, verified in production.',
	),
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
	'meta'    => array(
		'cc_seo_title'       => 'How We Build: Architecture Before Code | Code Charmer',
		'cc_seo_description' => 'Seven stages, each one making the next cheaper: discovery, architecture, design, development, testing, launch, growth. Front-loaded thinking keeps projects on budget.',
	),
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
	'meta'    => array(
		'cc_seo_title'       => 'About the Studio | Code Charmer',
		'cc_seo_description' => 'A digital engineering studio built around a simple idea: the best systems are the ones clients own and understand. How we think, and how we work.',
	),
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

// ------------------------------------------------------------- pricing -- //
$cc_pages['pricing'] = array(
	'title'   => 'Pricing',
	'order'   => 5,
	'excerpt' => 'Starting prices and typical ranges for every Code Charmer engagement: audit, sprint, implementation, custom platforms, and ongoing optimization.',
	'meta'    => array(
		'cc_seo_title'       => 'WordPress Project Pricing & Engagement Models | Code Charmer',
		'cc_seo_description' => 'Starting prices and typical ranges: audits from US$2,500, implementations from US$25,000, optimization retainers from US$2,500 a month. Scope variables explained.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"eyebrow":"Pricing","title":"Know the order of magnitude before you commit.","intro":"Every engagement is scoped around an outcome, but you should know the likely order of magnitude before giving us your time. These are honest starting points and typical ranges, not final quotes.","primaryLabel":"Request an audit","primaryUrl":"/wordpress-operations-audit","secondaryLabel":"Describe your project","secondaryUrl":"/contact"} /-->

<!-- wp:codecharmer/engagement-models {"variant":"pricing","eyebrow":"The offers","heading":"Six engagements, priced in the open.","intro":"Custom work doesn’t have a fixed final price. It does have a knowable shape: here is each engagement, what it starts at, and what moves the number."} -->
<!-- wp:codecharmer/engagement-model {"bestFor":"The fixed first step","name":"WordPress Operations & Automation Audit","price":"Starts at US$2,500","timeframe":"10 business days","body":"An implementation-ready plan showing where WordPress and the systems around it are costing time, money, reliability, or growth: workflow map, technical findings, ranked opportunities, and a 90-day plan.","detail":"Paid upfront. Up to 50% credits toward an implementation of US$25,000+ commissioned within 30 days. You own the findings either way."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"An unclear or risky scope","name":"Workflow & Architecture Sprint","price":"US$7,500 – 15,000","timeframe":"2 – 4 weeks","body":"Validated requirements, prototyped flows, system architecture, and a fixed implementation plan. The de-risking step for complex work.","detail":"Scope variables: number of workflows, systems to integrate, and stakeholders involved."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"The core project","name":"WordPress Platform Implementation","price":"Starts at US$25,000","timeframe":"6 – 16 weeks","body":"A production system tied to agreed operational outcomes: custom blocks, integrations, commerce, editorial workflows, and documented handoff.","detail":"Typical range US$25k – 75k. Commonly 40–50% to start, then milestone payments."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"Multi-system operations","name":"Complex Custom Operations Platform","price":"Starts at US$60,000","timeframe":"12+ weeks","body":"A bespoke platform and integrations for operations that span web, apps, POS, messaging, and internal tools, built on the patterns proven in our case studies.","detail":"Scope variables: surfaces, integrations, data migration, and compliance requirements."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"After launch","name":"Optimization & Support","price":"From US$2,500/month","timeframe":"Ongoing","body":"An SLA, monitoring, continuous improvements, experiments, and roadmap delivery from the team that knows your system.","detail":"Three-month minimum, billed in advance. Cancel with notice after that."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"Content operations at scale","name":"Managed Praxis Pilot","price":"Setup US$10k – 25k + US$1.5k – 5k/month","timeframe":"Pilot-dependent","body":"Governed content orchestration on Praxis for a validated use case: mixed-provenance content, metered AI drafting, human approval, enterprise search.","detail":"A design-partner experiment offered to a small number of organizations, not an off-the-shelf subscription."} /-->
<!-- /wp:codecharmer/engagement-models -->

<!-- wp:group {"tagName":"section","className":"section"} -->
<section class="wp-block-group section"><!-- wp:group {"className":"container prose"} -->
<div class="wp-block-group container prose"><!-- wp:heading -->
<h2 class="wp-block-heading">What moves the price.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The honest variables: how many systems have to talk to each other, how much content or data moves, how many people and roles touch the workflow, the state of what exists today, and how much certainty you need before committing. The audit or sprint pins these down, which is why the bigger numbers come with fixed scopes attached.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">How payment works.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The audit is paid upfront. Projects commonly start at 40–50% with milestone payments after. Retainers are billed in advance on a three-month minimum. Every proposal ties its deliverables to a concrete outcome: revenue enabled, hours saved, errors reduced, cycle time cut, risk reduced, or a capability unlocked. Proposals also say what is not included, so scope stays honest on both sides.</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">When we’re not the right fit.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A brochure site on a template budget, a project with no internal owner, or work with no describable business outcome: other teams serve those needs better and cheaper. If that’s where you are, we’ll say so on the first call and point you somewhere sensible.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:codecharmer/faq {"heading":"Straight answers."} -->
<!-- wp:codecharmer/faq-item {"question":"Why publish prices at all if the work is custom?","answer":"Because you shouldn’t have to book a call to learn whether we’re in your budget. Ranges and starting points are useful; false precision isn’t. The exact number always comes with a fixed scope attached."} /-->
<!-- wp:codecharmer/faq-item {"question":"Do you bill hourly?","answer":"No. Engagements are scoped around outcomes with fixed prices or clear ranges. Hourly billing rewards slowness; we’d rather be accountable to a result."} /-->
<!-- wp:codecharmer/faq-item {"question":"Is the audit ever free?","answer":"No. A short fit call is free; the audit is real diagnostic work with real deliverables. Up to half of it credits toward a qualifying implementation, so it’s a first step, not a toll."} /-->
<!-- wp:codecharmer/faq-item {"question":"What if we just need a small fix?","answer":"Below the audit minimum we’re honestly not the economical choice, and we’ll tell you so. Existing clients on retainers are the exception: small fixes are what the retainer is for."} /-->
<!-- /wp:codecharmer/faq -->

<!-- wp:codecharmer/cta-band {"heading":"Start with the fixed-scope step.","body":"Ten business days, US$2,500, and a plan you own whether or not we build it.","primaryLabel":"Request an operations audit","primaryUrl":"/wordpress-operations-audit"} /-->
BLOCKS
	,
);

// ------------------------------------------- wordpress-operations-audit -- //
// The audit body is shared between the canonical page and the /audit/
// campaign variant, so the two can never drift apart.
$cc_audit_body = <<<'BLOCKS'
<!-- wp:codecharmer/feature-list {"eyebrow":"This is for you if","heading":"The site stopped being a website a while ago.","intro":"The audit fits organizations already running WordPress with real operations on top of it. Any two of these signals usually mean it will pay for itself."} -->
<!-- wp:codecharmer/feature-item {"text":"Multiple editors, locations, languages, or approval stages move through the site every week"} /-->
<!-- wp:codecharmer/feature-item {"text":"Staff re-type or copy-paste data between WordPress and a CRM, spreadsheet, or commerce tool"} /-->
<!-- wp:codecharmer/feature-item {"text":"Publishing takes days because the workflow lives in chat threads and shared docs"} /-->
<!-- wp:codecharmer/feature-item {"text":"Orders, bookings, or leads depend on plugins nobody fully trusts anymore"} /-->
<!-- wp:codecharmer/feature-item {"text":"Every small change needs a developer, and releases feel risky"} /-->
<!-- wp:codecharmer/feature-item {"text":"There’s an AI mandate from above and no concrete plan underneath it"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/feature-list {"eyebrow":"Not a fit if","heading":"We’d rather tell you now than on the call.","intro":"The audit is diagnostic work for operations that already exist. It isn’t the right first step for everyone."} -->
<!-- wp:codecharmer/feature-item {"text":"You need a brochure site: a good template and a designer will serve you better and cheaper"} /-->
<!-- wp:codecharmer/feature-item {"text":"There’s no internal owner who can answer questions and act on the plan"} /-->
<!-- wp:codecharmer/feature-item {"text":"The outcome can’t be described in business terms: time, money, reliability, or capability"} /-->
<!-- wp:codecharmer/feature-item {"text":"You’re looking for free speculative architecture before any commitment"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- OWNER INPUT REQUIRED: link or embed a redacted sample audit deliverable here once one exists. -->
<!-- wp:codecharmer/feature-list {"eyebrow":"Deliverables","heading":"Exactly what you get.","intro":"Every item below is a document you keep, written to be acted on by any competent team, including one that isn’t us."} -->
<!-- wp:codecharmer/feature-item {"text":"A workflow map of how content, commerce, and data actually move through your operation"} /-->
<!-- wp:codecharmer/feature-item {"text":"Technical findings across the platform: architecture, integrations, performance, reliability"} /-->
<!-- wp:codecharmer/feature-item {"text":"Opportunities ranked by estimated impact against effort, with the reasoning shown"} /-->
<!-- wp:codecharmer/feature-item {"text":"An architecture recommendation grounded in what you have, not what we’d like to sell"} /-->
<!-- wp:codecharmer/feature-item {"text":"A 90-day implementation plan you can budget against"} /-->
<!-- wp:codecharmer/feature-item {"text":"A decision call to walk through all of it and answer the hard questions"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/approach {"eyebrow":"The ten days","heading":"A fixed timeline, start to finish.","intro":"The clock starts at access and kickoff, not at signature. You’ll know where things stand the whole way."} -->
<!-- wp:codecharmer/approach-step {"title":"Days 1–2 · Access and kickoff","body":"Credentials, systems inventory, and a kickoff conversation about where it hurts most.","weight":2} /-->
<!-- wp:codecharmer/approach-step {"title":"Days 3–7 · Investigation","body":"Workflow mapping with the people who do the work, plus a technical review of the platform and its integrations.","weight":5} /-->
<!-- wp:codecharmer/approach-step {"title":"Days 8–9 · Synthesis","body":"Findings ranked by impact, the architecture recommendation, and the 90-day plan written up.","weight":2} /-->
<!-- wp:codecharmer/approach-step {"title":"Day 10 · Decision call","body":"We walk through everything together. What happens next is your call, with or without us.","weight":1} /-->
<!-- /wp:codecharmer/approach -->

<!-- OWNER INPUT REQUIRED: named expert section (who conducts the audit: name, photo, relevant track record). Do not publish without real identity content. -->

<!-- OWNER INPUT REQUIRED: named, permissioned client testimonial relevant to audits or diagnostics. Renders nothing while empty. -->
<!-- wp:codecharmer/testimonial /-->

<!-- wp:codecharmer/proof {"eyebrow":"Proof","heading":"Judge the work, not the promises.","intro":"The systems we’d be auditing yours against are live and documented: commerce and POS on one WordPress engine, bilingual publishing without plugins, AI content workflows with human approval.","ctaLabel":"Read the case studies","ctaUrl":"/work"} /-->

<!-- wp:group {"tagName":"section","className":"section"} -->
<section class="wp-block-group section"><!-- wp:group {"className":"container prose"} -->
<div class="wp-block-group container prose"><!-- wp:heading -->
<h2 class="wp-block-heading">Price, payment, and the credit.</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The audit starts at US$2,500, paid upfront, with scope and timeline fixed before payment. Larger or multi-site operations may scope higher; you’ll know the exact number before committing. If you commission an implementation of US$25,000 or more within 30 days of the decision call, up to 50% of the audit fee credits toward it. The findings are yours in every case.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></section>
<!-- /wp:group -->

<!-- wp:codecharmer/faq {"heading":"Straight answers."} -->
<!-- wp:codecharmer/faq-item {"question":"What do you need from us?","answer":"Admin access to WordPress and the connected systems, a kickoff call, and a few short conversations with the people who actually run the workflows. Plan on two to three hours of your team’s time across the ten days."} /-->
<!-- wp:codecharmer/faq-item {"question":"Will you just recommend hiring you?","answer":"The plan is written to be executable by any competent team, and the ranking shows its reasoning. When a plugin or an off-the-shelf tool is the right answer, the plan says so. That honesty is why the audit is worth paying for."} /-->
<!-- wp:codecharmer/faq-item {"question":"Our setup is unusual. Does that break the audit?","answer":"Unusual setups are the point. Multisite, headless, WooCommerce, custom plugins, external systems: the audit exists precisely because generic advice doesn’t survive contact with a real operation."} /-->
<!-- wp:codecharmer/faq-item {"question":"What happens after we submit the form?","answer":"A real person replies within one business day with the exact scope we’d recommend, or honest questions if the fit isn’t clear. Payment and kickoff only happen after you’ve agreed to a written scope."} /-->
<!-- /wp:codecharmer/faq -->

<!-- wp:codecharmer/audit-form /-->
BLOCKS;

$cc_pages['wordpress-operations-audit'] = array(
	'title'   => 'WordPress Operations & Automation Audit',
	'order'   => 8,
	'excerpt' => 'In 10 business days, get an implementation-ready plan for the workflows, integrations, content systems, and automation opportunities around your existing WordPress platform. Starts at US$2,500.',
	'meta'    => array(
		'cc_seo_title'       => 'WordPress Operations & Automation Audit | Code Charmer',
		'cc_seo_description' => 'A 10-business-day audit of your WordPress operations: workflow map, technical findings, ranked opportunities, and a 90-day implementation plan. Starts at US$2,500.',
	),
	'content' => <<<BLOCKS
<!-- wp:codecharmer/page-hero {"tone":"ink","eyebrow":"The fixed first step","title":"Find where WordPress is costing your team time, revenue, and reliability.","intro":"In 10 business days, get an implementation-ready plan for the workflows, integrations, content systems, and automation opportunities around your existing WordPress platform.","primaryLabel":"Request the audit","primaryUrl":"#request-audit","secondaryLabel":"See how we build","secondaryUrl":"/work","note":"Starts at US$2,500 · Fixed scope and timeline before payment · You own the findings whether or not we implement them"} /-->

{$cc_audit_body}
BLOCKS
	,
);

// ------------------------------------------------- audit (campaign) -- //
// Chrome-stripped variant for paid and outbound traffic: same body, no
// site navigation, noindexed so the canonical page stays the indexed one.
$cc_pages['audit'] = array(
	'title'    => 'WordPress Operations Audit',
	'order'    => 10,
	'template' => 'page-landing',
	'excerpt'  => 'In 10 business days, get an implementation-ready plan for the workflows, integrations, content systems, and automation opportunities around your existing WordPress platform. Starts at US$2,500.',
	'meta'     => array(
		'cc_noindex'         => '1',
		'cc_seo_title'       => 'WordPress Operations & Automation Audit | Code Charmer',
		'cc_seo_description' => 'A 10-business-day audit of your WordPress operations: workflow map, technical findings, ranked opportunities, and a 90-day implementation plan. Starts at US$2,500.',
	),
	'content'  => <<<BLOCKS
<!-- wp:codecharmer/page-hero {"tone":"ink","eyebrow":"The fixed first step","title":"Find where WordPress is costing your team time, revenue, and reliability.","intro":"In 10 business days, get an implementation-ready plan for the workflows, integrations, content systems, and automation opportunities around your existing WordPress platform.","primaryLabel":"Request the audit","primaryUrl":"#request-audit","note":"Starts at US$2,500 · Fixed scope and timeline before payment · You own the findings whether or not we implement them"} /-->

{$cc_audit_body}
BLOCKS
	,
);

// ----------------------------------------------------- agency-partners -- //
$cc_pages['agency-partners'] = array(
	'title'   => 'Agency Partners',
	'order'   => 11,
	'excerpt' => 'Senior WordPress and application engineering behind your agency: white-label builds, direct-to-client work, or embedded capacity. Fixed scope, documented handoff, your client relationship intact.',
	'meta'    => array(
		'cc_seo_title'       => 'White-Label WordPress Engineering for Agencies | Code Charmer',
		'cc_seo_description' => 'Senior WordPress and application engineering behind your agency: white-label builds, direct-to-client engagements, or embedded capacity. Fixed scope and documented handoff.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"tone":"ink","eyebrow":"Agency partners","title":"The engineering bench your agency doesn’t have to staff.","intro":"You lead the brand, the design, and the client. We handle the WordPress and application layer agencies rarely want to carry permanently: custom blocks, integrations, portals, WooCommerce operations, and automation. Invisibly or by name, your call.","primaryLabel":"Describe the brief","primaryUrl":"/contact","secondaryLabel":"See the builds","secondaryUrl":"/work","note":"A real reply the same business day, US Eastern hours"} /-->

<!-- wp:codecharmer/engagement-models {"eyebrow":"Three ways to plug in","heading":"Pick the shape that fits the brief.","intro":"Every mode comes with fixed scope, written estimates, and a documented handoff. What we never offer is unlimited development: vague capacity produces vague work."} -->
<!-- wp:codecharmer/engagement-model {"bestFor":"An overflow or specialist build","name":"White-label build","price":"Builds start at US$25,000","timeframe":"Scoped per brief","body":"We work invisibly under your brand: your PM, your client, our engineering. Custom themes, blocks, integrations, and commerce delivered against your spec, with documentation your team presents as its own.","detail":"Paid discovery available at US$7,500 – 15,000 when the brief needs de-risking first."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"A brief outside your lane","name":"Direct-to-client","price":"Standard project pricing","timeframe":"Scoped per brief","body":"You introduce us, we contract with your client directly, and you stay the relationship lead. Cleanest when the engagement needs its own support relationship after launch.","detail":"Your client, your credit for the introduction, and no channel conflict: we don’t sell design or brand work."} /-->
<!-- wp:codecharmer/engagement-model {"bestFor":"Sustained technical depth","name":"Embedded engineering","price":"Reserved monthly capacity","timeframe":"3-month minimum","body":"Senior capacity reserved inside your delivery team each month: a stated hours band, your standups, your tooling, our engineering.","detail":"Priced per engagement against the reserved band. Tell us the shape of the need and you’ll get a number, not a rate card."} /-->
<!-- /wp:codecharmer/engagement-models -->
<!-- OWNER INPUT REQUIRED: confirm or replace the embedded-capacity pricing approach above once a real monthly band and number are decided. -->

<!-- wp:codecharmer/feature-list {"eyebrow":"What we take off your plate","heading":"The layer below the design.","intro":"The work is the same discipline shown in our case studies: engine-grade WordPress with the boring parts done properly."} -->
<!-- wp:codecharmer/feature-item {"text":"Custom Gutenberg blocks and editorial experiences your client's team can actually run"} /-->
<!-- wp:codecharmer/feature-item {"text":"Integrations that fail loudly and recover cleanly: CRM, search, messaging, payments"} /-->
<!-- wp:codecharmer/feature-item {"text":"WooCommerce operations: ordering, inventory, POS, loyalty, and the workflows behind them"} /-->
<!-- wp:codecharmer/feature-item {"text":"Client portals, dashboards, and the custom application layer around WordPress"} /-->
<!-- wp:codecharmer/feature-item {"text":"Performance, accessibility, and security handled as engineering, not as a plugin list"} /-->
<!-- wp:codecharmer/feature-item {"text":"Documentation and handoff written so the next developer, yours or theirs, is never stuck"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/proof {"eyebrow":"Judge the work","heading":"The builds speak for themselves.","intro":"Commerce and POS on one WordPress engine, bilingual publishing without a translation plugin, AI content workflows with human approval: live systems, documented in detail.","ctaLabel":"Read the case studies","ctaUrl":"/work"} /-->

<!-- wp:codecharmer/faq {"heading":"Straight answers."} -->
<!-- wp:codecharmer/faq-item {"question":"Will our client know you exist?","answer":"Only if you want them to. White-label means your brand on everything: our repos transfer, our documentation carries your name, and we join calls as your team or not at all. The choice is contractual, not casual."} /-->
<!-- wp:codecharmer/faq-item {"question":"Who owns the code and the IP?","answer":"Your client does, always, regardless of mode. Full repository transfer, no licensing tail, no dependency on us to keep running. It is the same ownership promise we make direct clients."} /-->
<!-- wp:codecharmer/faq-item {"question":"What happens when the build ships?","answer":"A documented handoff: architecture notes, editorial guides, and deployment runbooks. If ongoing support makes sense, it is a separate, explicit engagement, never a lock-in."} /-->
<!-- wp:codecharmer/faq-item {"question":"Do you take every brief?","answer":"No. Below the build minimum, or where a good theme and a generalist would serve your client better, we say so on the first call. Partnerships survive on the briefs we decline."} /-->
<!-- /wp:codecharmer/faq -->

<!-- wp:codecharmer/cta-band {"heading":"Have a brief that needs a serious bench?","body":"Send the shape of it: platform, scope, timeline. You’ll get an honest read and, if it fits, two relevant builds and our partner terms. A real reply the same business day, US Eastern hours.","primaryLabel":"Describe the brief","primaryUrl":"/contact"} /-->
BLOCKS
	,
);

// ------------------------------------------------------------ insights -- //
$cc_pages['insights'] = array(
	'title'   => 'Insights',
	'order'   => 9,
	'excerpt' => 'First-hand engineering notes from real WordPress operations, automation, and platform builds.',
	'meta'    => array(
		'cc_seo_title'       => 'WordPress Operations & Automation Insights | Code Charmer',
		'cc_seo_description' => 'First-hand engineering notes from real builds: WordPress operations, workflow automation, integrations, and the decisions behind them.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"eyebrow":"Insights","title":"Notes from real systems.","intro":"First-hand write-ups from the builds on this site: decisions, tradeoffs, checklists, and the occasional honest mistake. Written to be useful, not to fill a feed."} /-->

<!-- wp:codecharmer/insights /-->
BLOCKS
	,
);

// ------------------------------------------------------------- contact -- //
$cc_pages['contact'] = array(
	'title'   => 'Contact',
	'order'   => 6,
	'excerpt' => "Tell us what you're building. A short, qualifying conversation: no pitch deck, no obligation.",
	'meta'    => array(
		'cc_seo_title'       => 'Describe Your Project or Schedule a Call | Code Charmer',
		'cc_seo_description' => 'Two ways in: describe your project through a short qualifying form, or schedule a 20-minute fit call. A real person replies within one business day.',
	),
	'content' => <<<'BLOCKS'
<!-- OWNER INPUT REQUIRED: set the scheduling_url site setting to activate the "Schedule a fit call" path; until then only the form path renders a button. Also confirm the published response SLA and minimum engagement wording below. -->
<!-- wp:codecharmer/page-hero {"eyebrow":"Contact","title":"Two ways to start.","intro":"Describe your project in the form below, or schedule a 20-minute fit call if you’d rather talk first. Either way: no pitch deck, no obligation, and an honest answer about whether we’re the right team. Engagements start at the US$2,500 audit.","note":"A real person replies within one business day, not an autoresponder."} /-->

<!-- wp:codecharmer/contact-form /-->
BLOCKS
	,
);

// ------------------------------------------------------------- privacy -- //
$cc_pages['privacy'] = array(
	'title'   => 'Privacy',
	'order'   => 7,
	'excerpt' => 'How Code Charmer handles the information you share with us.',
	'meta'    => array(
		'cc_seo_title'       => 'Privacy Policy | Code Charmer',
		'cc_seo_description' => 'How Code Charmer handles the information you share with us: what we collect, what we never do with it, and how to ask us about it.',
	),
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
<p>To understand which pages are useful, we use cookieless, privacy-first analytics (Plausible). It stores no cookies, collects no personal data, and never follows you across other sites. Aggregate counts only: which pages were visited and which buttons were used.</p>
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
	'meta'    => array(
		'cc_seo_title'       => 'Praxis: AI Content Operations for WordPress | Code Charmer',
		'cc_seo_description' => 'Case study: an AI-native orchestration layer where WordPress stays the authoring surface, AI drafts are metered and human-approved, and search answers in about 90 ms.',
	),
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
	'meta'    => array(
		'cc_seo_title'       => 'Gramo Café: Bilingual Headless WordPress Platform | Code Charmer',
		'cc_seo_description' => 'Case study: a bilingual headless WordPress and Gatsby platform for a coffee brand with eight cafés. Block-composed editing, commerce, and SMS-driven operations.',
	),
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

// ----------------------------------------------------- work/pacifica -- //
$cc_pages['work/pacifica'] = array(
	'title'   => 'Pacífica Panadería',
	'order'   => 2,
	'excerpt' => 'Pacífica Panadería: an artisan sourdough bakery on one WordPress engine. Reserve-and-pickup WooCommerce storefront, an Expo customer app, a tablet POS, Apple Wallet loyalty, WhatsApp/SMS operations via Twilio.',
	'meta'    => array(
		'cc_seo_title'       => 'Pacífica Panadería: Commerce & POS on One WordPress Engine | Code Charmer',
		'cc_seo_description' => 'Case study: a bakery running storefront, customer app, tablet POS, Apple Wallet loyalty, and WhatsApp operations on one WordPress engine with a single source of truth.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"tone":"ink","eyebrow":"Case study · Pacífica Panadería","title":"The whole bakery, running on one engine.","intro":"Pacífica is an artisan sourdough bakery in Cuernavaca. Its platform is one WordPress engine driving three surfaces: a reserve-and-pickup storefront, a customer app whose loyalty card lives in Apple Wallet, and a tablet POS that runs the counter, the stock and the daily close.","primaryLabel":"Visit pacificapanaderia.com","primaryUrl":"https://pacificapanaderia.com","note":"es-MX · WordPress + WooCommerce Store API · Expo customer + POS apps"} /-->

<!-- wp:codecharmer/value-statement {"lead":"A bakery is a system: ovens, slots, counter, stock. <em>The software mirrors all of it</em>, and the same engine now runs its sister café down the street."} -->
<!-- wp:codecharmer/value-point {"title":"Reserve now, pay at pickup","body":"Capacity-limited 30-minute pickup slots with a 1-hour lead time, so same-day ordering works. Checkout rides the WooCommerce Store API. Pay at pickup is the live path; the Stripe gateway is wired and awaiting keys."} /-->
<!-- wp:codecharmer/value-point {"title":"Three surfaces, one truth","body":"Web, customer app and POS consume the same catalog, the same slots and the same order states through one REST API. Nothing to reconcile, nowhere to drift."} /-->
<!-- wp:codecharmer/value-point {"title":"Operations on WhatsApp","body":"New orders reach staff by WhatsApp/SMS via Twilio, and staff reply with a digit to advance them. Customers get a message at every step. Nobody has to watch a dashboard."} /-->
<!-- /wp:codecharmer/value-statement -->

<!-- wp:codecharmer/feature-list {"eyebrow":"Surface 01 · The website","heading":"The storefront.","intro":"Seventeen block templates and twenty-four patterns on a theme.json token system: everything editable, everything seeded from code."} -->
<!-- wp:codecharmer/feature-item {"text":"A 29-product WooCommerce catalog in three categories, real MXN prices, Agotado sold-out states driven by live stock"} /-->
<!-- wp:codecharmer/feature-item {"text":"Reserve-and-pickup checkout: capacity-limited 30-minute slots with a 1-hour lead time, so same-day orders work"} /-->
<!-- wp:codecharmer/feature-item {"text":"Fourteen seeded pages: menú, historia, filosofía, proceso, temporada, catering, cómo recoger, FAQ, contacto and three legal pages"} /-->
<!-- wp:codecharmer/feature-item {"text":"Bodoni Moda display type over a 12-color token palette, zero hardcoded hex in any template or pattern"} /-->
<!-- wp:codecharmer/feature-item {"text":"Two style variations: Horno de Noche (dark) and Mostrador (light)"} /-->
<!-- wp:codecharmer/feature-item {"text":"JSON-LD structured data (Bakery, Product, BreadcrumbList) plus Open Graph and Twitter cards"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/feature-list {"eyebrow":"Behind the counter","heading":"Back of house.","intro":"The parts customers never see: where the bakery actually runs."} -->
<!-- wp:codecharmer/feature-item {"text":"Every paid order reaches staff by WhatsApp/SMS via Twilio; a digit in reply advances it through the flow"} /-->
<!-- wp:codecharmer/feature-item {"text":"Customers are texted on every change, through custom order statuses: preparing, ready"} /-->
<!-- wp:codecharmer/feature-item {"text":"Operations dashboard, production calendar, reports and a low-stock widget inside wp-admin"} /-->
<!-- wp:codecharmer/feature-item {"text":"One REST API: /app/* for the customer app, /pos/* behind Application Passwords, /wallet/v1/* for PassKit"} /-->
<!-- wp:codecharmer/feature-item {"text":"Idempotent WP-CLI installer, versioned schema migrations, HPOS-ready commerce"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/feature-list {"eyebrow":"Surface 02 · In the pocket","heading":"The customer app.","intro":"An Expo app for iOS and Android built on React Native and React 19, sharing a typed API client with the POS."} -->
<!-- wp:codecharmer/feature-item {"text":"Four tabs: Carta, Canasta, Mis pedidos and Lealtad"} /-->
<!-- wp:codecharmer/feature-item {"text":"Catalog and cart against the same Store API as the web"} /-->
<!-- wp:codecharmer/feature-item {"text":"Checkout shares the web’s pickup slots: same capacity rules, same lead time"} /-->
<!-- wp:codecharmer/feature-item {"text":"Name, phone and email persisted on device: entered once, kept across orders and restarts"} /-->
<!-- wp:codecharmer/feature-item {"text":"Live order tracking with a push notification at every status change"} /-->
<!-- wp:codecharmer/feature-item {"text":"A signed loyalty QR card and an Add to Apple Wallet button"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/feature-list {"eyebrow":"Surface 03 · The counter","heading":"The counter, on a tablet.","intro":"Pacífica POS: a landscape tablet app that replaces paper across six tabs."} -->
<!-- wp:codecharmer/feature-item {"text":"Entrantes: incoming online orders with push alerts and slide-to-accept"} /-->
<!-- wp:codecharmer/feature-item {"text":"Pedidos: a live pickup board grouped by time slot, driving each order through its statuses"} /-->
<!-- wp:codecharmer/feature-item {"text":"Mostrador: walk-in counter sales in cash or card that decrement stock without consuming pickup slots"} /-->
<!-- wp:codecharmer/feature-item {"text":"Inventario: absolute stock recounts, salidas internas with destinations and an employee picker, per-day history"} /-->
<!-- wp:codecharmer/feature-item {"text":"Lealtad: a camera QR scanner to stamp and redeem loyalty cards"} /-->
<!-- wp:codecharmer/feature-item {"text":"Corte del día: revenue by channel and payment method, top sellers, salidas valued at price snapshots"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/feature-list {"eyebrow":"The loyalty loop","heading":"A pass that keeps itself current.","intro":"No accounts to create, no third-party pass service: the whole loop is built into the engine."} -->
<!-- wp:codecharmer/feature-item {"text":"Anonymous, device-registered loyalty members: no signup form, no password"} /-->
<!-- wp:codecharmer/feature-item {"text":"HMAC-signed QR tokens, read by the same POS scanner that stamps them"} /-->
<!-- wp:codecharmer/feature-item {"text":".pkpass store cards built and PKCS#7-signed in pure PHP"} /-->
<!-- wp:codecharmer/feature-item {"text":"The full Apple PassKit Web Service: device registration and per-pass auth tokens"} /-->
<!-- wp:codecharmer/feature-item {"text":"An APNs push on every stamp or redeem, so the pass in the customer’s Wallet refreshes itself"} /-->
<!-- wp:codecharmer/feature-item {"text":"Stamps and redemptions are counted; reward mechanics stay a business decision, deliberately un-encoded"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/beliefs {"heading":"Built like software, because it is.","intro":"The engine-versus-brand split our WordPress builds share, here at its fullest.","columns":4} -->
<!-- wp:codecharmer/belief-item {"title":"Plugin decides, theme presents","body":"All commerce logic lives in the pacifica-core plugin: 39 classes booted through a service container. The FSE theme is presentation only, tokens and templates."} /-->
<!-- wp:codecharmer/belief-item {"title":"Built to be re-branded","body":"The same engine now runs Haramara Café down the street. Brand lives in tokens, patterns and seed data, never in forks."} /-->
<!-- wp:codecharmer/belief-item {"title":"Verified end to end","body":"phpcs and PHPStan level 6 on the PHP, TypeScript checks across both apps, and a REST integration matrix that exercises ordering, inventory and loyalty before anything ships."} /-->
<!-- wp:codecharmer/belief-item {"title":"Deploys are boring","body":"GitHub Actions rsyncs only what changed to the VPS. The apps ship through EAS builds, with over-the-air updates in between."} /-->
<!-- /wp:codecharmer/beliefs -->

<!-- wp:codecharmer/stack {"eyebrow":"Under the hood","heading":"The stack, plainly."} -->
<!-- wp:codecharmer/stack-group {"label":"Web","items":"WordPress FSE theme\ntheme.json tokens\nWooCommerce Store API (MXN)\nBodoni Moda\nTwo style variations"} /-->
<!-- wp:codecharmer/stack-group {"label":"Backend","items":"pacifica-core plugin (PSR-4)\nREST pacifica/v1\nApplication Passwords\nVersioned migrations\nHPOS-ready\nWP-CLI installer"} /-->
<!-- wp:codecharmer/stack-group {"label":"Apps","items":"Expo SDK 57\nReact Native 0.86\nReact 19\nTanStack Query\nShared TypeScript api-client\nExpo push"} /-->
<!-- wp:codecharmer/stack-group {"label":"Wallet and messaging","items":"Apple PassKit Web Service\nPure-PHP .pkpass + PKCS#7\nAPNs HTTP/2\nTwilio WhatsApp/SMS"} /-->
<!-- wp:codecharmer/stack-group {"label":"Quality and delivery","items":"PHPCS + PHPStan level 6\nTypeScript strict checks\nEnd-to-end REST matrix\nGitHub Actions\nScoped rsync deploys\nEAS builds + OTA"} /-->
<!-- /wp:codecharmer/stack -->

<!-- wp:codecharmer/faq {"heading":"Straight answers."} -->
<!-- wp:codecharmer/faq-item {"question":"Why two apps for one bakery?","answer":"They do different jobs. The customer app sells: browse, reserve, track, collect stamps. The POS runs the counter: accept, hand off, sell walk-ins, count stock, close the day. Both speak to the same REST API, so there is one source of truth and nothing to reconcile."} /-->
<!-- wp:codecharmer/faq-item {"question":"Where are card payments?","answer":"Pay at pickup is the live path, because that is how this counter sells today. The Stripe gateway is installed and wired, awaiting keys, and Mercado Pago is planned. The checkout blocks neither, and we don’t claim what isn’t on."} /-->
<!-- wp:codecharmer/faq-item {"question":"Why pickup only, no delivery?","answer":"Because the product is the point. Bread comes out of a wood-fired oven on a schedule, and pickup slots are capacity-limited to match it. Reserve, walk in, collect it warm. Delivery is deliberately out of scope."} /-->
<!-- /wp:codecharmer/faq -->

<!-- wp:codecharmer/cta-band {"heading":"Want your whole operation on one engine?","body":"Storefront, apps, counter and stock on one system. Tell us how your business actually runs, and we’ll tell you what we’d build first."} /-->
BLOCKS
	,
);

// ----------------------------------------------------- work/haramara -- //
$cc_pages['work/haramara'] = array(
	'title'   => 'Haramara Café',
	'order'   => 3,
	'excerpt' => 'Haramara Café: a bilingual, dark-branded café platform on the same engine as its sister bakery. A virtual ES/EN mirror without a translation plugin, WooCommerce pickup ordering, customer and POS apps, self-refreshing Apple Wallet loyalty.',
	'meta'    => array(
		'cc_seo_title'       => 'Haramara Café: A Second Brand on a Reusable Commerce Engine | Code Charmer',
		'cc_seo_description' => 'Case study: the same commerce engine as its sister bakery, wearing an entirely different brand. Bilingual without a translation plugin, apps, POS, and Wallet loyalty.',
	),
	'content' => <<<'BLOCKS'
<!-- wp:codecharmer/page-hero {"tone":"ink","eyebrow":"Case study · Haramara Café","title":"Same engine. A brand entirely its own.","intro":"Haramara is a specialty coffee and sourdough café in Cuernavaca, sister to Pacífica Panadería on the same street. It runs the same commerce engine: storefront, customer app, POS and Wallet loyalty. Nothing about it looks shared: a dark carbon, clay and brass identity, and a site that is fully bilingual without a translation plugin.","primaryLabel":"Visit haramara.cafe","primaryUrl":"https://haramara.cafe","note":"ES · EN · WordPress + WooCommerce · Expo customer + POS apps · Apple Wallet loyalty"} /-->

<!-- wp:codecharmer/value-statement {"lead":"Haramara shares an engine with its sister bakery down the street. <em>Nothing about it looks shared.</em>"} -->
<!-- wp:codecharmer/value-point {"title":"The engine is the reuse","body":"The same core plugin architecture, apps, loyalty and Wallet system as Pacífica. The brand layer is entirely Haramara’s own: tokens, type, patterns, copy."} /-->
<!-- wp:codecharmer/value-point {"title":"Bilingual by rewrite, not by plugin","body":"The English site is a virtual mirror at /en/: rewrites plus a language layer render every page from one translation dictionary. No duplicated page tree, nothing to drift."} /-->
<!-- wp:codecharmer/value-point {"title":"Dark by design","body":"Carbon, clay and brass. Italiana display over Petrona text. Five atmospheric día patterns that walk the café’s day from horno to cierre."} /-->
<!-- /wp:codecharmer/value-statement -->

<!-- wp:codecharmer/feature-list {"eyebrow":"The website","heading":"One site, two languages, no plugin.","intro":"Seven pages and a sixteen-product catalog, mirrored in English without duplicating a word of content."} -->
<!-- wp:codecharmer/feature-item {"text":"A virtual /en/ mirror: rewrites strip the prefix, flip the locale and pass the render through a translation layer"} /-->
<!-- wp:codecharmer/feature-item {"text":"One translation dictionary drives the entire English site"} /-->
<!-- wp:codecharmer/feature-item {"text":"hreflang alternates on both languages, so search engines index the pair correctly"} /-->
<!-- wp:codecharmer/feature-item {"text":"A dark token palette (carbon, espresso, walnut, clay, brass, bone) with Italiana and Petrona type"} /-->
<!-- wp:codecharmer/feature-item {"text":"Seventeen patterns, including five atmospheric día sections: horno, filtrados, cueva, ocaso, cierre"} /-->
<!-- wp:codecharmer/feature-item {"text":"A 16-product WooCommerce catalog: espresso, cold brew, filtrados, salados and especiales"} /-->
<!-- wp:codecharmer/feature-item {"text":"Pickup ordering with a 2-hour lead time, Wednesday to Monday"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/feature-list {"eyebrow":"In the pocket","heading":"The café, in the customer’s pocket.","intro":"The same app engine as Pacífica’s, wearing Haramara’s dark UI."} -->
<!-- wp:codecharmer/feature-item {"text":"Four tabs: Carta, Canasta, Mis pedidos and Lealtad"} /-->
<!-- wp:codecharmer/feature-item {"text":"Store API checkout sharing the web’s pickup slots, with checkout details persisted on device"} /-->
<!-- wp:codecharmer/feature-item {"text":"Live order tracking: a push notification at every status change"} /-->
<!-- wp:codecharmer/feature-item {"text":"A loyalty QR card with Add to Apple Wallet: the pass is built and signed in pure PHP"} /-->
<!-- wp:codecharmer/feature-item {"text":"An APNs push on every stamp or redeem, so an installed pass refreshes itself"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/feature-list {"eyebrow":"The counter","heading":"The same counter system, tuned for the café.","intro":"The six-tab tablet POS from the shared engine, adjusted where the café differs."} -->
<!-- wp:codecharmer/feature-item {"text":"Entrantes: incoming orders with push alerts and slide-to-accept"} /-->
<!-- wp:codecharmer/feature-item {"text":"Pedidos: a live pickup board by slot, driving status transitions"} /-->
<!-- wp:codecharmer/feature-item {"text":"Mostrador: walk-in sales in cash or card, decrementing stock without touching slots"} /-->
<!-- wp:codecharmer/feature-item {"text":"Inventario: recounts and salidas internas, with destinations tuned to this café: Malva, empleado, merma, otro"} /-->
<!-- wp:codecharmer/feature-item {"text":"Lealtad: QR scanning to stamp and redeem"} /-->
<!-- wp:codecharmer/feature-item {"text":"Corte del día: the daily close by channel and payment method, top sellers, valued salidas"} /-->
<!-- /wp:codecharmer/feature-list -->

<!-- wp:codecharmer/beliefs {"heading":"What the second deployment proved.","intro":"Reuse is a claim until a second brand ships on the engine. Haramara is the proof.","columns":4} -->
<!-- wp:codecharmer/belief-item {"title":"Brand is data, not a fork","body":"Everything Haramara-specific lives in tokens, patterns, dictionaries and seed files. The engine stayed the engine, and both projects keep improving it."} /-->
<!-- wp:codecharmer/belief-item {"title":"33 checks before deploy","body":"An end-to-end REST matrix exercises ordering, walk-ins, inventory guards, employees, loyalty and the Wallet web service: 33 checks on this project alone."} /-->
<!-- wp:codecharmer/belief-item {"title":"Fails honestly","body":"When Wallet certificates aren’t configured, the pass endpoints answer with a clean 503 and the app hides the button. No pretending, no half-working features."} /-->
<!-- wp:codecharmer/belief-item {"title":"Updates without the store","body":"GitHub Actions deploys the site per path; the apps take over-the-air updates through EAS between releases."} /-->
<!-- /wp:codecharmer/beliefs -->

<!-- wp:codecharmer/stack {"eyebrow":"Under the hood","heading":"The stack, plainly."} -->
<!-- wp:codecharmer/stack-group {"label":"Web","items":"WordPress FSE theme\ntheme.json tokens\nItaliana + Petrona\nWooCommerce Store API (MXN)"} /-->
<!-- wp:codecharmer/stack-group {"label":"Bilingual","items":"Virtual /en/ mirror\nLocale-aware rewrites\nSingle translation dictionary\nhreflang alternates"} /-->
<!-- wp:codecharmer/stack-group {"label":"Apps","items":"Expo SDK 57\nReact Native 0.86\nReact 19\nShared TypeScript api-client\nExpo push\nEAS builds + OTA"} /-->
<!-- wp:codecharmer/stack-group {"label":"Loyalty and Wallet","items":"HMAC-signed QR tokens\nPure-PHP .pkpass + PKCS#7\nApple PassKit Web Service\nAPNs HTTP/2\nGraceful 503 dark-state"} /-->
<!-- wp:codecharmer/stack-group {"label":"Quality and delivery","items":"PHPCS + PHPStan level 6\nTypeScript strict checks\nverify-api.sh (33 checks)\nGitHub Actions\nScoped rsync deploys"} /-->
<!-- /wp:codecharmer/stack -->

<!-- wp:codecharmer/faq {"heading":"Straight answers."} -->
<!-- wp:codecharmer/faq-item {"question":"Is this just Pacífica re-skinned?","answer":"It is deliberately the same engine, and deliberately not a re-skin. The identity, type, color system, page set and copy are Haramara’s own, and the business rules diverge where the café diverges: a 2-hour pickup lead, a Wednesday-to-Monday week, its own salida destinations. That split, engine versus brand, is our methodology. The Pacífica case study shows the engine at full depth."} /-->
<!-- wp:codecharmer/faq-item {"question":"Bilingual without a translation plugin?","answer":"Yes. /en/ is a virtual mirror: rewrites and a language layer render every page in English from one translation dictionary, with hreflang alternates for search. There is no second page tree to fall out of sync. Translation plugins were evaluated and rejected: they are weakest exactly where block themes live."} /-->
<!-- wp:codecharmer/faq-item {"question":"How does the loyalty card stay current in Apple Wallet?","answer":"The pass registers with a PassKit Web Service, and every stamp or redeem fires an APNs push, so the installed pass refreshes its own counters. The system counts stamps and redemptions; what a full card earns stays a human decision at the counter, deliberately not encoded."} /-->
<!-- /wp:codecharmer/faq -->

<!-- wp:codecharmer/cta-band {"heading":"Have a brand that deserves its own build?","body":"Tell us what makes yours different. We’ll tell you what stays engine and what becomes brand."} /-->
BLOCKS
	,
);

return $cc_pages;
