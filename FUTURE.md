# OrcaLink — Future Plans

## 1. Stripe Payment Integration

Upgrade free accounts to paid plans. Unlocks higher or unlimited monthly quotes.

### What needs to happen

- **Stripe account & API keys** — register at stripe.com, get publishable + secret keys
- **`stripe/stripe-php` dependency** — `composer require stripe/stripe-php`
- **Plans table / config** — define tiers (e.g., Free: 5/mo, Pro: unlimited $9.99/mo)
- **Checkout flow** — user clicks "Upgrade" → redirected to Stripe Checkout → webhook confirms payment → user's `plan_type` updates to `pro`
- **Customer portal** — link to manage subscription (cancel, update payment method)
- **Webhook endpoint** — listen for `checkout.session.completed`, `customer.subscription.deleted`
- **UI** — pricing page, plan badge in nav showing current tier, upgrade CTA when hitting limit

### Key files affected

- `config/stripe.php` — API keys, plans
- `app/Http/Controllers/SubscriptionController.php` — checkout, portal, webhook
- `routes/web.php` — subscription routes + webhook (CSRF excluded)
- `database/migrations/` — maybe `stripe_id`, `trial_ends_at` on users
- `resources/views/` — pricing page, plan UI

---

## 2. Send Quote by Email

Automated email to the client with the shareable link, instead of requiring the user to copy/paste manually.

### What needs to happen

- **Mail config** — set up SMTP / Mailgun / Postmark in `.env`
- **Mailables** — `app/Mail/QuoteSent.php` with the quote details + share link
- **Email template** — `resources/views/emails/quote-sent.blade.php` — branded HTML email showing client name, items table, total, and a "View Quote" CTA button
- **Send on "Send"** — after `$quote->update(['status' => Sent])`, fire the mailable to `$quote->client_email`
- **Send on demand** — "Send Email" button on show page for already-sent quotes
- **Option to toggle** — let user choose whether to send the email or just generate the link

### Key files affected

- `app/Mail/QuoteSent.php`
- `resources/views/emails/quote-sent.blade.php`
- `app/Http/Controllers/QuoteController.php` — call mail after send
- `config/mail.php` — mail driver config

---

## 3. Dashboard Analytics Charts

Visual chart showing quote volume over time (total, pending, viewed, approved, rejected).

### What needs to happen

- **Chart library** — simplest option: use a canvas-based lib like Chart.js via CDN or `npm install chart.js`
- **Data endpoint** — `DashboardController` already passes counts; extend with monthly breakdown for a chart
- **Chart on dashboard** — line or bar chart showing last 6-12 months with series for each status
- **Summary cards** — the existing 3 cards (Total, Viewed, Pending) → update to: Total, Pending, Approved, Rejected (4 cards) with accurate status-based counts

### Status count fixes needed first

Current dashboard counts have overlap issues (see HANDOFF.md #1). Fix before building charts:
- "Viewed" should count `status = viewed` (not just `viewed_at IS NOT NULL`)
- "Pending" could combine Draft + Sent as "awaiting response"
- Add explicit Approved and Rejected cards

### Key files affected

- `app/Http/Controllers/DashboardController.php` — add monthly stats query
- `resources/views/dashboard.blade.php` — add chart canvas + Chart.js init
- `npm install chart.js`

---

## Implementation Order

1. Fix dashboard status counts (prerequisite for charts)
2. Add Chart.js chart to dashboard
3. Set up email sending (Mailgun/Postmark + mailable + template)
4. Integrate Stripe (payments → plan upgrades → automatic limit removal)
