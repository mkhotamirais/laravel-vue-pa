<script setup>
import { smartTrim } from "@/functions";
import { computed } from "vue";

defineProps({
  blogs: Object,
  totalBlogs: Number,
  carrentals: Object,
  totalCarrentals: Number,
});
</script>

<template>
  <div>
    <div class="mb-4">
      <p class="">Hi, {{ $page.props.auth.user.name }}</p>
    </div>
    <!-- Blog -->
    <div class="mb-4">
      <div class="mb-2">
        <h2 class="h2">Blog ({{ totalBlogs }})</h2>
        <Link :href="route('blog.index')" class="link">Manage Blog</Link>
      </div>
      <Link
        v-for="(blog, i) in blogs"
        :key="i"
        :href="route('public.blog.show', blog)"
        class="inline-flex items-center w-full p-1 border rounded mb-1 hover:underline"
      >
        <img
          :src="
            blog?.banner
              ? `/storage/${blog.banner}`
              : '/storage/images/logo-panoramaalam.png'
          "
          width="50"
          height="50"
          :alt="blog.title"
          class="size-10 object-cover object-center mr-2"
        />
        <h3 class="">{{ smartTrim(blog.title, 50) }}</h3>
      </Link>
    </div>
    <!-- Car Rental -->
    <div>
      <div class="mb-2">
        <h2 class="h2">Car Rental ({{ totalCarrentals }})</h2>
        <Link :href="route('rental-mobil.index')" class="link"
          >Manage Car Rental</Link
        >
      </div>
      <Link
        v-for="(carrental, i) in carrentals"
        :key="i"
        :href="route('public.carrental.show', carrental)"
        class="inline-flex items-center w-full p-1 border rounded mb-1 hover:underline"
      >
        <img
          :src="
            carrental?.banner
              ? `/storage/${carrental.banner}`
              : '/storage/images/logo-panoramaalam.png'
          "
          width="50"
          height="50"
          :alt="carrental.name"
          class="size-10 object-cover object-center mr-2"
        />
        <h3 class="">{{ smartTrim(carrental.name, 50) }}</h3>
      </Link>
    </div>
  </div>
</template>