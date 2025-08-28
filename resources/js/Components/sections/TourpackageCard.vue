<script setup>
import { formatRupiah } from "@/functions";
import { router } from "@inertiajs/vue3";

defineProps({ item: Object });

const chooseCategory = (cat) => {
  router.get(route("public.tourpackage", { tourpackagecat: cat }));
};
</script>

<template>
  <div class="shadow-md rounded overflow-hidden bg-white">
    <Link :href="route('public.tourpackage.show', item)">
      <img
        :src="
          item?.banner
            ? `/storage/${item.banner}`
            : '/storage/images/logo-panoramaalam.png'
        "
        :alt="item.name"
        loading="lazy"
        width="400"
        height="400"
        class="object-cover object-center w-full"
      />
    </Link>
    <div class="space-y-3 p-4">
      <div>
        <Link
          :href="route('public.tourpackage.show', item)"
          class="hover:underline block mb-1"
        >
          <h3 class="text-lg font-medium capitalize">{{ item.name }}</h3>
        </Link>
        <button
          @click="chooseCategory(item.tourpackagecat)"
          class="badge capitalize w-fit"
        >
          {{ item.tourpackagecat.name }}
        </button>
      </div>
      <div class="text-gray-500 text-sm">
        <span>{{ $t("others.start_from") }}</span>
        <div>
          <span class="text-2xl font-semibold pr-2 text-gray-700">
            {{ formatRupiah(item.price) }}
          </span>
          <span>/ {{ $t("others.person") }}</span>
        </div>
      </div>

      <a
        :href="$t('links.wa.url')"
        class="w-full py-2 bg-primary hover:bg-primary/90 transition-all text-white rounded-full inline-flex items-center justify-center gap-2"
      >
        <i class="fa-brands fa-whatsapp"></i>
        {{ $t("buttons.btn_order_now") }}
      </a>
    </div>
  </div>
</template>