<script setup>
import Sidebar from "@/Components/ui/Sidebar.vue";
import { usePage } from "@inertiajs/vue3";

import { computed, ref } from "vue";
import { useI18n } from "vue-i18n";

const { t, locale, messages } = useI18n();

const page = usePage();

const isSidebarOpen = ref(false);
const adminMenu = computed(() => messages.value[locale.value].admin_menu);

const user = computed(() => page.props.auth.user);
const title = computed(() => page.props.title);
</script>

<template>
  <div>
    <Head title="Dashboard" />
    <section class="py-4">
      <div class="container">
        <div class="flex items-start gap-6">
          <div class="w-1/4 hidden md:flex flex-col sticky top-20">
            <Link
              v-for="(menu, i) in adminMenu"
              :key="i"
              :href="route(menu.name)"
              class="py-2 bg-gray-100 hover:bg-gray-200 px-3 mb-1 rounded text-gray-600"
              :class="menu.url === $page.url ? 'bg-gray-200' : ''"
            >
              {{ menu.label }}
            </Link>
            <Link
              :href="route('logout')"
              method="post"
              as="button"
              class="py-2 mt-2 text-left bg-gray-600 hover:bg-gray-700 px-3 mb-1 rounded text-white"
            >
              Logout
            </Link>
          </div>
          <div class="w-full md:w-3/4">
            <div class="flex">
              <div class="flex md:hidden">
                <Sidebar v-model="isSidebarOpen" side="left" classSide="top-18">
                  <template #trigger>
                    <button @click="isSidebarOpen = true" class="btn-icon mr-2">
                      <i class="fa-solid fa-bars"></i>
                    </button>
                  </template>
                  <div class="flex flex-col">
                    <Link
                      v-for="(menu, i) in adminMenu"
                      :key="i"
                      :href="route(menu.name)"
                      class="py-2 bg-gray-100 hover:bg-gray-200 px-3 mb-1 rounded text-gray-600"
                      :class="menu.url === $page.url ? 'bg-gray-200' : ''"
                      @click="isSidebarOpen = false"
                    >
                      {{ menu.label }}
                    </Link>
                    <Link
                      @click="isSidebarOpen = false"
                      :href="route('logout')"
                      method="post"
                      as="button"
                      class="py-2 mt-2 text-left bg-gray-600 hover:bg-gray-700 px-3 mb-1 rounded text-white"
                    >
                      Logout
                    </Link>
                  </div>
                </Sidebar>
              </div>
              <h1 class="h1">{{ title }}</h1>
            </div>
            <main class="py-2">
              <slot></slot>
            </main>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>