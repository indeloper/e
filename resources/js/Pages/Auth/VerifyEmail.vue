<script setup lang="ts">
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Button from 'primevue/button';
import Message from 'primevue/message';

const props = defineProps<{
    status?: string;
}>();

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Подтверждение Email" />

        <div class="mb-6 text-sm text-gray-600 leading-relaxed">
            Спасибо за регистрацию! Прежде чем начать, пожалуйста, подтвердите свой адрес электронной почты, нажав на ссылку, которую мы только что отправили вам. Если вы не получили письмо, мы с радостью отправим вам другое.
        </div>

        <Message v-if="verificationLinkSent" severity="success" class="mb-6">
            Новая ссылка для подтверждения была отправлена на адрес электронной почты, который вы указали при регистрации.
        </Message>

        <form @submit.prevent="submit" class="space-y-6">
            <Button
                type="submit"
                label="Отправить письмо повторно"
                class="w-full h-12 rounded-xl bg-[#041E42] border-none text-white font-bold"
                :loading="form.processing"
            />

            <div class="flex items-center justify-center">
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-gray-500 hover:text-gray-700 underline font-medium"
                >
                    Выйти
                </Link>
            </div>
        </form>
    </GuestLayout>
</template>
