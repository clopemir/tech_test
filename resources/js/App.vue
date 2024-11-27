<script setup>

import { ref, onMounted, reactive } from 'vue'
import axios from 'axios'
import { TransitionRoot, TransitionChild, Dialog, DialogPanel, DialogTitle } from '@headlessui/vue'
import { Bars3Icon, XMarkIcon } from '@heroicons/vue/24/outline'

    let isOpen = ref(false)
    let openPostModal = ref(false)
    let isEdit = ref(false)

  function closeModal() {
      isOpen.value = false
      isEdit.value = false
      openPostModal.value = false
      Object.keys(formData.value).forEach(key => {
        formData.value[key] = '';
    });
  }
  function openModal() {
      isOpen.value = true
      openPostModal.value = true
  }

  const posts = ref([])
  const post = ref([])



  onMounted(() => {
    axios('/posts')
        .then(({data}) => posts.value = data)
        .catch(error => console.log('Error'))
  })

  const formData = ref({

    })


    const showPost = (postId) => {
        openPostModal.value = true
        axios(`/posts/${postId}`)
        .then(({data}) => post.value = data)
        .catch(error => console.log('Error'))
    }

  const createPost = () => {

    axios.post('/create-post', formData.value)
        .then(resp => {

            setTimeout(() => {
                axios('/posts')
                    .then(({data}) => posts.value = data)
                    .catch(error => console.log('Error'))
                closeModal()

            }, 500);

        })
        .catch(e => console.log(e))
  }

const showEditPost = (postId) => {
isOpen.value = true
isEdit.value = true
axios(`/posts/${postId}`)
        .then(({data}) => {
            Object.assign(formData.value, data)
        })
        .catch(error => console.log('Error'))

}

const editPost = (postId) => {

    axios.put(`/posts/${postId}`,formData.value)
    .then(resp => {
        setTimeout(() => {
                axios('/posts')
                    .then(({data}) => posts.value = data)
                    .catch(error => console.log('Error'))
                closeModal()

            }, 500);
    })
    .catch(e => console.log(e))
}

const deletePost = (postId) => {

axios.delete(`/posts/${postId}`)
.then(resp => {
    axios('/posts')
        .then(({data}) => posts.value = data)
        .catch(error => console.log('Error'))
    console.log(resp.data)
})
.catch(e => console.log(e))
}



  const addComment = (postId) => {
    axios.post(`/posts/${postId}/comments`, formData.value)
        .then(resp => {
            console.log(resp.data)
            setTimeout(() => {
                axios(`/posts/${postId}`)
                    .then(({data}) => {
                        post.value = data
                        formData.value.comment = ''
                    })
                    .catch(error => console.log('Error'))
            }, 200);
        })
        .catch(e => console.log(e))
  }

</script>

<template>
    <div >


      <div>

            <div class="mx-auto max-w-5xl py-16 sm:py-24 lg:py-32">

            <div v-if="posts.length < 1" class="text-center">
                <h1 class="text-balance text-5xl font-semibold tracking-tight dark:text-white text-gray-900 sm:text-7xl">Posts & Comments</h1>
                <p class="mt-8 text-pretty text-lg font-medium text-gray-600 dark:text-gray-200 sm:text-xl/8">Technical test.</p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <button @click="isOpen = true" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Crear Nuevo</button>
                </div>

            </div>
            <div v-else class="mt-4">
                <div class="flex items-center justify-center mb-6">
                    <button @click="isOpen = true" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Crear Nuevo</button>
                </div>
                <div class="mx-auto grid max-w-5xl gap-5 px-6 lg:px-8 xl:grid-cols-3">
                    <div class="max-w-xl">
                        <h2 class="text-pretty text-3xl font-semibold tracking-tight dark:text-gray-300 text-gray-900 sm:text-4xl">All Posts</h2>
                    </div>
                    <ul role="list" class="grid gap-x-8 gap-y-12 sm:grid-cols-3 grid-cols-2 sm:gap-y-16 xl:col-span-2">
                        <li v-for="post in posts" :key="post.id">
                            <div class="flex items-center gap-x-2 text-center">
                                <div class="flex justify-between gap-2 text-center items-center">

                                    <a @click="showPost(post.id)" class="text-base/7 font-semibold tracking-tight dark:text-white text-gray-900 cursor-pointer">{{ post.post_name }}</a>

                                        <button @click="showEditPost(post.id)" :key="post.id" class="rounded-md bg-indigo-600 p-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Editar</button>
                                        <button @click="deletePost(post.id)" :key="post.id" class="rounded-md bg-red-500 p-1.5 text-sm font-semibold text-white shadow-sm hover:bg-red-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Borrar</button>

                                </div>
                            </div>
                        </li>
                    </ul>
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
                        {{ isEdit ? 'Editar Registro' : 'Crear Nuevo' }}
                        </DialogTitle>
                        <div class="mt-2">
                            <form @submit.prevent="isEdit ? editPost(formData.id) : createPost()">
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
                                    {{ isEdit ? 'Editar' : 'Crear' }}
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


            <TransitionRoot appear :show="openPostModal" as="template">
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
                        <DialogPanel v-if="post"
                        class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                        >
                        <DialogTitle
                            as="h3"
                            class="text-lg font-medium leading-6 text-gray-900"
                        >
                        Detalle del Post
                        </DialogTitle>

                        <div class="mt-2">
                            <h1 class="text-balance text-2xl mt-5 font-semibold tracking-tight text-slate-800 dark:text-gray-900 sm:text-4xl">{{ post.post_name }}</h1>

                            <p class="mt-2 mb-4 text-pretty text-lg font-medium dark:text-gray-600 text-slate-800 sm:text-xl/8">{{ post.post_desc }}</p>

                            <div v-if="post.comments ? post.comments.length > 0 : false">
                                <p class="dark:text-slate-900">Comentarios:</p>
                                <ul class="bg-slate-200 rounded-lg p-2">
                                <li v-for="comment in post.comments" :key="comment.id" class="mb-2 text-slate-800 dark:text-slate-700">
                                    - {{ comment.comment }}
                                </li>
                                </ul>
                            </div>

                            <form @submit.prevent="addComment(post.id)">

                                <div class="sm:col-span-3">
                                    <label for="post_desc" class="block text-sm/6 font-medium text-gray-900">Agrega un comentario:</label>
                                    <div class="mt-2">
                                    <textarea rows="3" id="comment" v-model="formData.comment" autocomplete="given-desc" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm/6" />
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button
                                    type="submit"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    >
                                    Agregar
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




