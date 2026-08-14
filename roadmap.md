# OrcaLink Roadmap

> B2C SaaS for freelancers to create, send, and track quotes via shareable links.

All 31 steps implemented. 36 tests passing.

---

## Phase 1 — Foundation

### Logic

- [x] **1.** Add plan_type column to users table
      → `database/migrations/xxxx_add_plan_type_to_users_table.php`, `app/Models/User.php`

### UI

- [x] **2.** Edit plan field in profile page
      → `resources/views/profile/edit.blade.php`
- [x] **3.** Build dashboard stat cards
      → `resources/views/dashboard.blade.php`

---

## Phase 2 — Quote CRUD

### Logic

- [x] **4.** Create quotes table migration
- [x] **5.** Create quote_items table migration
- [x] **6.** Create Quote model
- [x] **7.** Create QuoteItem model
- [x] **8.** Create factories + seeders
- [x] **9.** Create StoreQuoteRequest
- [x] **10.** Create QuoteController
- [x] **11.** Register resource routes
- [x] **12.** Write CRUD feature tests

### UI

- [x] **13.** Build quotes index view
- [x] **14.** Build quote create view
- [x] **15.** Build quote edit view
- [x] **16.** Build quote show view
- [x] **17.** Dynamic line items JavaScript

---

## Phase 3 — Public Shareable Quote

### Logic

- [x] **18.** Add UUID + share_token to quotes
- [x] **19.** Create PublicQuoteController
- [x] **20.** Register public routes
- [x] **21.** Add view tracking
- [x] **22.** Add approve/reject endpoints
- [x] **23.** Add expiration check + Artisan command

### UI

- [x] **24.** Build public quote view

---

## Phase 4 — Business Rules

### Logic

- [x] **25.** Create QuoteStatus enum
- [x] **26.** Build CheckQuoteLimit middleware
- [x] **27.** Enforce status lifecycle transitions
- [x] **28.** Schedule expiration command

---

## Phase 5 — Launch

### Logic

- [x] **29.** Deploy config + Dockerfile
- [x] **30.** Error monitoring setup

### UI

- [x] **31.** Build landing page
