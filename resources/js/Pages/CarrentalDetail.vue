<script setup>
import { formatRupiah, smartTrim, diffForHumans } from "@/functions";
import { capitalize } from "vue";
import AsideLatestBlog from "../Components/sections/AsideLatestBlog.vue";
import AsideOtherCarrental from "../Components/sections/AsideOtherCarrental.vue";
import { router } from "@inertiajs/vue3";

defineProps({
  carrental: Object,
  otherCarrentals: Object,
  latestBlogs: Object,
});

const chooseCategory = (cat) => {
  router.get(route("public.carrental", { rentalcat: cat }));
};
</script>

<template>
  <div>
    <!-- <Head :title="`Sewa Mobil ${smartTrim(capitalize(carrental.name))}`" /> -->
    <section class="py-8">
      <div class="container">
        <div class="flex flex-col md:flex-row gap-8 items-start">
          <article class="md:w-2/3 space-y-4">
            <div class="space-y-2">
              <h1 class="h1">{{ carrental.name }}</h1>
              <button
                @click="chooseCategory(carrental.category)"
                class="badge w-fit text-base"
              >
                {{ carrental.category.replace("_", " ") }}
              </button>
              <p class="text-2xl text-primary font-semibold">
                {{ formatRupiah(carrental.price) }}
              </p>

              <a href="#detailCarrental" class="btn w-fit">Lihat Detail</a>
            </div>
            <img
              :src="
                carrental?.banner
                  ? `/storage/${carrental.banner}`
                  : '/storage/images/logo-panoramaalam.png'
              "
              alt=""
              class="rounded-md w-full"
              width="500"
              height="500"
            />
            <div id="detailCarrental" class="scroll-mt-20">
              <div>
                <h2 class="text-lg font-semibold">
                  {{ $t("buttons.btn_carrental_terms") }}
                </h2>
                <p v-html="carrental.policy" class="text-content"></p>
              </div>
              <div>
                <h2 class="text-lg font-semibold">
                  {{ $t("buttons.btn_carrental_info") }}
                </h2>
                <p v-html="carrental.information" class="text-content"></p>
              </div>
              <a href="#" class="btn w-fit mt-6 !py-4 !px-6 !rounded-full">
                <i class="fa-brands fa-whatsapp text-xl mr-2"></i>
                {{ $t("buttons.btn_order_now") }}</a
              >
            </div>
          </article>
          <div class="md:w-1/3 sticky top-20 space-y-6">
            <AsideOtherCarrental :otherCarrentals="otherCarrentals" />
            <AsideLatestBlog :latestBlogs="latestBlogs" />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>