<!-- This example requires Tailwind CSS v2.0+ -->
<template>
  <div class="flex items-center justify-between mb-3">
    <h1 v-if="!loading" class="text-3xl font-semibold">
      {{ posts.id ? `Update posts: "${posts.title}"` : 'Create new Post' }}
    </h1>
  </div>
  <div class="bg-white rounded-lg shadow animate-fade-in-down">
    <Spinner v-if="loading"
             class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center z-50"/>
    <form v-if="!loading" @submit.prevent="onSubmit">
      <div class="grid grid-cols-3">
        <div class="col-span-2 px-4 pt-5 pb-4">
          <CustomInput class="mb-2" v-model="posts.title" label="Post Title" :errors="errors['title']"/>
          <CustomInput type="richtext" class="mb-2" v-model="posts.description" label="Description" :errors="errors['description']"/>
          <CustomInput type="checkbox" class="mb-2" v-model="posts.published" label="Published" :errors="errors['published']"/>
        </div>
        <div class="col-span-1 px-4 pt-5 pb-4">
          <image-preview v-model="posts.images"
                         :images="posts.images"
                         v-model:deleted-images="posts.deleted_images"
                         v-model:image-positions="posts.image_positions"/>
        </div>
      </div>
      <footer class="bg-gray-50 rounded-b-lg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="submit"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                          text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
          Save
        </button>
        <button type="button"
                @click="onSubmit($event, true)"
                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                          text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
          Save & Close
        </button>
        <router-link :to="{name: 'app.posts'}"
                     class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                     ref="cancelButtonRef">
          Cancel
        </router-link>
      </footer>
    </form>
  </div>
</template>

<script setup>
import {onMounted, ref} from 'vue'
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";
import {useRoute, useRouter} from "vue-router";
import ImagePreview from "../../components/ImagePreview.vue";
// import the component
import Treeselect from 'vue3-treeselect'
// import the styles
import 'vue3-treeselect/dist/vue3-treeselect.css'
import axiosClient from "../../axios.js";

const route = useRoute()
const router = useRouter()

const posts = ref({
  id: null,
  title: null,
  images: [],
  deleted_images: [],
  image_positions: {},
  description: '',
  published: false,
})

const errors = ref({});

const loading = ref(false)
const options = ref([])

const emit = defineEmits(['update:modelValue', 'close'])

onMounted(() => {
  if (route.params.id) {
    loading.value = true
    store.dispatch('getPosts', route.params.id)
      .then((response) => {
        loading.value = false;
        posts.value = response.data
      })
  }

})

function onSubmit($event, close = false) {
  loading.value = true
  errors.value = {};
  posts.value.quantity = posts.value.quantity || null
  if (posts.value.id) {
    store.dispatch('updatePosts', posts.value)
      .then(response => {
        loading.value = false;
        if (response.status === 200) {
          posts.value = response.data
          store.commit('showToast', 'Post was successfully updated');
          store.dispatch('getPosts')
          if (close) {
            router.push({name: 'app.posts'})
          }
        }
      })
      .catch(err => {
        loading.value = false;
        errors.value = err.response.data.errors
      })
  } else {
    store.dispatch('createPost', posts.value)
      .then(response => {
        loading.value = false;
        if (response.status === 201) {
          posts.value = response.data
          store.commit('showToast', 'Post was successfully created');
          store.dispatch('getPosts')
          if (close) {
            router.push({name: 'app.'})
          } else {
            posts.value = response.data
            router.push({name: 'app.posts.edit', params: {id: response.data.id}})
          }
        }
      })
      .catch(err => {
        loading.value = false;
        errors.value = err.response.data.errors
      })
  }
}
</script>
