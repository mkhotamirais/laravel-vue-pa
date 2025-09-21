<script setup>
import Input from "@/Components/form/Input.vue";
import Textarea from "@/Components/form/Textarea.vue";
import TextareaCke from "@/Components/form/TextareaCke.vue";
import Select from "@/Components/form/Select.vue";
import ImageUpload from "@/Components/form/ImageUpload.vue";
import ImagesUpload from "@/Components/form/ImagesUpload.vue";
import { useForm } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
  tourpackage: Object,
  tourpackagecats: Object,
  tourroutes: Object,
});

const form = useForm({
  banner: null,
  name: props.tourpackage.name,
  price: props.tourpackage.price,
  price_detail: props.tourpackage.price_detail,
  status: props.tourpackage.status,
  itenary_description: props.tourpackage.itenary_description,
  itenary_detail: props.tourpackage.itenary_detail,
  policy_description: props.tourpackage.policy_description,
  policy_detail: props.tourpackage.policy_detail,
  info_description: props.tourpackage.info_description,
  info_detail: props.tourpackage.info_detail,
  tourpackagecat_id: props.tourpackage.tourpackagecat_id,
  tourroutes: props.tourpackage.tourroutes.map((tr) => tr.id),
  images: [],
  delete_images: [],
  meta_title: props.tourpackage.meta_title,
  meta_description: props.tourpackage.meta_description,
  meta_keywords: props.tourpackage.meta_keywords,
  _method: "PATCH",
});

const banner = (e) => (form.banner = e);
const images = (e) => (form.images = e);

const imagesErrors = computed(() => {
  return Object.entries(form.errors)
    .filter(([key]) => key.startsWith("images."))
    .map(([, message]) => message);
});

const submit = () => {
  form.post(route("paket-wisata.update", props.tourpackage), {
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <div>
    <Head title="Edit Tour Package" />
    <form @submit.prevent="submit" class="py-4">
      <ImageUpload
        @image="(e) => banner(e)"
        :oldBanner="tourpackage.banner"
        :error="form.errors.banner"
      />
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
              :checked="tourpackage.tourroutes.includes(tr.id)"
            />
            <span>{{ tr.name }}</span>
          </label>
        </div>
        <p v-if="form.errors.tourroutes" class="!text-danger">
          <small>{{ form.errors.tourroutes }}</small>
        </p>
      </div>

      <!-- current images -->
      <div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
          <div
            v-for="(ti, i) in tourpackage.tourimages"
            :key="i"
            class="relative group"
          >
            <label>
              <img
                :src="`/storage/${ti.image_path}`"
                class="w-full h-32 object-cover object-center rounded-lg"
              />
              <input
                type="checkbox"
                v-model="form.delete_images"
                :value="ti.id"
              />
              Delete
            </label>
          </div>
        </div>
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
          Simpan
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