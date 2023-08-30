<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm, router } from "@inertiajs/vue3";
import PaginationVue from "@/Components/PaginationLink.vue";
import DeleteConfirmBook from "./Partials/DeleteConfirmBookLoan.vue";
import { ref, onMounted } from 'vue';
import moment from "moment";
import "moment/locale/id";
moment.locale("id");

const props = defineProps({

});

const search = ref('');

const deleteId = ref(null);

const isLoading = ref(false);

const bookLoans = ref({});

async function getBookLoans(page) {
    isLoading.value = true
    const response = await fetch(`/transaction/getbookloan?page=${page}&search=${search.value}`)
    const data = await response.json();
    bookLoans.value = data
    isLoading.value = false
}

async function getBookLoansPerPage(url) {
    isLoading.value = true
    const response = await fetch(url + `&search=${search.value}`)
    const data = await response.json();
    bookLoans.value = data
    isLoading.value = false
}

const getDaysLoan = (startDate, endDate) => {
    var start = moment("2018-03-10", "YYYY-MM-DD");
    var end = moment("2018-03-15", "YYYY-MM-DD");

    return moment.duration(end.diff(start)).asDays();
}

onMounted(() => {
    getBookLoans()
})

</script>

<template>
    <Head title="Peminjaman" />

    <AuthenticatedLayout>
        <template #header>Peminjaman</template>
        
        <template #breadcrumbs>
            <ul>
                <li>Transaksi</li>
                <li>Peminjaman</li>
                <li>Daftar</li>
            </ul>
        </template>

        <DeleteConfirmBook :book_id="deleteId"></DeleteConfirmBook>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
            <div class="bg-base-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between">
                        <Link class="btn btn-sm btn-primary" :href="route('transaction.loan.create')">
                            <i class="fas fa-plus"></i> Baru
                        </Link>
                    </div>

                    <div class="divider my-1"></div>

                    <div class="overflow-x-auto">
                        <label class="input-group">
                            <input type="text" v-model="search" class="input input-sm input-bordered" autofocus placeholder="cari..." @keyup="getBookLoans">
                            <span @click="search = ''; getBookLoans();" v-if="search" class="text-error cursor-pointer">
                                <i class="fas fa-times"></i>
                            </span>
                        </label>

                        <table class="table table-sm mt-2 border border-base-300">

                            <span v-if="isLoading" class="absolute inset-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
                                <span class="loading loading-bars loading-lg text-secondary"></span>
                            </span>

                            <thead class="uppercase bg-base-300">
                                <tr>
                                    <th class="text-center">Kode</th>
                                    <th>Anggota</th>
                                    <th>Jumlah Buku</th>
                                    <th colspan="2" class="text-center">Periode</th>
                                    <th>Hari</th>
                                    <th>Status</th>
                                    <th class="text-center">opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(loan, i) in bookLoans.data" :key="i">
                                    <td class="capitalize">{{ loan.code }}</td>
                                    <td class="capitalize">{{ loan.user.name }}</td>
                                    <td class="capitalize">{{ loan.book_loan_detail_count }} buku</td>
                                    <td class="lowercase">
                                        {{ moment(loan.start_date).format('L') }}
                                    </td>
                                    <td>{{ moment(loan.end_date).format('L') }}</td>
                                    <td class="capitalize">{{ getDaysLoan(loan.start_date, loan.end_date) }}</td>
                                    <td class="lowercase">
                                        <span class="badge" :class="{'badge-success' : loan.refund, 'badge-error' : !loan.refund }">
                                            {{ loan.refund ? 'dalam proses' : 'dalam proses' }}
                                        </span>
                                    </td>
                                    <td class="space-x-1 text-center flex">
                                        <Link :href="route('transaction.loan.edit', loan.id)" class="btn btn-xs btn-info">
                                        lihat</Link>
                                        <label @click="deleteId = loan.id" for="delete-confirm"
                                            class="btn btn-xs btn-error">hapus</label>
                                    </td>
                                </tr>
                                <tr v-if="!bookLoans.total">
                                    <td colspan="8" class="font-extrabold capitalize text-center">data tidak ditemukan</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    <div class="flex justify-between pt-5">
                        <div class="btn-group">
                            <button type="button" @click="getBookLoansPerPage(link.url)" class="btn btn-ghost btn-sm"
                                v-for="(link, p) in bookLoans.links" :key="p" :class="{ 'btn-active': link.active }"
                                :disabled="!link.url">
                                <span v-html="link.label"></span>
                            </button>
                        </div>
                    </div>
                    <!-- PAGINATION END -->

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
