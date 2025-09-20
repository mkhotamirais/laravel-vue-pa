<script setup>
import { formatRupiah, smartTrim } from "@/functions";
defineProps({ otherCarrentals: Object });
</script>

<template>
  <div>
    <h2 class="h2 text-2xl mb-4">{{ $t("others.other_carrentals") }}</h2>
    <Link
      v-for="(or, i) in otherCarrentals"
      :key="i"
      :href="route('public.carrental.show', or)"
      class="group flex gap-2 overflow-hidden mb-2 h-22"
    >
      <img
        :src="
          or?.banner
            ? `/storage/${or.banner}`
            : `/storage/images/logo-panoramaalam.png`
        "
        :alt="smartTrim(or.name, 60)"
        width="100"
        height="100"
        class="h-full w-1/3 object-cover object-center"
      />
      <div class="w-2/3 flex flex-col">
        <h3 class="group-hover:underline text-gray-600 font-medium capitalize">
          {{ or.name }}
        </h3>
        <p class="badge w-fit">
          {{ or.category.replace("_", " ") }}
        </p>
        <p class="text-lg font-medium">
          {{ formatRupiah(or.price) }}
        </p>
      </div>
    </Link>
  </div>
</template>