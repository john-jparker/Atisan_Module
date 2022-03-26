
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
                                <select class="border border-2 rounded border-green-900" v-model="form.parent_name">
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                    <option value="opel">Opel</option>
                                    <option value="audi">Audi</option>
                                </select>

                                <!-- Child dropdown item -->
                                <select class="border border-2 mt-2 rounded" v-model="form.child_name">
                                    <option value="volvo">Volvo</option>
                                    <option value="saab">Saab</option>
                                    <option value="opel">Opel</option>
                                    <option value="audi">Audi</option>
                                </select>

                                <!-- Category Name -->
                                <input type="text" class="border border-2 mt-2 rounded" v-model="form.sub_child_name">

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
    setup () {
        const form = reactive({
            parent_name: null,
            child_name: null,
            sub_child_name: null
        })
        function submit() {
            Inertia.post(route('category.store'), form, {
                preserveScroll: true,
                onSuccess: () => form.reset('parent_name', 'child_name', 'sub_child_name')
            })
        }
        return { form, submit }
    }
})
</script>
