<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Password from 'primevue/password';
import Button from 'primevue/button';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Регистрация" />

        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-1">
                <label for="name" class="text-sm font-medium text-gray-700 ml-1">Имя</label>
                <div class="relative">
                    <i class="pi pi-user absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 z-10" />
                    <InputText
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="w-full pl-10 h-12 rounded-xl border-gray-200 focus:ring-2 focus:ring-[#041E42]/20"
                        placeholder="Александр Иванов"
                        required
                        autofocus
                        autocomplete="name"
                        :invalid="!!form.errors.name"
                    />
                </div>
                <small v-if="form.errors.name" class="text-red-500 text-xs ml-1">{{ form.errors.name }}</small>
            </div>

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
                        autocomplete="username"
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
                    :feedback="true"
                    toggleMask
                    class="w-full"
                    inputClass="w-full h-12 rounded-xl border-gray-200 focus:ring-2 focus:ring-[#041E42]/20"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password"
                    :invalid="!!form.errors.password"
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
                    inputClass="w-full h-12 rounded-xl border-gray-200 focus:ring-2 focus:ring-[#041E42]/20"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password"
                    :invalid="!!form.errors.password_confirmation"
                />
                <small v-if="form.errors.password_confirmation" class="text-red-500 text-xs ml-1">{{ form.errors.password_confirmation }}</small>
            </div>

            <div class="flex items-center justify-between">
                <Link
                    :href="route('login')"
                    class="text-sm text-[#041E42] font-medium hover:underline"
                >
                    Уже зарегистрированы?
                </Link>
            </div>

            <Button
                type="submit"
                label="Создать аккаунт"
                class="w-full h-12 rounded-xl bg-[#041E42] border-none text-white font-bold text-lg hover:bg-[#062c5f] transition-colors"
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
