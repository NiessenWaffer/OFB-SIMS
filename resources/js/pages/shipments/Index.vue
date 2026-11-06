<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import AppLayout from '../../layouts/AppLayout.vue';

defineOptions({ layout: AppLayout });

const props = defineProps({
    shipments: {
        type: Object,
        required: true,
    },
    search: {
        type: String,
        default: '',
    },
});

const searchQuery = ref(props.search);

const submitSearch = () => {
    router.get('/shipments', {
        search: searchQuery.value || undefined,
    }, {
        preserveState: true,
        replace: true,
    });
};

const formatNumber = (value) => new Intl.NumberFormat().format(value);
</script>

<template>
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-slate-950">Shipments</h2>
                <p class="mt-1 text-sm text-slate-500">Review registered delivery information.</p>
            </div>
            <Link href="/shipments/create" class="inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700">
                <span class="text-lg leading-none">+</span>
                New Shipment
            </Link>
        </div>

        <div class="rounded-xl border border-slate-200 bg-white shadow-sm">
            <form class="border-b border-slate-200 p-4 sm:p-5" @submit.prevent="submitSearch">
                <label for="shipment-search" class="sr-only">Search shipments</label>
                <div class="relative max-w-md">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                    <input id="shipment-search" v-model="searchQuery" type="search" placeholder="Search shipments..." class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100">
                </div>
            </form>

            <div v-if="shipments.data.length" class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="px-6 py-4">Delivery</th>
                            <th class="px-6 py-4">Denomination</th>
                            <th class="px-6 py-4">Supplier</th>
                            <th class="px-6 py-4">Boxes</th>
                            <th class="px-6 py-4 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr v-for="shipment in shipments.data" :key="shipment.id" class="text-sm text-slate-700 transition hover:bg-slate-50">
                            <td class="whitespace-nowrap px-6 py-4 font-semibold text-slate-900">
                                <div class="flex items-center gap-2">
                                    <span>{{ shipment.delivery_reference }}</span>
                                    <span v-if="shipment.delivery_reference.startsWith('DEMO')" class="rounded-full bg-amber-50 px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-amber-700">Demonstration Data</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">{{ shipment.denomination }}</td>
                            <td class="px-6 py-4">{{ shipment.supplier_name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ formatNumber(shipment.total_boxes) }}</td>
                            <td class="px-6 py-4 text-right">
                                <Link :href="`/shipments/${shipment.id}`" class="font-semibold text-indigo-700 hover:text-indigo-900">View</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div v-if="shipments.data.length === 0" class="px-6 py-16 text-center">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z" /></svg>
                </div>
                <h3 class="mt-4 text-lg font-semibold text-slate-900">No shipments found</h3>
                <p class="mt-2 text-sm text-slate-500">Try a different search term or create a new shipment.</p>
            </div>

            <div v-if="shipments.links.length > 3" class="flex flex-wrap gap-2 border-t border-slate-200 px-6 py-4">
                <Link
                    v-for="link in shipments.links"
                    :key="link.label"
                    :href="link.url || '#'"
                    class="rounded-md px-3 py-1.5 text-sm"
                    :class="link.active ? 'bg-indigo-600 text-white' : 'text-slate-600 hover:bg-slate-100'"
                    v-html="link.label"
                />
            </div>
        </div>
    </div>
</template>
