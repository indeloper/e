<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();
</script>

<template>
    <Head title="Личный кабинет" />

    <AuthenticatedLayout no-card>
        <template #header>
            Личный кабинет
        </template>

        <div class="max-w-4xl mx-auto space-y-6 pb-12">
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl shadow-slate-200/50 border border-white overflow-hidden">
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
