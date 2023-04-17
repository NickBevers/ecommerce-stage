<script setup>
import Index from '../Index.vue'
import DeleteUserForm from '../../../Profile/Partials/DeleteUserForm.vue'
</script>
<template>
    <Index>
        <DeleteUserForm class="px-2 py-6 sm:px-6 lg:col-span-6 lg:px-0 lg:py-0" user_type="customer" />
    </Index>
</template>