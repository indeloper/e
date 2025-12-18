<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Button from 'primevue/button';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();
</script>

<template>
    <Head title="Добро пожаловать" />
    
    <div class="min-h-screen flex flex-col bg-gradient-to-br from-gray-100 to-[#041E42]/20">
        <!-- Navigation -->
        <nav class="h-20 flex items-center justify-between px-6 md:px-12 z-10">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 rounded-xl bg-[#041E42] flex items-center justify-center shadow-lg shadow-blue-900/20">
                    <i class="pi pi-building text-white" />
                </div>
                <span class="text-2xl font-black text-[#041E42] tracking-tighter">SK ГOРOД</span>
            </div>
            
            <div v-if="canLogin" class="flex items-center gap-4">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                >
                    <Button label="Панель управления" class="rounded-xl px-6 h-11" />
                </Link>

                <template v-else>
                    <Link :href="route('login')">
                        <Button label="Войти" severity="secondary" text class="rounded-xl px-6 h-11 font-bold" />
                    </Link>

                    <Link v-if="canRegister" :href="route('register')">
                        <Button label="Регистрация" class="rounded-xl px-6 h-11 bg-[#041E42] border-none" />
                    </Link>
                </template>
            </div>
        </nav>

        <!-- Hero Section -->
        <main class="flex-1 flex flex-col items-center justify-center px-6 text-center">
            <div class="max-w-4xl space-y-8 animate-slide-up">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-500/10 text-blue-700 text-xs font-bold uppercase tracking-widest border border-blue-500/20">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                    </span>
                    Новое поколение ERP системы
                </div>
                
                <h1 class="text-5xl md:text-7xl font-black text-gray-900 leading-none tracking-tighter">
                    Управление будущим <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#041E42] to-blue-600">вашего бизнеса</span>
                </h1>
                
                <p class="text-lg md:text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Современная платформа для автоматизации процессов строительного холдинга. Все данные в одном месте, доступные в любое время.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <Link :href="route('login')">
                        <Button label="Начать работу" icon="pi pi-arrow-right" iconPos="right" class="rounded-2xl px-10 h-14 bg-[#041E42] border-none text-lg font-bold shadow-xl shadow-blue-900/20" />
                    </Link>
                    <Button label="Узнать больше" outlined severity="secondary" class="rounded-2xl px-10 h-14 text-lg font-bold border-2 border-gray-300" />
                </div>
            </div>
            
            <!-- Floating Elements Mockup -->
            <div class="mt-20 w-full max-w-5xl relative group animate-slide-up" style="animation-delay: 0.2s">
                <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-[#041E42] rounded-[2.5rem] blur opacity-25 group-hover:opacity-40 transition duration-1000 group-hover:duration-200"></div>
                <div class="relative bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-white p-2">
                    <div class="bg-gray-50 rounded-[2rem] h-[400px] flex items-center justify-center overflow-hidden">
                        <div class="grid grid-cols-3 gap-8 p-12 w-full">
                            <div v-for="i in 6" :key="i" class="h-32 bg-white rounded-3xl shadow-sm border border-gray-100 flex flex-col p-4 animate-pulse">
                                <div class="w-10 h-10 rounded-xl bg-gray-50 mb-3"></div>
                                <div class="w-2/3 h-3 bg-gray-100 rounded mb-2"></div>
                                <div class="w-1/2 h-2 bg-gray-50 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="h-20 flex items-center justify-between px-12 border-t border-gray-200/50 text-xs text-gray-400">
            <div>&copy; 2025 SK ГOРOД. Все права защищены.</div>
            <div class="flex items-center gap-6">
                <span>Laravel v{{ laravelVersion }}</span>
                <span>PHP v{{ phpVersion }}</span>
            </div>
        </footer>
    </div>
</template>

<style>
@keyframes slide-up {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
.animate-slide-up {
    animation: slide-up 0.8s cubic-bezier(0, 0, 0.2, 1) forwards;
}
</style>
