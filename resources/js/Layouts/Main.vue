<script setup>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
import { usePage } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const page = usePage();

const baseUrl = computed(() => page.props.baseUrl);
const currentUrl = computed(() => page.url);
</script>

<template>
  <div>
    <Head>
      <!-- title, description, keywords -->
      <title>{{ $t("home.title") }}</title>
      <meta
        head-key="description"
        name="description"
        :content="$t('home.description')"
      />
      <meta
        head-key="keywords"
        name="keywords"
        :content="$t('home.meta_keywords')"
      />

      <!-- canonical url -->
      <link rel="canonical" :href="baseUrl + currentUrl" />

      <!-- og -->
      <meta
        head-key="og:title"
        property="og:title"
        :content="$t('home.title')"
      />
      <meta
        head-key="og:description"
        property="og:description"
        :content="$t('home.description')"
      />
      <meta
        head-key="og:url"
        property="og:url"
        :content="baseUrl + currentUrl"
      />
      <meta head-key="og:type" property="og:type" content="website" />
      <meta
        head-key="og:image"
        property="og:image"
        content="/storage/images/logo-panoramaalam-icon.svg"
      />
    </Head>
    <div class="flex flex-col min-h-screen font-poppins">
      <Header />
      <main class="flex-1">
        <slot></slot>
      </main>
      <Footer />
    </div>
  </div>
</template>