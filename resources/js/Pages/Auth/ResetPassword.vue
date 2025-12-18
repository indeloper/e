<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';

const props = defineProps<{
    email: string;
    token: string;
}>();

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Сброс пароля" />

        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-1">
                <label for="email" class="text-sm font-medium text-gray-700 ml-1">Email</label>
                <InputText
                    id="email"
                    type="email"
                    class="w-full h-12 rounded-xl border-gray-200"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <small v-if="form.errors.email" class="text-red-500 text-xs ml-1">{{ form.errors.email }}</small>
            </div>

            <div class="space-y-1">
                <label for="password" class="text-sm font-medium text-gray-700 ml-1">Новый пароль</label>
                <Password
                    id="password"
                    v-model="form.password"
                    toggleMask
                    class="w-full"
                    inputClass="w-full h-12 rounded-xl border-gray-200"
                    required
                    autocomplete="new-password"
                    autofocus
                    placeholder="••••••••"
                />
                <small v-if="form.errors.password" class="text-red-500 text-xs ml-1">{{ form.errors.password }}</small>
            </div>

            <div class="space-y-1">
                <label for="password_confirmation" class="text-sm font-medium text-gray-700 ml-1">Подтверждение пароля</label>
                <Password
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :feedback="false"
                    toggleMask
                    class="w-full"
                    inputClass="w-full h-12 rounded-xl border-gray-200"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                />
                <small v-if="form.errors.password_confirmation" class="text-red-500 text-xs ml-1">{{ form.errors.password_confirmation }}</small>
            </div>

            <Button
                type="submit"
                label="Сбросить пароль"
                class="w-full h-12 rounded-xl bg-[#041E42] border-none text-white font-bold"
                :loading="form.processing"
            />
        </form>
    </GuestLayout>
</template>

<style>
.p-password input {
    width: 100% !important;
}
</style>
