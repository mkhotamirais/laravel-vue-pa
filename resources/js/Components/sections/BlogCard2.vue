<script setup>
defineProps({ blog: Object });

import { diffForHumans, smartTrim } from "@/functions";
import BlogExcerpt from "./BlogExcerpt.vue";
</script>

<template>
  <div class="flex h-52 mb-4 gap-4">
    <Link :href="route('public.blog.show', blog)" class="w-1/3">
      <img
        :src="
          blog?.banner
            ? `/storage/${blog.banner}`
            : '/storage/images/logo-panoramaalam.png'
        "
        :alt="blog.title"
        width="200"
        height="200"
        loading="lazy"
        class="w-full h-full rounded-l object-cover object-center"
      />
    </Link>
    <div class="w-2/3 flex flex-col space-y-2">
      <Link :href="route('public.blog.show', blog)" class="hover:underline">
        <h3 class="h3">{{ smartTrim(blog.title, 60) }}</h3>
      </Link>
      <BlogExcerpt :blog="blog" />
      <p v-html="smartTrim(blog.content, 160)" class="text-content"></p>
    </div>
  </div>
</template>