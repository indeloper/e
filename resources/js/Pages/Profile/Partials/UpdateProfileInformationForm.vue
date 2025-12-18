<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import Message from 'primevue/message';

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section>
        <header class="mb-6">
            <h2 class="text-xl font-bold text-gray-900">Профиль пользователя</h2>
            <p class="mt-1 text-sm text-gray-600">
                Обновите информацию о себе и адрес электронной почты.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="space-y-6">
            <div class="space-y-1">
                <label for="name" class="text-sm font-medium text-gray-700">Имя</label>
                <InputText
                    id="name"
                    class="w-full h-11 rounded-xl border-gray-200"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <small v-if="form.errors.name" class="text-red-500 text-xs">{{ form.errors.name }}</small>
            </div>

            <div class="space-y-1">
                <label for="email" class="text-sm font-medium text-gray-700">Email</label>
                <InputText
                    id="email"
                    type="email"
                    class="w-full h-11 rounded-xl border-gray-200"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <small v-if="form.errors.email" class="text-red-500 text-xs">{{ form.errors.email }}</small>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null" class="bg-amber-50 p-4 rounded-xl border border-amber-100">
                <p class="text-sm text-amber-800">
                    Ваш email не подтвержден.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="font-bold underline hover:text-amber-900"
                    >
                        Нажмите здесь, чтобы отправить письмо повторно.
                    </Link>
                </p>

                <Message v-if="status === 'verification-link-sent'" severity="success" class="mt-2 text-sm">
                    Новая ссылка для подтверждения была отправлена на ваш email.
                </Message>
            </div>

            <div class="flex items-center gap-4">
                <Button 
                    type="submit" 
                    label="Сохранить" 
                    class="rounded-xl px-8" 
                    :loading="form.processing" 
                />

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Сохранено.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
