<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import Checkbox from 'primevue/checkbox';
import Tag from 'primevue/tag';
import Message from 'primevue/message';

const props = defineProps<{
    roles: Array<any>;
    permissions: Record<string, Array<any>>;
}>();

const selectedRole = ref(props.roles[0] || null);

const roleForm = useForm({
    name: '',
});

const permissionForm = useForm({
    permissions: [] as string[],
});

const selectRole = (role: any) => {
    selectedRole.value = role;
    permissionForm.permissions = role.permissions.map((p: any) => p.name);
};

// Initial selection
if (selectedRole.value) {
    permissionForm.permissions = selectedRole.value.permissions.map((p: any) => p.name);
}

const createRole = () => {
    roleForm.post(route('roles.store'), {
        onSuccess: () => {
            roleForm.reset();
        }
    });
};

const updatePermissions = () => {
    if (!selectedRole.value) return;
    permissionForm.put(route('roles.permissions.update', selectedRole.value.id));
};

const deleteRole = (role: any) => {
    if (confirm(`Вы уверены, что хотите удалить роль "${role.name}"?`)) {
        useForm({}).delete(route('roles.destroy', role.id), {
            onSuccess: () => {
                if (selectedRole.value?.id === role.id) {
                    selectedRole.value = props.roles[0] || null;
                }
            }
        });
    }
};

const groupLabels: Record<string, string> = {
    'users': 'Пользователи',
    'roles': 'Роли и права',
    'logistics': 'Логистика',
    'objects': 'Объекты',
    'system': 'Системные настройки'
};
</script>

<template>
    <Head title="Должности и права" />

    <AuthenticatedLayout>
        <template #header>
            Должности и права доступа
        </template>

        <div class="flex flex-col md:flex-row h-full">
            <!-- Sidebar: Roles List -->
            <div class="w-full md:w-80 border-r border-gray-100 flex flex-col bg-gray-50/30">
                <div class="p-4 border-b border-gray-100 flex flex-col gap-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400">Список должностей</h3>
                    <form @submit.prevent="createRole" class="flex gap-2">
                        <InputText 
                            v-model="roleForm.name" 
                            placeholder="Новая должность..." 
                            class="flex-1 h-9 text-sm rounded-lg"
                            required
                        />
                        <Button type="submit" icon="pi pi-plus" size="small" :loading="roleForm.processing" />
                    </form>
                </div>

                <div class="flex-1 overflow-auto p-2">
                    <div class="flex flex-col gap-1">
                        <button
                            v-for="role in roles"
                            :key="role.id"
                            @click="selectRole(role)"
                            class="flex items-center justify-between px-4 py-3 rounded-xl transition-all text-left group"
                            :class="[
                                selectedRole?.id === role.id
                                    ? 'bg-[#041E42] text-white shadow-lg shadow-blue-900/10'
                                    : 'hover:bg-gray-100 text-gray-700'
                            ]"
                        >
                            <div class="flex flex-col min-w-0">
                                <span class="font-bold text-sm truncate">{{ role.name }}</span>
                                <span class="text-[10px] opacity-60">
                                    {{ role.permissions.length }} разрешений
                                </span>
                            </div>
                            <Button 
                                v-if="role.name !== 'Super Admin'"
                                icon="pi pi-trash" 
                                severity="danger" 
                                text 
                                size="small" 
                                class="opacity-0 group-hover:opacity-100 transition-opacity"
                                @click.stop="deleteRole(role)"
                            />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Main Content: Permissions Matrix -->
            <div class="flex-1 flex flex-col min-h-0 bg-white">
                <template v-if="selectedRole">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center shrink-0">
                        <div>
                            <h2 class="text-xl font-black text-gray-900 leading-none">
                                Настройка прав: {{ selectedRole.name }}
                            </h2>
                            <p class="text-xs text-gray-400 mt-2 uppercase tracking-widest font-bold">
                                Выберите доступные действия для этой должности
                            </p>
                        </div>
                        <Button 
                            label="Сохранить изменения" 
                            icon="pi pi-check" 
                            @click="updatePermissions" 
                            :loading="permissionForm.processing"
                            class="rounded-xl px-6 shadow-lg shadow-blue-500/20"
                        />
                    </div>

                    <div class="flex-1 overflow-auto p-6">
                        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                            <div 
                                v-for="(groupPermissions, group) in permissions" 
                                :key="group"
                                class="bg-gray-50/50 rounded-3xl p-6 border border-gray-100 flex flex-col gap-4"
                            >
                                <div class="flex items-center gap-3 mb-2">
                                    <div class="w-8 h-8 rounded-xl bg-white shadow-sm flex items-center justify-center border border-gray-100">
                                        <i class="pi pi-folder-open text-blue-500 text-sm" />
                                    </div>
                                    <h3 class="font-black text-gray-800 tracking-tight">{{ groupLabels[group] || group }}</h3>
                                </div>

                                <div class="flex flex-col gap-3">
                                    <div 
                                        v-for="permission in groupPermissions" 
                                        :key="permission.id"
                                        class="flex items-center gap-3 p-3 bg-white rounded-2xl border border-gray-100 hover:border-blue-200 transition-colors cursor-pointer"
                                        @click="() => {
                                            const idx = permissionForm.permissions.indexOf(permission.name);
                                            if (idx > -1) permissionForm.permissions.splice(idx, 1);
                                            else permissionForm.permissions.push(permission.name);
                                        }"
                                    >
                                        <Checkbox 
                                            v-model="permissionForm.permissions" 
                                            :value="permission.name" 
                                            @click.stop
                                        />
                                        <div class="flex flex-col leading-tight">
                                            <span class="text-sm font-bold text-gray-700">{{ permission.name }}</span>
                                            <span class="text-[11px] text-gray-400">Описание права (заглушка)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <div v-else class="flex-1 flex flex-col items-center justify-center text-gray-400 p-12">
                    <i class="pi pi-shield text-6xl mb-4 opacity-20" />
                    <p class="text-lg font-medium">Выберите роль для настройки прав</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
/* Custom transitions and styles */
</style>

