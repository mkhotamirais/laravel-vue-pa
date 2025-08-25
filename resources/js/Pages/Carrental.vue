<script setup>
import { router } from "@inertiajs/vue3";
import CarrentalCard from "../Components/sections/CarrentalCard.vue";
import Hero from "../Components/sections/Hero.vue";
import PaginationInput from "@/Components/ui/PaginationInput.vue";

defineProps({ carrentals: Object });

const params = route().params;

const categories = [
  { name: "All", slug: "" },
  { name: "Lepas Kunci", slug: "lepas_kunci" },
  { name: "Include Driver", slug: "include_driver" },
];

const chooseCategory = (cat) => {
  router.get(route("public.carrental", { rentalcat: cat }));
};
</script>

<template>
  <div>
    <Hero
      :top_title="'carrental.top_title'"
      :title="'carrental.title'"
      :description="'carrental.description'"
    />
    <section class="py-8">
      <div class="container">
        <div class="mb-8 flex gap-1 justify-center">
          <button
            v-for="(c, i) in categories"
            :key="i"
            @click="chooseCategory(c.slug)"
            class="py-2 text-sm px-3 rounded-lg bg-primary/5 hover:bg-primary/10 transition-all"
            :class="params.rentalcat === c.slug ? 'bg-primary/20' : ''"
          >
            {{ c.name }}
          </button>
        </div>
        <div v-if="carrentals.data.length">
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2">
            <div v-for="(carrental, i) in carrentals.data" :key="i">
              <CarrentalCard :key="i" :carrental="carrental" />
            </div>
          </div>
          <div>
            <PaginationInput :paginator="carrentals" />
          </div>
        </div>
        <div v-else class="p-4 rounded-lg shado-md bg-white">
          <p>Data tidak ditemukan</p>
        </div>
      </div>
    </section>
  </div>
</template>