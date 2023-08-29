<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    catalog: Object,
});

const form = useForm({
    name: props.catalog?.name,
});

const submit = () => {
    if (props.catalog) {
        form.put(route("catalog.update", props.catalog.id), {
            preserveState: false,
            // onFinish: () => form.reset(),
        });
    } else {
        form.post(route("catalog.store"), {
            preserveState: false,
            onFinish: () => form.reset(),
        });
    }
};

</script>

<template>
    <AuthenticatedLayout>

        <Head :title="catalog ? 'Entry Catalog' : 'Edit Catalog'" />

        <template #header>Katalog</template>
        <template #breadcrumbs>
            <ul>
                <li>Pustaka</li>
                <li>Katalog</li>
                <li>Baru</li>
            </ul>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-40">
            <div class="bg-base-100 overflow-visible shadow-sm sm:rounded-lg p-5 z-0">
                <form @submit.prevent="submit">
                    <div class="form-control mb-2">
                        <label for="nama" class="label">Nama Katalog :</label>
                        <input id="nama" type="text" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.name,
                            'input-primary': !form.errors.name,
                        }" v-model="form.name" autofocus autocomplete="name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="divider"></div>

                    <div class="flex items-center justify-center space-x-3 mt-4">
                        <button class="btn btn-sm btn-primary" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Simpan
                        </button>

                        <Link :href="route('catalog.index')" class="btn btn-sm btn-secondary">Kembali</Link>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>