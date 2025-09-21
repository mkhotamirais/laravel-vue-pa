<script setup>
import { stripHtml, smartTrim, diffForHumans } from "@/functions";
import { capitalize } from "vue";
import BlogExcerpt from "@/Components/sections/BlogExcerpt.vue";
import AsideLatestBlog from "@/Components/sections/AsideLatestBlog.vue";
import AsideOtherCarrental from "@/Components/sections/AsideOtherCarrental.vue";
import AsideOtherTourpackage from "@/Components/sections/AsideOtherTourpackage.vue";

defineProps({
  blog: Object,
  latestBlogs: Object,
  otherCarrentals: Object,
  otherTourpackages: Object,
});
</script>

<template>
  <div>
    <Head>
      <title>
        {{ blog.meta_title || smartTrim(capitalize(blog.title), 60) }}
      </title>
      <meta
        head-key="description"
        name="description"
        :content="
          blog?.meta_description ||
          smartTrim(stripHtml(blog.content), 150) ||
          $t('home.description')
        "
      />
      <meta
        head-key="keywords"
        name="keywords"
        :content="blog?.meta_keywords || blog?.tags || $t('home.meta_keywords')"
      />
    </Head>

    <section class="py-8">
      <div class="container">
        <div class="flex flex-col md:flex-row gap-8 items-start">
          <article class="w-full md:w-2/3 space-y-4">
            <h1 class="h1 sm:text-center">{{ blog.title }}</h1>
            <BlogExcerpt :blog="blog" class="sm:justify-center" />
            <img
              :src="
                blog?.banner
                  ? `/storage/${blog.banner}`
                  : '/storage/images/logo-panoramaalam.png'
              "
              alt=""
              width="500"
              height="500"
              class="rounded w-full h-120 object-cover object-center"
            />
            <p v-html="blog.content" class="text-content"></p>
            <span
              v-for="(tag, i) in blog.tags.split(',')"
              :key="i"
              class="mr-2"
            >
              #{{ tag }}
            </span>
          </article>
          <div
            class="w-full md:w-1/3 sticky top-20 space-y-6 overflow-y-scroll h-[calc(100vh-6rem)]"
          >
            <AsideLatestBlog :latestBlogs="latestBlogs" />
            <AsideOtherCarrental :otherCarrentals="otherCarrentals" />
            <AsideOtherTourpackage :otherTourpackages="otherTourpackages" />
          </div>
        </div>
      </div>
    </section>
  </div>
</template>