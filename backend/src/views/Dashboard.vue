<template>
  <div class="mb-2 flex items-center justify-between">
    <h1 class="text-3xl font-semibold">Dashboard</h1>
    <div class="flex items-center">
      <label class="mr-2">Change Date Period</label>
      <CustomInput type="select" v-model="chosenDate" @change="onDatePickerChange" :select-options="dateOptions"/>
    </div>
  </div>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
    <!--    Active Customers-->
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
      <label class="text-lg font-semibold block mb-2">Active USers</label>
      <template v-if="!loading.usersCount">
        <span class="text-3xl font-semibold">{{ usersCount }}</span>
      </template>
      <Spinner v-else text="" class=""/>
    </div>
    <!--/    Active Customers-->
    <!--    Active Posts -->
    <div class="animate-fade-in-down bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center"
         style="animation-delay: 0.1s">
      <label class="text-lg font-semibold block mb-2">Active Posts</label>
      <template v-if="!loading.postsCount">
        <span class="text-3xl font-semibold">{{ postsCount }}</span>
      </template>
      <Spinner v-else text="" class=""/>
    </div>
  </div>

</template>

<script setup>
import {UserIcon} from '@heroicons/vue/outline'
import DoughnutChart from '../components/core/Charts/Doughnut.vue'
import axiosClient from "../axios.js";
import {computed, onMounted, ref} from "vue";
import Spinner from "../components/core/Spinner.vue";
import CustomInput from "../components/core/CustomInput.vue";
import {useStore} from "vuex";

const store = useStore();
const dateOptions = computed(() => store.state.dateOptions);
const chosenDate = ref('all')

const loading = ref({
  usersCount: true,
  postsCount: true,
})
const usersCount = ref(0);
const postsCount = ref(0);

function updateDashboard() {
  const d = chosenDate.value
  loading.value = {
    usersCount: true,
    postsCount: true,
   
  }
  axiosClient.get(`/dashboard/users-count`, {params: {d}}).then(({data}) => {
    usersCount.value = data
    loading.value.usersCount = false;
  })
  axiosClient.get(`/dashboard/posts-count`, {params: {d}}).then(({data}) => {
    postsCount.value = data;
    loading.value.postsCount = false;
  })





}

function onDatePickerChange() {
  updateDashboard()
}

onMounted(() => updateDashboard())

</script>

<style scoped>

</style>
