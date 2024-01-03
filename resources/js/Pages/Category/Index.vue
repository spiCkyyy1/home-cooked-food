<template>
  <div v-if="$page.props.flash.success" class="alert alert-success">
      {{ $page.props.flash.success }}
  </div>
  <!--  Start Delete Category Modal-->
    <div id="delete-category-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" @click="hideModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this category?</h3>
                    <button @click="confirmDelete" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                        Yes, I'm sure
                    </button>
                    <button @click="hideModal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                </div>
            </div>
        </div>
    </div>
  <!--  End Delete Category Modal-->

  <!-- Start Add Category modal -->
  <div id="add-category-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative w-full max-w-md max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <button type="button" @click="hideAddCategoryModal" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" >
          <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
          </svg>
          <span class="sr-only">Close modal</span>
        </button>
        <div class="px-6 py-6 lg:px-8">
          <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Add Category</h3>
          <form class="space-y-6" @submit.prevent="submit" autocomplete="off">
              <div class="mb-6">
                  <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="name">Name</label>
                  <input v-model="form.name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" id="name" type="text" placeholder="Name">
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500" v-if="errors.name">{{errors.name[0]}}</p>
              </div>
              <div class="mb-6">
                  <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                  <input v-model="form.description" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" id="description" type="text" placeholder="Description">
                  <p class="mt-2 text-sm text-red-600 dark:text-red-500" v-if="errors.description">{{errors.description[0]}}</p>
              </div>
              <div class="mb-6">
                <label for="slug" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Slug</label>
                <input v-model="form.slug" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" id="slug" type="text" placeholder="Slug">
                <p class="mt-2 text-sm text-red-600 dark:text-red-500" v-if="errors.slug">{{errors.slug[0]}}</p>
              </div>
            <button type="submit" :disabled="form.processing" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Add Category</button>
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
  <!-- End Add Category modal -->

  <!--TABLE-->
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
            <button  @click="showAddCategoryModal" type="button" class="px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              Add Category
            </button>
            <!--                        <div class="flex items-center space-x-3 w-full md:w-auto">-->
            <!--                            <button id="actionsDropdownButton" data-dropdown-toggle="actionsDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">-->
            <!--                                <svg class="-ml-1 mr-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">-->
            <!--                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />-->
            <!--                                </svg>-->
            <!--                                Actions-->
            <!--                            </button>-->
            <!--                            <div id="actionsDropdown" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">-->
            <!--                                <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="actionsDropdownButton">-->
            <!--                                    <li>-->
            <!--                                        <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Mass Edit</a>-->
            <!--                                    </li>-->
            <!--                                </ul>-->
            <!--                                <div class="py-1">-->
            <!--                                    <a href="#" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete all</a>-->
            <!--                                </div>-->
            <!--                            </div>-->
            <!--                            <button id="filterDropdownButton" data-dropdown-toggle="filterDropdown" class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700" type="button">-->
            <!--                                <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400" viewbox="0 0 20 20" fill="currentColor">-->
            <!--                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />-->
            <!--                                </svg>-->
            <!--                                Filter-->
            <!--                                <svg class="-mr-1 ml-1.5 w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">-->
            <!--                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />-->
            <!--                                </svg>-->
            <!--                            </button>-->
            <!--                            <div id="filterDropdown" class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700">-->
            <!--                                <h6 class="mb-3 text-sm font-medium text-gray-900 dark:text-white">Choose brand</h6>-->
            <!--                                <ul class="space-y-2 text-sm" aria-labelledby="filterDropdownButton">-->
            <!--                                    <li class="flex items-center">-->
            <!--                                        <input id="apple" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">-->
            <!--                                        <label for="apple" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Apple (56)</label>-->
            <!--                                    </li>-->
            <!--                                    <li class="flex items-center">-->
            <!--                                        <input id="fitbit" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">-->
            <!--                                        <label for="fitbit" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Microsoft (16)</label>-->
            <!--                                    </li>-->
            <!--                                    <li class="flex items-center">-->
            <!--                                        <input id="razor" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">-->
            <!--                                        <label for="razor" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Razor (49)</label>-->
            <!--                                    </li>-->
            <!--                                    <li class="flex items-center">-->
            <!--                                        <input id="nikon" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">-->
            <!--                                        <label for="nikon" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nikon (12)</label>-->
            <!--                                    </li>-->
            <!--                                    <li class="flex items-center">-->
            <!--                                        <input id="benq" type="checkbox" value="" class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">-->
            <!--                                        <label for="benq" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">BenQ (74)</label>-->
            <!--                                    </li>-->
            <!--                                </ul>-->
            <!--                            </div>-->
            <!--                        </div>-->
          </div>
        </div>
        <div class="overflow-x-auto" v-if="showTable">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-4 py-3">ID</th>
              <th scope="col" class="px-4 py-3">Category Name</th>
              <th scope="col" class="px-4 py-3">Description</th>
              <th scope="col" class="px-4 py-3">Slug</th>
              <th scope="col" class="px-4 py-3">
                <span >Actions</span>
              </th>
            </tr>
            </thead>
            <tbody>
            <tr class="border-b dark:border-gray-700" v-for="data in categories.data">
              <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ data.id }}
              </th>
              <td class="px-4 py-3">{{ capitalizeFirstLetter(data.name) }}</td>
              <td class="px-4 py-3">{{ data.description }}</td>
              <td class="px-4 py-3">{{ data.slug }}</td>
              <td class="px-4 py-3 flex">
                <a href="#" class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                  </svg>
                  Edit
                </a>
                <a @click="deleteCategory(data.id)" href="javascript:;" class="block py-2 px-4 text-sm text-red-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-red-200 dark:hover:text-white">
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
              <h1 class="ml-8">Sorry, categories not found.</h1>
          </div>
        <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" v-if="showTable" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing
                    <span class="font-semibold text-gray-900 dark:text-white">{{categories.current_page}}-{{categories.per_page}}</span>
                    of
                    <span class="font-semibold text-gray-900 dark:text-white">{{ categories.total }}</span>
                </span>
          <ul class="inline-flex items-stretch -space-x-px">
            <li v-for="pagination in categories.links">
              <!--                          :href="pagination.url"-->
              <a href="javascript:;"
                 @click="getCategories(pagination.url)"
                 :class="{ 'bg-red-700 text-white':  pagination.active, 'disabled:bg-slate-50 disabled:text-slate-500 disabled:border-slate-200 disabled:shadow-none disabled:pointer-events-none disabled:cursor-default disabled:opacity-75': pagination.url == null }"
                 class="flex items-center justify-center text-sm py-2 px-3 leading-tight
                               text-gray-500 bg-white border border-gray-300
                               dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700
                               dark:hover:text-white" v-html="pagination.label"></a>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </section>
  <!--  END TABLE-->

</template>
<script>
import axios from "axios";
import {initFlowbite, Modal} from 'flowbite'
import capitalizeFirstLetter from "@/mixin.js";
export default {
  mixins: [capitalizeFirstLetter],
  mounted() {
      this.getCategories('');
      initFlowbite();
      this.deleteModal = new Modal(document.getElementById('delete-category-modal'), this.options);
      this.addModal = new Modal(document.getElementById('add-category-modal'), this.options);
  },
  watch: {
    'form.name'(newVal, oldVal){
        if(newVal != null){
            this.form.slug = newVal.replace(/ +/g, '-').toLowerCase();
        }
    },
    searchString(newVal, oldVal){
      this.getCategories('');
    },
  },
  computed: {
    showTable(newVal, oldVal){
      if(this.categoriesCount > 0)
      {
        return true;
      }
    }
  },
  data(){
      return {
          categories: {},
          categoriesCount: 0,
          searchString: '',
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
          addModal: null,
          form: {
              name: '',
              description: '',
              slug: ''
          },
          errors: [],
          deleteCategoryId: null,
          baseURL: this.$page.props.baseUrl
      }
  },
  methods: {
    showAddCategoryModal(){
      this.addModal.show();
    },
    hideAddCategoryModal(){
      this.addModal.hide();
    },
    getCategories(url){
      if(url === ''){
        axios.get(this.baseURL+'/categories/get', {params: {searchString: this.searchString}})
            .then(response => {
              if(response.data.success){
                this.categories = response.data.success;
                this.categoriesCount = response.data.count;
              }
              if(response.data.errors){
                this.errors = response.data.errors;
              }
            })
      }
      axios.get(url, {params: {searchString: this.searchString}})
          .then(response => {
            if(response.data.success){
              this.categories = response.data.success;
              this.categoriesCount = response.data.count;
            }
            if(response.data.errors){
              this.errors = response.data.errors;
            }
          })
    },
      submit(){
          axios.post(this.baseURL+'/categories/add', this.form)
              .then(response => {
                  if(response.data.success){
                      this.getCategories('');
                      this.hideAddCategoryModal();
                      this.resetForm();
                  }
                if(response.data.errors){
                  this.errors = response.data.errors;
                }
              })
      },
      deleteCategory(categoryId){
          this.deleteModal.show();
          this.deleteCategoryId = categoryId;

      },
      confirmDelete(){
          axios.post(this.baseURL+'/categories/delete-category/'+this.deleteCategoryId)
              .then(response => {
                  if(response.data.success){
                    this.getCategories('');
                  }
              })
          if(this.deleteModal.isVisible()){
              this.deleteModal.hide();
          }
      },
      hideModal(){
          this.deleteModal.hide();
      },
    resetForm(){
      this.form = {
        name: '',
        description: '',
        slug: ''
      };
      this.errors = [];
    }
  }
}

</script>
