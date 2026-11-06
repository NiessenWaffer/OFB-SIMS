<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });

defineProps({
    shipment: {
        type: Object,
        required: true,
    },
    samplingPlan: {
        type: Object,
        required: true,
    },
});

const displayConfirmedValue = (value) => value === null || value === undefined || value === ''
    ? 'Not yet confirmed'
    : value;

const displayDeterminedValue = (value) => value === null || value === undefined || value === ''
    ? 'Not yet determined'
    : value;

const formatNumber = (value) => value === null || value === undefined
    ? 'Not yet determined'
    : new Intl.NumberFormat().format(value);
</script>

<template>
    <div class="mx-auto max-w-6xl space-y-6">
        <div class="flex items-start gap-4">
            <Link :href="`/shipments/${shipment.id}/plans`" class="mt-1 rounded-lg p-1 text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Back to sampling plans">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
            </Link>
            <div>
                <p class="text-sm text-slate-500">Shipment Details &gt; Sampling Plan</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Sampling Plan</h2>
                <p class="mt-1 text-sm text-slate-500">Read-only information for {{ shipment.delivery_reference }}.</p>
            </div>
        </div>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h3 class="text-base font-semibold text-slate-950">Shipment Information</h3>
            <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
                <div><dt class="detail-label">Delivery Reference</dt><dd class="detail-value">{{ shipment.delivery_reference }}</dd></div>
                <div><dt class="detail-label">Denomination</dt><dd class="detail-value">{{ shipment.denomination }}</dd></div>
                <div><dt class="detail-label">Currency Series</dt><dd class="detail-value">{{ shipment.currency_series }}</dd></div>
                <div><dt class="detail-label">Total Boxes</dt><dd class="detail-value">{{ formatNumber(shipment.total_boxes) }}</dd></div>
            </dl>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h3 class="text-base font-semibold text-slate-950">Sampling Parameters</h3>
            <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2 lg:grid-cols-4">
                <div><dt class="detail-label">Standard</dt><dd class="detail-value">{{ displayConfirmedValue(samplingPlan.standard_ref) }}</dd></div>
                <div><dt class="detail-label">Inspection Level</dt><dd class="detail-value">Not yet confirmed</dd></div>
                <div><dt class="detail-label">AQL</dt><dd class="detail-value">Not yet confirmed</dd></div>
                <div><dt class="detail-label">Status</dt><dd class="detail-value">{{ displayConfirmedValue(samplingPlan.status) }}</dd></div>
            </dl>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-5 sm:px-8">
                <h3 class="text-base font-semibold text-slate-950">Sampling Requirements</h3>
                <p class="mt-1 text-sm text-slate-500">Calculated values will appear here after the rules are approved.</p>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="px-6 py-4">Stage</th>
                            <th class="px-6 py-4">Lot Size</th>
                            <th class="px-6 py-4">Code</th>
                            <th class="px-6 py-4">Required Samples</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-900">Boxes</td>
                            <td class="px-6 py-4">{{ formatNumber(shipment.total_boxes) }}</td>
                            <td class="px-6 py-4">{{ displayDeterminedValue(null) }}</td>
                            <td class="px-6 py-4">{{ formatNumber(samplingPlan.target_sample_boxes) }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-900">Bundles</td>
                            <td class="px-6 py-4">{{ displayDeterminedValue(null) }}</td>
                            <td class="px-6 py-4">{{ displayDeterminedValue(null) }}</td>
                            <td class="px-6 py-4">{{ formatNumber(samplingPlan.target_sample_bundles) }}</td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-slate-900">Banknotes</td>
                            <td class="px-6 py-4">{{ displayDeterminedValue(null) }}</td>
                            <td class="px-6 py-4">{{ displayDeterminedValue(null) }}</td>
                            <td class="px-6 py-4">{{ formatNumber(samplingPlan.target_sample_notes) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 sm:p-8">
            <h3 class="text-base font-semibold text-slate-950">Sample Distribution</h3>
            <p class="mt-2 text-sm text-slate-500">Not yet determined</p>
        </section>
    </div>
</template>

<style scoped>
@reference "../../../css/app.css";

.detail-label {
    @apply text-xs font-medium uppercase tracking-wider text-slate-400;
}

.detail-value {
    @apply mt-1.5 text-sm font-medium text-slate-800;
}
</style>
