<script setup>
import { InputError, InputLabel, PrimaryButton, TextInput } from "@/Components/Admin";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { ApplicationLogo } from "@/Components/Customer";
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
  <Head title="Log in" />
  <div class="flex min-h-screen">
    <div class="flex flex-1 flex-col justify-center py-12 px-4 sm:px-6 lg:flex-none lg:px-20 xl:px-24 w-1/2">
      <div class="mx-auto w-full max-w-sm lg:w-96">
        <div>
          <Link href="/">
          <ApplicationLogo class="h-12 w-auto" />
          </Link>
          <h2 class="mt-6 text-3xl font-bold tracking-tight text-gray-900">Create an account</h2>
        </div>

        <div class="mt-8">
          <div class="mt-6">
            <form @submit.prevent="submit" class="space-y-6">
              <div class="flex w-full justify-between gap-6">
                <div>
                  <InputLabel for="firstname" value="Firstname" />
                  <div>
                    <TextInput id="firstname" type="text" name="firstname" class="mt-1 block w-full"
                      v-model="form.firstname" required autofocus autocomplete="firstname" placeholder="John" />
                    <InputError class="mt-2" :message="form.errors.firstname" />
                  </div>
                </div>
                <div class="space-y-1">
                  <InputLabel for="lastname" value="Lastname" />
                  <div class="mt-2">
                    <TextInput id="lastname" name="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname"
                      required autofocus autocomplete="lastname" placeholder="Green" />
                    <InputError class="mt-2" :message="form.errors.lastname" />
                  </div>
                </div>
              </div>
              <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput id="email" type="email" class="mt-1 block w-full" name="email" v-model="form.email" required
                  autocomplete="name" placeholder="user@mail.com" />

                <InputError class="mt-2" :message="form.errors.email" />
              </div>
              <div class="space-y-1">
                <InputLabel for="password" value="Password" />
                <div class="mt-2">
                  <TextInput id="password" type="password" name="password" class="mt-1 block w-full"
                    v-model="form.password" required autocomplete="new-password" placeholder="••••••••" />
                  <InputError class="mt-2" :message="form.errors.password" />
                </div>
              </div>
              <div class="space-y-1">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <div class="mt-2">
                  <TextInput id="password_confirmation" type="password" name="password_confirmation"
                    class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password"
                    placeholder="••••••••" />

                  <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
              </div>
              <div>
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="w-full">
                  Sign up
                </PrimaryButton>
              </div>

              <div class="flex items-center justify-between">
                <div class="text-sm">
                  Already registered?
                  <Link :href="route('login')" class="font-medium text-indigo-600 hover:text-indigo-500">Sign in</Link>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="relative hidden w-0 flex-1 lg:block">
      <img class="absolute inset-0 h-full w-full object-cover object-center"
        src="https://images.unsplash.com/photo-1633103110606-070511de45ee?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80"
        alt="" />
    </div>
  </div>
</template>
