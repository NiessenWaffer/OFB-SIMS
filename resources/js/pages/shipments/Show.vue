<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });

defineProps({
    shipment: {
        type: Object,
        required: true,
    },
});

const page = usePage();

const formatNumber = (value) => new Intl.NumberFormat().format(value);
</script>

<template>
    <div class="mx-auto max-w-5xl space-y-6">
        <div v-if="page.props.flash?.success" class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ page.props.flash.success }}</div>
        <div v-if="shipment.delivery_reference.startsWith('DEMO')" class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">Demonstration Data: this shipment is for local development and does not represent an operational record.</div>

        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-start">
            <div class="flex items-start gap-4">
                <Link href="/shipments" class="mt-1 rounded-lg p-1 text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Back to shipments">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
                </Link>
                <div>
                    <p class="text-sm text-slate-500">Shipment Details</p>
                    <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">{{ shipment.delivery_reference }}</h2>
                    <p class="mt-1 text-sm text-slate-500">{{ shipment.supplier_name }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <Link :href="`/shipments/${shipment.id}/edit`" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50">Edit Shipment</Link>
                <span class="rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">Registered</span>
            </div>
        </div>

        <div class="flex gap-1 overflow-x-auto border-b border-slate-200">
            <span class="border-b-2 border-indigo-600 px-4 py-3 text-sm font-semibold text-indigo-700">Overview</span>
            <Link :href="`/shipments/${shipment.id}/plans`" class="px-4 py-3 text-sm text-slate-500 hover:text-indigo-700">Sampling Plans</Link>
            <span class="px-4 py-3 text-sm text-slate-400">Inspections</span>
        </div>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h3 class="text-base font-semibold text-slate-950">Shipment information</h3>
            <dl class="mt-6 grid gap-x-8 gap-y-6 sm:grid-cols-2 lg:grid-cols-3">
                <div><dt class="detail-label">Delivery Reference</dt><dd class="detail-value">{{ shipment.delivery_reference }}</dd></div>
                <div><dt class="detail-label">Supplier</dt><dd class="detail-value">{{ shipment.supplier_name }}</dd></div>
                <div><dt class="detail-label">Denomination</dt><dd class="detail-value">{{ shipment.denomination }}</dd></div>
                <div><dt class="detail-label">Currency Series</dt><dd class="detail-value">{{ shipment.currency_series }}</dd></div>
                <div><dt class="detail-label">Yearmark</dt><dd class="detail-value">{{ shipment.yearmark }}</dd></div>
                <div><dt class="detail-label">Total Boxes</dt><dd class="detail-value">{{ formatNumber(shipment.total_boxes) }}</dd></div>
                <div><dt class="detail-label">Total Notes</dt><dd class="detail-value">{{ formatNumber(shipment.total_notes) }}</dd></div>
                <div><dt class="detail-label">First Box Code</dt><dd class="detail-value break-all">{{ shipment.first_box_code }}</dd></div>
                <div><dt class="detail-label">Last Box Code</dt><dd class="detail-value break-all">{{ shipment.last_box_code }}</dd></div>
                <div><dt class="detail-label">Documents Received</dt><dd class="detail-value">{{ shipment.documents_received_date || 'Not recorded' }}</dd></div>
                <div><dt class="detail-label">Delivery Date</dt><dd class="detail-value">{{ shipment.delivery_date || 'Not recorded' }}</dd></div>
            </dl>
        </section>

        <section class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 sm:p-8">
            <h3 class="text-base font-semibold text-slate-950">Related modules</h3>
            <p class="mt-1 text-sm text-slate-500">Sampling plans and inspection records will be linked to this shipment in a future phase.</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <span class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-400">Sampling Plans</span>
                <span class="rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm text-slate-400">Inspections</span>
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
