<template>
    <Head title="Book List" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Book List</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:max-w-7xl lg:px-8">
                        <div class="grid grid-cols-1 gap-x-2 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                            <div class="group relative text-center" v-for="(value, index) in books">
                                <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-t-md bg-gray-200 lg:aspect-none group-hover:opacity-75 h-40">
                                    <div class="h-full w-full object-cover object-center lg:h-full lg:w-full bg-blue-500 flex flex-col justify-center">
                                        <h1 class="text-2xl text-white font-bold font-sans">
                                            {{value.book_name}}
                                        </h1>
                                        <h6 class="text-sm text-gray-300 font-light font-sans">{{value.book_type.book_type_name}}</h6>
                                    </div>
                                </div>
                                <div class="rounded-b-md bg-gray-100">
                                    <p class="text-sm font-sans">
                                        {{value.book_publisher}}
                                    </p>
                                    <p class="text-xs font-thin text-gray-500 font-sans">
                                        {{value.book_year}}
                                    </p>
                                    <h6 class="text-sm font-semibold font-sans">Stock: {{value.book_stock}}</h6>
                                    <PrimaryButton class="mb-2 mt-2 text-center" v-if="value.book_stock > 0" @click="addToCart(value)"><i class="fas fa-cart-shopping mr-1"/>Add To Cart</PrimaryButton>
                                    <PrimaryButton class="mb-2 mt-2 text-center disabled:opacity-50" v-if="value.book_stock == 0" disabled>Out Of Stock</PrimaryButton>
                                </div>
                                <InputError :message="form.errors.formData" class="mt-2" />
                            </div>

                            <!-- More products... -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useToast } from "vue-toastification";

const form = useForm({
    id: '',
    book_name: ''
});

const props = defineProps({
    books: {
        type: Array,
    }
});

const toast = useToast();

const addToCart = (value) => {
    form.id = value.id;
    form.book_name = value.book_name;

    form.post(route('cart.add'),{
        preserveScroll: true,
        onSuccess: () =>{
            form.reset();
            toast.success("Succes! Item added to cart.", {
                timeout: 3000
            });
        },
        onError: () =>{
            form.reset();
            toast.error("Failed! Item already on cart.", {
                timeout: 3000
            });
        }
    });
}
</script>
<style scoped>

</style>
