<script setup>
import { ref } from "vue";

const emit = defineEmits(["image"]);

const props = defineProps({ oldBanner: String, error: String });
const currentImage = props.oldBanner
  ? `/storage/${props.oldBanner}`
  : `/storage/images/logo-panoramaalam.png`;

const preview = ref(currentImage);
const oversizedImage = ref(false);
const showRevertBtn = ref(false);

const imageSelected = (e) => {
  preview.value = URL.createObjectURL(e.target.files[0]);
  oversizedImage.value = e.target.files[0].size > 2048000;
  showRevertBtn.value = true;
  emit("image", e.target.files[0]);
};

const revertImageChange = () => {
  showRevertBtn.value = false;
  preview.value = currentImage;
  oversizedImage.value = false;
};
</script>

<template>
  <div class="mb-3">
    <span
      class="block text-sm font-medium text-slate-700 dark:text-slate-300"
      :class="{ '!text-red-500': oversizedImage }"
    >
      {{
        oversizedImage
          ? "The selected image exceeds 2MB"
          : "Banner (Max size 2Mb)"
      }}
    </span>
    <label
      for="image"
      class="block rounded-md mt-1 bg-gray-100 h-56 overflow-hidden cursor-pointer border-gray-200 border relative"
      :class="{ '!border-red-500': oversizedImage || error }"
    >
      <img
        :src="preview ?? '/storage/images/logos/logo-panoramaalam.png'"
        class="object-center object-contain h-full w-full"
        alt=""
      />
      <button
        @click.prevent="revertImageChange"
        v-if="showRevertBtn"
        type="button"
        class="absolute top-2 right-2 bg-white/75 w-8 h-8 rounded-full grid place-items-center text-slate-700"
      >
        <i class="fa-solid fa-rotate-left"></i>
      </button>
    </label>
    <input
      @input="imageSelected"
      type="file"
      name="image"
      id="image"
      class="hidden"
    />
    <small class="text-sm text-red-500">{{ error ? error : "" }}</small>
  </div>
</template>