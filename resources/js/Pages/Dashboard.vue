<script setup lang="ts">
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Tag from 'primevue/tag';
import InputText from 'primevue/inputtext';
import Button from 'primevue/button';
import { ref } from 'vue';

const props = defineProps<{
    users: Array<any>;
}>();

const filters = ref({
    global: { value: null, matchMode: 'contains' },
});
</script>

<template>
    <Head title="Список пользователей" />

    <AuthenticatedLayout>
        <template #header>
            Пользователи
        </template>

        <div class="flex-1 flex flex-col min-h-0">
            <!-- Table Toolbar -->
            <div class="p-4 border-b border-gray-100 flex justify-between items-center gap-4 bg-gray-50/50">
                <div class="flex items-center gap-3">
                    <span class="relative">
                        <i class="pi pi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" />
                        <InputText
                            v-model="filters['global'].value"
                            placeholder="Поиск..."
                            class="pl-10 h-10 w-64 border-gray-200"
                        />
                    </span>
                </div>
                <div class="flex items-center gap-2">
                    <Button icon="pi pi-refresh" severity="secondary" rounded text />
                    <Button label="Экспорт" icon="pi pi-download" severity="secondary" outlined size="small" />
                    <Button label="Добавить" icon="pi pi-plus" size="small" />
                </div>
            </div>

            <!-- Table -->
            <div class="flex-1 overflow-auto">
                <DataTable
                    :value="users"
                    :filters="filters"
                    dataKey="id"
                    stripedRows
                    scrollable
                    scrollHeight="flex"
                    class="p-datatable-sm"
                    :pt="{
                        thead: { class: 'bg-gray-50' },
                        headerRow: { class: 'text-xs uppercase tracking-wider text-gray-500 font-semibold' }
                    }"
                >
                    <Column field="id" header="ID" sortable style="width: 80px" class="font-mono text-xs text-gray-500" />
                    <Column header="ФИО" sortable field="name">
                        <template #body="{ data }">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                    {{ data.name.substring(0, 2).toUpperCase() }}
                                </div>
                                <span class="font-medium text-gray-900">{{ data.name }}</span>
                            </div>
                        </template>
                    </Column>
                    <Column field="email" header="Email" sortable />
                    <Column field="is_active" header="Активен" sortable style="width: 120px">
                        <template #body="{ data }">
                            <Tag
                                :value="data.is_active ? 'Да' : 'Нет'"
                                :severity="data.is_active ? 'success' : 'danger'"
                                rounded
                                class="px-3"
                            />
                        </template>
                    </Column>
                    <Column field="last_synced_at" header="Синхронизирован" sortable>
                        <template #body="{ data }">
                            <span class="text-sm text-gray-500">
                                {{ data.last_synced_at ? new Date(data.last_synced_at).toLocaleString('ru-RU') : 'Никогда' }}
                            </span>
                        </template>
                    </Column>
                    <Column header="Действия" style="width: 100px" align-frozen="right" frozen>
                        <template #body>
                            <div class="flex items-center gap-1">
                                <Button icon="pi pi-pencil" severity="secondary" text rounded size="small" />
                                <Button icon="pi pi-trash" severity="danger" text rounded size="small" />
                            </div>
                        </template>
                    </Column>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
/* Стили для таблицы в стиле Tailwind */
.p-datatable .p-datatable-thead > tr > th {
    background: transparent;
    border-bottom: 1px solid #f3f4f6;
    padding: 1rem;
}

.p-datatable .p-datatable-tbody > tr > td {
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
}

.p-datatable.p-datatable-striped .p-datatable-tbody > tr:nth-child(even) {
    background: #f9fafb;
}
</style>
