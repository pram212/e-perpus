<script setup>
import HamburgerVue from "@/Components/Hamburger.vue";
import ThemeControlVue from "@/Components/ThemeControl.vue";
import { Link } from "@inertiajs/vue3";
import LateNoftification from "@/Components/LateNoftification.vue";

</script>

<template>
    <div class="navbar py-0 shadow-md bg-base-100">
        <div class="flex-1 gap-x-5">
            <button class="btn btn-ghost hidden lg:block" @click.prevent="$emit('sidebarToggle')">
                <HamburgerVue />
            </button>

            <label for="my-drawer" class="btn btn-ghost drawer-button lg:hidden">
                <HamburgerVue />
            </label>
            <span class="my-auto hidden md:flex">
                {{ $page.props.company_profile.name }}
            </span>
        </div>
        <div class="flex-none gap-2">
            <LateNoftification></LateNoftification>

            <ThemeControlVue></ThemeControlVue>

            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost avatar">
                    {{ $page.props.auth.user.name }}

                </label>
                <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                    <li>
                        <h1 class="capitalize bg-base-300">
                            {{ $page.props.auth.user.name }}
                        </h1>
                    </li>
                    <li>
                        <Link href="/profile">Profile</Link>
                    </li>
                    <li>
                        <Link :href="route('logout')" method="post" as="button">Logout</Link>
                    </li>
                </ul>
            </div>
        </div>
    </div></template>
