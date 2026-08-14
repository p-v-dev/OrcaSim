# OrcaLink — Handoff

## Current Status

MVP is functional. 36 tests pass. SQLite database. All critical bugs resolved.

---

## Resolved (MVP Complete)

| Issue | Fix |
|---|---|
| Alpine.js not installed | `npm install alpinejs`, wired up in `bootstrap.js` |
| `@stack('scripts')` missing | Added to `app.blade.php` + `guest.blade.php` |
| `quoteForm()` duplicated | Extracted to `resources/js/quotes.js` via Vite |
| Alpine start before function defined | Import order swapped in `app.js` (quotes → bootstrap) |
| `:name` PHP backtick → empty names | Changed to `x-bind:name` on item inputs |
| No items submitted → validation loop | Items now submit with correct `name` attributes |
| Expiration `after:today` → can't set today | Changed to `after_or_equal:today` |
| Inline limit check in `store()` only | Removed; middleware `quote.limit` applied to route |
| Limit middleware registered but unused | Applied to `POST /quotes` in `routes/web.php` |
| No back button on create | Added "Back to Quotes" header link |
| Items reset on validation failure | `quoteForm(@json(old('items', [])))` preserves submitted data |
| No validation error for items | Added `x-input-error` for `items` |
| Send redirects to index | Changed to `quotes.show` — land on page with share link |
| No way to preview client view | Added "Preview as Client" link on show page |
| Public view expired at midnight `isPast()` | Changed to `endOfDay()->isPast()` |
| Public view never marks as viewed | `$quote->status === 'sent'` was comparing enum to string → always false |
| Approve/reject used magic strings, not enums | Changed to `QuoteStatus::Approved` / `::Rejected` |
| Delete modal not working | Replaced with inline `confirm()` form (no Alpine dependency) |
| No quota visibility | Added quota badge on dashboard + create page |
| No limit error shown on create | Added `x-input-error` for `quote` error key |

---

## Minor Issues Still Open

### 1. Dashboard stats overlap
`DashboardController` counts "Viewed" as any quote with `viewed_at` set (even if rejected). "Pending" counts `sent` or `viewed` status. These overlap when a viewed-then-rejected quote is counted in both.

### 2. No confirmation before Send
Send button immediately transitions to `sent` with no confirmation. Once sent, cannot revert (per `canTransitionTo`).

### 3. Empty states
- **Index:** "No quotes yet." — no create CTA in the empty content area (button is in header only)
- **Dashboard:** Create button shown even at limit

### 4. Price formatting
Some views show `$`, some don't. No consistent formatting helper.

### 5. Navigation
No plan/quota indicator in nav bar. Quota banner exists on dashboard + create but not globally visible.

---

## Test Status

```
Tests:    36 passed (95 assertions)
Duration: 2.40s
```

---

## Current Roadmap

| Phase | Status |
|---|---|
| Phase 1: Foundation (plan_type, profile, dashboard) | ✅ Done |
| Phase 2: Quote CRUD (models, controller, views, dynamic items) | ✅ Done |
| Phase 3: Public shareable quote (view, approve/reject, expiration) | ✅ Done |
| Phase 4: Business Rules (enum, limit, status lifecycle, scheduler) | ✅ Done |
| Phase 5: Launch (Dockerfile, landing page) | ✅ Done |
| Phase 6: Payments, Email, Analytics | ❌ See FUTURE.md |
