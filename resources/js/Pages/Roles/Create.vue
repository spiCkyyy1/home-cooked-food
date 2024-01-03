<template>
    <div v-if="$page.props.flash.success" class="alert alert-success">
        {{ $page.props.flash.success }}
    </div>
    <!--  START TABLE-->
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" v-model="searchString" id="simple-search" autocomplete="off" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search">
                            </div>
                        </form>
                    </div>
                    <div class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0">
                        <button  @click="showAddRoleModal" type="button" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Add Role
                        </button>
                    </div>
                </div>
                <div class="overflow-x-auto" v-if="rolesWithPermissions">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">ID</th>
                            <th scope="col" class="px-4 py-3">Role</th>
                            <th scope="col" class="px-4 py-3">Permissions</th>
                            <th scope="col" class="px-4 py-3">
                                <span >Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="border-b dark:border-gray-700" v-for="data in rolesWithPermissions.data">
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ data.id }}
                            </th>
                            <td class="px-4 py-3">{{ data.name }}</td>
                            <td class="px-4 py-3" >
                              <span >
                                <span class="bg-purple-100 text-purple-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded-full dark:bg-purple-900 dark:text-purple-300">{{showPermissions(data.permissions)}}</span>
                              </span>
                            </td>

                            <td class="px-4 py-3 flex">
                                <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Edit
                                </a>
                                <a @click="deleteRole(data.id)" href="javascript:;" class="block py-2 px-4 text-sm text-red-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-200 dark:hover:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-800">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    Delete
                                </a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div v-else>
                    <h1 class="ml-8">Sorry, no roles found.</h1>
                </div>
                <nav v-if="rolesWithPermissions" class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing
                    <span class="font-semibold text-gray-900 dark:text-white">{{rolesWithPermissions.current_page}}-{{rolesWithPermissions.per_page}}</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">{{ rolesWithPermissions.total }}</span>
                </span>
                    <ul class="inline-flex items-stretch -space-x-px">
                        <li v-for="pagination in rolesWithPermissions.links">
                            <a href="javascript:;"
                               @click="getRoles(pagination.url)"
                               :class="{ 'bg-red-700 text-white':  pagination.active, 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none disabled:pointer-events-none disabled:cursor-default disabled:opacity-75': pagination.url == null }"
                               class="flex items-center justify-center text-sm py-2 px-3 leading-tight
                               text-gray-500 border border-gray-300
                               dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700
                               dark:hover:text-white" v-html="pagination.label"></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <!--  END TABLE-->
    <div id="delete-role-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" @click="hideModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Deleting this role would delete all the permissions as well</h3>
                    <button @click="confirmDelete" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Yes, I'm sure
                    </button>
                    <button @click="hideModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div id="add-role-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" @click="hideAddModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <h1 class="text-4xl font-bold">Add Role</h1>
                    <form class="w-full max-w-lg" @submit.prevent="submit" autocomplete="off">
                        <div class="flex flex-col">
                                <div>
                                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
                                        Role Name
                                    </label>
                                    <input v-model="form.role" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Vendor">
                                    <div class="bg-red-100 border border-red-400 text-red-700 rounded relative" role="alert" v-if="formErrors">
                                        <span class="block sm:inline">{{ formErrors.role[0] }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="countries_multiple" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Assign Permissions</label>
                                    <select :disabled="form.role == null" v-model="form.permissions" multiple id="countries_multiple" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option disabled selected value="">Choose Permissions</option>
                                        <option :value="permission.id" v-for="permission in permissions">{{permission.name}}</option>
                                    </select>
                                    <div class="bg-red-100 border border-red-400 text-red-700  rounded relative" role="alert" v-if="formErrors">
                                        <span class="block sm:inline">{{ formErrors.permissions[0] }}</span>
                                    </div>
                                </div>

                                <div class="w-full px-3 mt-4">
                                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded" type="submit" :disabled="form.processing">Submit</button>
                                </div>
                        </div>
                        <div class="flex flex-wrap -mx-3 mb-6">
                            <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                                {{ form.progress.percentage }}%
                            </progress>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { router } from '@inertiajs/vue3'
import {initFlowbite, Modal} from 'flowbite'
export default {
    mounted() {
        initFlowbite();
        this.deleteModal = new Modal(document.getElementById('delete-role-modal'), this.options);
        this.addModal = new Modal(document.getElementById('add-role-modal'), this.options);
        this.getRoles('');
    },
    watch: {
        searchString: function(newVal, oldVal) {
            this.getRoles('');
        },
    },
    data(){
        return {
            rolesWithPermissions: {},
            permissions: {},
            options : {
                placement: 'center',
                backdrop: 'dynamic',
                backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
                closable: true,
                onHide: () => {
                    console.log('modal is hidden');
                },
                onShow: () => {
                    console.log('modal is shown');
                },
                onToggle: () => {
                    console.log('modal has been toggled');
                }
            },
            deleteModal: null,
            form: {
                role: '',
                permissions: []
            },
            formErrors: null,
            deleteRoleId: null,
            baseURL: this.$page.props.baseUrl,
            searchString: '',
        }
    },
    methods: {
        getRoles(url) {
            if(url === ''){
                axios.get(this.baseURL+'/get-roles', {params: {searchString:  this.searchString}})
                    .then(response => {
                        console.log(response);
                        if(response.data){
                            this.rolesWithPermissions = response.data.rolesWithPermissions;
                            this.permissions = response.data.permissions;
                        }

                    })
            }
            axios.get(url, {params: {searchString:  this.searchString}})
                .then(response => {
                    if(response.data.success){
                        this.rolesWithPermissions = response.data.rolesWithPermissions;
                        this.permissions = response.data.permissions;
                    }
                })
        },
        submit(){
            axios.post(this.baseURL+'/add-role', {role: this.form.role, permissions: this.form.permissions})
                .then(response => {
                    if(response.data.success){
                        router.reload({ only: ['rolesWithPermissions', 'permissions'] })
                    }
                    if(response.data.errors){
                        this.addModal.show();
                        this.formErrors = response.data.errors;
                    }
                })
        },
        deleteRole(roleId){
            this.deleteModal.show();
            this.deleteRoleId = roleId;
        },
        showAddRoleModal(){
            this.addModal.show();
        },
        confirmDelete(){
            axios.post(this.baseURL+'/delete-role/'+this.deleteRoleId, {id: this.deleteRoleId})
                .then(response => {
                    if(response.data.success){
                        router.reload({ only: ['rolesWithPermissions', 'permissions'] })
                    }
                })
            if(this.deleteModal.isVisible()){
                this.deleteModal.hide();
            }
        },
        hideModal(){
            this.deleteModal.hide();
        },
        hideAddModal(){
            this.addModal.hide();
        },
        showPermissions(permissions){
            let result = permissions.map(({ name }) => name)
            return result.toString();
        }
    }
}

</script>
