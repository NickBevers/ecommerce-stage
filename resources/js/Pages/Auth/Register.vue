<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/atoms/InputError.vue";
import InputLabel from "@/Components/atoms/InputLabel.vue";
import PrimaryButton from "@/Components/atoms/PrimaryButton.vue";
import TextInput from "@/Components/atoms/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
  firstname: "",
  lastname: "",
  email: "",
  password: "",
  password_confirmation: "",
  terms: false,
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Register" />
    <h1
      class="text-xl mb-8 mt-4 font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white"
    >
      Create an account
    </h1>
    <form @submit.prevent="submit">
      <div class="flex w-full justify-between">
        <div>
          <InputLabel for="firstname" value="Firstname" />
          <TextInput
            id="firstname"
            type="text"
            name="firstname"
            class="mt-1 block w-full"
            v-model="form.firstname"
            required
            autofocus
            autocomplete="firstname"
            placeholder="John"
          />

          <InputError class="mt-2" :message="form.errors.firstname" />
        </div>
        <div>
          <InputLabel for="lastname" value="Lastname" />
          <TextInput
            id="lastname"
            name="lastname"
            type="text"
            class="mt-1 block w-full"
            v-model="form.lastname"
            required
            autofocus
            autocomplete="lastname"
            placeholder="Green"
          />

          <InputError class="mt-2" :message="form.errors.lastname" />
        </div>
      </div>

      <div class="mt-4">
        <InputLabel for="email" value="Email" />

        <TextInput
          id="email"
          type="email"
          class="mt-1 block w-full"
          name="email"
          v-model="form.email"
          required
          autocomplete="name"
          placeholder="user@mail.com"
        />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />

        <TextInput
          id="password"
          type="password"
          name="password"
          class="mt-1 block w-full"
          v-model="form.password"
          required
          autocomplete="new-password"
          placeholder="••••••••"
        />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="mt-4">
        <InputLabel for="password_confirmation" value="Confirm Password" />

        <TextInput
          id="password_confirmation"
          type="password"
          name="password_confirmation"
          class="mt-1 block w-full"
          v-model="form.password_confirmation"
          required
          autocomplete="new-password"
          placeholder="••••••••"
        />

        <InputError class="mt-2" :message="form.errors.password_confirmation" />
      </div>

      <div class="flex items-center justify-end mt-4">
        <PrimaryButton
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          Register
        </PrimaryButton>
      </div>
      <div
        class="flex items-center justify-start my-4 text-sm font-medium text-gray-600 dark:text-white0"
      >
        <span>Already registered?&nbsp;</span>
        <Link
          :href="route('login')"
          class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500"
        >
          Login
        </Link>
      </div>
    </form>
  </GuestLayout>
</template>
