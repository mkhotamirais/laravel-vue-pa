<script setup>
import Input from "@/Components/form/Input.vue";
import TextareaCke from "@/Components/form/TextareaCke.vue";
import Select from "@/Components/form/Select.vue";
import ImageUpload from "@/Components/form/ImageUpload.vue";
import ImagesUpload from "@/Components/form/ImagesUpload.vue";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";

defineProps({ tourpackagecats: Object, tourroutes: Object });

const form = useForm({
  banner: null,
  name: "",
  price: null,
  price_detail: null,
  status: "active",
  itenary_description: "",
  itenary_detail: null,
  policy_description: "",
  policy_detail: null,
  info_description: "",
  info_detail: null,
  tourpackagecat_id: null,
  tourroutes: [],
  images: [],
  meta_title: null,
  meta_description: null,
  meta_keywords: null,
});

const banner = (e) => (form.banner = e);
const images = (e) => (form.images = e);

const imagesErrors = computed(() => {
  return Object.entries(form.errors)
    .filter(([key]) => key.startsWith("images."))
    .map(([, message]) => message);
});

const submit = () => {
  form.post(route("paket-wisata.store"), {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <div>
    <Head title="Create Tour Package" />
    <form @submit.prevent="submit" class="py-4">
      <ImageUpload @image="(e) => banner(e)" :error="form.errors.banner" />
      <Input
        label="Name"
        id="name"
        icon="heading"
        placeholder="Judul.."
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
        label="Price Detail"
        id="price_detail"
        v-model="form.price_detail"
        :error="form.errors.price_detail"
      />
      <!-- Itenary -->
      <Input
        label="Itenary Description"
        id="itenary_description"
        icon="paragraph"
        placeholder="Itenary description.."
        v-model="form.itenary_description"
        :error="form.errors.itenary_description"
      />
      <TextareaCke
        label="Itenary Detail"
        id="itenary_detail"
        v-model="form.itenary_detail"
        :error="form.errors.itenary_detail"
      />
      <!-- Policy -->
      <Input
        label="Policy Description"
        id="policy_description"
        icon="paragraph"
        placeholder="Policy description.."
        v-model="form.policy_description"
        :error="form.errors.policy_description"
      />
      <TextareaCke
        label="Policy Detail"
        id="policy_detail"
        v-model="form.policy_detail"
        :error="form.errors.policy_detail"
      />
      <!-- Info -->
      <Input
        label="Information Description"
        id="info_description"
        icon="paragraph"
        placeholder="Information description.."
        v-model="form.info_description"
        :error="form.errors.info_description"
      />
      <TextareaCke
        label="Information Detail"
        id="info_detail"
        v-model="form.info_detail"
        :error="form.errors.info_detail"
      />
      <Select
        label="Category"
        id="tourpackagecat_id"
        icon="sitemap"
        v-model="form.tourpackagecat_id"
        :error="form.errors.tourpackagecat_id"
      >
        <option :value="null">Pilih Kategori</option>
        <option
          v-for="(t, i) in tourpackagecats"
          :key="i"
          :value="t.id"
          class="capitalize"
        >
          {{ t.name }}
        </option>
      </Select>

      <div class="mb-3">
        <p>Tour Route</p>
        <div class="flex gap-2 flex-wrap">
          <label
            v-for="(tr, i) in tourroutes"
            :key="i"
            :for="tr.id"
            class="flex gap-2 items-center border border-gray-300 px-3 py-1 rounded"
          >
            <input
              type="checkbox"
              :id="tr.id"
              name="tourroutes"
              v-model="form.tourroutes"
              :value="tr.id"
            />
            <span>{{ tr.name }}</span>
          </label>
        </div>
        <p v-if="form.errors.tourroutes" class="!text-danger">
          <small>{{ form.errors.tourroutes }}</small>
        </p>
      </div>

      <ImagesUpload @images="(files) => images(files)" :error="imagesErrors" />

      <Select
        label="Status"
        id="status"
        icon="info-circle"
        v-model="form.status"
        :error="form.errors.status"
      >
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
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
          :href="route('paket-wisata.index')"
          class="btn inline-block !bg-gray-500 hover:!bg-gray-600"
          >Kembali</Link
        >
      </div>
    </form>
  </div>
</template>