<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-100 to-[#041E42]/30">
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/80 backdrop-blur-xl shadow-2xl border border-white/20 overflow-hidden sm:rounded-3xl">
            <div class="flex flex-col items-center mb-8">
                <Link href="/" class="mb-4">
                    <span class="text-3xl font-black text-[#041E42] tracking-tighter">SK ГOРOД</span>
                </Link>
                <h1 class="text-xl font-semibold text-gray-800">Добро пожаловать</h1>
                <p class="text-sm text-gray-500 mt-1">Войдите в систему для начала работы</p>
            </div>

            <slot />
        </div>
        
        <div class="mt-8 text-xs text-gray-400">
            &copy; {{ new Date().getFullYear() }} SK ГOРOД. Все права защищены.
        </div>
    </div>
</template>
