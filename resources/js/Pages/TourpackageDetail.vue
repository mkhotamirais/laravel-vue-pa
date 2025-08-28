<script setup>
import { formatRupiah, smartTrim } from "@/functions";
import Slider from "@/Components/ui/Slider.vue";
import AsideLatestBlog from "@/Components/sections/AsideLatestBlog.vue";
import { capitalize, ref } from "vue";
import { router } from "@inertiajs/vue3";
import Payment from "@/Components/sections/Payment.vue";
import AsideOtherTourpackage from "@/Components/sections/AsideOtherTourpackage.vue";
import AsideOtherCarrental from "@/Components/sections/AsideOtherCarrental.vue";

const props = defineProps({
  tourpackage: Object,
  otherTourpackages: Object,
  latestBlogs: Object,
  otherCarrentals: Object,
});

const otherImages = props.tourpackage.tourimages.map((ti) => ({
  id: ti.id,
  url: `/storage/${ti.image_path}`,
}));

const firstImage = {
  id: props.tourpackage.id,
  url: `/storage/${props.tourpackage.banner}`,
};
const images = [firstImage, ...otherImages];

const chooseCategory = (cat) => {
  router.get(route("public.tourpackage", { tourpackagecat: cat }));
};
</script>

<template>
  <div>
    <Head :title="`${smartTrim(capitalize(tourpackage.name))}`" />
    <section class="py-8">
      <div class="container">
        <div class="flex flex-col md:flex-row gap-8 items-start">
          <article class="w-full md:w-2/3 space-y-4">
            <Slider :images="images" />

            <h1 class="h1 mt-4">{{ tourpackage.name }}</h1>

            <button
              @click="chooseCategory(tourpackage.tourpackagecat)"
              class="badge w-fit text-sm"
            >
              {{ tourpackage.tourpackagecat.name }}
            </button>

            <div class="text-gray-500 text-sm">
              <span>{{ $t("others.start_from") }}</span>
              <div>
                <span class="text-2xl font-semibold pr-2 text-gray-700">
                  {{ formatRupiah(tourpackage.price) }}
                </span>
                <span>/ {{ $t("others.person") }}</span>
              </div>
            </div>

            <div>
              <p class="font-medium leading-none text-gray-500">
                {{ $t("others.price_detail") }} :
              </p>
              <div class="text-content" v-html="tourpackage.price_detail"></div>
            </div>

            <div
              class="flex flex-wrap gap-2 items-center border py-2 px-3 bg-primary/5 border-primary/50 rounded-md"
            >
              <span class="font-semibold">{{ $t("others.route") }} : </span>
              <div
                v-for="(item, i) in tourpackage.tourroutes"
                :key="i"
                class="text-gray-600"
              >
                {{ item.name }}
                {{ i !== tourpackage.tourroutes.length - 1 ? " → " : "" }}
              </div>
            </div>

            <!-- Itinerary -->
            <div class="py-2 px-3 border border-primary/50 rounded-md">
              <h2 class="h2 text-xl">
                <i class="fa-solid fa-route text-primary mr-2"></i>
                {{ $t("others.itinerary") }}
              </h2>
              <div class="text-content">
                <p class="font-medium">
                  {{ tourpackage.itenary_description }}
                </p>
                <div v-html="tourpackage.itenary_detail"></div>
              </div>
            </div>

            <!-- Policy -->
            <div
              v-if="tourpackage.policy_detail || tourpackage.policy_description"
              class="py-2 px-3 border border-primary/50 rounded-md bg-primary/5"
            >
              <h2 class="h2 text-xl">{{ $t("others.policy") }}</h2>
              <div class="text-content">
                <p class="font-medium">
                  {{ tourpackage.policy_description }}
                </p>
                <div v-html="tourpackage.policy_detail"></div>
              </div>
            </div>

            <!-- Info -->
            <div
              v-if="tourpackage.info_detail || tourpackage.info_description"
              class="py-2 px-3 border border-primary/50 rounded-md"
            >
              <h2 class="h2 text-xl">{{ $t("others.info") }}</h2>
              <div class="text-content">
                <p class="font-medium">
                  {{ tourpackage.info_description }}
                </p>
                <div v-html="tourpackage.info_detail"></div>
              </div>
            </div>

            <Payment />
          </article>
          <div
            class="w-full md:w-1/3 sticky top-20 space-y-6 overflow-y-scroll h-[calc(100vh-6rem)]"
          >
            <AsideOtherTourpackage :otherTourpackages="otherTourpackages" />
            <AsideOtherCarrental :otherCarrentals="otherCarrentals" />
            <AsideLatestBlog :latestBlogs="latestBlogs" />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>