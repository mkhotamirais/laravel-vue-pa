<script setup>
defineProps({
  top_title: String,
  title: String,
  description: String,
});
</script>

<template>
  <section class="py-8 bg-gray-100">
    <div
      class="container max-w-5xl space-y-3 flex flex-col justify-center items-start sm:items-center sm:text-center"
    >
      <div class="flex flex-col items-start sm:items-center gap-1">
        <p class="text-primary font-semibold">{{ $t(top_title) }}</p>
        <hr class="h-[2.8px] w-8 rounded-full text-primary bg-primary" />
      </div>
      <h1 class="h1">{{ $t(title) }}</h1>
      <p>{{ $t(description) }}</p>
    </div>
  </section>
</template>