<script setup>
defineProps({ blog: Object });

import { diffForHumans, smartTrim } from "@/functions";
import BlogExcerpt from "./BlogExcerpt.vue";
</script>

<template>
  <div
    :href="route('public.blog.show', blog)"
    class="group space-y-3 inline-block mb-2 w-full"
  >
    <Link :href="route('public.blog.show', blog)" class="w-full inline-block">
      <img
        :src="
          blog?.banner
            ? `/storage/${blog.banner}`
            : '/storage/images/logo-panoramaalam.png'
        "
        :alt="blog.title"
        width="400"
        height="400"
        loading="lazy"
        class="rounded-t w-full h-56 object-cover object-center mb-3"
      />
      <h3 class="h3 group-hover:underline">{{ smartTrim(blog.title, 50) }}</h3>
    </Link>
    <BlogExcerpt :blog="blog" />
  </div>
</template>