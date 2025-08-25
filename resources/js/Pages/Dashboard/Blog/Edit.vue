<script setup>
import Input from "@/Components/form/Input.vue";
import TextareaCke from "@/Components/form/TextareaCke.vue";
import Select from "@/Components/form/Select.vue";
import ImageUpload from "@/Components/form/ImageUpload.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({ blog: Object, blogcats: Object });

const form = useForm({
  title: props.blog.title,
  blogcat_id: props.blog.blogcat_id,
  content: props.blog.content,
  tags: props.blog.tags,
  banner: null,
  _method: "PATCH",
});

const page = usePage();
const user = computed(() => page.props.auth.user);

const banner = (e) => (form.banner = e);

const submit = () => {
  form.post(route("blog.update", props.blog));
};
</script>

<template>
  <div>
    <Head title="Update Blog" />
    <form @submit.prevent="submit" class="py-4 max-w-lg">
      <ImageUpload @image="(e) => banner(e)" :oldBanner="blog.banner" />
      <Input
        label="Title"
        id="title"
        icon="heading"
        placeholder="Judul.."
        v-model="form.title"
        :error="form.errors.title"
      />
      <Select
        label="Information Category"
        id="information-category"
        icon="sitemap"
        v-model="form.blogcat_id"
        :error="form.errors.blogcat_id"
      >
        <option :value="null">Pilih Kategori</option>
        <option v-for="(bc, i) in blogcats" :key="i" :value="bc.id">
          {{ bc.name }}
        </option>
      </Select>
      <TextareaCke
        label="Content"
        id="info_content"
        v-model="form.content"
        :error="form.errors.content"
      />
      <Input
        label="Tags (pisah dengan koma)"
        id="tags"
        icon="tags"
        placeholder="tag1, tag2, tag3"
        v-model="form.tags"
        :error="form.errors.tags"
      />
      <div class="flex gap-2">
        <button type="submit" class="btn" :disabled="form.processing">
          Simpan
        </button>
        <Link
          :href="route('blog.index')"
          class="btn inline-block !bg-gray-500 hover:!bg-gray-600"
          >Kembali</Link
        >
      </div>
    </form>
  </div>
</template>