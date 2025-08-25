<script setup>
defineProps({
  top_title: String,
  title: String,
});
</script>

<template>
  <div class="space-y-2 mb-8">
    <p class="text-primary font-semibold">
      {{ $t(top_title) }}
    </p>
    <hr class="h-[2.8px] bg-primary text-primary w-12 rounded-full" />
    <h2 class="h2">{{ $t(title) }}</h2>
  </div>
</template>