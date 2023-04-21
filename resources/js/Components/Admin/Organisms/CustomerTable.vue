<script setup>
import { Pagination, Alert, Dropdown } from '@/Components/Admin'
import { onMounted, ref, reactive } from 'vue';
import moment from 'moment';
import { Link, router } from '@inertiajs/vue3';
import { PencilIcon, EyeIcon, TrashIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    customers: Object,
});

const roles = reactive(
    ["user", "admin"]
);

function changeRole(customer) {

    fetch('/admin/users/' + customer.id, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(
            {
                user_id: customer.id,
                user_type: customer.user_type
            }
        )
    })
        .then(response => console.log(response))
        .catch((error) => {
            console.error('Error:', error);
        });
}

</script>
<template>
    <section class="my-8">
        <div class="px-4 py-5 rounded-lg bg-white shadow">
            <div class="flow-root">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <table class="min-w-full divide-y divide-gray-300 ">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Name</th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Phone
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email
                                    </th>
                                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                        Roles
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white ">
                                <tr v-for="customer in props.customers" :key="customer.id">
                                    <td class="whitespace-nowrap py-4 text-sm text-gray-500 ">
                                        <div class="font-medium text-gray-900">{{ customer.firstname }} {{ customer.lastname
                                        }}</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <div class="font-medium text-gray-900" v-if="customer.phone">{{
                                            customer.phone }}
                                        </div>
                                        <div class="font-medium text-gray-300" v-else>Not provided</div>
                                    </td>
                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{
                                            customer.email }}
                                    </td>
                                    <td class="whitespace-nowrap text-sm text-gray-500">
                                        <select
                                            class="w-full rounded-md shadow border-none ring-1 ring-gray-200 focus:ring-gray-300"
                                            v-model="customer.user_type" @change="changeRole(customer)">
                                            <option v-for="role in roles" :key="role" :value="role">
                                                {{ role }}
                                            </option>
                                        </select>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="border-t border-gray-200  flex sm:justify-end">
                            <!-- <Pagination :links="props.links" /> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</template>