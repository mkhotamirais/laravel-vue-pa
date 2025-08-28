<script setup>
import Logo from "@/Components/Logo.vue";
import SetLocale from "./SetLocale.vue";
import Sidebar from "@/Components/ui/Sidebar.vue";
import Search from "./Search.vue";

import { computed, ref } from "vue";
import { useI18n } from "vue-i18n";
import { usePage } from "@inertiajs/vue3";

const blogResults = [];
const carrentalResults = [];
const tourpackageResults = [];

const { t, locale, messages } = useI18n();
const page = usePage();

const isSidebarOpen = ref(false);

const mainMenu = computed(() => messages.value[locale.value].main_menu);
const user = computed(() => page.props.auth.user);
</script>

<template>
  <header class="h-16 sticky top-0 bg-white z-30 shadow">
    <div class="container flex items-center justify-between">
      <Logo />
      <!-- nav desktop -->
      <div class="hidden lg:flex items-center gap-2">
        <nav class="flex">
          <Link
            v-for="(menu, i) in mainMenu"
            :key="i"
            :href="route(menu.name)"
            class="py-2 text-sm mx-[1px] px-3 rounded text-gray-600 hover:bg-gray-100 font-medium w-max"
            :class="menu.url === $page.url ? 'bg-gray-100' : ''"
            >{{ menu.label }}</Link
          >
        </nav>

        <Search
          :blogResults="blogResults"
          :carrentalResults="carrentalResults"
          :tourpackageResults="tourpackageResults"
          class="mr-2"
        />

        <a :href="$t('links.wa.url')" class="btn text-sm px-4 rounded-full">
          <i class="fa-brands fa-whatsapp mr-2 text-xl"></i>
          {{ $t("links.contact_us_btn") }}</a
        >
        <Link
          v-if="user"
          :href="route('dashboard')"
          class="py-2 px-3 ring ring-inset ring-primary text-sm capitalize rounded"
          >dashboard</Link
        >
        <SetLocale />
      </div>

      <!-- nav mobile -->
      <div class="lg:hidden flex items-center">
        <Search
          :blogResults="blogResults"
          :carrentalResults="carrentalResults"
          :tourpackageResults="tourpackageResults"
          class="mr-3"
        />
        <Sidebar v-model="isSidebarOpen">
          <template #trigger>
            <button
              @click="isSidebarOpen = true"
              type="button"
              class="btn-icon"
              aria-label="mobile menu"
            >
              <i class="fa-solid fa-bars"></i>
            </button>
          </template>

          <template #title>
            <div class="px-1">
              <SetLocale />
            </div>
          </template>

          <div>
            <nav class="mt-2 flex flex-col">
              <Link
                v-for="(menu, i) in mainMenu"
                :key="i"
                :href="route(menu.name)"
                class="py-2 mx-0.5 px-3 mb-1 rounded text-gray-600 hover:bg-gray-100 font-medium"
                :class="menu.url === $page.url ? 'bg-gray-100' : ''"
                @click="isSidebarOpen = false"
              >
                {{ menu.label }}
              </Link>
              <div class="space-y-2 mt-2">
                <a
                  :href="$t('links.wa.url')"
                  @click="isSidebarOpen = false"
                  class="btn w-full px-4"
                >
                  <i class="fa-brands fa-whatsapp mr-2 text-xl"></i>
                  {{ $t("links.contact_us_btn") }}</a
                >
                <Link
                  v-if="user"
                  :href="route('dashboard')"
                  @click="isSidebarOpen = false"
                  class="py-2 px-3 ring ring-inset ring-primary block capitalize rounded"
                  >dashboard</Link
                >
              </div>
            </nav>
          </div>
        </Sidebar>
      </div>
    </div>
  </header>
</template>