<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from 'primevue/button';
import Dialog from 'primevue/dialog';
import Password from 'primevue/password';
import InputText from 'primevue/inputtext';

const confirmingUserDeletion = ref(false);
const passwordInput = ref<any>(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value?.$el.querySelector('input').focus(),
        onFinish: () => {
            form.reset();
        },
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-xl font-bold text-gray-900">Удаление аккаунта</h2>
            <p class="mt-1 text-sm text-gray-600">
                После удаления вашего аккаунта все его ресурсы и данные будут безвозвратно удалены.
            </p>
        </header>

        <Button
            label="Удалить аккаунт"
            severity="danger"
            outlined
            @click="confirmUserDeletion"
            class="rounded-xl"
        />

        <Dialog
            v-model:visible="confirmingUserDeletion"
            modal
            header="Вы уверены, что хотите удалить аккаунт?"
            :style="{ width: '30rem' }"
            :pt="{
                root: { class: 'rounded-3xl border-none shadow-2xl overflow-hidden' },
                header: { class: 'p-6 bg-gray-50 border-b border-gray-100' },
                content: { class: 'p-6' },
                footer: { class: 'p-6 border-t border-gray-100' }
            }"
        >
            <p class="text-sm text-gray-600 mb-6">
                Пожалуйста, введите ваш пароль, чтобы подтвердить удаление аккаунта.
            </p>

            <div class="space-y-1">
                <Password
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    :feedback="false"
                    toggleMask
                    class="w-full"
                    inputClass="w-full h-11 rounded-xl border-gray-200"
                    placeholder="Пароль"
                    @keyup.enter="deleteUser"
                />
                <small v-if="form.errors.password" class="text-red-500 text-xs">{{ form.errors.password }}</small>
            </div>

            <template #footer>
                <div class="flex justify-end gap-3">
                    <Button 
                        label="Отмена" 
                        severity="secondary" 
                        text 
                        @click="closeModal" 
                        class="rounded-xl"
                    />
                    <Button
                        label="Удалить аккаунт"
                        severity="danger"
                        :loading="form.processing"
                        @click="deleteUser"
                        class="rounded-xl"
                    />
                </div>
            </template>
        </Dialog>
    </section>
</template>

<style>
.p-password input {
    width: 100% !important;
}
</style>
