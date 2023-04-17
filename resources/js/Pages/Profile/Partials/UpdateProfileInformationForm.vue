<script setup>
import { InputError, InputLabel, PrimaryButton, TextInput } from "@/Components/Admin";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";

const props = defineProps({
  mustVerifyEmail: Boolean,
  status: String,
  user_type: {
    type: String,
    default: "admin",
  },
});

const user = usePage().props.auth.user;

const form = useForm({
  firstname: user.firstname,
  lastname: user.lastname,
  email: user.email,
  password: "",
});

onMounted(() => {
  form.reset("firstname", "lastname", "email", "password");
});

const updateProfile = () => {
  form.patch(route(`users.update`, user.id), {
    preserveScroll: true,
    onSuccess: () => {
      form.update({
        firstname: user.firstname,
        lastname: user.lastname,
        email: user.email,
        password: "",
      });

      form.reset();
    },
    onError: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <section>
    <header v-if="props.user_type != 'customer'">
      <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

      <p class="mt-1 text-sm text-gray-600">
        Update your account's profile information and email address.
      </p>
    </header>
    <header v-else>
      <div class="mx-auto max-w-2xl px-4 lg:max-w-4xl lg:px-0">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Profile Information</h1>
        <p class="mt-2 text-sm text-gray-500"> Update your account's profile information and email address.</p>
      </div>
    </header>

    <form @submit.prevent="updateProfile" class="mt-6 space-y-6">
      <div class="flex justify-between gap-6">
        <div class="w-2/4">
          <InputLabel for="firstname" value="Firstname" />

          <TextInput id="firstname" type="text" class="mt-1 block w-full" v-model="form.firstname" required autofocus
            autocomplete="firstname" />

          <InputError class="mt-2" :message="form.errors.firstname" />
        </div>
        <div class="w-2/4">
          <InputLabel for="lastname" value="Lastname" />

          <TextInput id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" required autofocus
            autocomplete="lastname" />

          <InputError class="mt-2" :message="form.errors.lastname" />
        </div>
      </div>

      <div>
        <InputLabel for="email" value="Email" />

        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required
          autocomplete="username" />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div>
        <InputLabel for="password_check" value="Password" />

        <TextInput id="password_check" type="password" class="mt-1 block w-full" v-model="form.password"
          autocomplete="new-password" required />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div v-if="props.mustVerifyEmail && user.email_verified_at === null">
        <p class="text-sm mt-2 text-gray-800">
          Your email address is unverified.
          <Link :href="route('verification.send')" method="post" as="button"
            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          Click here to re-send the verification email.
          </Link>
        </p>

        <div v-show="props.status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600">
          A new verification link has been sent to your email address.
        </div>
      </div>

      <div class="flex items-center gap-4">
        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

        <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
          <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">
            Saved.
          </p>
        </Transition>
      </div>
    </form>
  </section>
</template>