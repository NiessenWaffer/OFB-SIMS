<script setup>
import { ref } from 'vue';

const isSidebarOpen = ref(false);

const navigation = [
    { label: 'Dashboard', icon: 'dashboard' },
    { label: 'Shipments', icon: 'shipments' },
    { label: 'Sampling Plans', icon: 'sampling' },
    { label: 'Inspections', icon: 'inspections' },
];
</script>

<template>
    <div class="min-h-screen bg-slate-50 text-slate-900">
        <div
            v-if="isSidebarOpen"
            class="fixed inset-0 z-20 bg-slate-950/40 lg:hidden"
            aria-hidden="true"
            @click="isSidebarOpen = false"
        ></div>

        <aside
            class="fixed inset-y-0 left-0 z-30 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform lg:translate-x-0"
            :class="{ 'translate-x-0': isSidebarOpen }"
        >
            <div class="flex h-20 items-center gap-3 border-b border-slate-200 px-6">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-sm font-bold text-white">
                    OF
                </div>
                <div>
                    <p class="text-sm font-bold tracking-wide text-slate-950">OFB-SIMS</p>
                    <p class="text-xs text-slate-500">Inspection management</p>
                </div>
            </div>

            <nav class="flex-1 space-y-1 px-4 py-6" aria-label="Main navigation">
                <p class="mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">Workspace</p>
                <a
                    v-for="(item, index) in navigation"
                    :key="item.label"
                    href="#"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-colors"
                    :class="index === 0 ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-950'"
                    @click="isSidebarOpen = false"
                >
                    <svg v-if="item.icon === 'dashboard'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5Zm0 10a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4Zm10-10a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V5Zm0 10a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2v-4Z" /></svg>
                    <svg v-else-if="item.icon === 'shipments'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m3 7 9-4 9 4-9 4-9-4Zm0 0v10l9 4 9-4V7M12 11v10" /></svg>
                    <svg v-else-if="item.icon === 'sampling'" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6M10 3v5.2L5.8 15a4 4 0 0 0 3.4 6h5.6a4 4 0 0 0 3.4-6L14 8.2V3M8 14h8" /></svg>
                    <svg v-else class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="m9 12 2 2 4-4m5-1.5A9 9 0 1 1 4 5.5M20 4l-7 7" /></svg>
                    <span>{{ item.label }}</span>
                </a>
            </nav>

            <div class="border-t border-slate-200 p-4">
                <div class="flex items-center gap-3 rounded-lg bg-slate-50 px-3 py-3">
                    <div class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-200 text-xs font-semibold text-slate-700">AD</div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-slate-800">Administrator</p>
                        <p class="truncate text-xs text-slate-500">System user</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="lg:pl-72">
            <header class="sticky top-0 z-10 flex h-20 items-center justify-between border-b border-slate-200 bg-white/95 px-4 backdrop-blur sm:px-8">
                <div class="flex items-center gap-3">
                    <button class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden" aria-label="Open navigation" @click="isSidebarOpen = true">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" /></svg>
                    </button>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400">Workspace</p>
                        <h1 class="text-lg font-semibold text-slate-950">Dashboard</h1>
                    </div>
                </div>
                <button class="rounded-full p-2 text-slate-500 hover:bg-slate-100" aria-label="Notifications">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.9 18a3 3 0 0 1-5.8 0M18 9a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9Z" /></svg>
                </button>
            </header>

            <main class="p-4 sm:p-8">
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center sm:p-16">
                    <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 19V5m0 14h16M8 16v-5m4 5V8m4 8v-9" /></svg>
                    </div>
                    <h2 class="mt-4 text-xl font-semibold text-slate-900">Welcome to OFB-SIMS</h2>
                    <p class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-500">Your application workspace is ready. Dashboard content and workflows will be added here.</p>
                </div>
            </main>
        </div>
    </div>
</template>
