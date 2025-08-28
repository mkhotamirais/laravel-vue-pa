<script setup>
import { ref, watch } from "vue";

const emit = defineEmits(["images"]);
defineProps({
  label: { type: String, default: "Images (multiple allowed)" },
  icon: { type: String, default: "images" },
  error: Array,
});

const imageFiles = ref([]);
const previewImages = ref([]);
const imageInputRef = ref(null);

const handleFileChange = (e) => {
  const files = Array.from(e.target.files);
  imageFiles.value = files;
};

watch(imageFiles, (newFiles) => {
  previewImages.value = [];
  if (!newFiles.length) return;

  newFiles.forEach((file) => {
    const reader = new FileReader();
    reader.onload = (e) => {
      previewImages.value.push(e.target.result);
    };
    reader.readAsDataURL(file);
  });

  emit("images", newFiles);
});

const removeImage = (index) => {
  const updatedFiles = [...imageFiles.value];
  updatedFiles.splice(index, 1);
  imageFiles.value = updatedFiles;

  // Reset input file (untuk hapus caption "x files")
  if (imageInputRef.value) {
    imageInputRef.value.value = "";
  }

  if (updatedFiles.length > 0) {
    const dt = new DataTransfer();
    updatedFiles.forEach((file) => dt.items.add(file));
    imageInputRef.value.files = dt.files;
  }

  emit("images", updatedFiles);
};
</script>

<template>
  <div class="mb-3 w-full">
    <label :for="label" class="block text-sm font-medium text-slate-700">
      {{ label }}
    </label>
    <div class="relative mt-1 rounded-md">
      <div
        class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3"
      >
        <span class="grid place-content-center text-sm text-slate-400">
          <i :class="`fa-solid fa-${icon}`"></i>
        </span>
      </div>
      <input
        ref="imageInputRef"
        id="images"
        type="file"
        multiple
        accept="image/*"
        :class="[
          'border w-full rounded-md py-2 pr-3 pl-9 text-sm border-slate-300 outline-0 focus:ring-1 focus:ring-inset focus:ring-primary focus:border-primary plaholder:text-slate-400',
          error.length
            ? 'border-red-500 ring-1 ring-red-500'
            : 'border-gray-300 ring-transparent',
        ]"
        @change="handleFileChange"
      />
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
        <div
          v-for="(src, index) in previewImages"
          :key="index"
          class="relative group"
        >
          <img
            :src="src"
            class="w-full h-32 object-cover object-center rounded-lg"
          />
          <button
            @click.prevent="removeImage(index)"
            class="absolute top-1 right-1 bg-white/80 hover:bg-red-500 hover:text-white text-sm rounded-full p-1 px-2"
          >
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
      </div>
    </div>
    <div v-if="error.length">
      <small
        v-for="(e, l) in error"
        :key="l"
        class="text-sm block text-red-500"
        >{{ e }}</small
      >
    </div>
  </div>
</template>
