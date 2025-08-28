<script setup></script>

<template>
  <div class="space-y-3 py-4">
    <h2 class="h2 text-2xl">{{ $t("buttons.btn_order_now") }}</h2>
    <p class="flex flex-col text-gray-600">
      <span
        >{{ $t("others.payment.title") }} :
        {{ $t("others.payment.bank_account") }}
        {{ $t("others.payment.bank_account_number") }}</span
      >
      <span>(a.n {{ $t("others.payment.bank_account_name") }})</span>
      <span>{{ $t("links.wa.label") }}</span>
    </p>
    <a
      :href="$t('links.wa.url')"
      class="inline-flex items-center gap-2 py-3 px-6 rounded-full bg-primary hover:bg-primary/80 text-white"
    >
      <i class="fa-brands fa-whatsapp text-2xl"></i>
      {{ $t("buttons.btn_chat") }}</a
    >
  </div>
</template>