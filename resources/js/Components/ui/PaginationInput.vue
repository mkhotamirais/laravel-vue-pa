<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({ paginator: Object });

const currentPage = ref(props.paginator.current_page);
const totalPages = props.paginator.last_page;

const goToPage = () => {
  if (
    currentPage.value >= 1 &&
    currentPage.value <= totalPages &&
    currentPage.value !== props.paginator.current_page
  ) {
    router.get(
      props.paginator.path + "?page=" + currentPage.value,
      {}
      // { preserveScroll: true }
    );
  }
};

const goToPrev = () => {
  if (props.paginator.prev_page_url) {
    router.get(props.paginator.prev_page_url, {}, { preserveScroll: true });
  }
};

const goToNext = () => {
  if (props.paginator.next_page_url) {
    router.get(props.paginator.next_page_url, {}, { preserveScroll: true });
  }
};
</script>

<template>
  <div
    class="flex flex-col sm:flex-row gap-4 justify-between items-center w-full py-6"
  >
    <div class="flex items-center gap-1">
      <!-- Previous Button -->
      <button
        @click="goToPrev"
        :disabled="!paginator.prev_page_url"
        class="px-3 py-1 hover:bg-primary hover:text-white rounded-lg"
      >
        <i class="fa-solid fa-chevron-left"></i>
      </button>

      <!-- Page Input -->
      <div class="flex items-center gap-2">
        <input
          type="number"
          v-model.number="currentPage"
          @keyup.enter="goToPage"
          class="text-center border border-primary rounded p-1"
          min="1"
          :max="totalPages"
        />
        <span class="p-1">/ {{ totalPages }}</span>
      </div>

      <!-- Next Button -->
      <button
        @click="goToNext"
        :disabled="!paginator.next_page_url"
        class="px-3 py-1 hover:bg-primary hover:text-white rounded-lg"
      >
        <i class="fa-solid fa-chevron-right"></i>
      </button>
    </div>

    <p>
      Menampilkan {{ paginator.from }} sampai {{ paginator.to }} dari
      {{ paginator.total }}
    </p>
  </div>
</template>
  
<style scoped>
input[type="number"]::-webkit-inner-spin-button,
input[type="number"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
}
</style>