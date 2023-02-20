<script setup>
import Checkbox from "@/Components/atoms/Checkbox.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/atoms/InputError.vue";
import InputLabel from "@/Components/atoms/InputLabel.vue";
import PrimaryButton from "@/Components/atoms/PrimaryButton.vue";
import TextInput from "@/Components/atoms/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Log in" />
    <h1
      class="text-xl mb-8 mt-4 font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
    >
      Sign in to your account
    </h1>
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          v-model="form.email"
          required
          autofocus
          autocomplete="username"
          placeholder="name@mail.com"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />

        <TextInput
          id="password"
          type="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="current-password"
          placeholder="••••••••"
        />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="flex items-center justify-between my-4">
        <Link
          v-if="canResetPassword"
          :href="route('password.request')"
          class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500"
        >
          Forgot your password?
        </Link>
      </div>

      <div class="flex items-center justify-end mt-4 mb-8">
        <PrimaryButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Log in
        </PrimaryButton>
      </div>
      <div
        class="flex items-center justify-start my-4 text-sm font-medium text-gray-600 dark:text-white0"
      >
        <span>Don't have an account yet?&nbsp;</span>
        <Link
          :href="route('register')"
          class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500"
        >
          Sign up
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
