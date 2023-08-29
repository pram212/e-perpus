<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import PaginationVue from "@/Components/PaginationLink.vue";
import DeleteConfirmBook from "./Partials/DeleteConfirmBook.vue";
import { ref, onMounted } from 'vue';
import moment from "moment";
import "moment/locale/id";
moment.locale("id");

const props = defineProps({

});

const search = ref('');

const deleteId = ref(null);

const isLoading = ref(false);

const books = ref({});

async function getBooks(page) {
    isLoading.value = true
    const response = await fetch(`/getbook?page=${page}&search=${search.value}`)
    const data = await response.json();
    books.value = data
    isLoading.value = false
}

async function getBooksPerPage(url) {
    isLoading.value = true
    const response = await fetch( url + `&search=${search.value}`)
    const data = await response.json();
    books.value = data
    isLoading.value = false
}

onMounted(() => {
    getBooks()
})

</script>

<template>
    <Head title="Buku" />

    <AuthenticatedLayout>
        <template #header>Buku</template>
        <template #breadcrumbs>
            <ul>
                <li>Pustaka</li>
                <li>Buku</li>
                <li>Daftar</li>
            </ul>
        </template>

        <DeleteConfirmBook :book_id="deleteId"></DeleteConfirmBook>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
            <div class="bg-base-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between">
                        <Link class="btn btn-sm btn-primary" :href="route('book.create')"><i class="fas fa-plus"></i>  Baru</Link>
                        <button class="btn btn-sm btn-success"><i class="fas fa-upload"></i>  Import</button>
                    </div>

                    <span v-if="isLoading" class="absolute inset-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
                        <span class="loading loading-bars loading-lg text-secondary"></span>
                    </span>
                    <div class="divider my-1"></div>
                    <div class="overflow-x-auto">
                        <label class="input-group">
                            <input type="text" v-model="search" class="input input-sm input-bordered" autofocus placeholder="cari..." @keyup="getBooks">
                            <span @click="search = ''; getBooks();" v-if="search" class="text-error cursor-pointer"><i class="fas fa-times"></i></span>
                        </label>
                        
                        <table class="table table-sm mt-2 border">
                            <thead class="uppercase bg-base-300">
                                <tr>
                                    <th colspan="2" class="text-center">Judul</th>
                                    <th>ISBN</th>
                                    <th>Katalog</th>
                                    <th>Penerbit</th>
                                    <th>tahun terbit</th>
                                    <th class="text-center" style="width: 20%;">
                                        opsi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(book, i) in books.data" :key="i">
                                    <td><i class="fas fa-book text-3xl"></i></td>
                                    <td class="capitalize">{{ book.title }}</td>
                                    <td class="capitalize">{{ book.isbn }}</td>
                                    <td class="capitalize">{{ book.catalog.name }}</td>
                                    <td class="capitalize">{{ book.publisher }}</td>
                                    <td class="capitalize">{{ book.published_at }}</td>
                                    <td class="space-x-1 text-center">
                                        <Link :href="route('book.edit', book.id)" class="btn btn-sm btn-info">edit</Link>
                                        <label @click="deleteId = book.id" for="delete-confirm"
                                            class="btn btn-sm btn-error">hapus</label>
                                    </td>
                                </tr>
                                <tr v-if="!books.total">
                                    <td colspan="6" class="font-extrabold capitalize text-center">data tidak ditemukan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex justify-between pt-5">
                        <!-- PAGINATION -->
                        <div class="btn-group">
                            <button type="button" @click="getBooksPerPage(link.url)" class="btn btn-ghost btn-sm" v-for="(link, p) in books.links" :key="p" :class="{ 'btn-active': link.active }" :disabled="!link.url">
                                <span v-html="link.label"></span>
                            </button>
                        </div>
                        <!-- PAGINATION END -->
                        
                        <!-- <PaginationVue :links="books.links"></PaginationVue>
                        <div class="btn-secondary btn btn-sm">
                            Total Data : {{ books.total }}
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
