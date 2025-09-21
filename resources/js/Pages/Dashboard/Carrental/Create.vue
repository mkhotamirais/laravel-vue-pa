<script setup>
import Input from "@/Components/form/Input.vue";
import TextareaCke from "@/Components/form/TextareaCke.vue";
import ImageUpload from "@/Components/form/ImageUpload.vue";
import Select from "@/Components/form/Select.vue";
import { useForm } from "@inertiajs/vue3";

const image = (e) => (form.banner = e);

const form = useForm({
  name: null,
  price: null,
  policy: null,
  information: null,
  banner: null,
  category: null,
  meta_title: null,
  meta_description: null,
  meta_keywords: null,
});

const submit = () => {
  form.post(route("rental-mobil.store"));
};
</script>

<template>
  <div>
    <Head title="Create Car Rental" />
    <form @submit.prevent="submit">
      <ImageUpload @image="(e) => image(e)" :error="form.errors.banner" />
      <Input
        label="Name"
        id="name"
        icon="heading"
        placeholder="Brand name"
        v-model="form.name"
        :error="form.errors.name"
      />
      <Input
        label="Price"
        type="number"
        id="price"
        icon="dollar-sign"
        placeholder="Price"
        v-model="form.price"
        :error="form.errors.price"
      />
      <TextareaCke
        label="Policy"
        id="policy"
        v-model="form.policy"
        :error="form.errors.policy"
      />
      <TextareaCke
        label="Information"
        id="information"
        v-model="form.information"
        :error="form.errors.information"
      />
      <Select
        label="Category"
        id="category"
        icon="tag"
        v-model="form.category"
        :error="form.errors.category"
      >
        <option :value="null">--Select Category</option>
        <option value="lepas_kunci">Lepas Kunci</option>
        <option value="include_driver">Include Driver</option>
      </Select>
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
          :href="route('rental-mobil.index')"
          class="btn inline-block !bg-gray-500 hover:!bg-gray-600"
          >Kembali</Link
        >
      </div>
    </form>
  </div>
</template>