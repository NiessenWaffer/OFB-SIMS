<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';
import ShipmentForm from '../../components/shipments/ShipmentForm.vue';

defineOptions({ layout: AppLayout });

const props = defineProps({
    shipment: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    denomination: props.shipment.denomination,
    currency_series: props.shipment.currency_series,
    yearmark: props.shipment.yearmark,
    supplier_name: props.shipment.supplier_name,
    delivery_reference: props.shipment.delivery_reference,
    total_boxes: props.shipment.total_boxes,
    total_notes: props.shipment.total_notes,
    first_box_code: props.shipment.first_box_code,
    last_box_code: props.shipment.last_box_code,
    documents_received_date: props.shipment.documents_received_date ?? '',
    delivery_date: props.shipment.delivery_date ?? '',
});

const submit = () => form.put(`/shipments/${props.shipment.id}`);
</script>

<template>
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="flex items-start gap-4">
            <Link :href="`/shipments/${shipment.id}`" class="mt-1 rounded-lg p-1 text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Back to shipment details">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" /></svg>
            </Link>
            <div>
                <p class="text-sm text-slate-500">Shipment Management</p>
                <h2 class="mt-1 text-2xl font-bold tracking-tight text-slate-950">Edit Shipment</h2>
                <p class="mt-1 text-sm text-slate-500">Update the delivery details for {{ shipment.delivery_reference }}.</p>
            </div>
        </div>

        <ShipmentForm :form="form" submit-label="Update Shipment" @submit="submit" />
    </div>
</template>
