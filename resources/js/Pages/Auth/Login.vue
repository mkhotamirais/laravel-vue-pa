<script setup>
import Input from "@/Components/Form/Input.vue";
import CheckBox from "@/Components/Form/CheckBox.vue";
import SessMsg from "@/Components/Form/SessMsg.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({ email: "", password: "", remember: null });

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <div>
    <Head title="Login" />

    <section class="bg-slate-100 py-12">
      <div class="container">
        <div
          class="p-6 lg:p-8 max-w-md bg-white dark:bg-dark-2 mx-auto rounded-lg shadow"
        >
          <div class="mb-4">
            <h1 class="h1 mb-2">login</h1>
            <p>
              {{ $t("form.login_desc") }}
              <Link :href="route('register')" class="link">{{
                $t("form.register")
              }}</Link>
            </p>
          </div>

          <SessMsg :msg="form.errors.msg" :isError="true" />

          <form @submit.prevent="submit" class="space-y-6">
            <Input
              label="Email"
              icon="at"
              v-model="form.email"
              placeholder="example@email.com"
              :error="form.errors.email"
            />
            <Input
              label="Password"
              type="password"
              placeholder="********"
              icon="key"
              v-model="form.password"
              :error="form.errors.password"
            />

            <div class="flex items-center justify-between">
              <CheckBox name="remember" v-model="form.remember">
                Remember me
              </CheckBox>
              <Link :href="route('password.request')" class="link">{{
                $t("form.login_forgot")
              }}</Link>
            </div>

            <button
              type="submit"
              :disabled="form.processing"
              class="btn w-full mt-4 justify-center"
            >
              Login
            </button>
          </form>
        </div>
      </div>
    </section>
  </div>
</template>