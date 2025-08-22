<script setup>
import Logo from "@/Components/Logo.vue";
import SetLocale from "./SetLocale.vue";
import Sidebar from "@/Components/ui/Sidebar.vue";

import { computed } from "vue";
import { useI18n } from "vue-i18n";

const { t, locale, messages } = useI18n();

const mainMenu = computed(() => messages.value[locale.value].main_menu);
</script>

<template>
  <header class="h-16 border-b sticky top-0 bg-white z-30">
    <div class="container flex items-center justify-between">
      <Logo />
      <!-- nav desktop -->
      <div class="hidden md:flex mr-2">
        <div class="hidden md:flex mr-2">
          <Link
            v-for="(menu, i) in mainMenu"
            :key="i"
            :href="route(menu.name)"
            class="btn-link"
            :class="menu.url === $page.url ? 'bg-primary/10' : ''"
            >{{ menu.label }}</Link
          >
        </div>
      </div>
      <!-- nav mobil -->
      <div>
        <Sidebar>
          <template #trigger>
            <button
              class="rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700"
            >
              Buka Sidebar
            </button>
          </template>

          <template #title>
            <h2 class="text-lg font-semibold">Menu Utama</h2>
          </template>

          <p class="mt-4 text-gray-700">
            Ini adalah konten di dalam sidebar. Anda bisa menempatkan navigasi
            atau informasi di sini.
          </p>
        </Sidebar>
      </div>
      <SetLocale />
    </div>
  </header>
</template>