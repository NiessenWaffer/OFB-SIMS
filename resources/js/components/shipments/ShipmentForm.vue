<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    form: {
        type: Object,
        required: true,
    },
    submitLabel: {
        type: String,
        default: 'Save Shipment',
    },
});

const emit = defineEmits(['submit']);
</script>

<template>
    <form class="space-y-6" @submit.prevent="emit('submit')">
        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h3 class="text-base font-semibold text-slate-950">Shipment information</h3>
            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="delivery_reference" class="field-label">Delivery Reference</label>
                    <input id="delivery_reference" v-model="form.delivery_reference" type="text" class="field-input" placeholder="e.g. 6th Delivery">
                    <p v-if="form.errors.delivery_reference" class="field-error">{{ form.errors.delivery_reference }}</p>
                </div>
                <div>
                    <label for="supplier_name" class="field-label">Supplier Name</label>
                    <input id="supplier_name" v-model="form.supplier_name" type="text" class="field-input" placeholder="Supplier or manufacturer">
                    <p v-if="form.errors.supplier_name" class="field-error">{{ form.errors.supplier_name }}</p>
                </div>
                <div>
                    <label for="denomination" class="field-label">Denomination</label>
                    <input id="denomination" v-model="form.denomination" type="text" class="field-input" placeholder="e.g. 100-Piso">
                    <p v-if="form.errors.denomination" class="field-error">{{ form.errors.denomination }}</p>
                </div>
                <div>
                    <label for="currency_series" class="field-label">Currency Series</label>
                    <input id="currency_series" v-model="form.currency_series" type="text" class="field-input" placeholder="e.g. eNGC or Polymer">
                    <p v-if="form.errors.currency_series" class="field-error">{{ form.errors.currency_series }}</p>
                </div>
                <div>
                    <label for="yearmark" class="field-label">Yearmark</label>
                    <input id="yearmark" v-model="form.yearmark" type="text" class="field-input" placeholder="e.g. 2026">
                    <p v-if="form.errors.yearmark" class="field-error">{{ form.errors.yearmark }}</p>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h3 class="text-base font-semibold text-slate-950">Shipment quantity and box interval</h3>
            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="total_boxes" class="field-label">Total Boxes</label>
                    <input id="total_boxes" v-model="form.total_boxes" type="number" min="1" class="field-input" placeholder="e.g. 1400">
                    <p v-if="form.errors.total_boxes" class="field-error">{{ form.errors.total_boxes }}</p>
                </div>
                <div>
                    <label for="total_notes" class="field-label">Total Banknotes (pieces)</label>
                    <input id="total_notes" v-model="form.total_notes" type="number" min="1" class="field-input" placeholder="e.g. 70000000">
                    <p class="field-help">Enter the total number of individual banknotes, such as 70,000,000 for 70 million.</p>
                    <p v-if="form.errors.total_notes" class="field-error">{{ form.errors.total_notes }}</p>
                </div>
                <div>
                    <label for="first_box_code" class="field-label">First Box Code</label>
                    <input id="first_box_code" v-model="form.first_box_code" type="text" class="field-input" placeholder="e.g. 2026-TE-15601">
                    <p v-if="form.errors.first_box_code" class="field-error">{{ form.errors.first_box_code }}</p>
                </div>
                <div>
                    <label for="last_box_code" class="field-label">Last Box Code</label>
                    <input id="last_box_code" v-model="form.last_box_code" type="text" class="field-input" placeholder="e.g. 2026-TE-17000">
                    <p v-if="form.errors.last_box_code" class="field-error">{{ form.errors.last_box_code }}</p>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h3 class="text-base font-semibold text-slate-950">Delivery dates <span class="font-normal text-slate-400">(optional)</span></h3>
            <div class="mt-6 grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="documents_received_date" class="field-label">Documents Received Date</label>
                    <input id="documents_received_date" v-model="form.documents_received_date" type="date" class="field-input">
                    <p v-if="form.errors.documents_received_date" class="field-error">{{ form.errors.documents_received_date }}</p>
                </div>
                <div>
                    <label for="delivery_date" class="field-label">Delivery Date</label>
                    <input id="delivery_date" v-model="form.delivery_date" type="date" class="field-input">
                    <p v-if="form.errors.delivery_date" class="field-error">{{ form.errors.delivery_date }}</p>
                </div>
            </div>
        </section>

        <div class="flex justify-end gap-3">
            <Link href="/shipments" class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Cancel</Link>
            <button type="submit" class="rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 disabled:cursor-not-allowed disabled:opacity-60" :disabled="form.processing">{{ form.processing ? 'Saving...' : submitLabel }}</button>
        </div>
    </form>
</template>

<style scoped>
@reference "../../../css/app.css";

.field-label {
    @apply mb-1.5 block text-sm font-medium text-slate-700;
}

.field-input {
    @apply block w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100;
}

.field-error {
    @apply mt-1.5 text-xs text-red-600;
}

.field-help {
    @apply mt-1.5 text-xs text-slate-500;
}
</style>
