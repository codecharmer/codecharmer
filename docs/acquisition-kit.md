# Acquisition Kit

The working kit for the founder-led sales motion: channel playbooks with
ready-to-personalize templates, the CRM stage model, and the weekly
dashboard. Companion to [client-evidence-kit.md](client-evidence-kit.md),
which produces the proof these messages point at. Channels run in the
order listed; each later channel assumes the earlier ones are moving.

Ground rules that apply to every channel: no bulk "checking in" campaigns,
no scare tactics, no fake personalization, no automated mass outreach.
Every message leads with a specific observation about the recipient's
system, and every claim in a message must already be published on the
site or cleared through the evidence matrix.

## 1. Past-client reactivation

Within seven days of the audit offer being live. One pass over every past
client, then done; this is a review, not a campaign.

Process, per client:

1. Review their current site and what we know of their operations.
2. Identify one credible opportunity: revenue, workflow, performance, or
   reliability. If there is none, skip the pitch and send only the
   referral/testimonial ask.
3. Send the personal note below, adapted until it could not have been
   sent to anyone else.
4. Record outcome in the CRM regardless of reply.
5. Ask satisfied clients for a referral and a testimonial even if they do
   not buy (feeds the evidence kit).

Template:

> Subject: One operational improvement for [company]
>
> I reviewed [specific workflow/page/system] and noticed [specific
> observation]. It may be creating [time/revenue/reliability
> consequence], especially now that [context]. We have packaged a
> 10-business-day WordPress Operations & Automation Audit that maps the
> workflow, quantifies the opportunities we can verify, and gives you an
> implementation-ready plan. It starts at US$2,500, and you own the
> findings. If this is timely, I can send the exact scope I would
> recommend for [company].

## 2. Agency partnerships

Target: agencies with strong brand/marketing work and visible WordPress
projects, but limited senior engineering depth. Destination is
`/agency-partners/` (white-label, direct, and embedded modes are already
published there).

Cadence: 20 highly relevant contacts researched per week, of which 5 get
deeply personalized notes. Offer paid discovery, fixed-scope builds, or
reserved monthly capacity. Never offer unlimited development, and never
promise response times or capacity we cannot deliver.

Template:

> Subject: The WordPress layer behind [client/example]
>
> Your work for [client/example] is strong. I noticed your team leads
> [brand/design/marketing], while Code Charmer handles the
> WordPress/application layer agencies usually do not want to staff
> permanently: custom blocks, integrations, portals, WooCommerce
> operations, and automation. We work invisibly or directly, with fixed
> scope, ownership, and documented handoff. If overflow or an unusually
> technical WordPress brief appears, I can show you two relevant builds
> and our partner model.

## 3. Account-based direct outreach

Only organizations matching the ICP and showing a trigger. Good triggers:

- WordPress plus multiple disconnected forms/tools
- Hiring for content operations or WordPress engineering
- Visible multi-location or manual process
- New site, rebrand, or acquisition
- Broken or slow editorial flow
- Public AI/content initiative

Weekly founder motion:

- 20 researched accounts
- 5 personalized 3-to-5-minute teardown videos or annotated audits
- 15 concise, observation-led messages
- 2 useful public posts
- Follow-up at 3, 7, and 14 business days, each with new information,
  then stop

Opening message skeleton (the observation is the message; the offer is
one line at the end):

> Subject: [Specific observation about their system]
>
> [What we noticed, stated plainly, with why it likely costs them time,
> revenue, or reliability. One short paragraph, no adjectives.]
>
> [One sentence on the comparable thing we have built or fixed, linking
> to the published case.]
>
> If this is worth an hour, our paid audit maps the whole workflow and
> prices the fixes; happy to send the exact scope I would propose.

## 4. Organic search and email

Bottom-funnel pages first (live). Email capture only in exchange for
something genuinely useful; the audit-method article doubles as the
checklist offer. Nurture sequence, one message each: diagnosis, example,
decision guide, audit invitation; the drafts, entry/exit rules, and
sending rules live in [nurture-sequence.md](nurture-sequence.md).
Measure before believing any external benchmark about email versus
paid.

## Paid media gate

No broad search or social spend until all four are true:

1. The audit page has converted at least five qualified leads from
   direct, outbound, or referral traffic.
2. The lead-handling workflow is tested end to end.
3. Conversion value and qualification are recorded in the CRM.
4. Negative keywords and geographic targeting are defined.

Then a small, capped test on exact/high-intent terms plus retargeting.
Optimize to qualified opportunities, never to raw form submissions.

## Lead response SLA

- Immediate confirmation email with honest next steps (automated, live).
- During stated business hours: personal acknowledgment within 15
  minutes when feasible, hard ceiling one business hour.
- After hours: a truthful time promise and the scheduling option.
- Every lead gets an owner, a next action, and a timestamp in the CRM.

## CRM stages

1. New inquiry
2. Marketing qualified
3. Sales accepted
4. Fit call held
5. Paid audit proposed
6. Paid audit won/lost
7. Implementation proposed
8. Implementation won/lost
9. Retainer won/lost

Loss reasons, controlled list only: budget, timing, no decision,
capability mismatch, trust/proof, competitor, internal build,
unresponsive, other.

## Weekly dashboard

Reviewed weekly, in this order. Traffic that does not create qualified
pipeline is not celebrated.

| Metric | Source |
|---|---|
| Sessions by source and landing page | Plausible |
| Qualified inquiries by source | CRM |
| Fit calls booked/held | Calendar + CRM |
| Paid audits proposed/won | CRM |
| Implementation pipeline value and weighted value | CRM |
| Average deal size | CRM |
| Sales-cycle days | CRM |
| Win/loss reasons | CRM |
| Lead-response time | Inbox + CRM timestamps |
| Retainer MRR and churn | Accounting |
| Gross margin by offer | Accounting |
| Search impressions/clicks for commercial pages | Search Console |

Initial management targets (revise after 60 to 90 days of real data;
these are targets, not promises):

| Metric | Initial target |
|---|---:|
| Qualified landing-page visitor to inquiry | 4 to 6% |
| Inquiry to qualified fit call | at least 50% |
| Fit call to paid audit | 25 to 40% |
| Paid audit to implementation | 30 to 50% |
| Proposal to closed-won | at least 30% |
| Implementation to retainer attach | at least 40% |
| Personal response during business hours | under 1 hour, aim for 15 minutes |
| Project gross margin | at least 55% |

## Operational dependencies

Still owner-gated, tracked in `data/pages.php` markers and the evidence
kit: `plausible_domain` (dashboard's traffic rows are blind until set),
`scheduling_url` (the direct-booking path), CRM choice itself (any tool
with the nine stages above works; a spreadsheet qualifies at current
volume), and permissioned proof for outreach attachments.
