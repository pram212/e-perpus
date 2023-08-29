<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed, onMounted } from 'vue'

const menus = [
    {
        name: "Dashboard",
        url: "/dashboard",
        icon: '<i class="fas fa-home w-5"></i>',
    },
    {
        name: "Pustaka",
        url: null,
        icon: '<i class="fas fa-book w-5"></i>',
        submenu: [
            {
                name: "Daftar Pustaka",
                url: "/book",
                icon: '<i class="fas fa-book w-5"></i>',
            },
            {
                name: "Daftar Katalog",
                url: "/catalog",
                icon: '<i class="fas fa-bar w-5"></i>',
            },
        ]
    },
    {
        name: "Peminjaman",
        url: "/order",
        icon: '<i class="fas fa-retweet w-5"></i>',
    },
    {
        name: "Keanggotaan",
        url: "/member",
        icon: '<i class="fas fa-id-card w-5"></i>',
    },
    {
        name: "setting",
        url: "/user",
        icon: '<i class="fas fa-cog w-5"></i>',
        submenu: [
            {
                name: "profil perpustakaan",
                url: "/setting/company-profile",
                icon: '',
            },
            {
                name: "admin",
                url: "/admin",
                icon: '<i class="fas fa-users w-5 w-5"></i>',
            },
            {
                name: "hak akses",
                url: "/users",
                icon: '<i class="fas fa-users w-5 w-5"></i>',
            },
        ]
    },
];


const isEmtySubmenu = (submenu) => {
    return _.size(submenu) > 0 ? true : false
}

</script>

<template>
    <aside class="bg-base-100 w-80 h-full">
        <ul class="menu p-4 w-80 capitalize font-extrabold bg-base-100 min-h-screen text-base-content">

            <h2 class="menu-title uppercase">{{$page.props.app_name}}</h2>
            <div class="divider my-0"></div>
            <li v-for="(menu, i) in menus" :key="i">
                <!-- submenu 1 -->
                <details v-if="isEmtySubmenu(menu.submenu)" :open="$page.url.includes(menu.url)">
                    <summary>
                        <span v-html="menu.icon"></span> {{ menu.name }}
                    </summary>
                    <ul>
                        <li v-for="(submenu, j) in menu.submenu" :key="j">
                            <details v-if="isEmtySubmenu(submenu.submenu)" :open="$page.url.includes(submenu.url)">
                                <summary>
                                    <i class="fas fa-folder-open"></i> {{ submenu.name }}
                                </summary>
                                <ul>
                                    <li v-for="(submenu2, j) in submenu.submenu" :key="j">
                                        <Link :href="submenu2.url" :class="{ active: $page.url.includes(submenu2.url) }"><i
                                            class="fas fa-folder-open"></i>
                                        {{ submenu2.name }}</Link>
                                    </li>
                                </ul>
                            </details>

                            <Link v-else :href="submenu.url" :class="{ active: $page.url.includes(submenu.url) }"><i
                                class="fas fa-folder-open"></i>
                            {{ submenu.name }}</Link>
                        </li>
                    </ul>
                </details>
                <!-- submenu 1 end -->

                <Link v-else :href="menu.url" :class="{ active: $page.url.includes(menu.url) }">
                <span v-html="menu.icon"></span> {{ menu.name }}</Link>
            </li>
            <!-- <li class="my-5"></li> -->
        </ul>
    </aside>

    <!-- </aside> -->
</template>
