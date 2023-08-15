<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Edit Book Type
        </h2>
        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div>
                <InputLabel value="Name"></InputLabel>
                <TextInput
                    id="name"
                    type="text"
                    v-model="form.name"
                    class="mt-1 block w-full"
                    autocomplete="name"
                />

                <InputError :message="form.errors.name" class="mt-2" />
            </div>
            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
                <SecondaryButton @click="$emit('close')"> Cancel </SecondaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </div>
</template>

<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import {onMounted, ref} from 'vue';

const form = useForm({
    id: '',
    name:''
});

const props = defineProps({
    data: {
        type: Object
    }
});

const emit = defineEmits(['close']);

onMounted(() =>{
    form.name = props.data.book_type_name;
    form.id = props.data.id;
})

const submitForm = () => {
    form.post(route('book_type.update', {bookType: form.id}), {
        preserveScroll: true,
        onSuccess: () =>{
            form.reset(),
                emit('close')
        }
    });
};

</script>

<style scoped>

</style>
