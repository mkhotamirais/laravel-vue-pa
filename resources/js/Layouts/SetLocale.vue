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
    class="rounded-lg dark:bg-dark py-1 font-poppins text-sm"
  >
    <option value="en">EN</option>
    <option value="id">ID</option>
  </select>
</template>