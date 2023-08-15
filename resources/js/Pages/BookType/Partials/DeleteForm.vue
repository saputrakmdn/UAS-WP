<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Anda yakin ingin menghapus {{data.book_type_name}}?
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Setelah data dihapus, semua sumber daya dan datanya akan dihapus secara permanen.
        </p>

        <div class="mt-6 flex justify-end">
            <DangerButton
                class="mr-3"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                @click="deleteData"
            >
                Delete
            </DangerButton>
            <SecondaryButton @click="$emit('close')"> Cancel </SecondaryButton>
        </div>
    </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import DangerButton from '@/Components/DangerButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const form = useForm({
    name: '',
    id: ''
});

const props = defineProps({
    data: {
        type: Object
    }
});

const emit = defineEmits(['close']);

const deleteData = () => {
    form.name = props.data.book_type_name;
    form.id = props.data.id
    form.post(route('book_type.delete', {bookType:form.id}), {
        preserveScroll: true,
        onSuccess: () =>{
            form.reset(),
            emit('close')
        }
    });
}

</script>

<style scoped>

</style>
