<template>
    <Head title="Cart" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cart</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-if="data.length == 0" class="p-6 text-gray-900">Cart Empty! <a class="text-blue-400" :href="route('book.list')">Select Book</a> </div>
                    <div v-if="data.length > 0" class="flex lg:flex-row flex-col" id="cart">
                        <div class="lg:w-1/2 md:w-8/12 w-full lg:px-8 lg:py-14 md:px-6 px-4 md:py-8 py-4 bg-white overflow-y-auto overflow-x-hidden lg:h-screen h-auto" id="scroll">
                            <div class="flex items-strech py-8 md:py-10 lg:py-8 border-t border-gray-50" v-for="(value, index) in data">
                                <div class="w-5/12 lg:w-4/12 bg-blue-500 flex flex-col justify-center">
                                    <h1 class="text-2xl text-white font-bold font-sans text-center">
                                        {{value.book_name}}
                                    </h1>
                                </div>
                                <div class="pl-3 w-7/12 lg:w-8/12 2xl:w-3/4 flex flex-col justify-center">
                                    <p class="text-xs leading-3 text-gray-800 md:pt-0 pt-4 text-blue">{{value.book_type.book_type_name}}</p>
                                    <div class="flex items-center justify-between w-full">
                                        <p class="text-base font-black leading-none text-gray-800">{{value.book_name}}</p>
                                        <div class="flex items-center rounded rounded-sm border-gray-200 mr-6">
                                            <span class="cursor-pointer rounded-l bg-gray-300 py-1 px-3.5 duration-100 hover:bg-blue-500 hover:text-blue-50" @click="decrementQty(value.id)"> - </span>
                                            <input class="h-8 w-10 bg-white text-center text-xs outline-none border-gray-300" v-model="form.qty[value.id]" type="number" :min="1" :max="10"/>
                                            <span class="cursor-pointer rounded-r bg-gray-300 py-1 px-3 duration-100 hover:bg-blue-500 hover:text-blue-50" @click="incrementQty(value.id)"> + </span>
                                        </div>
                                    </div>
                                    <p class="text-xs leading-3 text-gray-600 pt-2">Publsiher: {{value.book_publisher}}</p>
                                    <p class="text-xs leading-3 text-gray-600 py-4">Year: {{value.book_year}}</p>
                                    <p class="text-xs leading-3 text-gray-600 break-words">Description: {{value.book_description}}</p>
                                    <div class="flex items-center justify-between pt-5">
                                        <div class="flex itemms-center">
                                            <p class="text-xs leading-3 underline text-red-500 cursor-pointer" @click="removeCart(value.id)">Remove</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:w-1/2 md:w-8/12 w-full bg-gray-300 h-full">
                            <div class="flex flex-col lg:h-screen h-auto lg:px-8 md:px-7 px-4 lg:py-20 md:py-10 py-6 overflow-y-auto">
                                <div>
                                    <p class="lg:text-4xl text-3xl font-black leading-9 text-gray-800">Summary</p>
                                    <div class="flex items-center justify-between pt-16">
                                        <p class="text-base leading-none text-gray-800">Return Date</p>
                                        <TextInput
                                            id="name"
                                            type="date"
                                            v-model="form.return_date"
                                            class="border border-gray-300 bg-gray-300 rounded-lg focus:ring-gray-300 focus:ring-gray-300"
                                            autocomplete="name"
                                        />
                                    </div>
                                </div>
                                <div class="mt-20">
                                    <div class="flex items-center pb-6 justify-between">
                                        <p class="text-2xl leading-normal text-gray-800">Total Book</p>
                                        <p class="text-2xl font-bold leading-normal text-right text-gray-800">{{data.length}}</p>
                                    </div>
                                    <button @click="checkout()" class="text-base leading-none w-full py-5 bg-gray-800 border-gray-800 border focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 text-white">Checkout</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, useForm} from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import {useToast} from "vue-toastification";
import {onMounted} from "vue";

const form = useForm({
    return_date: '',
    qty: {
        type: Array
    }
});

onMounted(() => {
    props.data.forEach((item) => {
        form.qty[item.id] = 1;
    });
})

const toast = useToast();

const deleteCartForm = useForm({
    id: ''
});

const removeCart = (id) => {
    deleteCartForm.id = id;
    deleteCartForm.post(route('cart.delete'), {
        preserveScroll: true,
        onSuccess: () =>{
            deleteCartForm.reset();
            toast.success("Item already deleted!", {
                timeout: 3000
            });
        }
    });
}

const checkout = () => {
    form.post(route('cart.checkout'), {
        preserveScroll: true,
        onSuccess: () =>{
            form.reset();
            toast.success("Success checkout books!. please go to pickup store.", {
                timeout: 5000
            });
        },
        onError: (errors) =>{
            for(var error in errors){
                toast.error(errors[error], {
                    timeout: 5000
                });
            }
        }
    });
}

const incrementQty = (id) => {
    if (form.qty[id] < 10)
        form.qty[id] = form.qty[id] + 1;
}

const decrementQty = (id) => {
    if(form.qty[id] == 1)
        form.qty[id] = 1;
    else
        form.qty[id] = form.qty[id]-1;
}

const props = defineProps({
    data:{
        type: Array
    }
});
</script>

<style scoped>
input[type='number'] {
    -moz-appearance:textfield;
}
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}
</style>
