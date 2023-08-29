<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    nirm: '',
    phone: '',
    address: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>

        <Head title="Register" />

        <form @submit.prevent="submit">
            <h5 class="uppercase text-center">registrasi</h5>
            <div class="divider"></div>

            <div class="form-control w-full">
                <label class="label"><span class="label-text">Nama Lengkap <span class="text-error">*</span></span></label>
                <input type="text" v-model="form.name"  class="input input-sm input-bordered w-full" />
                <label class="label font-semibold" v-if="form.errors.name"><span class="label-text-alt text-error">{{form.errors.name}}</span></label>
            </div>

            <div class="form-control w-full">
                <label class="label"><span class="label-text">Email <span class="text-error">*</span></span></label>
                <input type="email" v-model="form.email" autocomplete="username" class="input input-sm input-bordered w-full" />
                <label class="label font-semibold" v-if="form.errors.email"><span class="label-text-alt text-error">{{form.errors.email}}</span></label>
            </div>

            <div class="form-control w-full">
                <label class="label"><span class="label-text">Password <span class="text-error">*</span></span></label>
                <input type="password" v-model="form.password" autocomplete="new-password"  class="input input-sm input-bordered w-full" />
                <label class="label font-semibold" v-if="form.errors.password"><span class="label-text-alt text-error">{{form.errors.password}}</span></label>
            </div>

            <div class="form-control w-full">
                <label class="label"><span class="label-text">Konfirmasi Password <span class="text-error">*</span></span></label>
                <input type="password" v-model="form.password_confirmation" autocomplete="new-password"  class="input input-sm input-bordered w-full" />
                <label class="label font-semibold" v-if="form.errors.password_confirmation"><span class="label-text-alt text-error">{{form.errors.password_confirmation}}</span></label>
            </div>

            <div class="form-control w-full">
                <label class="label"><span class="label-text">No Telepon</span></label>
                <input type="tel" v-model="form.phone" class="input input-sm input-bordered w-full" />
                <label class="label font-semibold" v-if="form.errors.phone"><span class="label-text-alt text-error">{{ form.errors.phone }}</span></label>
            </div>

            <div class="form-control w-full">
                <label class="label"><span class="label-text">NIRM</span></label>
                <input type="text" v-model="form.nirm"  class="input input-sm input-bordered w-full" />
                <label class="label font-semibold" v-if="form.errors.nirm"><span class="label-text-alt text-error">{{ form.errors.nirm }}</span></label>
            </div>
           
            <div class="form-control w-full">
                <label class="label"><span class="label-text">Alamat Lengkap</span></label>
                <textarea v-model="form.address"  class="textarea textarea-bordered w-full" />
                <label class="label font-semibold" v-if="form.errors.address"><span class="label-text-alt text-error">{{ form.errors.address }}</span></label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Already registered?
                </Link>

                <button class="btn btn-primary btn-sm ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Daftar</button>
                
            </div>
        </form>
    </GuestLayout>
</template>
