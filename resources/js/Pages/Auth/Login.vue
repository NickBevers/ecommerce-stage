<script setup>
import ApplicationLogo from "@/Components/Customer/Atoms/ApplicationLogo.vue";
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/Admin/Atoms/InputError.vue";
import InputLabel from "@/Components/Admin/Atoms/InputLabel.vue";
import PrimaryButton from "@/Components/Admin/Atoms/PrimaryButton.vue";
import TextInput from "@/Components/Admin/Atoms/TextInput.vue";
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
    <h1 class="text-xl mb-8 mt-4 font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
      Sign in to your account
    </h1>
    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit">
      <div>
        <InputLabel for="email" value="Email" />

        <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
          autocomplete="username" placeholder="name@mail.com" />

        <InputError class="mt-2" :message="form.errors.email" />
      </div>

      <div class="mt-4">
        <InputLabel for="password" value="Password" />

        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required
          autocomplete="current-password" placeholder="••••••••" />

        <InputError class="mt-2" :message="form.errors.password" />
      </div>

      <div class="flex items-center justify-between my-4">
        <Link v-if="canResetPassword" :href="route('password.request')"
          class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">
        Forgot your password?
        </Link>
      </div>

      <div class="flex items-center justify-end mt-4 mb-8">
        <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
          Log in
        </PrimaryButton>
      </div>
      <div class="flex items-center justify-start my-4 text-sm font-medium text-gray-600 dark:text-white0">
        <span>Don't have an account yet?&nbsp;</span>
        <Link :href="route('register')"
          class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">
        Sign up
        </Link>
      </div>
    </form>
    
  </GuestLayout>
  <div class="flex min-h-full">
    <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
      <div class="mx-auto w-full max-w-sm lg:w-96">
        <div>
          <ApplicationLogo class="h-12 w-auto" />
          <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Sign in to your account</h2>
        </div>

        <div class="mt-8">
          <div class="mt-6">
            <form @submit.prevent="submit" class="space-y-6">
              <div>
                <InputLabel for="email" value="Email address" />
                <div class="mt-2">
                  <TextInput id="email" type="email" v-model="form.email" required autofocus autocomplete="username" placeholder="name@mail.com" />
                  <InputError class="mt-2" :message="form.errors.email" />
                </div>
              </div>

              <div class="space-y-1">
                <InputLabel for="password" value="Password" />
                <div class="mt-2">
                  <TextInput id="password" type="password" v-model="form.password" required autocomplete="current-password" placeholder="••••••••" />
                  <InputError class="mt-2" :message="form.errors.password" />
                </div>
              </div>

              <div class="flex items-center justify-between">
                <div class="text-sm">
                  <Link v-if="canResetPassword" :href="route('password.request')"
                    class="font-medium text-indigo-600 hover:text-indigo-500">
                        Forgot your password?
                  </Link>
                </div>
              </div>

              <div>
                <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 py-2 px-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
              </div>

              <div class="flex items-center justify-between">
                <div class="text-sm">
                  Don't have an account yet? 
                  <Link :href="route('register')" class="font-medium text-indigo-600 hover:text-indigo-500">Sign up</Link>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
      <img class="absolute inset-0 h-full w-full object-cover" src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=720&q=80" alt="" />
    </div>
  </div>
</template>