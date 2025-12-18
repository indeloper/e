<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps<{
    collapsed?: boolean;
}>();

const menuItems = [
    {
        label: 'Главная',
        icon: 'pi pi-th-large',
        route: 'dashboard',
    },
    {
        label: 'Система',
        icon: 'pi pi-cog',
        items: [
            { label: 'Пользователи', route: 'dashboard', icon: 'pi pi-users' },
            { label: 'Роли', route: 'roles.index', icon: 'pi pi-shield' },
            { label: 'Настройки', route: 'dashboard', icon: 'pi pi-cog' },
        ]
    },
    {
        label: 'Объекты',
        icon: 'pi pi-map-marker',
        route: 'dashboard',
    },
    {
        label: 'Библиотека',
        icon: 'pi pi-book',
        route: 'dashboard',
    },
    {
        label: 'Логистика',
        icon: 'pi pi-truck',
        route: 'dashboard',
    },
    {
        label: 'Имущество',
        icon: 'pi pi-box',
        route: 'dashboard',
    },
    {
        label: 'Справочники',
        icon: 'pi pi-list',
        route: 'dashboard',
    },
    {
        label: 'Администрирование',
        icon: 'pi pi-shield',
        route: 'dashboard',
    },
    {
        label: 'Документация',
        icon: 'pi pi-file-pdf',
        route: 'dashboard',
    }
];

const openMenus = ref<string[]>(['Система']);

const toggleMenu = (label: string) => {
    const index = openMenus.value.indexOf(label);
    if (index > -1) {
        openMenus.value.splice(index, 1);
    } else {
        openMenus.value.push(label);
    }
};

const isActive = (routeName: string) => {
    return route().current(routeName);
};

const isMenuOpen = (label: string) => openMenus.value.includes(label);
</script>

<template>
    <nav class="flex flex-col gap-0.5">
        <template v-for="item in menuItems" :key="item.label">
            <!-- Simple Item -->
            <div v-if="!item.items">
                <Link
                    :href="route(item.route)"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group"
                    :class="[
                        isActive(item.route)
                            ? 'bg-white/10 text-white shadow-sm'
                            : 'text-white/60 hover:bg-white/5 hover:text-white'
                    ]"
                >
                    <i :class="[item.icon, 'text-base shrink-0 transition-transform group-hover:scale-110']" />
                    <span v-if="!collapsed" class="text-[13px] font-medium tracking-tight">
                        {{ item.label }}
                    </span>
                </Link>
            </div>
            
            <!-- Group with Sub-items -->
            <div v-else class="flex flex-col">
                <button
                    v-if="!collapsed"
                    @click="toggleMenu(item.label)"
                    class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-xl text-white/60 hover:bg-white/5 hover:text-white transition-all duration-200 group"
                >
                    <div class="flex items-center gap-3">
                        <i :class="[item.icon, 'text-base shrink-0 group-hover:scale-110 transition-transform']" />
                        <span class="text-[13px] font-medium tracking-tight">{{ item.label }}</span>
                    </div>
                    <i 
                        class="pi pi-chevron-down text-[10px] transition-transform duration-300"
                        :class="{ 'rotate-180': isMenuOpen(item.label) }"
                    />
                </button>
                <div v-else class="flex items-center justify-center py-2 text-white/20">
                    <i :class="[item.icon, 'text-base']" />
                </div>

                <div 
                    v-if="!collapsed && isMenuOpen(item.label)" 
                    class="flex flex-col gap-0.5 mt-0.5"
                >
                    <Link
                        v-for="subItem in item.items"
                        :key="subItem.label"
                        :href="route(subItem.route)"
                        class="flex items-center gap-3 px-3 py-2 rounded-xl transition-all duration-200 ml-4 border-l border-white/5"
                        :class="[
                            isActive(subItem.route)
                                ? 'bg-white/10 text-white'
                                : 'text-white/40 hover:bg-white/5 hover:text-white'
                        ]"
                    >
                        <span class="text-[12px] font-medium tracking-tight">
                            {{ subItem.label }}
                        </span>
                    </Link>
                </div>
            </div>
        </template>
    </nav>
</template>

<style scoped>
/* Optional styling */
</style>
