<script setup>
import ApplicationLogo from "@/Components/Customer/Atoms/ApplicationLogo.vue";
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
    <Head title="Log in" />
  <div class="flex min-h-screen">
    <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 w-1/2">
      <div class="mx-auto w-full max-w-sm lg:w-96">
        <div>
          <Link href="/">
          <ApplicationLogo class="h-12 w-auto" />
          </Link>
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
                <PrimaryButton
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                class="w-full"
                >
                Sign in
              </PrimaryButton>
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
      <img class="absolute inset-0 h-full w-full object-cover object-top" src="https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=720&q=80" alt="" />
    </div>
  </div>
</template>