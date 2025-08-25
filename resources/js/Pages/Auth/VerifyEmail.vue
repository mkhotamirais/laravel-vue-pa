<script setup>
import { useForm } from "@inertiajs/vue3";
import SessMsg from "@/Components/form/SessMsg.vue";

defineProps({ msgVerify: String });

const form = useForm({});

const submit = () => {
  form.post(route("verification.send"));
};
</script>

<template>
  <div>
    <Head title="Email Verification" />

    <section class="container">
      <div
        class="max-w-md py-4 mx-auto bg-white dark:bg-dark-2 my-12 rounded-xl p-4"
      >
        <div class="mb-8">
          <SessMsg :msg="msgVerify" />
          <p class="py-4">
            Thanks for signing up! Before getting started, could you verify your
            email address by clicking on the link we just emailed to you!
          </p>
        </div>
        <form @submit.prevent="submit">
          <p class="mb-4">
            If you didn't receive the email, we will gladly send you another.
          </p>
          <button class="link" :disabled="form.processing">
            Resend Verification Email
          </button>
        </form>
      </div>
    </section>
  </div>
</template>