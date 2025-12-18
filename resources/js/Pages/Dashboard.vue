<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import Button from 'primevue/button';
import Card from 'primevue/card';
import Message from 'primevue/message';

const messages = ref<string[]>([]);
const form = useForm({});

onMounted(() => {
    (window as any).Echo.channel('demo-channel')
        .listen('.Domain\\Shared\\Events\\DemoEvent', (e: any) => {
            messages.value.unshift(e.message);
        });
});

const triggerEvent = () => {
    form.post(route('trigger.event'), {
        preserveScroll: true
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard & Real-time Demo
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                <Card>
                    <template #title>
                        PrimeVue + Laravel Reverb
                    </template>
                    <template #content>
                        <div class="flex flex-col items-center gap-4">
                            <p class="text-gray-600">
                                Нажмите кнопку ниже, чтобы отправить событие через сокеты.
                            </p>
                            <Button 
                                label="Отправить событие" 
                                icon="pi pi-send" 
                                @click="triggerEvent"
                                :loading="form.processing"
                            />
                        </div>
                    </template>
                </Card>

                <div v-if="messages.length > 0" class="space-y-2">
                    <h3 class="font-medium text-lg text-gray-700">Последние сообщения из сокета:</h3>
                    <div v-for="(msg, index) in messages" :key="index">
                        <Message severity="success">{{ msg }}</Message>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
