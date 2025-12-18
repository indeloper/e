<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Password from 'primevue/password';
import Button from 'primevue/button';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Подтверждение пароля" />

        <div class="mb-6 text-sm text-gray-600 leading-relaxed">
            Это защищенная область приложения. Пожалуйста, подтвердите свой пароль перед продолжением.
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-1">
                <label for="password" class="text-sm font-medium text-gray-700 ml-1">Пароль</label>
                <Password
                    id="password"
                    v-model="form.password"
                    :feedback="false"
                    toggleMask
                    class="w-full"
                    inputClass="w-full h-12 rounded-xl border-gray-200"
                    required
                    autocomplete="current-password"
                    autofocus
                    placeholder="••••••••"
                />
                <small v-if="form.errors.password" class="text-red-500 text-xs ml-1">{{ form.errors.password }}</small>
            </div>

            <Button
                type="submit"
                label="Подтвердить"
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
