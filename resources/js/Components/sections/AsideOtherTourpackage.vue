<script setup>
import { formatRupiah, smartTrim } from "@/functions";
defineProps({ otherTourpackages: Object });
</script>

<template>
  <div>
    <h2 class="h2 text-2xl mb-4">{{ $t("others.other_tourpackages") }}</h2>
    <Link
      v-for="(ot, i) in otherTourpackages"
      :key="i"
      :href="route('public.tourpackage.show', ot)"
      class="group flex gap-2 overflow-hidden mb-2 h-22"
    >
      <img
        :src="
          ot?.banner
            ? `/storage/${ot.banner}`
            : `/storage/images/logo-panoramaalam.png`
        "
        :alt="smartTrim(ot.name, 60)"
        width="100"
        height="100"
        class="h-full w-1/3 object-cover object-center"
      />
      <div class="w-2/3 flex flex-col">
        <h3 class="group-hover:underline text-gray-600 font-medium capitalize">
          {{ ot.name }}
        </h3>
        <p class="text-lg font-medium">
          {{ formatRupiah(ot.price) }}
        </p>
      </div>
    </Link>
  </div>
</template>