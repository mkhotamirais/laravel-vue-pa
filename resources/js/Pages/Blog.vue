<script setup>
import Hero from "@/Components/sections/Hero.vue";
import BlogCard2 from "@/Components/sections/BlogCard2.vue";
import BlogCard1 from "@/Components/sections/BlogCard1.vue";

defineProps({ blogs: Object, blogcats: Object });
</script>

<template>
  <div>
    <Hero
      :top_title="'blog.top_title'"
      :title="'blog.title'"
      :description="'blog.description'"
    />
    <section class="py-16">
      <div class="container flex flex-col md:flex-row gap-8 items-start">
        <div class="md:w-2/3">
          <div v-for="(blog, i) in blogs.data" :key="i" class="hidden sm:flex">
            <BlogCard2 :blog="blog" />
          </div>
          <div
            v-for="(blog, i) in blogs.data"
            :key="i"
            class="w-full flex sm:hidden"
          >
            <BlogCard1 :blog="blog" />
          </div>
        </div>
        <div class="md:w-1/3 sticky top-20">
          <h2 class="h2">Blog Category</h2>
          <ul class="ml-4 mt-4">
            <li
              v-for="(bc, i) in blogcats"
              :key="i"
              class="list-inside list-disc"
            >
              <Link
                :href="route('public.blog.category', bc)"
                class="py-1 hover:underline inline-block"
              >
                {{ bc.name }}
              </Link>
            </li>
          </ul>
        </div>
      </div>
    </section>
  </div>
</template>