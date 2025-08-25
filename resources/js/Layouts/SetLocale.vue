<script setup>
import { useI18n } from "vue-i18n";
import { ref } from "vue";

const { locale } = useI18n();
const lang = ref(locale.value);

const changeLang = () => {
  locale.value = lang.value;
  localStorage.setItem("locale", lang.value);
};
</script>

<template>
  <label for="language-select" class="sr-only">Pilih Bahasa</label>
  <select
    id="language-select"
    v-model="lang"
    @change="changeLang"
    class="py-2 mx-2 text-sm text-gray-600 font-medium cursor-pointer"
  >
    <option value="en">EN</option>
    <option value="id">ID</option>
  </select>
</template>