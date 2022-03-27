
<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Brand
            </h2>
            <Link :href="route('brand.create')" class="mt-10 p-2 rounded bg-green-900 text-white">Add Brand</Link>
            <Link :href="route('category.create')" class="mt-10 ml-2 p-2 rounded bg-green-900 text-white">Add Category</Link>
        </template>

        <div class="max-w-xl mx-auto py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <!--Category Adding Form Start -->
                    <section class="bg-white p-2">
                        <div class="max-w-full sm:max-w-3xl mx-auto h-screen flex items-center">
                            <form @submit.prevent="submit" class="w-full sm:w-[250px] p-4 mx-auto flex flex-col bg-gray-200 rounded-md">
                                <!-- Parent dropdown item -->
                                <select class="border border-2 rounded border-green-900"
                                        v-model="form.parent_name"
                                        @change="onChangeParentCategory($event)">
                                    <option :value="null">Select parent category</option>
                                    <option
                                        v-if="parent_categories"
                                        v-for="parent_category in parent_categories"
                                        :value="parent_category.slug">{{ parent_category.name }}</option>
                                </select>

                                <!-- Child dropdown item -->
                                <select class="border border-2 mt-2 rounded" v-model="form.child_name">
                                    <option :value="null">Select child category</option>
                                    <option v-if="child_categories" v-for="child_category in child_categories" :value="child_category.slug">{{ child_category.name }}</option>
                                </select>

                                <!-- Category Name -->
                                <input type="text" class="border border-2 mt-2 rounded" placeholder="Ex: Shirt" v-model="form.sub_child_name" required>
                                <div class="text-red-500" v-if="this.$attrs.errors.sub_child_name">{{ this.$attrs.errors.sub_child_name }}</div>

                                <button class="p-2 rounded-md bg-green-900 text-white mt-3" type="submit">Submit</button>
                            </form>
                        </div>
                    </section>
                    <!--Category Adding Form End-->
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import { defineComponent } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'

export default defineComponent({
    components: {
        AppLayout
    },
    props: {
        parent_categories: Object
    },
    data() {
        return {
            child_categories: null
        }
    },
    setup () {
        let form = reactive({
            parent_name: null,
            child_name: null,
            sub_child_name: null
        })
        function submit() {
            Inertia.post(route('category.store'), form, {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.parent_name= null
                    this.form.child_name= null
                    this.form.sub_child_name= null
                    if (this.$page.props.flash.message){
                        this.$swal.fire({
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                }
            })
        }
        return { form, submit }
    },
    methods: {
        onChangeParentCategory: function (event){
            axios.get(route('category.child_category', {'category': event.target.value}))
                .then((response) => {
                    this.child_categories = response.data.data.child_categories
                })
        }
    }
})
</script>
