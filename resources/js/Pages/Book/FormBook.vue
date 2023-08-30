<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import VueFromMultiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
// import '' './../../../css/tw-vueselect.css';

const props = defineProps({
    book: Object,
});

const form = useForm({
    title: props.book?.title,
    isbn: props.book?.isbn,
    author: props.book?.author,
    publisher: props.book?.publisher,
    published_at: props.book?.published_at,
    catalog_id:  props.book ? [{'value' : props.book.catalog.id, 'label' : props.book.catalog.name} ] : [],
    stock: props.book?.stock,
});

const submit = () => {
    if (props.book) {
        form.put(route("pustaka.book.update", props.book.id), {
            preserveState: false,
            preserveScroll: true,
            // onFinish: () => form.reset(),
        });
    } else {
        form.post(route("pustaka.book.store"), {
            preserveState: false,
            preserveScroll: true,
            // onFinish: () => form.reset(),
        });
    }
};

const fetchLanguages = async (query) => {
  const response = await fetch('/getcatalog?query=' + query);
  const data = await response.json(); // Here you have the data that you nee
  return data.results.map((item) => {
    return { value: item.id, label: item.name }
  })
}

</script>

<template>
    <AuthenticatedLayout>

        <Head :title="catalog ? 'Edit Baru' : 'Entry Buku'" />

        <template #header>Buku</template>
        <template #breadcrumbs>
            <ul>
                <li>Pustaka</li>
                <li>Buku</li>
                <li>Baru</li>
            </ul>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-40">
            <div class="bg-base-100 overflow-visible shadow-sm sm:rounded-lg p-5 z-0">
                <form @submit.prevent="submit" class="lg:grid grid-cols-2 gap-2">
                    <div class="form-control col-span-2">
                        <label for="katalog_id" class="label">Katalog :</label>
                        <VueFromMultiselect 
                            mode="multiple"
                            :close-on-select="false"
                            v-model="form.catalog_id" 
                            placeholder="cari..."
                            :filter-results="false"
                            :min-chars="1"
                            :resolve-on-load="false"
                            :object="true"
                            max="1"
                            :delay="0"
                            :searchable="form.catalog_id.length < 1"
                            :options="async function(query) {
                                return await fetchLanguages(query) // check JS block in JSFiddle for implementation
                            }"
                        >
                        <template v-slot:multiplelabel="{ values }">
                            <div class="multiselect-multiple-label">
                            {{ values[0].label }}
                            </div>
                        </template>
                        </VueFromMultiselect>
                        <InputError class="mt-2" :message="form.errors.catalog_id" />
                    </div>


                    <div class="form-control mb-2">
                        <label for="title" class="label">Judul Buku :</label>
                        <input id="title" type="text" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.title,
                            'input-primary': !form.errors.title,
                        }" v-model="form.title" autofocus autocomplete="title" />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>
                    <div class="form-control mb-2">
                        <label for="isbn" class="label">No. ISBN :</label>
                        <input id="isbn" type="text" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.isbn,
                            'input-primary': !form.errors.isbn,
                        }" v-model="form.isbn" autofocus autocomplete="isbn" />
                        <InputError class="mt-2" :message="form.errors.isbn" />
                    </div>

                    <div class="form-control mb-2">
                        <label for="author" class="label">Pengarang :</label>
                        <input id="author" type="text" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.author,
                            'input-primary': !form.errors.author,
                        }" v-model="form.author" autofocus autocomplete="author" />
                        <InputError class="mt-2" :message="form.errors.author" />
                    </div>

                    <div class="form-control mb-2">
                        <label for="publisher" class="label">Penerbit :</label>
                        <input id="publisher" type="text" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.publisher,
                            'input-primary': !form.errors.publisher,
                        }" v-model="form.publisher" autofocus autocomplete="publisher" />
                        <InputError class="mt-2" :message="form.errors.publisher" />
                    </div>

                    <div class="form-control mb-2">
                        <label for="published_at" class="label">Tahun Penerbit :</label>
                        <input id="published_at" type="number" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.published_at,
                            'input-primary': !form.errors.published_at,
                        }" v-model="form.published_at" autofocus autocomplete="published_at" />
                        <InputError class="mt-2" :message="form.errors.publisher" />
                    </div>

                    <div class="form-control mb-2">
                        <label for="stock" class="label">Ketersediaan :</label>
                        <input id="stock" type="number" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.stock,
                            'input-primary': !form.errors.stock,
                        }" v-model="form.stock" autofocus autocomplete="stock" />
                        <InputError class="mt-2" :message="form.errors.stock" />
                    </div>

                    <div class="divider col-span-2"></div>

                    <div class="flex items-center justify-center space-x-3 mt-4 col-span-2">
                        <button class="btn btn-sm btn-primary" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Simpan
                        </button>

                        <Link :href="route('pustaka.book.index')" class="btn btn-sm btn-secondary">Kembali</Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>