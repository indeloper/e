<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/button';
import Message from 'primevue/message';

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Авторизация" />

        <Message v-if="status" severity="success" class="mb-4">{{ status }}</Message>
        
        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-1">
                <label for="email" class="text-sm font-medium text-gray-700 ml-1">Email</label>
                <div class="relative">
                    <i class="pi pi-envelope absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 z-10" />
                    <InputText
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="w-full pl-10 h-12 rounded-xl border-gray-200 focus:ring-2 focus:ring-[#041E42]/20"
                        placeholder="example@mail.com"
                        required
                        autofocus
                        :invalid="!!form.errors.email"
                    />
                </div>
                <small v-if="form.errors.email" class="text-red-500 text-xs ml-1">{{ form.errors.email }}</small>
            </div>

            <div class="space-y-1">
                <label for="password" class="text-sm font-medium text-gray-700 ml-1">Пароль</label>
                <Password
                    id="password"
                    v-model="form.password"
                    :feedback="false"
                    toggleMask
                    class="w-full"
                    inputClass="w-full h-12 rounded-xl border-gray-200 focus:ring-2 focus:ring-[#041E42]/20"
                    placeholder="••••••••"
                    required
                    :invalid="!!form.errors.password"
                />
                <small v-if="form.errors.password" class="text-red-500 text-xs ml-1">{{ form.errors.password }}</small>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <Checkbox v-model="form.remember" binary id="remember" class="mr-2" />
                    <label for="remember" class="text-sm text-gray-600 cursor-pointer">Запомнить меня</label>
                </div>
                
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-[#041E42] font-medium hover:underline"
                >
                    Забыли пароль?
                </Link>
            </div>

            <Button
                type="submit"
                label="Войти"
                class="w-full h-12 rounded-xl bg-[#041E42] border-none text-white font-bold text-lg hover:bg-[#062c5f] transition-colors"
                :loading="form.processing"
            />
        </form>
    </GuestLayout>
</template>

<style>
/* Специфичные фиксы для PrimeVue в контексте Tailwind */
.p-password input {
    width: 100% !important;
}
</style>
