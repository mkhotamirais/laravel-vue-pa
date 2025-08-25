<script setup>
defineProps({ blog: Object });

import { diffForHumans } from "@/functions";
</script>

<template>
  <div class="text-sm text-gray-500 flex gap-2">
    <Link :href="route('public.blog.category', blog.blogcat)" class="link">
      {{ blog.blogcat?.name || "Rentallombok Blog" }}
    </Link>
    <span>|</span>
    <span>
      {{ diffForHumans(blog.created_at) }}
    </span>
  </div>
</template>