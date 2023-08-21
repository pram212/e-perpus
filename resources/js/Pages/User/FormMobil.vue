<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import VueFromMultiselect from '@vueform/multiselect';
// import '@vueform/multiselect/themes/default.css';
import './../../../css/tw-vueselect.css';
import CurrencyInputVue from '@/Components/CurrencyInput.vue';

const props = defineProps({
    mobil: Object,
    mereks: Object,
});

const form = useForm({
    merek_id: props.mobil?.merek_id,
    model: props.mobil?.model,
    plat_nomor: props.mobil?.plat_nomor,
    tarif: props.mobil?.tarif,
    tersedia: props.mobil?.tersedia,
});

const submit = () => {
    if (props.mobil) {
        form.put(route("mobil.update", props.mobil.id), {
            preserveState: true,
            // onFinish: () => form.reset(),
        });
    } else {
        form.post(route("mobil.store"), {
            // preserveState: true,
            // onFinish: () => form.reset(),
        });
    }
};

</script>

<template>
    <AuthenticatedLayout>

        <Head title="Manajemen Mobil" />

        <template #header><i class="fas fa-area-car mr-2"></i> Manajemen Mobil</template>
        <template #breadcrumbs>
            <ul>
                <li>Manajemen Mobil</li>
                <li>Entry Mobil</li>
            </ul>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-40">
            <div class="bg-base-100 overflow-visible shadow-sm sm:rounded-lg p-5 z-0">
                <form @submit.prevent="submit">
                    <div class="form-control">
                        <label for="merek_id" class="label">Merek :</label>
                        <VueFromMultiselect v-model="form.merek_id" :options="mereks" :searchable="true"
                            :create-option="false" multiselect-blue />
                            <InputError class="mt-2" :message="form.errors.merek_id" />
                    </div>

                    <div class="form-control mb-2">
                        <label for="nama" class="label">Model :</label>
                        <input id="nama" type="text" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.model,
                            'input-primary': !form.errors.model,
                        }" v-model="form.model" autofocus autocomplete="model" />
                        <InputError class="mt-2" :message="form.errors.model" />
                    </div>

                    <div class="form-control mb-2">
                        <label for="plat_nomor" class="label">Plat nomor :</label>
                        <input id="plat_nomor" type="text" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.plat_nomor,
                            'input-primary': !form.errors.plat_nomor,
                        }" v-model="form.plat_nomor" autofocus autocomplete="plat_nomor" />
                        <InputError class="mt-2" :message="form.errors.plat_nomor" />
                    </div>

                    <div class="form-control mb-2">
                        <label for="tarif" class="label">Tarif sewa per hari :</label>
                        <CurrencyInputVue id="tarif" type="text" class="mt-1 block w-full input input-sm input-bordered" :class="{
                            'input-error': form.errors.tarif,
                            'input-primary': !form.errors.tarif,
                        }" v-model="form.tarif" :options="{ currency: 'IDR' }" autofocus autocomplete="tarif" />
                        <InputError class="mt-2" :message="form.errors.tarif" />
                    </div>
                    <div class="form-control mb-2">
                        <label for="tarif" class="label">Tersedia :</label>
                        <VueFromMultiselect v-model="form.tersedia" :options="[
                                { value: 0, label: 'Tidak tersedia' },
                                { value: 1, label: 'Tersedia' },
                            ]" :searchable="true" :create-option="false" multiselect-blue />
                        <InputError class="mt-2" :message="form.errors.tersedia" />
                    </div>


                    <div class="divider"></div>

                    <div class="flex items-center justify-center space-x-3 mt-4">
                        <Link :href="route('mobil.index')" class="btn btn-sm btn-secondary">Kembali</Link>
                        <button class="btn btn-sm btn-primary" :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>