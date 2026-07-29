/**
 * Site content model.
 * Structured so each object maps cleanly to a future WordPress block's
 * editable fields / ACF repeater. Keep copy here, not in markup.
 */

export const site = {
  name: 'Code Charmer',
  domain: 'codecharmer.io',
  url: 'https://codecharmer.io',
  email: 'codecharmer@codecharmer.io',
  tagline: 'Digital systems that create business value.',
  positioning:
    'A digital engineering studio building AI-first architecture, WordPress systems, and custom software that clients own and understand.',
} as const;

export type Pillar = {
  slug: string;
  name: string;
  icon: IconName;
  descriptor: string;
  thesis: string;
  href: string;
  /** Problem hook — headline of the detail page. */
  problem: string;
  /** Capabilities list ("What's included"). */
  included: string[];
  /**
   * Ordered approach — a real sequence. `weight` is optional and follows the
   * same rule as Stage['weight']: a design-authored proportion, never data.
   * Omitted here on purpose — these three steps carry no weighting claim in
   * the copy, so the rail renders them evenly rather than inventing one.
   */
  approach: { title: string; body: string; weight?: number }[];
  faq: { q: string; a: string }[];
  /** Slug of a related case study. */
  relatedCase: string;
};

export const pillars: Pillar[] = [
  {
    slug: 'ai-strategy',
    name: 'AI Strategy & Architecture',
    icon: 'architecture',
    descriptor: 'Prepare the business for AI — not just bolt features onto it.',
    thesis:
      'AI-ready architecture, knowledge organization, and data structure that make intelligent automation possible.',
    href: '/services/ai-strategy',
    problem: 'Most AI projects start with a tool and go looking for a use. That’s backwards — and expensive.',
    included: [
      'AI-ready architecture',
      'Knowledge organization',
      'Data structure & modeling',
      'Internal workflow mapping',
      'AI integration planning',
      'Automation strategy',
    ],
    approach: [
      { title: 'Map the real workflows', body: 'Find where time and money actually go before proposing any technology.' },
      { title: 'Organize the knowledge', body: 'Structure the data and documents AI needs to be useful and reliable.' },
      { title: 'Design the architecture', body: 'Integrations, guardrails, and a path to scale — built to last, not to demo.' },
    ],
    faq: [
      { q: 'Do we even need AI?', a: 'Sometimes the honest answer is no, and we’ll tell you. AI earns its place only by removing real work.' },
      { q: 'Isn’t our data too messy for this?', a: 'That messiness is exactly the work. Organizing knowledge so AI has something reliable to stand on is most of the value.' },
    ],
    relatedCase: 'ai-knowledge-base',
  },
  {
    slug: 'wordpress',
    name: 'WordPress Engineering',
    icon: 'blocks',
    descriptor: 'Enterprise-grade engineering, not another off-the-shelf theme.',
    thesis:
      'Custom themes, Gutenberg block development, performance, and security built to last — WordPress as an asset, not a burden.',
    href: '/services/wordpress',
    problem: 'Off-the-shelf WordPress becomes technical debt the moment your needs outgrow the theme.',
    included: [
      'Custom theme development',
      'Gutenberg block development',
      'ACF & structured content',
      'Headless / API solutions',
      'Performance & Core Web Vitals',
      'Accessibility',
      'SEO foundations',
      'Security & maintainability',
      'Editorial workflows',
    ],
    approach: [
      { title: 'Architect the content model', body: 'Design the blocks and fields your team will actually edit, day to day.' },
      { title: 'Engineer the theme', body: 'Fast, accessible, and maintainable by default — not bolted on at the end.' },
      { title: 'Hand over the keys', body: 'Documentation and editorial workflows your team owns without depending on us.' },
    ],
    faq: [
      { q: 'Can you work with our existing site?', a: 'Usually yes. We audit first, then decide together what to keep, refactor, or rebuild.' },
      { q: 'Will our team be able to manage it?', a: 'That’s the whole point. We build editing experiences your team controls, so you’re never locked in.' },
    ],
    relatedCase: 'membership-platform',
  },
  {
    slug: 'custom-software',
    name: 'Custom Software',
    icon: 'terminal',
    descriptor: 'Software that improves how the business actually operates.',
    thesis:
      'Internal dashboards, portals, APIs, and integrations that remove manual work and give teams leverage.',
    href: '/services/custom-software',
    problem: 'When the business runs on five disconnected tools and a lot of spreadsheets, the software is the bottleneck.',
    included: [
      'Internal dashboards',
      'Business portals',
      'CRM integrations',
      'APIs & integrations',
      'Process automation',
      'Membership systems',
      'Booking systems',
      'Custom applications',
    ],
    approach: [
      { title: 'Understand the operation', body: 'The real workflow, not the org chart — where the friction actually lives.' },
      { title: 'Design the system', body: 'Data, integrations, and an interface that serves the work instead of fighting it.' },
      { title: 'Build and integrate', body: 'Production software that connects the tools you already rely on.' },
    ],
    faq: [
      { q: 'Do we have to replace our current tools?', a: 'Rarely. We integrate with what works and replace only what’s genuinely holding you back.' },
      { q: 'How do we avoid another system nobody uses?', a: 'By designing around the actual workflow. Adoption is a design problem, not a training problem.' },
    ],
    relatedCase: 'operations-dashboard',
  },
  {
    slug: 'ai-automation',
    name: 'AI Automation',
    icon: 'flow',
    descriptor: 'Practical automation with measurable outcomes — not hype.',
    thesis:
      'Content workflows, internal assistants, retrieval systems, and process automation that pay for themselves.',
    href: '/services/ai-automation',
    problem: 'Most “AI automation” is a demo. The value is in the unglamorous, repetitive work it quietly removes.',
    included: [
      'Content workflows',
      'Internal assistants',
      'Customer support automation',
      'Business process automation',
      'AI integrations',
      'Retrieval systems (RAG)',
      'AI-powered search',
    ],
    approach: [
      { title: 'Find the repetitive work', body: 'The tasks that eat hours and add no human judgment — those come first.' },
      { title: 'Build the automation', body: 'Reliable and observable, with a human in the loop wherever it matters.' },
      { title: 'Measure the payoff', body: 'Hours saved, errors avoided, throughput gained — automation should pay for itself.' },
    ],
    faq: [
      { q: 'Will this replace our people?', a: 'No. It removes the busywork so your people spend time on the work that needs judgment.' },
      { q: 'How do you stop AI from making things up?', a: 'Retrieval over your own structured knowledge, with guardrails and human review where it counts.' },
    ],
    relatedCase: 'ai-knowledge-base',
  },
];

export type EngagementModel = { name: string; bestFor: string; body: string };

export const engagementModels: EngagementModel[] = [
  {
    name: 'Fixed-scope project',
    bestFor: 'A defined outcome',
    body: 'A clear deliverable, timeline, and price. Best when you know what needs building and want certainty.',
  },
  {
    name: 'Discovery & architecture',
    bestFor: 'An unclear problem',
    body: 'A focused engagement to map the workflow and design the system before committing to a full build.',
  },
  {
    name: 'Ongoing partnership',
    bestFor: 'A growing platform',
    body: 'A retained team that knows your systems and keeps improving them — without rebuilding the relationship each time.',
  },
];

export const nav = {
  primary: [
    { label: 'Services', href: '/services', hasMenu: true },
    { label: 'Work', href: '/work' },
    { label: 'Process', href: '/process' },
    { label: 'About', href: '/about' },
  ],
  cta: { label: 'Book a consultation', href: '/contact' },
} as const;

export type Belief = { title: string; body: string };

export const beliefs: Belief[] = [
  {
    title: 'AI should solve real business problems',
    body: 'Not a demo bolted onto a homepage. Automation earns its place by removing manual work and creating leverage.',
  },
  {
    title: 'WordPress is an asset, not a burden',
    body: 'Engineered properly, it stops being technical debt and becomes a platform your team can actually run.',
  },
  {
    title: 'Clients own their platform',
    body: 'You should understand and control what you paid for. No lock-in, no dependency, no black boxes.',
  },
  {
    title: 'Good architecture lowers future cost',
    body: 'Decisions made early compound. We build so the next change is cheaper, not more expensive.',
  },
];

export type Stage = {
  n: number;
  name: string;
  body: string;
  deliverable: string;
  /**
   * Relative *decision leverage* of this stage — how much of the project's
   * eventual cost is determined here. Drives the width of the stage's segment
   * on the instrumented rail, so the copy's own claims ("deliberately
   * front-loaded", "each one making the next cheaper", "this is where the
   * biggest costs are won or lost") render as geometry instead of adjectives.
   *
   * NOT duration, NOT budget share, NOT measured data — a design-authored
   * proportion. Render it as unlabeled relative width only; never attach
   * units, weeks, or percentages to it.
   */
  weight: number;
};

export const process: Stage[] = [
  { n: 1, name: 'Discovery', weight: 3.6, body: 'Understand the business, the users, and the real problem before proposing anything. We ask more questions than most agencies do — it’s cheaper than building the wrong thing.', deliverable: 'A shared understanding of the problem and what success looks like.' },
  { n: 2, name: 'Architecture', weight: 4.4, body: 'Design the system — data, structure, and integrations — so everything downstream is cheaper. This is where the biggest costs are won or lost.', deliverable: 'A system design and a plan you can budget against.' },
  { n: 3, name: 'Design', weight: 2.8, body: 'Interface and experience that serve the workflow and the brand, not decoration. Every screen earns its place.', deliverable: 'Interfaces and flows, ready to build.' },
  { n: 4, name: 'Development', weight: 2.2, body: 'Production-grade engineering: maintainable, accessible, and fast by default. Tested as it’s written, not bolted on at the end.', deliverable: 'Working software you can actually read and extend.' },
  { n: 5, name: 'Testing', weight: 1.5, body: 'Verify against real conditions and edge cases before anything ships. Empty states, error states, the messy middle — all of it.', deliverable: 'Confidence it holds up under real use.' },
  { n: 6, name: 'Launch', weight: 1.1, body: 'Deploy with confidence, hand over the keys, and make sure the team can drive. Documentation and workflows included.', deliverable: 'A live platform and a team that can run it.' },
  { n: 7, name: 'Growth', weight: 1.4, body: 'Measure, iterate, and extend — the platform compounds instead of stalling. We stay as long as we’re adding value, and no longer.', deliverable: 'A roadmap and the data to prioritize it.' },
];

/** Contact form option sets. */
export const projectTypes = [
  'AI strategy & architecture',
  'WordPress engineering',
  'Custom software',
  'AI automation',
  'Not sure yet',
] as const;

export const budgetRanges = [
  'Under $10k',
  '$10k – $25k',
  '$25k – $50k',
  '$50k+',
  'Not sure yet',
] as const;

export const timelines = [
  'As soon as possible',
  'Within 1–3 months',
  '3–6 months',
  'Just exploring',
] as const;

export const contact = {
  /** POST endpoint for the form. Empty → falls back to a prefilled mailto. */
  endpoint: '',
  /** Direct scheduling link (Cal.com / Calendly). Empty → the scheduling card invites an email instead. */
  schedulingUrl: '',
  responseTime: 'within one business day',
} as const;

export type Project = {
  name: string;
  url: string;
  descriptor: string;
  tags: string[];
  image: string;
  /** Aspect-ratio dimensions of the screenshot for CLS-free rendering. */
  width: number;
  height: number;
};

export const projects: Project[] = [
  {
    name: 'Pura Capoeira',
    url: 'https://puracapoeira.com',
    descriptor:
      'The home of an international capoeira school spanning Mexico, Brazil, Angola and the USA — locations, professors, events and gallery, in three languages.',
    tags: ['Community platform', 'Multi-location', 'Multilingual'],
    image: '/images/work/pura-capoeira.jpg',
    width: 1440,
    height: 900,
  },
  {
    name: 'Capoeira is Life',
    url: 'https://capoeirais.life',
    descriptor:
      'A multilingual apparel brand and store for the global capoeira community — built to sell the culture, not just the merch.',
    tags: ['Brand & identity', 'E-commerce', 'Multilingual'],
    image: '/images/work/capoeirais.jpg',
    width: 1440,
    height: 900,
  },
  {
    name: 'Kenia Navarro',
    url: 'https://kenianavarro.com.mx',
    descriptor:
      'A quiet, editorial portfolio for a contemporary dancer and movement researcher — works, workshops and a practice journal, in two languages.',
    tags: ['Portfolio', 'Art direction', 'Bilingual'],
    image: '/images/work/keni-navarro.jpg',
    width: 1440,
    height: 900,
  },
  {
    name: 'Pura Capoeira Cuernavaca',
    url: 'https://capoeiracuernavaca.com',
    descriptor:
      'A local capoeira school in Cuernavaca — classes, enrollment, a shop and WhatsApp booking for a growing community.',
    tags: ['Community platform', 'E-commerce', 'Booking'],
    image: '/images/work/capoeira-cuernavaca.jpg',
    width: 1440,
    height: 900,
  },
];

/** Hosting / platform partners. */
export const partners: string[] = ['WordPress VIP', 'Kinsta', 'WP Engine'];

/** Agencies and enterprises collaborated with. */
export const collaborators: string[] = ['10up', 'Capgemini', 'Enzo Biochem'];

export type IconName =
  | 'architecture'
  | 'blocks'
  | 'terminal'
  | 'flow'
  | 'arrow'
  | 'spark'
  | 'check'
  | 'external';
