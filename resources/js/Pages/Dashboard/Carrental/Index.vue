<script setup>
import SessMsg from "@/Components/form/SessMsg.vue";
// import PaginationInput from "@/Components/ui/PaginationInput.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { smartTrim, formatRupiah } from "@/functions";

defineProps({ carrentals: Object, msg: String });

const page = usePage();

const deleteCarrental = (id) => {
  if (confirm("Apakah anda yakin?")) {
    router.delete(route("rental-mobil.destroy", id));
  }
};

const chooseCategory = (cat) => {
  router.get(route("rental-mobil.index", { rentalcat: cat }));
};
</script>

<template>
  <div>
    <Head>
      <title>{{ $t("carrental.title") }}</title>
      <meta head-key="description" name="description" />
    </Head>

    <Link :href="route('rental-mobil.create')" class="btn w-fit"
      >Create Car Rental</Link
    >

    <SessMsg :msg="msg" />
    <div class="py-2 flex flex-col md:flex-row gap-4 items-start">
      <div v-if="carrentals.data.length" class="w-full">
        <div
          v-for="(carrental, i) in carrentals.data"
          :key="i"
          class="border border-gray-300 mb-1 rounded p-1 flex"
        >
          <Link
            :href="route('public.carrental.show', carrental)"
            class="w-4/5 flex items-center gap-2"
          >
            <img
              :src="
                carrental?.banner
                  ? `/storage/${carrental.banner}`
                  : '/storage/images/logo-panoramaalam.png'
              "
              :alt="carrental.banner"
              width="100"
              height="100"
              class="size-16 object-center object-contain bg-gray-100 border border-gray-200"
            />
            <div>
              <h3
                class="first-letter:capitalize sm:text-lg font-medium hover:underline"
              >
                {{ carrental.name }}
              </h3>

              <p>{{ formatRupiah(carrental.price) }}</p>
            </div>
          </Link>
          <div class="w-1/5 flex flex-col items-center">
            <Link
              :href="route('rental-mobil.edit', carrental)"
              class="link text-primary py-1"
              >ubah</Link
            >
            <button
              type="button"
              @click="deleteCarrental(carrental)"
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