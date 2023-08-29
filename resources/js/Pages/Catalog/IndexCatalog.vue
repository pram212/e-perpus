<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import PaginationVue from "@/Components/PaginationLink.vue";
import DeleteConfirmCatalog from "./Partials/DeleteConfirmCatalog.vue";
import { ref } from 'vue';
import moment from "moment";
import "moment/locale/id";
moment.locale("id");

const props = defineProps({
    catalogs: Object,
    requests: Object,
});

const formFilter = useForm({
    search: props.requests?.search,
});

const deleteId = ref(null);

function filter() {
    formFilter.get(route("catalog.index"), formFilter, {
        preserveScroll: true,
    });
}

</script>

<template>
    <Head title="Katalog" />

    <AuthenticatedLayout>
        <template #header>Katalog</template>
        <template #breadcrumbs>
            <ul>
                <li>Pustaka</li>
                <li>Katalog</li>
                <li>Daftar</li>
            </ul>
        </template>

        <DeleteConfirmCatalog :catalog_id="deleteId"></DeleteConfirmCatalog>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-56">
            <div class="bg-base-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between">
                        <Link class="btn btn-sm btn-primary" href="/catalog/create">Baru</Link>
                        
                        <input type="text" v-model="formFilter.search" class="input input-sm input-bordered" placeholder="ketik + enter" @keyup.enter="filter" autofocus>
                    </div>
                    
                    <div class="divider"></div>
                    

                    <table class="table table-sm">
                        <thead class="uppercase">
                            <tr>
                                <th>Title</th>
                                <th class="text-center" style="width: 20%;">
                                    opsi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(catalog, i) in catalogs.data" :key="i">
                                <td class="capitalize">{{ catalog.name }}</td>
                                <td class="space-x-1 text-center">
                                    <Link :href="route('catalog.edit', catalog.id)" class="btn btn-sm btn-info">edit</Link>
                                    <label @click="deleteId=catalog.id" for="delete-confirm" class="btn btn-sm btn-error">hapus</label>
                                </td>
                            </tr>
                            <tr v-if="!catalogs.total">
                                <td colspan="2" class="font-extrabold capitalize text-center">data tidak ditemukan</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="flex justify-between pt-5">
                        <!-- PAGINATION -->
                        <PaginationVue :links="catalogs.links"></PaginationVue>
                        <!-- PAGINATION END -->

                        <div class="btn-secondary btn btn-sm">
                            Total Data : {{ catalogs.total }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
