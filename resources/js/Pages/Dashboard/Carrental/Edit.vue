<script setup>
import Input from "@/Components/form/Input.vue";
import TextareaCke from "@/Components/form/TextareaCke.vue";
import ImageUpload from "@/Components/form/ImageUpload.vue";
import Select from "@/Components/form/Select.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  carrental: Object,
});

const image = (e) => (form.banner = e);

const form = useForm({
  name: props.carrental.name,
  price: props.carrental.price,
  policy: props.carrental.policy,
  information: props.carrental.information,
  banner: null,
  category: props.carrental.category,
  _method: "PATCH",
});
</script>

<template>
  <div>
    <Head title="Edit Car Rental" />
    <form @submit.prevent="form.post(route('rental-mobil.update', carrental))">
      <ImageUpload @image="(e) => image(e)" :oldBanner="carrental.banner" />
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
      <div class="flex gap-2">
        <button type="submit" class="btn" :disabled="form.processing">
          Simpan
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