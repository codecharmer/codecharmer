# Client Evidence Kit

The working kit for turning delivered projects into publishable proof. This
unblocks the highest-leverage remaining playbook items: the outcome-led
case-study rewrites (CASE-001/002), named testimonials, and the homepage
proof strip. Nothing collected here is published without explicit written
permission.

## 1. The interview script

One conversation per client, 30 to 45 minutes, recorded with consent. Ask in
this order; the early questions make the later ones concrete.

1. Walk me through what your staff did before this system existed, for one
   real task. Who touched it, in which tools, and how long did it take?
2. How many people and roughly how many hours a week did that consume?
3. What failed, got delayed, or simply never happened because of the old way?
4. What can customers or staff do now that they could not do before?
5. What volume has the system handled since launch? Orders, publishes,
   locations, users: whatever the natural unit is.
6. Did any number you track change? Repeat purchases, order completion,
   response time, publishing time, error rate. If you do not track it,
   say so, that is a finding too.
7. Which of these results are you comfortable seeing published, with what
   attribution: name, role, company?
8. If another owner in your position asked about working with us, what would
   you tell them? (Capture verbatim: this is the testimonial candidate.)

Close by scheduling the permission follow-up, not by asking for permission on
the spot. People give better, calmer consent in writing a day later.

## 2. Permission and evidence matrix

One row per claim, kept in this file or a sheet. A claim ships only when
every column is filled.

| Client | Claim | Evidence basis | Measurement period | Permission status | Attribution granted | Where used |
|---|---|---|---|---|---|---|
| Pacífica Panadería | e.g. orders processed across 3 surfaces | POS/WooCommerce records | e.g. Mar–Aug 2026 | requested / granted (date) / declined | name + company / anonymous / none | case study, homepage strip |
| Haramara Café | | | | | | |
| Gramo Café | | | | | | |
| Praxis (own product) | technical metrics need no permission, only measurement notes | live endpoints | dated | n/a | n/a | case study |

Rules: never retrofit an uplift number; label every estimate as an estimate;
a declined permission removes the claim everywhere, including sales decks.

## 3. Measurement fallback ladder

Use the highest rung the evidence supports, and say which rung it is:

1. Revenue, profit, or conversion impact
2. Cost or staff-hours saved
3. Cycle time or error reduction
4. Adoption, repeat use, order volume, editorial volume
5. Capability unlocked across a stated number of users, locations, systems
6. Verified technical performance or reliability

Rung 6 alone is acceptable only for technically sophisticated buyers. The
current case studies live on rungs 5 and 6; the interviews exist to climb.

## 4. Consolidated owner questionnaire

Every open input across the playbook, in one place. Items unblock in the
order listed.

| # | Input | Unblocks | Status |
|---|---|---|---|
| 1 | Three client interviews (script above) | CASE-001/002 rewrites, homepage proof strip | open |
| 2 | Two-plus permissioned testimonials (quote, name, role, company) | testimonial blocks on home + audit page | open |
| 3 | Founder identity: bio, photo, track record, LinkedIn/GitHub URLs | About rewrite, audit-page named expert, `sameas_urls` setting | open |
| 4 | Calendar provider + booking URL | `scheduling_url` setting; activates every "schedule" path | open |
| 5 | Plausible account (hosted or self-hosted) | `plausible_domain` setting; activates all funnel analytics | open |
| 6 | Real test lead through the audit form after deploy | confirms production mail transport | open |
| 6b | First audit delivered, then permission for a redacted sample ([delivery kit §6](audit-delivery-kit.md)) | replaces the sample marker on the audit page | open |
| 7 | Embedded-capacity price band for agency partners | replaces the scoped-per-engagement wording on /agency-partners/ | open |
| 8 | Review + publish decision on the two seeded insight drafts | first content ships; insights joins the nav | open |
| 9 | Client logos / screenshots publication permissions | future logo usage, social cards per case study | open |
| 10 | `/cancellation-policy.html`: legally required or stays 404? | closes the last legacy-URL question | open |
| 11 | CRM choice + pipeline stages | lead storage beyond email; playbook §12 stages | open |
| 12 | Search Console: confirm sitemap + monitor the five /services/ 301s | migration hygiene | open |

## 5. Publishing checklist per case study

Before an outcome-led rewrite ships:

- [ ] Interview held and notes filed
- [ ] Every claim has a filled matrix row
- [ ] Written permission on file (email is fine)
- [ ] Measurement period labeled in the copy
- [ ] Client voice quoted verbatim and approved by the client
- [ ] Honest limitations section retained (what remains, what was not measured)
