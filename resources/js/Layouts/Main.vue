<script setup>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
</script>

<template>
  <div>
    <Head>
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