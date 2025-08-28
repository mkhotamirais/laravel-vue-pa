<script setup>
import { formatRupiah } from "@/functions";
import { router } from "@inertiajs/vue3";

defineProps({ carrental: Object });

const chooseCategory = (cat) => {
  router.get(route("public.carrental", { rentalcat: cat }));
};
</script>

<template>
  <div class="shadow-md rounded overflow-hidden bg-white">
    <Link :href="route('public.carrental.show', carrental)">
      <img
        :src="
          carrental?.banner
            ? `/storage/${carrental.banner}`
            : '/storage/svg/panorama_icon.svg'
        "
        :alt="carrental.name"
        width="400"
        height="400"
        loading="lazy"
        class="w-full object-cover object-center"
      />
    </Link>
    <div class="space-y-3 p-4">
      <div>
        <Link
          :href="route('public.carrental.show', carrental)"
          class="hover:underline block mb-1"
        >
          <h3 class="text-lg font-medium capitalize">{{ carrental.name }}</h3>
        </Link>
        <button
          @click="chooseCategory(carrental.category)"
          class="badge capitalize w-fit"
        >
          {{ carrental.category.replace("_", " ") }}
        </button>
      </div>

      <p class="text-2xl font-semibold">
        {{ formatRupiah(carrental.price) }}
      </p>

      <a
        :href="$t('links.wa.url')"
        class="w-full py-2 bg-primary hover:bg-primary-hover transition-all text-white rounded-full inline-flex items-center justify-center gap-2"
      >
        <i class="fa-brands fa-whatsapp"></i>
        {{ $t("buttons.btn_order_now") }}
      </a>
    </div>
  </div>
</template>