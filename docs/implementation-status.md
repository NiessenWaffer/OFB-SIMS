# OFB-SIMS Progress Report

## Purpose

This report explains what has been built so far in plain language and identifies what still requires an approved business decision.

## Completed work

### Main application screen

The system now has a clean administrative layout with:

- A side menu.
- A top navigation area.
- A main working area.
- Navigation for Shipments, Sampling Plans, and Inspections.
- A responsive design for desktop and mobile screens.

### Shipment Management

Shipment Management is complete for the current phase.

Staff can:

- View all registered shipments.
- Search shipments by delivery reference, denomination, or supplier.
- Move through shipment records when there are many results.
- Register a new shipment.
- See clear messages when information is missing or invalid.
- View the complete details of a shipment.
- Edit an existing shipment.
- Update box codes without losing letters, hyphens, or leading zeroes.
- Return to the shipment details after saving an update.

Shipment information is stored and retrieved from the actual project database. The shipment list is not using demonstration records.

### Sampling Plans viewing screen

A read-only Sampling Plans screen has been added.

Staff can:

- Open Sampling Plans from a shipment's details.
- See which shipment the plans belong to.
- View existing plans if they have been recorded.
- See the standard reference.
- See the planned number of sample boxes, bundles, and notes.
- See the current plan status.
- See “Not yet determined.” when information is missing.
- See a clear message when the shipment has no sampling plans.

The screen does not create or change sampling plans.

## What has deliberately not been built

The following items remain on hold:

- Automatic ISO sample calculations.
- ISO lookup tables.
- Automatic selection of physical boxes or bundles.
- Acceptance and rejection decisions.
- Sampling plan creation or editing.
- Approval and locking of sampling plans.
- Inspection recording and approval workflows.

These items are on hold because the official standard, internal procedure, and approval rules have not yet been formally confirmed.

## Important decisions still needed

Management should confirm:

1. Which ISO edition the organization will use.
2. Whether the three-stage box, bundle, and note process is officially approved.
3. How defects, acceptance, and rejection will be decided.
4. How the physical boxes will be selected.
5. Whether packaging quantities may vary between shipments.
6. Whether one shipment may have multiple sampling plans.
7. Who can approve or finalize a sampling plan.

These questions are documented in the stakeholder sign-off document.

## Review of current progress

The Shipment Management phase is working and has passed the available automated checks. The system can save, retrieve, display, and update shipment records.

The Sampling Plans area is currently a safe viewing shell. It is connected to the shipment record, but it does not make unapproved decisions or calculations.

## Current risks to resolve

- The example packaging values of 50 bundles per box and 1,000 notes per bundle must not be treated as permanent rules without approval.
- Deleting a shipment may also remove its related sampling plans. The organization must decide whether this is acceptable.
- The rules for plan revisions and approvals are not yet defined.

## Recommended next step

Obtain stakeholder approval for the seven sampling decisions before building calculation or plan-entry features. Once approved, use one official example shipment to verify the rules before automating them.
