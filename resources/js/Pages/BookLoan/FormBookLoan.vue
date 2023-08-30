<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import VueFromMultiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
// import '' './../../../css/tw-vueselect.css';

const props = defineProps({
    bookLoan: Object,
});

const form = useForm({
    start_date: props.bookLoan?.start_date,
    end_date: props.bookLoan?.end_date,
    user_id: props.bookLoan ? [{ 'value': props.bookLoan.user.id, 'label': props.bookLoan.user.name }] : [],
    book_id: props.bookLoan 
        ? props.bookLoan.book_loan_detail.map((books) => { return { value: books.book.id, label: books.book.title } })
        : [],
});

const submit = () => {
    if (props.bookLoan) {
        form.put(route("transaction.loan.update", props.bookLoan.id), {
            // preserveState: false,
            // preserveScroll: true,
            // onFinish: () => form.reset(),
        });
    } else {
        form.post(route("transaction.loan.store"), {
            // preserveState: false,
            // preserveScroll: true,
            // onFinish: () => form.reset(),
        });
    }
};

const fetchBooks = async (query) => {
    const response = await fetch('/transaction/getbookoptions?query=' + query);
    const data = await response.json(); // Here you have the data that you nee
    return data.results.map((item) => {
        return { value: item.id, label: item.title }
    })
}

const fetchMembers = async (query) => {
    const response = await fetch('/transaction/getuseroptions?query=' + query);
    const data = await response.json(); // Here you have the data that you nee
    return data.results.map((item) => {
        return { value: item.id, label: item.name }
    })
}

</script>

<template>
    <AuthenticatedLayout>

        <Head :title="catalog ? 'Detail Peminjaman' : 'Entry Peminjaman'" />

        <template #header>Peminjaman Buku</template>
        <template #breadcrumbs>
            <ul>
                <li>Transaksi</li>
                <li>Peminjaman</li>
                <li>Entry</li>
            </ul>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-40">
            <div class="bg-base-100 overflow-visible shadow-sm sm:rounded-lg p-5 z-0">
                <form @submit.prevent="submit" class="lg:grid grid-cols-2 gap-2">
                    <div class="form-control mb-2">
                        <label for="start_date" class="label">Tanggal Pinjam :</label>
                        <input id="start_date" type="date" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.start_date,
                            'input-primary': !form.errors.start_date,
                        }" v-model="form.start_date" autofocus autocomplete="start_date" />
                        <InputError class="mt-2" :message="form.errors.start_date" />
                    </div>

                    <div class="form-control mb-2">
                        <label for="end_date" class="label">Tanggal Kembali :</label>
                        <input id="end_date" type="date" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.end_date,
                            'input-primary': !form.errors.end_date,
                        }" v-model="form.end_date" autofocus autocomplete="end_date" />
                        <InputError class="mt-2" :message="form.errors.end_date" />
                    </div>

                    <div class="form-control col-span-2">
                        <label for="katalog_id" class="label">Anggota :</label>
                        <VueFromMultiselect mode="multiple" :close-on-select="false" v-model="form.user_id"
                            placeholder="cari..." :filter-results="false" :min-chars="1" max="1" :resolve-on-load="false"
                            :object="true" :delay="0" :searchable="form.user_id.length < 1" :options="async function (query) {
                                return await fetchMembers(query)
                            }">
                            <template v-slot:multiplelabel="{ values }">
                                <div class="multiselect-multiple-label">
                                    {{ values[0].label }}
                                </div>
                            </template>
                        </VueFromMultiselect>
                        <InputError class="mt-2" :message="form.errors.user_id" />
                    </div>

                    <div class="form-control col-span-2">
                        <label for="katalog_id" class="label">Buku :</label>
                        <VueFromMultiselect mode="tags" :close-on-select="false" v-model="form.book_id"
                            placeholder="cari..." :filter-results="false" :min-chars="1" :resolve-on-load="false"
                            :object="true" :delay="0" :searchable="true" :options="async function (query) {
                                return await fetchBooks(query)
                            }">
                            <template v-slot:multiplelabel="{ values }">
                                <div class="multiselect-multiple-label">
                                    {{ values[0].label }}
                                </div>
                            </template>
                        </VueFromMultiselect>
                        <InputError class="mt-2" :message="form.errors.book_id" />
                    </div>

                    <div class="divider col-span-2"></div>

                    <div class="flex items-center justify-center space-x-3 mt-4 col-span-2">
                        <button class="btn btn-sm btn-primary" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Simpan
                        </button>

                        <Link :href="route('transaction.loan.index')" class="btn btn-sm btn-secondary">Kembali</Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>