<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';
import ShipmentForm from '../../components/shipments/ShipmentForm.vue';

defineOptions({ layout: AppLayout });

const form = useForm({
    denomination: '',
    currency_series: '',
    yearmark: '',
    supplier_name: '',
    delivery_reference: '',
    total_boxes: '',
    total_notes: '',
    first_box_code: '',
    last_box_code: '',
    documents_received_date: '',
    delivery_date: '',
});

const submit = () => form.post('/shipments');
</script>

<template>
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-start gap-4">
            <Link href="/shipments" class="mt-1 rounded-lg p-1 text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Back to shipments">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
            </Link>
            <div>
                <p class="text-sm text-slate-500">Shipment Management</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Create Shipment</h2>
                <p class="mt-1 text-sm text-slate-500">Record the delivery details for future sampling and inspection records.</p>
            </div>
        </div>

        <ShipmentForm :form="form" @submit="submit" />
    </div>
</template>
