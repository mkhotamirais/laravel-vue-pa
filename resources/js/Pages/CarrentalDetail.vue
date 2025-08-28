<script setup>
import { formatRupiah, smartTrim, diffForHumans } from "@/functions";
import { capitalize } from "vue";
import AsideLatestBlog from "../Components/sections/AsideLatestBlog.vue";
import AsideOtherCarrental from "../Components/sections/AsideOtherCarrental.vue";
import { router } from "@inertiajs/vue3";
import AsideOtherTourpackage from "../Components/sections/AsideOtherTourpackage.vue";
import Payment from "../Components/sections/Payment.vue";

defineProps({
  carrental: Object,
  otherCarrentals: Object,
  latestBlogs: Object,
  otherTourpackages: Object,
});

const chooseCategory = (cat) => {
  router.get(route("public.carrental", { rentalcat: cat }));
};
</script>

<template>
  <div>
    <Head :title="`Sewa Mobil ${smartTrim(capitalize(carrental.name))}`" />
    <section class="py-8">
      <div class="container">
        <div class="flex flex-col md:flex-row gap-8 items-start">
          <article class="w-full md:w-2/3 space-y-4">
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
                  {{ $t("others.policy") }}
                </h2>
                <p v-html="carrental.policy" class="text-content"></p>
              </div>
              <div>
                <h2 class="text-lg font-semibold">
                  {{ $t("others.terms") }}
                </h2>
                <p v-html="carrental.information" class="text-content"></p>
              </div>
            </div>

            <Payment />
          </article>
          <div
            class="w-full md:w-1/3 sticky top-20 space-y-6 overflow-y-scroll h-[calc(100vh-6rem)]"
          >
            <AsideOtherCarrental :otherCarrentals="otherCarrentals" />
            <AsideOtherTourpackage :otherTourpackages="otherTourpackages" />
            <AsideLatestBlog :latestBlogs="latestBlogs" />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>