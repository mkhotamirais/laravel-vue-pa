<script setup>
import { ref, computed, watch, provide } from "vue";

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  bg: { type: String, default: "" },
  title: {},
  close: { type: Boolean, default: true },
  className: { type: String, default: "" },
  ariaLabel: { type: String, default: "menu" },
  side: {
    type: String,
    default: "right",
    validator: (value) => ["left", "right"].includes(value),
  },
  classSide: { type: String, default: "" },
});

const emit = defineEmits(["update:modelValue"]);

const open = computed({
  get: () => props.modelValue,
  set: (value) => emit("update:modelValue", value),
});

const closeSidebar = () => {
  open.value = false;
};

provide("closeSidebar", closeSidebar);

const sideClasses = computed(() => {
  const classes = {
    "right-0": props.side === "right",
    "left-0": props.side === "left",
    "translate-x-full": props.side === "right" && !open.value,
    "translate-x-0": open.value,
    "translate-x-[-100%]": props.side === "left" && !open.value,
  };
  return classes;
});
</script>

<template>
  <div :class="`relative ${props.className}`">
    <slot name="trigger" />

    <div
      :class="[
        'fixed inset-0 z-50 transition-all',
        open ? 'visible opacity-100' : 'invisible opacity-0',
        props.bg,
      ]"
      @click="closeSidebar"
    >
      <div
        @click.stop
        :class="[
          'absolute w-64 h-full bg-white border border-gray-200 rounded shadow-lg transition-transform',
          sideClasses,
          props.classSide,
        ]"
      >
        <div class="p-3">
          <div class="flex items-center justify-between">
            <slot name="title">
              <div v-if="props.title" v-html="props.title"></div>
            </slot>

            <button
              v-if="props.close"
              type="button"
              @click="closeSidebar"
              aria-label="Close Sidebar"
              class="btn-icon border-none"
            >
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
          <div class="mt-2">
            <slot />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>