<script setup>

import { ref, onMounted } from 'vue'
import axios from 'axios'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle, } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

  const isOpen = ref(false)

  function closeModal() {
      isOpen.value = false
  }
  function openModal() {
      isOpen.value = true
  }

  const posts = ref([])

  onMounted(() => {
    axios('/posts')
        .then(({data}) => posts.value = data)
        .catch(error => console.log('Error'))
  })

  const formData = ref({
        post_name: '',
        post_desc: '',
    })
  const createPost = () => {

    axios.post('/create-post', formData.value)
        .then(resp => console.log(resp.data))
        .catch(e => console.log(e))
  }


</script>

<template>
    <div >


      <div>

        <div class="mx-auto max-w-2xl py-32 sm:py-48 lg:py-56">

          <div class="text-center">
            <h1 class="text-balance text-5xl font-semibold tracking-tight dark:text-white text-gray-900 sm:text-7xl">Posts & Comments</h1>
            <p class="mt-8 text-pretty text-lg font-medium text-gray-600 dark:text-gray-200 sm:text-xl/8">Technical test.</p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
              <button @click="isOpen = true" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Crear Nuevo</button>
            </div>
          </div>

          <TransitionRoot appear :show="isOpen" as="template">
            <Dialog as="div" @close="closeModal" class="relative z-10">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div
                class="flex min-h-full items-center justify-center p-4 text-center"
                >
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95"
                >
                    <DialogPanel
                    class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                    >
                    <DialogTitle
                        as="h3"
                        class="text-lg font-medium leading-6 text-gray-900"
                    >
                        Crear Nuevo
                    </DialogTitle>
                    <div class="mt-2">
                        <form @submit.prevent="createPost">
                            <div class="sm:col-span-3">
                                <label for="post_name" class="block text-sm/6 font-medium text-gray-900">Nombre para el Post</label>
                                <div class="mt-2">
                                <input type="text" v-model="formData.post_name" id="post_name" autocomplete="given-name" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="post_desc" class="block text-sm/6 font-medium text-gray-900">Contenido</label>
                                <div class="mt-2">
                                <textarea rows="3" v-model="formData.post_desc" id="post_desc" autocomplete="given-desc" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6" />
                                </div>
                            </div>
                            <div class="mt-4">
                                <button
                                type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                >
                                Crear
                                </button>
                            </div>
                        </form>
                    </div>


                    </DialogPanel>
                </TransitionChild>
                </div>
            </div>
            </Dialog>
        </TransitionRoot>
        </div>

      </div>
    </div>
  </template>




