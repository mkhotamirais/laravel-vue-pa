<script setup>
import { useForm } from "@inertiajs/vue3";
import Input from "@/Components/form/Input.vue";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <div>
    <Head title="Register" />

    <section class="bg-gray-100 py-12">
      <div class="container">
        <div class="max-w-md p-6 lg:p-8 bg-white mx-auto rounded-lg shadow">
          <div class="mb-4">
            <h1 class="h1 mb-2">{{ $t("form.register") }}</h1>
            <p>
              {{ $t("form.register_desc") }}
              <Link :href="route('login')" class="link">{{
                $t("form.login")
              }}</Link>
            </p>
          </div>

          <form @submit.prevent="submit">
            <Input
              :label="$t('form.register_fields[0]')"
              id="name"
              icon="id-badge"
              placeholder="Your name"
              v-model="form.name"
              :error="form.errors.name"
            />
            <Input
              label="Email"
              id="email"
              icon="at"
              placeholder="example@email.com"
              v-model="form.email"
              :error="form.errors.email"
            />
            <Input
              label="Password"
              id="password"
              type="password"
              placeholder="********"
              icon="key"
              v-model="form.password"
              :error="form.errors.password"
            />
            <Input
              :label="$t('form.register_fields[3]')"
              id="password_confirmation"
              type="password"
              placeholder="********"
              icon="key"
              v-model="form.password_confirmation"
            />

            <button
              type="submit"
              class="btn mt-4 w-full justify-center"
              :disabled="form.processing"
            >
              {{ $t("form.register") }}
            </button>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>