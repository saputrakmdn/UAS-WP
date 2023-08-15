<template>
    <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900">
            Edit Book Type
        </h2>
        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div>
                <InputLabel value="Book Type"></InputLabel>
                <select name="book_type" id="book_type" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" v-model="form.book_type" >
                    <option v-for="item in bookType"
                            :value="item.id" :selected="item.id == form.book_type ? true: false">
                        {{item.book_type_name}}
                    </option>
                </select>

                <InputError :message="form.errors.book_type" class="mt-2" />
            </div>
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
            <div>
                <InputLabel value="Description"></InputLabel>
                <TextInput
                    id="description"
                    type="text"
                    v-model="form.description"
                    class="mt-1 block w-full"
                    autocomplete="description"
                />

                <InputError :message="form.errors.description" class="mt-2" />
            </div>
            <div>
                <InputLabel value="Publisher"></InputLabel>
                <TextInput
                    id="publisher"
                    type="text"
                    v-model="form.publisher"
                    class="mt-1 block w-full"
                    autocomplete="description"
                />

                <InputError :message="form.errors.publisher" class="mt-2" />
            </div>
            <div>
                <InputLabel value="Year"></InputLabel>
                <TextInput
                    id="year"
                    type="number"
                    v-model="form.year"
                    class="mt-1 block w-full"
                    autocomplete="year"
                />

                <InputError :message="form.errors.year" class="mt-2" />
            </div>
            <div>
                <InputLabel value="Stock"></InputLabel>
                <TextInput
                    id="stock"
                    type="number"
                    v-model="form.stock"
                    class="mt-1 block w-full"
                    autocomplete="stock"
                />

                <InputError :message="form.errors.stock" class="mt-2" />
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
    name:'',
    description: '',
    publisher: '',
    year: '',
    stock: '',
    book_type: '',
    id: ''
});

const props = defineProps({
    data: {
        type: Object
    },
    bookType: {
        type: Array
    }
});

const emit = defineEmits(['close']);

onMounted(() =>{
    form.name = props.data.book_name;
    form.id = props.data.id;
    form.publisher = props.data.book_publisher;
    form.year = props.data.book_year;
    form.stock = props.data.book_stock;
    form.description = props.data.book_description;
    form.book_type = props.data.book_type_id;
})

const submitForm = () => {
    form.post(route('book.update', {book: form.id}), {
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
