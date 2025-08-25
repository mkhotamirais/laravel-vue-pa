<script setup>
import SessMsg from "@/Components/form/SessMsg.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { smartTrim } from "@/functions";

defineProps({ blogs: Object, blogcats: Object, msg: String });

const deleteBlog = (b) => {
  if (confirm("Apakah anda yakin?")) {
    router.delete(route("blog.destroy", b));
  }
};
</script>

<template>
  <div>
    <Head>
      <title>{{ $t("blog.title") }}</title>
      <meta head-key="description" name="description" />
    </Head>
    <Link :href="route('blog.create')" class="btn w-fit mb-2">Create Blog</Link>
    <SessMsg :msg="msg" />
    <div class="flex flex-col md:flex-row gap-4 items-start">
      <div v-if="blogs.data.length" class="w-full">
        <div
          v-for="(blog, i) in blogs.data"
          :key="i"
          class="border border-gray-300 mb-1 rounded p-1 flex"
        >
          <Link
            :href="route('public.blog.show', blog)"
            class="w-4/5 flex items-center gap-2"
          >
            <img
              :src="
                blog?.banner
                  ? `/storage/${blog.banner}`
                  : '/storage/images/logo-panoramaalam.png'
              "
              :alt="blog.banner"
              width="100"
              height="100"
              class="size-16 object-center object-contain bg-gray-100 border border-gray-200"
            />
            <h3
              class="first-letter:capitalize sm:text-lg font-medium hover:underline"
            >
              {{ smartTrim(blog.title, 60) }}
            </h3>
          </Link>
          <div class="w-1/5 flex flex-col items-center">
            <Link
              :href="route('blog.edit', blog)"
              class="link text-primary py-1"
              >ubah</Link
            >
            <button
              type="button"
              @click="deleteBlog(blog)"
              class="link text-danger py-1"
            >
              hapus
            </button>
          </div>
        </div>
      </div>
      <div v-else class="w-full bg-white py-4 rounded-lg">
        <p>Data tidak ditemukan</p>
      </div>
    </div>
  </div>
</template>