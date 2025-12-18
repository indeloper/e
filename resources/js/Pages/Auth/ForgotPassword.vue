<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};

defineProps<{
    status?: string;
}>();
</script>

<template>
    <GuestLayout>
        <Head title="Восстановление пароля" />

        <div class="mb-6 text-sm text-gray-600 leading-relaxed">
            Забыли пароль? Без проблем. Просто сообщите нам свой адрес электронной почты, и мы вышлем вам ссылку для сброса пароля.
        </div>

        <div v-if="status" class="mb-6 p-4 rounded-xl bg-emerald-50 text-sm font-medium text-emerald-600 border border-emerald-100">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="space-y-6">
            <div class="space-y-1">
                <label for="email" class="text-sm font-medium text-gray-700 ml-1">Email</label>
                <InputText
                    id="email"
                    type="email"
                    class="w-full h-12 rounded-xl border-gray-200"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="example@mail.com"
                />
                <small v-if="form.errors.email" class="text-red-500 text-xs ml-1">{{ form.errors.email }}</small>
            </div>

            <Button
                type="submit"
                label="Отправить ссылку"
                class="w-full h-12 rounded-xl bg-[#041E42] border-none text-white font-bold"
                :loading="form.processing"
            />
        </form>
    </GuestLayout>
</template>
