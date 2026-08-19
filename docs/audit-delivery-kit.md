# Audit Delivery Kit

The working kit for selling and delivering the WordPress Operations &
Automation Audit repeatedly, without reinventing it per client. Every
number and promise here mirrors the public audit page; if scope, price,
or timeline changes there, change it here in the same commit. Companion
to [acquisition-kit.md](acquisition-kit.md), which fills the calendar,
and [client-evidence-kit.md](client-evidence-kit.md), which proves the
work afterward.

Ground rules, the same ones the site makes in public: never invent a
number, label every estimate as an estimate, and when a plugin or an
off-the-shelf tool is the right answer, the plan says so. The plan must
be executable by any competent team, including one that is not us. That
honesty is the product.

## 1. Scope statement (before payment)

The page promises scope and timeline fixed before payment. This is the
one-page document that fixes them, sent with the payment request after
the inquiry reply. Nothing starts without a signed-off copy.

Template, one page, plain language:

> **WordPress Operations & Automation Audit for [company]**
>
> **Systems in scope:** [the WordPress install(s), plus each connected
> system we will review: CRM, commerce, DAM, search, forms, analytics]
>
> **Workflows in scope:** [the two to four named workflows we will map,
> e.g. "publish a product update", "fulfill an online order"]
>
> **Out of scope:** [anything adjacent we will not review, named
> explicitly: other sites, mobile apps, systems we get no access to]
>
> **Access needed by day 1:** [from the checklist in section 2]
>
> **Your team's time:** two to three hours total across the ten days,
> mostly short workflow conversations.
>
> **Price:** US$[2,500 or scoped higher], paid upfront. If you
> commission an implementation of US$25,000 or more within 30 days of
> the decision call, up to 50% of this fee credits toward it.
>
> **Timeline:** ten business days, starting the day we have access and
> the kickoff call, not the day of payment.
>
> **You get:** the workflow map, technical findings, ranked
> opportunities with reasoning, an architecture recommendation, a
> 90-day implementation plan, and a decision call. The findings are
> yours whether or not we implement them.

Multi-site or unusually large operations scope higher; say the exact
number in this document, never after it.

## 2. Days 1 to 2: access and kickoff

Access checklist, requested with the scope statement so day 1 is not
spent waiting:

- [ ] WordPress admin (administrator role, own account, never shared)
- [ ] Hosting or server panel, or a contact who can pull logs/config
- [ ] Read access to each in-scope connected system, or a screen-share
      session scheduled with its owner
- [ ] Analytics and Search Console read access, where they exist
- [ ] Staging environment details, or confirmation none exists (that
      is a finding, not a blocker)
- [ ] The list of people who actually run the in-scope workflows, with
      15-to-30-minute slots booked in week one

Kickoff call agenda (30 to 45 minutes):

1. Where it hurts most, in their words. Capture verbatim.
2. Walk each in-scope workflow once, end to end, at the headline level.
3. What a good outcome from the audit looks like to them.
4. Confirm the interview slots and the day-10 decision call.

## 3. Days 3 to 7: investigation

Two tracks, run in parallel.

**Workflow mapping**, with the people who do the work, not their
managers. Per workflow, capture: the trigger, every step, the tool each
step lives in, who touches it, how long it takes, where it waits, and
what happens when it fails. The interview questions in the
[client evidence kit](client-evidence-kit.md) adapt directly; the only
difference is tense (present pain instead of past results).

**Technical review**, against the mapped workflows rather than in the
abstract:

- Architecture: theme/plugin split, custom code location and quality,
  data model fit, multisite/headless topology if present
- Integrations: how data enters and leaves WordPress, retry and failure
  behavior, duplicated or manually re-typed data
- Performance: Core Web Vitals field data where available, lab data
  otherwise, labeled as which
- Reliability: backups, update process, release process, staging
  discipline, single points of failure
- Editorial experience: what publishing actually takes, in clicks and
  handoffs, for the mapped workflows
- Security posture: user roles, credential sharing, plugin provenance,
  update lag

Every observation gets a row in the findings register as it is found,
not reconstructed in week two:

| # | Observation | Evidence | Consequence | Category |
|---|---|---|---|---|
| 1 | what we saw, plainly | screenshot, log, timing, quote | what it costs them | one of: revenue enabled, hours saved, errors reduced, cycle time reduced, risk reduced, capability unlocked |

## 4. Days 8 to 9: the deliverable

One document, written to be acted on. Fixed skeleton:

1. **Executive summary.** One page. The three findings that matter
   most, in business terms, and what the 90-day plan buys.
2. **Workflow map.** Each in-scope workflow as steps, tools, people,
   and time, with the waits and failure points marked. A diagram per
   workflow; the notation matters less than legibility.
3. **Technical findings.** The register from section 3, cleaned up,
   every row keeping its evidence. No finding without evidence, no
   evidence without a finding.
4. **Opportunity ranking.** Each opportunity scored for estimated
   impact against estimated effort, with the reasoning shown in a
   sentence or two per cell. Estimates are labeled as estimates, with
   the basis stated (their numbers, our measurement, or analogy to a
   named comparable build). Opportunities where the right answer is an
   existing plugin, a SaaS tool, or doing nothing are listed with the
   same rigor as the ones we would build.
5. **Architecture recommendation.** Grounded in what they have.
   Alternatives considered and rejected, with the rejection reasons,
   including "keep everything as is."
6. **90-day implementation plan.** Three 30-day phases, each with the
   opportunities it captures, the order-of-magnitude budget band, and
   what becomes possible at the end of it. Written so any competent
   team can execute it.

## 5. Day 10: decision call and follow-up

Agenda (60 minutes):

1. Walk the executive summary, then the ranking. Spend the time on the
   top three, not on reading the document aloud.
2. Answer the hard questions. Invite them explicitly.
3. Lay out the next-step options evenly: implement with us, run a
   scoped sprint first, hand the plan to another team, or stop here.
   The plan supports all four; say so.
4. If they want a proposal, agree on which phase-one opportunities it
   should cover and promise a date.

Proposal skeleton, when asked for one:

- Each deliverable tied to one of the six consequence categories from
  the findings register, so the business case traces back to evidence.
- What is not included, named explicitly. Scope ambiguity erodes
  margin and trust in that order.
- Price and payment: 40 to 50% to start, milestone payments after,
  audit credit applied and shown as a line item when it qualifies.
- Timeline with the same honesty as the audit's: a start trigger, not
  a start date.

## 6. Producing the redacted sample

The audit page carries an owner-input marker for a redacted sample
deliverable. After the first real delivery:

1. Ask the client for written permission to publish a redacted version,
   using the follow-up pattern from the evidence kit (in writing, a day
   later, never on the call).
2. Redact identity, numbers the client considers sensitive, and
   anything security-relevant (URLs, versions, credentials, topology
   details an attacker could use).
3. Export the executive summary, one workflow map, two findings rows,
   and the ranking table format. The sample shows the shape and rigor,
   not the client's business.
4. Publish it linked from the audit page and replace the marker in
   `data/pages.php`.

Until then the marker stays; a fabricated sample is worse than none.

## 7. After delivery

- File the engagement in the CRM: stage, dates, price, and the win/loss
  reason if it stalls (controlled list in the acquisition kit).
- Record delivery hours against the fee; the audit stays priced right
  only if margin is tracked from audit number one.
- Six to eight weeks after any implementation ships, the client enters
  the evidence-kit interview flow. The audit's before-state workflow
  map is the baseline that makes the after-state measurable; keep it.
