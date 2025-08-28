<script setup>
import SearchCard from "./SearchCard.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { computed, nextTick, ref } from "vue";

const page = usePage();
const searchResults = computed(() => page.props.searchResults);

const isOpen = ref(false);
const inputRef = ref(null);
const searchKey = ref(null);

const form = useForm({ q: searchKey ?? "" });
const open = () => {
  isOpen.value = true;
  nextTick(() => {
    setTimeout(() => {
      inputRef.value?.focus();
    }, 150);
  });
};
const close = () => {
  isOpen.value = false;
  searchKey.value = null;
};

const submit = () => {
  const slug = form.q?.trim().replace(/\s+/g, "-").toLowerCase();
  router.get(page.url, {
    q: slug,
  });
  searchKey.value = form.q;
  // close();
};
</script>

<template>
  <div class="relative h-16 flex items-center">
    <button
      @click="open"
      type="button"
      class="px-3 py-2 hover:bg-primary/10 rounded-lg text-gray-600"
      aria-label="Global Search"
    >
      <i class="fa-solid fa-magnifying-glass text-sm"></i>
    </button>
    <div
      @click="close"
      class="fixed inset-0 bg-black/80 z-50 transition-all flex items-center justify-center"
      :class="isOpen ? 'visible opacity-100' : 'invisible opacity-0'"
    >
      <div
        @click="(e) => e.stopPropagation()"
        class="mx-3 text-white max-w-lg w-full"
      >
        <form
          @submit.prevent="submit"
          class="flex border border-gray-500 w-full rounded mb-2 sticky top-0"
        >
          <input
            ref="inputRef"
            v-model="form.q"
            type="search"
            class="py-3 px-5 focus:outline-none w-full"
            placeholder="Search.."
          />
          <button type="submit" class="px-3 text-md">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </form>
        <div
          v-if="searchKey"
          class="p-3 h-100 overflow-y-scroll border border-gray-500 rounded transition-all"
        >
          <p>
            Results for
            <span class="italic">"{{ searchKey }}"</span>
          </p>
          <div
            v-if="
              (searchResults && searchResults?.carrentalResults?.length) ||
              (searchResults && searchResults?.blogResults?.length) ||
              (searchResults && searchResults?.tourpackageResults?.length)
            "
          >
            <div
              v-if="searchResults && searchResults?.carrentalResults?.length"
              class="mt-2"
            >
              <SearchCard
                :results="searchResults?.carrentalResults"
                title="Car Rentalss"
                @close="close"
              />
            </div>
            <div
              v-if="searchResults && searchResults?.tourpackageResults?.length"
              class="mt-2"
            >
              <SearchCard
                :results="searchResults?.tourpackageResults"
                title="Tour Packages"
                @close="close"
              />
            </div>
            <div
              v-if="searchResults && searchResults?.blogResults?.length"
              class="mt-2"
            >
              <SearchCard
                :results="searchResults?.blogResults"
                title="Blogs"
                @close="close"
              />
            </div>
          </div>
          <div v-else>
            <p v-if="form.processing">Searching..</p>
            <p v-else>No results</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>