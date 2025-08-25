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
});

const submit = () => {
  form.post(route("rental-mobil.store"));
};
</script>

<template>
  <div>
    <Head title="Create Rental" />
    <form @submit.prevent="submit">
      <ImageUpload @image="(e) => image(e)" />
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
      <div class="flex items-center gap-1">
        <button type="submit" class="btn" :disabled="form.processing">
          Submit
        </button>
        <Link
          :href="route('rental-mobil.index')"
          type="button"
          class="btn !bg-gray-500"
          >Back</Link
        >
      </div>
    </form>
  </div>
</template>