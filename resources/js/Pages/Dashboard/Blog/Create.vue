<script setup>
import Input from "@/Components/form/Input.vue";
import Textarea from "@/Components/form/Textarea.vue";
import TextareaCke from "@/Components/form/TextareaCke.vue";
import Select from "@/Components/form/Select.vue";
import ImageUpload from "@/Components/form/ImageUpload.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";

defineProps({ blogcats: Object });

const form = useForm({
  title: null,
  blogcat_id: null,
  content: "",
  tags: null,
  banner: null,
  meta_title: null,
  meta_description: null,
  meta_keywords: null,
});

const page = usePage();
const user = computed(() => page.props.auth.user);

const banner = (e) => (form.banner = e);

const submit = () => {
  form.post(route("blog.store"), {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <div>
    <Head title="Create Blog" />
    <form @submit.prevent="submit" class="py-4">
      <ImageUpload @image="(e) => banner(e)" :error="form.errors.banner" />
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
        <option
          v-for="(bc, i) in blogcats"
          :key="i"
          :value="bc.id"
          class="capitalize"
        >
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
      <div class="mt-4">
        <p>
          <b>
            Field Metadata opsional, jika tidak diisi maka akan diisi dengan
            isian default
          </b>
        </p>
        <Input
          label="Meta Title"
          id="meta_title"
          icon="heading"
          maxlength="60"
          placeholder="Meta Title.."
          v-model="form.meta_title"
          :error="form.errors.meta_title"
        />
        <Textarea
          label="Meta Description"
          id="meta_description"
          icon="paragraph"
          maxlength="160"
          placeholder="Meta Description.."
          v-model="form.meta_description"
          :error="form.errors.meta_description"
        />
        <Input
          label="Meta Keywords"
          id="meta_keywords"
          icon="tags"
          placeholder="Keyword 1, Keyword 2, Keyword 3, ..."
          v-model="form.meta_keywords"
          :error="form.errors.meta_keywords"
        />
      </div>
      <div class="flex gap-2">
        <button type="submit" class="btn" :disabled="form.processing">
          Tambah
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