<script setup>
import { computed } from "vue";
import Logo from "../Components/Logo.vue";
import { useI18n } from "vue-i18n";

const { t, locale, messages } = useI18n();

const mainMenu = computed(() => messages.value[locale.value].main_menu);
</script>

<template>
  <footer class="border-t border-gray-200">
    <div class="container pt-12 pb-8 grid lg:grid-cols-4 gap-8">
      <div>
        <div class="w-fit">
          <Logo />
        </div>
        <p class="text-text">{{ $t("footer.moto") }}</p>
        <address class="mt-4 text-sm block text-gray-500">
          {{ $t("footer.address") }}
        </address>
      </div>
      <div>
        <h4 class="h3 py-2">{{ $t("footer.links") }}</h4>
        <nav class="flex flex-col">
          <Link
            v-for="(m, i) in mainMenu"
            :key="i"
            :href="m.url"
            class="footer-link"
          >
            {{ m.label }}
          </Link>
        </nav>
      </div>
      <div>
        <h4 class="h3 py-2">{{ $t("footer.other_links") }}</h4>
        <nav class="flex flex-col">
          <!-- <Link :href="route('login')" class="footer-link"> Login </Link> -->
          <a :href="$t('links.rl.url')" class="footer-link">{{
            $t("links.rl.label")
          }}</a>
        </nav>
      </div>
      <div>
        <h4 class="h3 py-2">{{ $t("links.contact_us_btn") }}</h4>
        <nav class="flex flex-col">
          <a :href="$t('links.wa.url')" class="footer-link">{{
            $t("links.wa.label")
          }}</a>
          <a :href="$t('links.ig.url')" class="footer-link"
            >@{{ $t("links.ig.label") }}</a
          >
        </nav>
      </div>
    </div>
    <div class="py-4 bg-gray-100">
      <div class="container">
        <p class="text-sm text-center">
          Copyright &copy; {{ new Date().getFullYear() }}
          <span class="font-medium"> PT. Panoramaalam Bahagian </span>
        </p>
      </div>
    </div>
  </footer>
</template>