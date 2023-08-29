<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { onMounted } from "vue";
import { themeChange } from "theme-change";

onMounted(() => {
    themeChange(false);
});
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-base-300">
        <div class="mt-5 uppercase">
            {{$page.props.app_name}}
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-base-100 shadow-md overflow-hidden sm:rounded-lg mb-10"
        >
            <slot />
        </div>
    </div>
</template>
