<script setup>
import Hero from "@/Components/sections/Hero.vue";
import TourpackageCard from "@/Components/sections/TourpackageCard.vue";
import { router } from "@inertiajs/vue3";
import PaginationInput from "@/Components/ui/PaginationInput.vue";

const params = route().params;

defineProps({ tourpackages: Object, tourpackagecats: Object });

const chooseCategory = (cat) => {
  router.get(route("public.tourpackage", { tourpackagecat: cat }));
};
</script>

<template>
  <div>
    <Head>
      <title>{{ $t("tourpackage.title") }}</title>
      <meta
        head-key="description"
        name="description"
        :content="$t('tourpackage.description')"
      />
    </Head>
    <Hero
      :top_title="'tourpackage.top_title'"
      :title="'tourpackage.title'"
      :description="'tourpackage.description'"
    />
    <section class="py-8">
      <div class="container">
        <div class="mb-8 flex gap-1 justify-center max-w-2xl flex-wrap mx-auto">
          <button
            @click="chooseCategory('')"
            class="py-2 text-sm px-3 rounded-lg bg-primary/5 hover:bg-primary/10 transition-all capitalize"
          >
            all
          </button>
          <button
            v-for="(c, i) in tourpackagecats"
            :key="i"
            @click="chooseCategory(c.slug)"
            class="py-2 text-sm px-3 rounded-lg bg-primary/5 hover:bg-primary/10 transition-all capitalize"
            :class="params.tourpackagecat === c.slug ? 'bg-primary/20' : ''"
          >
            {{ c.name }}
          </button>
        </div>
        <div v-if="tourpackages.data.length">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <TourpackageCard
              v-for="(item, i) in tourpackages.data"
              :key="i"
              :item="item"
            />
          </div>
          <div>
            <PaginationInput :paginator="tourpackages" />
          </div>
        </div>
        <div v-else class="p-4 rounded-lg shado-md bg-white">
          <p>Data tidak ditemukan</p>
        </div>
      </div>
    </section>
  </div>
</template>