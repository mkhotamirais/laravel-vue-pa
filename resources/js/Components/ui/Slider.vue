<script setup>
import "vue3-carousel/carousel.css";
import { Carousel, Slide, Navigation } from "vue3-carousel";
import { ref } from "vue";

// const images = Array.from({ length: 10 }, (_, index) => ({
//   id: index + 1,
//   url: `https://picsum.photos/seed/${Math.random()}/800/600`,
// }));

defineProps({
  images: {
    type: Array,
    required: true,
  },
});

const currentSlide = ref(0);

const slideTo = (nextSlide) => (currentSlide.value = nextSlide);

const galleryConfig = {
  itemsToShow: 1,
  wrapAround: true,
  slideEffect: "fade",
  mouseDrag: false,
  touchDrag: false,
  height: 320,
};

const thumbnailsConfig = {
  height: 80,
  wrapAround: false,
  touchDrag: false,
  gap: 10,
  loop: false,
  breakpoints: {
    0: {
      itemsToShow: 3,
    },
    768: {
      itemsToShow: 6,
    },
  },
};
</script>

<template>
  <div>
    <Carousel
      id="gallery"
      v-bind="galleryConfig"
      v-model="currentSlide"
      class="!h-88"
    >
      <Slide v-for="image in images" :key="image.id" class="">
        <a :href="image.url" class="block object-contain w-full h-full">
          <img
            :src="image.url"
            alt="Gallery Image"
            width="800"
            height="800"
            class="gallery-image bg-gray-100 !object-contain"
          />
        </a>
      </Slide>
    </Carousel>

    <Carousel id="thumbnails" v-bind="thumbnailsConfig" v-model="currentSlide">
      <Slide v-for="image in images" :key="image.id">
        <template #default="{ currentIndex, isActive }">
          <div
            :class="['thumbnail', { 'is-active': isActive }]"
            @click="slideTo(currentIndex)"
          >
            <img
              :src="image.url"
              alt="Thumbnail Image"
              class="thumbnail-image"
            />
          </div>
        </template>
      </Slide>

      <template #addons>
        <Navigation />
      </template>
    </Carousel>
  </div>
</template>

<style scoped>
.carousel {
  --vc-nav-background: rgba(255, 255, 255, 0.7);
  --vc-nav-border-radius: 100%;
}

img {
  border-radius: 8px;
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.gallery-image {
  border-radius: 16px;
}

#thumbnails {
  margin-top: 10px;
}

.thumbnail {
  height: 100%;
  width: 100%;
  cursor: pointer;
  opacity: 0.6;
  transition: opacity 0.3s ease-in-out;
}

.thumbnail.is-active,
.thumbnail:hover {
  opacity: 1;
}
</style>
