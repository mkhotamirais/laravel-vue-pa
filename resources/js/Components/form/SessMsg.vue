<script setup>
defineProps({
  msg: String,
  isError: { type: Boolean, default: false },
});
</script>

<template>
  <div
    v-if="msg"
    class="mb-4 mt-1 font-medium text-sm py-2 px-3 rounded-lg border"
    :class="
      isError
        ? 'bg-danger/5 text-danger border-danger/50'
        : 'bg-primary/5 text-primary border-primary/50'
    "
  >
    {{ msg }}
  </div>
</template>