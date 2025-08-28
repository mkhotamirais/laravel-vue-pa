<script setup>
import { smartTrim } from "@/functions";
defineProps({
  title: String,
  results: Object,
});

const emit = defineEmits(["close"]);

function close() {
  emit("close");
}
</script>

<template>
  <div>
    <p>Results From {{ title }}</p>
    <Link
      v-for="(r, i) in results"
      :key="i"
      @click="close"
      :href="
        route(
          title === 'Car Rentals'
            ? 'public.carrental.show'
            : title === 'Tour Packages'
            ? 'public.tourpackage.show'
            : 'public.blog.show',
          r
        )
      "
      class="flex items-center border border-primary/50 gap-2 mb-1 hover:bg-primary/10 transition-all rounded-lg overflow-hidden"
    >
      <img
        :src="`/storage/${r.banner}`"
        alt=""
        width="50"
        height="50"
        class="size-[50px] object-cover object-center"
      />
      <p class="text-sm">
        {{ smartTrim(title === "Blogs" ? r.title : r.name, 40) }}
      </p>
    </Link>
  </div>
</template>