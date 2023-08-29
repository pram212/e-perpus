<script setup>

import { Link } from "@inertiajs/vue3";

</script>

<template>
    <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-circle">
            <div class="indicator">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="badge badge-sm badge-warning indicator-item">8</span>
            </div>
        </label>
        <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-52 bg-base-100 shadow">
            <div class="card-body">
                <span class="font-bold text-lg">8 Keterlambatan</span>
                <span class="text-info"><i class="fas fa-user mr-2"></i> Kirna</span>
                <div class="card-actions">

                    <Link href="" class="link link-secondary">Lihat detail</Link>
                </div>
            </div>
        </div>
    </div>
</template>