<script setup>
import { onMounted } from "vue";
import { themeChange } from "theme-change";
import { Link, usePage } from "@inertiajs/vue3";
import Navbar from "@/Layouts/Navbar.vue";
import Sidebar from "@/Layouts/Sidebar.vue";
import { ref } from "vue";

const notificationType = usePage().props.flash.type
const notificationMessage = usePage().props.flash.message
const sidebarOpen = ref(true)

onMounted(() => {
    themeChange(false)

    if (usePage().props.flash.type) {
        if (notificationType == 'success') {
            const template = `<div class="flex p-0"><i class="fas fa-check-circle mr-2"></i> ${notificationMessage}</div>`
            toaster.success(template);
        } else {
            const template = `<div class="flex p-0"><i class="fas fa-exclamation mr-2"></i> ${notificationMessage}</div>`
            toaster.error(template);
        }
    }

    setTimeout(toaster.clear(), 3000);

});
</script>

<template>
    <!-- // The root container -->
    <div class="drawer" :class="{'lg:drawer-open' : sidebarOpen }"> 
        <!-- // A hidden checkbox to toggle the visibility of the sidebar -->
        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
        <!-- // All your page content goes here -->
        <div class="drawer-content max-h-full overflow-x-scroll">
            <!-- Navbar -->
            <Navbar @sidebar-toggle="sidebarOpen=!sidebarOpen"></Navbar>
            <!-- Navbar End -->

            <!-- PAGE CONTENT -->
            <div class="min-h-screen bg-base-300 ">
                <!-- Page Heading -->
                <header class="bg-base-200 shadow-lg" v-if="$slots.header">
                    <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                        <!-- <slot name="header" /> -->
                        <h2 class="text-md font-extrabold capitalize">
                            <slot name="header" />
                        </h2>
                        <div class="divider m-0" v-if="$slots.breadcrumbs"></div>
                        <div
                            class="text-xs breadcrumbs ml-2 p-1"
                            v-if="$slots.breadcrumbs"
                        >
                            <slot name="breadcrumbs" />
                        </div>
                    </div>
                </header>
                <!-- Page content here -->
                <main class="py-4">
                    <slot />
                </main>
            </div>
            <!-- PAGE CONTENT END -->
        </div>

        <!-- // Sidebar wrapper -->
        <div
            class="drawer-side h-full"
            style="scroll-behavior: smooth; scroll-padding-top: 5rem"
        >
            <!-- // A dark overlay that covers the whole page when the drawer is open -->
            <label for="my-drawer" class="drawer-overlay"></label>

            <Sidebar />
        </div>
        <!-- // Sidebar wrapper End -->
    </div>
</template>
