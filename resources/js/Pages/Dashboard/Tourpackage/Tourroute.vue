<script setup>
import Input from "@/Components/form/Input.vue";
import SessMsg from "@/Components/form/SessMsg.vue";
import { router, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({ tourroutes: Object, msg: String });

const form = useForm({ name: "" });
const editForm = useForm({ name: "" });

const isEdit = ref(null);

const setIsEdit = (i, ic) => {
  isEdit.value = i;
  editForm.name = ic.name;
};

const cancelIsEdit = () => {
  isEdit.value = null;
  editForm.reset();
};

const submit = () => {
  form.post(route("tourroute.store"), {
    onSuccess: () => form.reset(),
    preserveScroll: true,
  });
};

const submitEdit = (ic) => {
  editForm.put(route("tourroute.update", ic), {
    onSuccess: () => {
      editForm.reset();
      cancelIsEdit();
    },
    preserveScroll: true,
  });
};

const deleteInfocat = (ic) => {
  if (confirm("Apakah kamu yakin?")) {
    router.delete(route("tourroute.destroy", ic));
  }
};
</script>

<template>
  <div>
    <Head title="Tour Package Route" />

    <SessMsg :msg="msg" />

    <!--  Add and Filters -->
    <div class="max-w-lg">
      <form @submit.prevent="submit" class="gap-2">
        <Input
          label="Tambah Category"
          icon="sitemap"
          placeholder="Name"
          v-model="form.name"
          :error="form.errors.name"
        />
        <button type="submit" class="btn mb-3" :disabled="form.processing">
          Tambah
        </button>
      </form>
    </div>

    <div v-if="tourroutes.length">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <div v-for="(ic, i) in tourroutes" :key="i" class="shadow-md p-3">
          <form @submit.prevent="submitEdit(ic)" v-if="isEdit === i" class="">
            <Input
              placeholder="Edit name"
              icon="sitemap"
              v-model="editForm.name"
              :error="editForm.errors.name"
            />
            <div class="flex gap-2 items-center">
              <button type="submit" class="btn" :disabled="editForm.processing">
                simpan
              </button>
              <button class="link" @click="cancelIsEdit">Batal</button>
            </div>
          </form>
          <div v-else>
            <p>
              {{ ic.name }}
            </p>
            <!-- <span class="text-sm text-gray-400">By {{ ic.user.name }}</span> -->
          </div>

          <div class="flex gap-3 mt-2">
            <div v-if="isEdit !== i" class="flex gap-3">
              <button class="link" @click="setIsEdit(i, ic)">Edit</button>
              <button class="link !text-red-500" @click="deleteInfocat(ic)">
                Hapus
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-else>
      <i>Tourpackage route tidak ditemukan</i>
    </div>
  </div>
</template>