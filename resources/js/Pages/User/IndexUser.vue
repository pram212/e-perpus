<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import PaginationVue from "@/Components/PaginationLink.vue";
import moment from "moment";
import "moment/locale/id";
moment.locale("id");

const props = defineProps({
    users: Object,
    requests: Object,
});

const formFilter = useForm({
    search: props.requests.search,
});

function filter() {
    formFilter.get(route("users.index"), formFilter, {
        preserveScroll: true,
    });
}

</script>

<template>
    <Head title="Management user" />

    <AuthenticatedLayout>
        <template #header><i class="fas fa-folder-open mr-2 capitalize"></i>Management User
        </template>
        <template #breadcrumbs>
            <ul>
                <li>Manage your user data in this page!</li>
            </ul>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-56">
            <div class="bg-base-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between">
                        <span class=" text-2xl">User List</span>
                        <input type="text" v-model="formFilter.search" class="input input-sm" placeholder="ketik + enter" @keyup.enter="filter" autofocus>
                    </div>
                    
                    <div class="divider"></div>
                    

                    <table class="table table-sm table-zebra">
                        <thead class="uppercase">
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, i) in users.data" :key="i">
                                <td class="capitalize">{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-between pt-5">
                        <!-- PAGINATION -->
                        <PaginationVue :links="users.links"></PaginationVue>
                        <!-- PAGINATION END -->

                        <div class="btn-secondary btn btn-sm">
                            Total Data : {{ users.total }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
