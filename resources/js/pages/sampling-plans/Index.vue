<script setup>
import { Link } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });

defineProps({
    shipment: {
        type: Object,
        required: true,
    },
    plans: {
        type: Object,
        required: true,
    },
});

const displayValue = (value) => value === null || value === undefined || value === ''
    ? 'Not yet determined.'
    : value;

const formatNumber = (value) => value === null || value === undefined
    ? 'Not yet determined.'
    : new Intl.NumberFormat().format(value);
</script>

<template>
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex items-start gap-4">
            <Link :href="`/shipments/${shipment.id}`" class="mt-1 rounded-lg p-1 text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Back to shipment details">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
            </Link>
            <div>
                <p class="text-sm text-slate-500">Sampling Plans</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">{{ shipment.delivery_reference }}</h2>
                <p class="mt-1 text-sm text-slate-500">Read-only plans for {{ shipment.supplier_name }}.</p>
            </div>
        </div>

        <div v-if="shipment.delivery_reference.startsWith('DEMO')" class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">Demonstration Data: these sampling plans are for local development and do not represent approved operational rules.</div>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-semibold text-slate-950">Parent shipment</h3>
                    <p class="mt-1 text-sm text-slate-500">The sampling plans below belong to this shipment.</p>
                </div>
                <Link :href="`/shipments/${shipment.id}`" class="text-sm font-semibold text-indigo-700 hover:text-indigo-900">View Shipment</Link>
            </div>
            <dl class="mt-6 grid gap-5 sm:grid-cols-3">
                <div><dt class="detail-label">Delivery Reference</dt><dd class="detail-value">{{ shipment.delivery_reference }}</dd></div>
                <div><dt class="detail-label">Denomination</dt><dd class="detail-value">{{ shipment.denomination }}</dd></div>
                <div><dt class="detail-label">Supplier</dt><dd class="detail-value">{{ shipment.supplier_name }}</dd></div>
            </dl>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-200 px-6 py-5">
                <h3 class="text-base font-semibold text-slate-950">Existing sampling plans</h3>
            </div>

            <div v-if="plans.data.length" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="px-6 py-4">Standard Reference</th>
                            <th class="px-6 py-4">Sample Boxes</th>
                            <th class="px-6 py-4">Sample Bundles</th>
                            <th class="px-6 py-4">Sample Notes</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="plan in plans.data" :key="plan.id" class="text-sm text-slate-700">
                            <td class="px-6 py-4">{{ displayValue(plan.standard_ref) }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ formatNumber(plan.target_sample_boxes) }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ formatNumber(plan.target_sample_bundles) }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ formatNumber(plan.target_sample_notes) }}</td>
                            <td class="px-6 py-4"><span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ displayValue(plan.status) }}</span></td>
                            <td class="px-6 py-4 text-right"><Link :href="`/shipments/${shipment.id}/plans/${plan.id}`" class="font-semibold text-indigo-700 hover:text-indigo-900">View</Link></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-else class="px-6 py-16 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6M10 3v5.2L5.8 15a4 4 0 0 0 3.4 6h5.6a4 4 0 0 0 3.4-6L14 8.2V3M8 14h8" /></svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-slate-900">No sampling plans yet</h3>
                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">Sampling plan details have not been recorded for this shipment.</p>
            </div>

            <div v-if="plans.links.length > 3" class="flex flex-wrap gap-2 border-t border-slate-200 px-6 py-4">
                <Link
                    v-for="link in plans.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    class="rounded-md px-3 py-1.5 text-sm"
                    :class="link.active ? 'bg-indigo-600 text-white' : 'text-slate-600 hover:bg-slate-100'"
                    v-html="link.label"
                />
            </div>
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
