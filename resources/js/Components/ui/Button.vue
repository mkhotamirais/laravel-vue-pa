<script setup>
import { computed } from "vue";

// Definisi props
const props = defineProps({
  as: {
    type: [String, Object],
    default: "button",
  },
  variant: {
    type: String,
    default: "primary",
    validator: (value) =>
      ["primary", "secondary", "outline", "gray", "danger"].includes(value),
  },
  icon: {},
  className: {
    type: String,
    default: "",
  },
});

// Hitung kelas CSS berdasarkan variant
const variantClasses = computed(() => {
  const classes = {
    primary: "bg-primary text-white hover:bg-primary/90",
    secondary: "bg-gray-500 text-white hover:bg-gray-600",
    outline: "ring-1 hover:ring-2 ring-inset ring-primary text-primary",
    gray: "bg-gray-100 ring-1 ring-inset ring-gray-200 text-gray-600 hover:bg-gray-200",
    danger: "bg-red-600 text-white hover:bg-red-700",
  };
  return classes[props.variant];
});

// Menangani klik pada tombol
const handleClick = (event) => {
  // Emit event click ke parent component
  // Ini memungkinkan Anda menggunakan @click di komponen Button
  emit("click", event);
};

const emit = defineEmits(["click"]);
</script>

<template>
  <component
    :is="props.as"
    class="inline-flex items-center justify-center rounded-full px-4 py-2 text-sm transition-colors disabled:opacity-50"
    :class="[variantClasses, props.className]"
    @click="handleClick"
  >
    <div v-if="props.icon" class="mr-2 pt-[1px]">
      <component :is="props.icon" />
    </div>
    <slot />
  </component>
</template>