<script setup>
import SessMsg from "@/Components/form/SessMsg.vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import { smartTrim } from "@/functions";
import PaginationInput from "@/Components/ui/PaginationInput.vue";

defineProps({ tourpackages: Object, msg: String });

const deleteTourpackage = (tour) => {
  if (confirm("Apakah anda yakin?")) {
    router.delete(route("paket-wisata.destroy", tour));
  }
};
</script>

<template>
  <div>
    <Head title="Tour Package List" />

    <Link :href="route('paket-wisata.create')" class="btn w-fit mb-2"
      >Create Tour Package</Link
    >
    <SessMsg :msg="msg" />
    <div class="flex flex-col md:flex-row gap-4 items-start">
      <div v-if="tourpackages.data.length" class="w-full">
        <div
          v-for="(tourpackage, i) in tourpackages.data"
          :key="i"
          class="border border-gray-300 mb-1 rounded p-1 flex"
        >
          <Link
            :href="route('public.tourpackage.show', tourpackage)"
            class="w-4/5 flex items-center gap-2"
          >
            <img
              :src="
                tourpackage?.banner
                  ? `/storage/${tourpackage.banner}`
                  : '/storage/images/logo-panoramaalam.png'
              "
              :alt="tourpackage.banner"
              width="100"
              height="100"
              class="size-16 object-center object-contain bg-gray-100 border border-gray-200"
            />
            <h3
              class="first-letter:capitalize sm:text-lg font-medium hover:underline"
            >
              {{ smartTrim(tourpackage.name, 60) }}
            </h3>
          </Link>
          <div class="w-1/5 flex flex-col items-center">
            <Link
              :href="route('paket-wisata.edit', tourpackage)"
              class="link text-primary py-1"
              >ubah</Link
            >
            <button
              type="button"
              @click="deleteTourpackage(tourpackage)"
              class="link text-danger py-1"
            >
              hapus
            </button>
          </div>
        </div>
        <div>
          <PaginationInput :paginator="tourpackages" />
        </div>
      </div>
      <div v-else class="w-full bg-white py-4 rounded-lg">
        <p>Data tidak ditemukan</p>
      </div>
    </div>
  </div>
</template>