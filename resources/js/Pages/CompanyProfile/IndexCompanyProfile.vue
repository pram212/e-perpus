<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    profile: Object
})

const form = useForm({
    _method: 'patch',
    name: props.profile.name,
    address: props.profile.address,
    logo_path: props.logo_path,
});

const tempUrl = ref(null)

const previewAvatar = (e) => {
    const file = e.target.files[0];
    tempUrl.value = URL.createObjectURL(file);
}

const submit = () => {
    form.post(route("setting.company-profile.update", props.profile.id), {
        onSuccess : () => {
            const template = `<div class="flex p-0"><i class="fas fa-check-circle mr-2"></i> ${usePage().props.flash.message}</div>`
            toaster.success(template);
        },
        onError : (error) => {
            const template = `<div class="flex p-0"><i class="fas fa-exclamation mr-2"></i> ${usePage().props.flash.message}</div>`
            toaster.error(template);
        }
    });
};


</script>

<template>
    <Head title="Profil Perpustakaan" />

    <AuthenticatedLayout>
        <template #header>Profil Perpustakaan </template>
        <template #breadcrumbs>
            <ul>
                <li>Setting</li>
                <li>Profile Perpustakaan</li>
            </ul>
        </template>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-base-100 overflow-visible shadow-sm sm:rounded-lg" :class="{'cursor-wait' : form.processing}">
                <div class="p-6 text-accent-focus text-center font-extrabold">
                    <div class="avatar hover:cursor-pointer">
                        <div class="w-24 rounded">
                            <img v-if="tempUrl" :src="tempUrl" class="h-60 rounded-full hover:cursor-pointer" @click="$refs.fileInput.click();" />
                            <img v-else @click="$refs.fileInput.click()" :src="'/' + profile.logo_path" />
                        </div>
                    </div>

                    <input type="file" class="hidden" ref="fileInput" @change="previewAvatar" @input="form.logo_path = $event.target.files[0]" accept=".jpg, .jpeg, .png" />


                    <div class="form-control">
                        <label for="" class="label">Nama Istitusi:</label>
                        <input type="text" v-model="form.name" class="input uppercase input-bordered w-full">
                    </div>
                    <div class="form-control">
                        <label for="" class="label">Alamat :</label>
                        <input type="text" v-model="form.address" class="input uppercase input-bordered w-full">
                    </div>
                    <div class="divider"></div>

                    <div class="flex justify-center space-x-2">
                        <button type="button" @click="submit" class="btn btn-sm btn-primary uppercase">simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
