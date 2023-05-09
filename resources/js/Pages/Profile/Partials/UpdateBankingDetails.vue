<script setup>
import { InputError, InputLabel, PrimaryButton, TextInput } from "@/Components/Admin";
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';


const user = usePage().props.auth.user;

const bankInput = ref(null);
const passwordInput = ref(null);

const passwordError = ref('');

const form = useForm({
    bank_account: '',
    password_confirm: '',
});

const updateBank = () => {
    // check if the password is correct with a fetch request
    // if it is, then update the bank account

    fetch('/admin/validatePassword', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            password: form.password_confirm,
        }),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.status === 'success') {
                form.patch(route('users.updateBankAccount'), {
                    preserveScroll: true,
                    onSuccess: () => { form.reset(); passwordError.value = ''; },
                    onError: () => {
                        if (form.errors.bank_account) {
                            form.reset('bank_account');
                            bankInput.value.focus();
                        }
                    },
                });
            } else if (data.status === 'error') {
                passwordError.value = data.message;
                setTimeout(() => {
                    passwordError.value = '';
                }, 5000);
            } else {
                form.reset('password_confirm');
                passwordInput.value.focus();
            }
        });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Update Bank Account</h2>

            <p class="mt-1 text-sm text-gray-600">
                Ensure your bank account is correct.
            </p>
        </header>

        <form @submit.prevent="updateBank" class="mt-6 space-y-6">
            <div>
                <InputLabel for="bank_account" value="Bank Account" />
                <TextInput id="bank_account" ref="bankInput" v-model="form.bank_account" type="text"
                    class="mt-1 block w-full" autocomplete="bank_account" />

                <InputError :message="form.errors.bank_account" class="mt-2" />
            </div>

            <div>
                <InputLabel for="password_confirm" value="Password for confirmation" />
                <TextInput id="password_confirm" ref="passwordInput" v-model="form.password_confirm" type="password"
                    class="mt-1 block w-full" />

                <InputError :message="passwordError" class="mt-2" v-if="passwordError.length > 0" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
