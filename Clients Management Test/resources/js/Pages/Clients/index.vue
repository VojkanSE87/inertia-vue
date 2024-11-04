<script setup>

import MagnifyingGlass from "@/Components/Icons/MagnifyingGlass.vue";
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, useForm, usePage } from "@inertiajs/vue3";
import { data } from "autoprefixer";
import { computed, ref, watch } from "vue";


defineProps({
    
    clients: {
        type: Object,
        required: true,
    },

    classes:{
        type: Object,
        required: true,
    },
});

//console.log(usePage().props.clients);


let search = ref(usePage().props.search),

    class_id = ref(""),
    pageNumber = ref(1);


let clientsUrl = computed(() => {

    let url = new URL(route("clients.index"));
    url.searchParams.append("page", pageNumber.value);


    if(search.value) {

        url.searchParams.append("search", search.value);

    }

    if(class_id.value) {

        url.searchParams.append("class_id", class_id.value);

    }

    return url;

});

const updatedPageNumber = (link) => {

    pageNumber.value = link.url.split("=") [1];

}



watch(() => clientsUrl.value, 

    (updatedClientsUrl) => {

        router.visit(updatedClientsUrl, {
           
            preserveScroll: true,
            preserveState: true,
            replace: true,

        })
    }
);

watch(() => search.value, 

    (value) => {

        if(value) {
           
            pageNumber.value = 1;
        }
    }
);

const deleteForm = useForm({});

const deleteClient = (clientId) => {

    if(confirm('You are about to delete this client. Do you wish to continue?')) {
        deleteForm.delete(route('clients.destroy', clientId));
    }

}


</script>

<template>
    <Head title="Clients" />

<AuthenticatedLayout>
    <template #header>
        <h2
            class="text-xl font-semibold leading-tight text-gray-800"
        >
            Clients list
        </h2>
    </template>

    <div class="bg-gray-100 py-10">
        <div class="mx-auto max-w-7xl">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="sm:flex sm:item-center">
                    <div class="sm:flex-auto">
                    <h1 class="text-xl font-semibold text-gray-900">
                            Clients
                        </h1>
                        <p class="mt-2 text-sm text-gray-700">
                            A list of all the clients    
                        </p>
                    </div>

                    <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                        <Link                        
                            
                            :href="route('clients.create')"
                            class="inline-flex items-center justify-center rounded-md 
                            border border-transparent bg-orange-600 px-4 py-2 text-sm 
                            font-medium text-white shadow-sm hover:bg-orange-500 
                            focus:outline-none focus:ring-2 focus:ring-orange-400 
                            focus:ring-offset-2 sm:w-auto"                        
                        >
                            Add Client
                        </Link>
                    </div>    
                </div>

                <div class="flex flex-col justify-start sm:flex-row mt-6">
                        <div class="relative text-sm text-gray-800 col-span-3">
                            <div
                                class="absolute pl-2 left-0 top-0 bottom-0 flex 
                                items-center pointer-events-none text-gray-500"
                            >
                            <MagnifyingGlass />
                            </div>
                          
                            <input
                            
                                v-model="search"
                                type="text"
                                
                                placeholder="Search clients data..."
                                id="search"
                                class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-900 sm:text-sm sm:leading-6"
                            />                        
                        </div>      
                        
                        <select 
                        
                            v-model="class_id"
                            
                            class="block rounded-lg border-0 py-2 ml-5 text-gray-900
                            ring-1 ring-inset ring-gray-200 placeholder:text-gray-400
                            sm:text-sm sm:leading-6">

                            <option value="">Class filter</option>

                            <option :value="item.id" :key="item.id" v-for="item in classes.data">
                                {{ item.name }}
                            </option>

                        </select>

                    </div>

                    <div class="mt-8 flex flex-col">
                        <div
                            class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8"
                        >
                            <div
                                class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                            >
                                <div
                                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative"
                                >
                                    <table
                                        class="min-w-full divide-y divide-gray-300"
                                    >
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    ID
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    Email
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Class
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Section
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                                                >
                                                    Created At
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="relative py-3.5 pl-3 pr-4 sm:pr-6"
                                                />
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
                                        <tr v-for="client in clients.data"
                                            :key="client.id"
                                            
                                            >
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ client.id }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ client.name }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ client.email }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ client.class.name }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                    {{ client.section.name }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                                                >
                                                {{ client.created_at }}
                                                </td>

                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                                                >
                                                    <Link
                                                        :href="route('clients.edit', client.id)"
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        Edit
                                                    </Link>

                                                    <button

                                                        @click="deleteClient(client.id)"

                                                        class="ml-2 text-indigo-600 hover:text-indigo-900"
                                                    
                                                    >
                                                        Delete

                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Pagination 
                                    :data="clients"
                                    :updatedPageNumber="updatedPageNumber"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        </div>
</AuthenticatedLayout>

</template>