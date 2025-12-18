<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import { useToast } from 'primevue/usetoast';
import Toast from 'primevue/toast';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import AppLayoutNavMenu from '@/Layouts/Partials/AppLayoutNavMenu.vue';

const props = defineProps<{
    noCard?: boolean;
}>();

const page = usePage();
const user = computed(() => page.props.auth.user);

const sidebarCollapsed = ref(localStorage.getItem('sidebar-collapsed') === 'true');
const isUserMenuOpen = ref(false);
const userMenuRef = ref<HTMLElement | null>(null);

const toggleSidebar = () => {
    sidebarCollapsed.value = !sidebarCollapsed.value;
    localStorage.setItem('sidebar-collapsed', String(sidebarCollapsed.value));
};

const userInitials = computed(() => {
    const name = user.value?.name || user.value?.email || '??';
    const names = name.trim().split(' ');
    if (names.length >= 2) {
        return (names[0][0] + names[1][0]).toUpperCase();
    }
    return name.substring(0, 2).toUpperCase();
});

const logout = () => {
    router.post(route('logout'));
};

const handleClickOutside = (event: MouseEvent) => {
    if (userMenuRef.value && !userMenuRef.value.contains(event.target as Node)) {
        isUserMenuOpen.value = false;
    }
};

onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside);
});
</script>

<template>
    <div class="h-screen w-full flex bg-slate-100/50">
        <Toast />

        <!-- Sidebar -->
        <aside
            class="hidden md:flex flex-col shrink-0 transition-all duration-300 ease-in-out bg-[#041E42] shadow-2xl z-30"
            :class="sidebarCollapsed ? 'w-20' : 'w-72'"
        >
            <!-- Logo Section -->
            <div class="h-16 shrink-0 flex items-center px-6 gap-3">
                <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center shrink-0">
                    <i class="pi pi-building text-white" />
                </div>
                <Link 
                    v-if="!sidebarCollapsed" 
                    :href="route('dashboard')" 
                    class="font-black text-xl text-white tracking-tighter overflow-hidden whitespace-nowrap animate-fade-in"
                >
                    SK ГOРOД
                </Link>
            </div>

            <!-- Navigation -->
            <div class="flex-1 overflow-y-auto overflow-x-hidden px-3 py-4 custom-scrollbar">
                <AppLayoutNavMenu :collapsed="sidebarCollapsed" />
            </div>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-white/5">
                <div class="flex items-center gap-3 p-2 rounded-xl bg-white/5">
                    <div class="w-8 h-8 rounded-lg bg-blue-500 flex items-center justify-center text-[10px] font-bold text-white shrink-0">
                        {{ userInitials }}
                    </div>
                    <div v-if="!sidebarCollapsed" class="min-w-0 overflow-hidden">
                        <p class="text-[11px] font-bold text-white truncate leading-none mb-1">{{ user?.name }}</p>
                        <p class="text-[9px] text-white/40 truncate leading-none uppercase tracking-widest">Администратор</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Workspace -->
        <div class="flex-1 flex flex-col min-h-0 min-w-0 overflow-hidden">
            <!-- Glass Header -->
            <header class="h-16 shrink-0 flex items-center px-6 gap-6 z-20 bg-white/80 backdrop-blur-xl border-b border-gray-200/50 shadow-sm">
                <button
                    class="flex items-center justify-center w-10 h-10 rounded-xl hover:bg-gray-100 transition-colors shrink-0"
                    @click="toggleSidebar"
                >
                    <i class="pi pi-bars text-gray-500" />
                </button>

                <!-- Page Info -->
                <div class="flex-1 min-w-0">
                    <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wider">
                        <slot name="header" />
                    </h2>
                </div>

                <!-- Global Actions -->
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex relative group">
                        <i class="pi pi-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-blue-500 transition-colors" />
                        <InputText 
                            placeholder="Поиск по системе..." 
                            class="pl-10 h-10 w-64 bg-gray-50 border-none rounded-xl text-sm focus:ring-2 focus:ring-blue-500/10 transition-all"
                        />
                    </div>

                    <button class="w-10 h-10 rounded-xl bg-gray-50 flex items-center justify-center hover:bg-gray-100 transition-colors">
                        <i class="pi pi-bell text-gray-400" />
                    </button>

                    <div ref="userMenuRef" class="relative">
                        <button
                            @click="isUserMenuOpen = !isUserMenuOpen"
                            class="flex items-center gap-2 pl-1 pr-3 py-1 rounded-xl hover:bg-gray-50 transition-colors border border-transparent hover:border-gray-200"
                        >
                            <div class="w-8 h-8 rounded-lg bg-blue-600 flex items-center justify-center text-[10px] font-bold text-white shadow-lg shadow-blue-500/20">
                                {{ userInitials }}
                            </div>
                            <i class="pi pi-chevron-down text-[10px] text-gray-400" />
                        </button>

                        <Transition
                            enter-active-class="transition ease-out duration-200"
                            enter-from-class="transform opacity-0 scale-95 translate-y-2"
                            enter-to-class="transform opacity-100 scale-100 translate-y-0"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100 translate-y-0"
                            leave-to-class="transform opacity-0 scale-95 translate-y-2"
                        >
                            <div
                                v-if="isUserMenuOpen"
                                class="absolute top-full right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl shadow-black/10 ring-1 ring-black/5 overflow-hidden z-50"
                            >
                                <div class="p-5 bg-gradient-to-br from-gray-50 to-white border-b border-gray-100">
                                    <div class="font-bold text-gray-900 leading-tight">{{ user?.name }}</div>
                                    <div class="text-xs text-gray-400 truncate mt-1">{{ user?.email }}</div>
                                </div>
                                <div class="p-2">
                                    <Link
                                        :href="route('profile.edit')"
                                        class="flex items-center gap-3 px-4 py-3 text-sm text-gray-600 hover:bg-blue-50 hover:text-blue-700 rounded-xl transition-all"
                                    >
                                        <i class="pi pi-user text-xs opacity-60" />
                                        <span>Личный кабинет</span>
                                    </Link>
                                    <button
                                        @click="logout"
                                        class="w-full flex items-center gap-3 px-4 py-3 text-sm text-red-600 hover:bg-red-50 rounded-xl transition-all text-left"
                                    >
                                        <i class="pi pi-sign-out text-xs opacity-60" />
                                        <span>Завершить сеанс</span>
                                    </button>
                                </div>
                            </div>
                        </Transition>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-hidden flex flex-col p-4 md:p-6 bg-slate-100/30">
                <div 
                    v-if="!noCard"
                    class="flex-1 bg-white rounded-3xl shadow-xl shadow-slate-200/50 border border-white flex flex-col overflow-hidden animate-slide-up"
                >
                    <slot />
                </div>
                <div v-else class="flex-1 flex flex-col overflow-auto animate-slide-up">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>

<style>
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 20px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.2);
}

@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}
.animate-fade-in {
    animation: fade-in 0.3s ease-out forwards;
}

@keyframes slide-up {
    from { transform: translateY(10px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.animate-slide-up {
    animation: slide-up 0.4s cubic-bezier(0, 0, 0.2, 1) forwards;
}
</style>
