<script setup>
import { formatRupiah, smartTrim } from "@/functions";
defineProps({ otherCarrentals: Object });
</script>

<template>
  <div>
    <h2 class="h2 mb-4">{{ $t("buttons.btn_other_carrentals") }}</h2>
    <Link
      v-for="(or, i) in otherCarrentals"
      :key="i"
      :href="route('public.carrental.show', or)"
      class="group flex gap-2 overflow-hidden mb-2 h-20"
    >
      <img
        :src="
          or?.banner
            ? `/storage/${or.banner}`
            : `/storage/images/logo-rentallombok.png`
        "
        :alt="smartTrim(or.name, 60)"
        width="100"
        height="100"
        class="h-full w-1/3 object-cover object-center"
      />
      <div class="col-span-1 md:col-span-2 space-y-2 md:space-y-1">
        <h3 class="group-hover:underline text-base font-medium capitalize">
          {{ or.name }}
        </h3>
        <p class="badge">{{ or.category.replace("_", " ") }}</p>
        <p class="text-lg font-medium">
          {{ formatRupiah(or.price) }}
        </p>
      </div>
    </Link>
  </div>
</template>