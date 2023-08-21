<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header><i class="fas fa-area-chart mr-2"></i> Dashboard </template>
        <template #breadcrumbs>
            <ul>
                <li>Dashboard</li>
                <li>Grafik</li>
            </ul>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-base-100 overflow-visible shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 uppercase text-center font-extrabold">
                   welcome, {{ $page.props.auth.user.name }}!
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
