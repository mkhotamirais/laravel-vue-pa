<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from "vue";

const model = defineModel();
const props = defineProps({
  label: String,
  id: String,
  error: String,
});

const editorRef = ref(null);
// const editorInstance = ref(null);
let editorInstance = null;

onMounted(() => {
  if (window.ClassicEditor && editorRef.value) {
    ClassicEditor.create(editorRef.value, {
      toolbar: [
        "heading",
        "|",
        "bold",
        "italic",
        "link",
        "bulletedList",
        "numberedList",
        "blockQuote",
        "undo",
        "redo",
      ],
    })
      .then((editor) => {
        // editorInstance.value = editor;
        editorInstance = editor;
        editor.setData(model.value || "");

        editor.model.document.on("change:data", () => {
          model.value = editor.getData();
        });
      })
      .catch((error) => {
        console.error("CKEditor failed to initialize:", error);
      });
  }
});

onBeforeUnmount(() => {
  if (editorInstance) {
    editorInstance.destroy().catch((error) => {
      console.warn("CKEditor destroy failed:", error);
    });
    editorInstance = null;
  }
});
</script>

<template>
  <div class="mb-3">
    <label
      v-if="label"
      :for="id"
      class="block text-sm font-medium text-slate-700"
    >
      {{ label }}
    </label>
    <textarea
      :id="id"
      ref="editorRef"
      v-model="model"
      class="text-content"
    ></textarea>
    <small v-if="error" class="text-sm text-red-500">{{
      error ? error : ""
    }}</small>
  </div>
</template>
  