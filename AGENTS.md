# OFB-SIMS — AI Coding Rules

Project: Outsourced Finished Banknotes Sampling and Inspection Management System.
Intended stack: Laravel 13, Vue 3, Inertia.js, MySQL; use the TypeScript/JavaScript conventions already present in the repository.

## Goal

Write correct, readable, secure, maintainable code with the **least necessary complexity**.
Prefer established Laravel/Vue conventions over custom architecture. Keep one Laravel application with Inertia pages; do not introduce a separate API, microservices, repositories, or extra infrastructure without a real requirement.

## Working agreement

1. Inspect only the relevant existing files and follow the project's established style before editing.
2. Implement the **smallest complete change**. Do not add unrelated features, refactor unrelated files, or change dependencies without a clear reason.
3. Use the simplest built-in framework feature that solves the problem. Avoid speculative future-proofing, unnecessary layers, generic abstractions, helpers, traits, interfaces, DTOs, and one-use services.
4. Keep controllers focused on HTTP concerns, requests on validation, policies on authorization, models on data/relationships. Extract a service only for meaningful, reusable or multi-step business logic (for example, approved sampling calculations).
5. Write obvious, descriptive code. Avoid needless temporary variables, trivial wrappers, duplicated state, deeply nested conditions, and clever chains. Introduce a variable when it improves clarity or avoids meaningful repeated work.
6. **Prevent N+1 database queries.** Prefer query-level filtering, aggregation, `withCount()`, `exists()`, eager loading, pagination, and efficient writes over fetching all rows and processing them in PHP. A `Collection` does not fix N+1 on its own; `foreach` is fine when it is the clearest tool.
7. Validate inputs and authorize actions **server-side**. Never trust browser props, hidden UI controls, or client-calculated sampling results for access decisions or authoritative records.
8. Preserve data integrity using appropriate database constraints and transactions for operations that must succeed or fail together. Never run destructive migration/reset commands without explicit permission.
9. The supplied Excel sampling workbook contains **demonstration data**. Do not invent sampling selection methods, approval steps, inspection/acceptance rules, employee roles, or ISO compliance. Implement only confirmed requirements; clearly flag unresolved rules.
10. Do not hardcode secrets, expose sensitive records in logs, swallow errors, or leave debugging statements in committed code.
11. Prefer existing dependencies. Add a package, queue, event, observer, abstraction, or global configuration only when the task requires it and the simpler option is inadequate.
12. Add or update focused tests for changed behavior and important edge cases. Run relevant formatting, tests, and build checks if available; report what actually ran and what failed. Never claim unrun tests passed.

## Naming and placement

- PHP: `PascalCase` classes, `camelCase` methods/variables; singular Eloquent models (`Shipment`, `SamplingPlan`); use standard `app/Http/Controllers`, `app/Http/Requests`, `app/Models`, `app/Policies`.
- Database: plural `snake_case` tables (`shipments`, `sampling_plans`), `snake_case` columns, foreign keys such as `shipment_id`.
- Routes: resource-oriented URLs (`/shipments`), conventional route names (`shipments.index`, `shipments.store`).
- Vue: `PascalCase` components; feature-based page directories such as `resources/js/pages/Shipments/Index.vue` when they match the existing starter structure; use `<script setup>`.
- Services: `app/Services/` only when justified; choose domain-specific names such as `SamplingCalculator`, not `BaseManager` or `GenericProcessor`.
- Tests: `tests/Feature` for endpoints/workflows, `tests/Unit` for pure calculation rules; follow the installed test framework.
- Prefer precise domain names: `sampleBoxes`, `shipmentNumber`, `samplingPlan` rather than `data`, `item`, or `result` when ambiguity matters.

## Before finishing any coding task

Check: correct behavior; minimal diff; clear names; no accidental N+1; no unbounded loads; no authorization gap; no invented sampling rules; no unused code; no unnecessary new files; focused tests. Summarize changed files, decisions that matter, checks actually run, and any remaining assumptions.

For detailed review and example patterns, use the `ofb-sims-code-standards` skill in `.agents/skills/ofb-sims-code-standards/SKILL.md` when implementing or reviewing Laravel/Vue/Inertia code.
