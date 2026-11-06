---
name: ofb-sims-code-standards
description: Apply OFB-SIMS coding standards when implementing, debugging, refactoring, or reviewing Laravel 13, Vue 3, Inertia, Eloquent, MySQL, validation, or sampling logic. Prefer the smallest correct conventional solution; detect overengineering, N+1 queries, unsafe changes, and invented business rules.
---

# OFB-SIMS: Practical coding and review skill

Use this skill for code changes or reviews in OFB-SIMS. Read the root `AGENTS.md` first. Work with the existing codebase; do not create an architecture or new folders merely because this skill mentions them.

## 1. Decide before coding

1. State the exact behavior to add or fix in one sentence.
2. Locate the closest existing route/controller/model/page/test. Check installed framework versions and local patterns rather than guessing APIs.
3. Pick the **fewest files and layers** that solve the current task. Prefer modifying an existing file over creating a wrapper.
4. If an OFB business rule is missing, do not guess it. Explain the assumption or leave the feature unimplemented pending confirmation; never silently make the workbook's example data into a real policy.
5. Keep the diff scoped. Do not rename, reformat, reorganize, or modernize unrelated code.

## 2. Choose the simplest implementation

- First choice: native Laravel route/controller/request/model/policy + Inertia page and Vue component.
- Eloquent relationships and query builder before handwritten SQL; use raw SQL only when justified and parameterized.
- A controller can directly make a clear, short Eloquent call. **Do not force every request through a service.**
- Extract a service for substantial domain logic, multiple coordinated steps, or logic reused in multiple entry points. A pure `SamplingCalculator` may be appropriate **after rules are approved**; no generic `BaseService`.
- No repository interfaces wrapping Eloquent, CQRS, command buses, event sourcing, microservices, DTOs, or patterns copied from larger apps unless a real limitation demands them.
- Use early returns and short functions where they improve readability. Do not split a readable operation into many one-line functions.
- Do not introduce `$data`, `$result`, `$value`, or `$payload` just to pass a single expression onward. Introduce named intermediates for clarity, reuse, side-effect control, or debugging.
- Avoid extra `try/catch` that only rethrows or hides an error. Handle exceptions at the right boundary.
- Avoid excessive defensive code for impossible internal states; validate real external inputs and enforce real invariants.

## 3. Query efficiency: fix N+1 at the database boundary

- Before iterating models, check which related properties will be accessed. Use `with()`, constrained eager loading, or `load()` where appropriate.
- For counts/existence/sums, use `withCount()`, `withExists()`, `withSum()`, `count()`, `exists()`, or database aggregates **without loading every related row**.
- Filter/sort/group in SQL when it avoids downloading large datasets; use Collections for readable **in-memory** transformations on already-bounded data.
- Do not replace every `foreach` with `collect()->map()`; both iterate. Prefer whichever makes intent clearer. Avoid expensive chained transformations when a simple pass is clearer.
- Paginate user-facing tables. Do not use unbounded `::all()`/`->get()` for large shipments, bundles, or banknotes.
- For large background operations use `chunkById()` / `lazyById()` when mutation may affect the result set; select only needed columns.
- Avoid queries inside loops unless intentionally batched and justified. For writes, consider validated `insert()`/`upsert()` or a transaction, while preserving events/observers if those matter.
- Use indexes for actual frequent search/join patterns and unique constraints for true invariants; avoid indexes on every column.
- Diagnose performance with query counts, execution plans, or measurements rather than speculative optimization.

Example: prefer a relationship count without per-row queries:

```php
// BAD: count() executes a query for each shipment.
$shipments = Shipment::all();
foreach ($shipments as $shipment) {
    $shipment->sampleBoxes()->count();
}

// BETTER: one paginated query with a related count.
$shipments = Shipment::query()
    ->withCount('sampleBoxes')
    ->latest()
    ->paginate(20);
// Use $shipment->sample_boxes_count in the page props.
```

## 4. Laravel and Inertia boundaries

- Controller: accept a request, authorize, call minimal required logic, return `Inertia::render()` or a redirect. Do not compute complex sampling rules in a controller.
- Form Request: validate input when form rules are nontrivial or deserve a named class. Use built-in validation for a trivial one-off case.
- Policy/Gate: enforce permission to view, modify, inspect, export, or approve records on the server; hiding a button in Vue is not authorization.
- Model: relationships, casts, and small model-specific behavior. Avoid giant models full of workflow orchestration.
- Database transaction: use when multiple dependent writes must be atomic, not as a default wrapper for every read or save.
- Schema: use migrations, referential integrity, and unique constraints where needed; avoid duplicating derived totals as mutable fields without a requirement.
- Inertia: pass only the props a page needs. Avoid duplicating an API just to populate normal Inertia pages.
- Do not log shipment identifiers, banknote identifiers, personal data, or credentials unless logging is approved and appropriately protected.

## 5. Vue 3: keep the interface straightforward

- Use the existing Vue and Inertia form conventions; keep state local unless sharing is necessary.
- Use `computed()` for meaningful derived reactive values, ordinary functions for actions, and `watch()` only for a real side effect. Avoid unnecessary watchers mirroring props into extra state.
- Do not create a composable for a one-line helper or a component used once unless it materially improves a complex page.
- Keep frontend sampling calculations informational unless approved as authoritative; backend must validate authoritative records.
- Avoid both client-side filtering of enormous datasets and unnecessary API calls; use server-side query parameters and pagination.
- Provide clear empty/loading/error states when relevant; do not build a generic UI framework just for one form.

## 6. Reliability, security, and domain truth

- Treat HTTP data, files, and query parameters as untrusted. Validate data types, ranges, ownership, and permissions.
- Guard mass assignment: write only approved fields, never trust client-supplied role, status, totals, or ownership fields.
- Prevent duplicate sample identifiers/records with confirmed unique constraints; do not rely on a `first()` then `create()` check alone under concurrency.
- Never swallow exceptions, silently return success, or remove errors to make tests pass.
- Preserve existing records; do not run `migrate:fresh`, delete existing data, or change deployed schema without explicit approval.
- No invented sample-selection algorithms, ISO acceptance/rejection decisions, QC thresholds, reviewer roles, or approvals. Demo workbook values are examples, not established business rules.
- Keep secrets in environment/configuration; never commit `.env`, credentials, or real inspection data.

## 7. Meaningful tests, not test theater

- Test changed functionality at the cheapest useful layer: feature tests for endpoints/authorization/persistence; unit tests for pure calculations.
- Cover invalid input, unauthorized access, duplicates, empty results, and relevant calculation boundaries.
- For query-heavy screens, verify queries when an N+1 regression is a realistic risk.
- Follow the project's existing Pest/PHPUnit and frontend test setup. Do not install a new testing stack just to write one test.
- Run only available, relevant checks (for example, `php artisan test --filter=Shipment`, `vendor/bin/pint --test`, `npm run build` when configured). Report exact results; do not claim all tests passed if only some ran.

## 8. Final self-review: common AI-assistant failure modes

Before reporting completion, ask:

- Did I add unrequested features, packages, files, architecture layers, or speculative abstractions?
- Did I create a temporary variable, wrapper, helper, collection chain, or watcher that does not clarify anything?
- Did I fetch all records, query inside a loop, or load relations only to count them?
- Did I introduce hidden state, duplicated sources of truth, or an unnecessary frontend/backend split?
- Did I assume a method/API exists without checking the installed framework/version?
- Did I forget authorization, validation, sensitive data handling, race conditions, or a useful constraint?
- Did I change unrelated behavior, overwrite records, or add debugging leftovers?
- Did I make up OFB rules based on demonstration data?
- Did I add proportionate tests and run the checks I report?

**Response format:** Briefly state what changed, why this is the simplest suitable approach, tests/checks actually run, and unresolved requirements. No long self-congratulatory explanation.
