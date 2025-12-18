<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Password from 'primevue/password';
import Button from 'primevue/button';

const passwordInput = ref<any>(null);
const currentPasswordInput = ref<any>(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value?.$el.querySelector('input').focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value?.$el.querySelector('input').focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header class="mb-6">
            <h2 class="text-xl font-bold text-gray-900">Безопасность</h2>
            <p class="mt-1 text-sm text-gray-600">
                Используйте длинный случайный пароль, чтобы обеспечить безопасность вашего аккаунта.
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="space-y-6">
            <div class="space-y-1">
                <label for="current_password" class="text-sm font-medium text-gray-700">Текущий пароль</label>
                <Password
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    :feedback="false"
                    toggleMask
                    class="w-full"
                    inputClass="w-full h-11 rounded-xl border-gray-200"
                    autocomplete="current-password"
                />
                <small v-if="form.errors.current_password" class="text-red-500 text-xs">{{ form.errors.current_password }}</small>
            </div>

            <div class="space-y-1">
                <label for="password" class="text-sm font-medium text-gray-700">Новый пароль</label>
                <Password
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    toggleMask
                    class="w-full"
                    inputClass="w-full h-11 rounded-xl border-gray-200"
                    autocomplete="new-password"
                />
                <small v-if="form.errors.password" class="text-red-500 text-xs">{{ form.errors.password }}</small>
            </div>

            <div class="space-y-1">
                <label for="password_confirmation" class="text-sm font-medium text-gray-700">Подтверждение нового пароля</label>
                <Password
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    :feedback="false"
                    toggleMask
                    class="w-full"
                    inputClass="w-full h-11 rounded-xl border-gray-200"
                    autocomplete="new-password"
                />
                <small v-if="form.errors.password_confirmation" class="text-red-500 text-xs">{{ form.errors.password_confirmation }}</small>
            </div>

            <div class="flex items-center gap-4">
                <Button 
                    type="submit" 
                    label="Обновить пароль" 
                    class="rounded-xl px-8" 
                    :loading="form.processing" 
                />

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Пароль обновлен.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>

<style>
.p-password input {
    width: 100% !important;
}
</style>
