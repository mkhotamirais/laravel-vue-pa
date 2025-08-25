<script setup>
import { smartTrim, diffForHumans } from "@/functions";
defineProps({ latestBlogs: Object });
</script>

<template>
  <div>
    <h2 class="h2 mb-4">{{ $t("buttons.btn_latest_blogs") }}</h2>
    <div>
      <Link
        v-for="(b, i) in latestBlogs"
        :key="i"
        :href="route('public.blog.show', b)"
        class="group flex gap-2 overflow-hidden mb-2 h-20"
      >
        <img
          :src="
            b?.banner
              ? `/storage/${b.banner}`
              : `/storage/images/logo-rentallombok.png`
          "
          :alt="smartTrim(b.title, 60)"
          width="100"
          height="100"
          class="h-full w-1/3 object-cover object-center"
        />
        <div class="w-2/3 flex flex-col">
          <h3
            class="group-hover:underline text-sm font-medium first-letter:capitalize"
          >
            {{ smartTrim(b.title, 40) }}
          </h3>
          <p class="text-xs mt-auto">
            {{ diffForHumans(b.created_at) }}
          </p>
        </div>
      </Link>
    </div>
  </div>
</template>