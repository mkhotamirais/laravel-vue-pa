<script setup>
import Subtitle from "@/Components/sections/Subtitle.vue";
import BlogCard1 from "@/Components/sections/BlogCard1.vue";
import CarrentalCard from "@/Components/sections/CarrentalCard.vue";
import TourpackageCard from "@/Components/sections/TourpackageCard.vue";

defineProps({ blogs: Object, carrentals: Object, tourpackages: Object });
</script>

<template>
  <div>
    <section
      class="bg-[url('/storage/images/unsplash_home_hero_bg.avif')] bg-cover bg-center"
    >
      <div class="bg-gradient-to-b from-black/60 to-black/60">
        <div
          class="container max-w-4xl text-white py-16 flex flex-col items-start sm:items-center sm:text-center space-y-8"
        >
          <h1 class="text-4xl sm:text-5xl font-bold">{{ $t("home.title") }}</h1>
          <p class="leading-relaxed">{{ $t("home.description") }}</p>
          <div class="flex flex-col sm:flex-row gap-2 text-center">
            <Link
              :href="route('public.carrental')"
              class="bg-primary hover:bg-primary-hover py-4 w-42 justify-center rounded-full"
              >{{ $t("main_menu.1.label") }}</Link
            >
            <Link
              :href="route('public.tourpackage')"
              class="btn-outline w-42"
              >{{ $t("main_menu.2.label") }}</Link
            >
          </div>
        </div>
      </div>
    </section>

    <!-- Car Rental -->
    <section class="py-16">
      <div class="container">
        <Subtitle top_title="carrental.top_title" title="carrental.title" />
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="(carrental, i) in carrentals" :key="i">
            <CarrentalCard :key="i" :carrental="carrental" />
          </div>
        </div>
        <Link :href="route('public.carrental')" class="btn-outline mt-8">{{
          $t("buttons.btn_all_carrentals")
        }}</Link>
      </div>
    </section>

    <!-- Tour Package -->
    <section class="py-16 bg-gray-100">
      <div class="container">
        <Subtitle top_title="tourpackage.top_title" title="tourpackage.title" />
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="(item, i) in tourpackages" :key="i">
            <TourpackageCard :item="item" />
          </div>
        </div>
        <Link :href="route('public.tourpackage')" class="btn-outline mt-8">{{
          $t("buttons.btn_all_tourpackages")
        }}</Link>
      </div>
    </section>

    <!-- Blog -->
    <section class="py-16">
      <div class="container">
        <Subtitle top_title="blog.top_title" title="blog.title" />
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <div v-for="(blog, i) in blogs" :key="i">
            <BlogCard1 :key="i" :blog="blog" />
          </div>
        </div>
        <Link :href="route('public.blog')" class="btn-outline mt-8">{{
          $t("buttons.btn_all_blogs")
        }}</Link>
      </div>
    </section>

    <!-- Contact -->
    <section class="py-16 bg-primary text-white text-center">
      <div class="container space-y-4">
        <h2 class="text-3xl md:text-4xl font-semibold">
          {{ $t("home.contact_title") }}
        </h2>
        <p class="text-lg">{{ $t("home.contact_description") }}</p>
        <a
          :href="$t('links.wa.url')"
          class="inline-flex items-center w-fit bg-white hover:bg-white/90 text-primary font-semibold px-6 py-4 rounded-full"
        >
          <i class="fa-brands fa-whatsapp mr-2 text-2xl"></i>
          {{ $t("links.contact_us_btn") }}</a
        >
      </div>
    </section>
  </div>
</template>