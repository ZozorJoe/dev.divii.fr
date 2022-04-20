<template>
  <div class="row">
    <div class="col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start">
      <label>
        <select v-model="per_page" @change="$emit('change-per-page', $event.target.value)" class="form-select form-select-sm form-select-solid">
          <option :value="10">10</option>
          <option :value="25">25</option>
          <option :value="50">50</option>
          <option :value="100">100</option>
        </select>
      </label>
    </div>
    <div class="col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end">
      <ul class="pagination">
        <li class="page-item previous" :class="{'disabled' : current_page === 1}">
          <a href="#" @click="prevPage" class="page-link"><i class="previous"></i></a>
        </li>

        <li
            class="page-item"
            v-for="item in pages"
            :key="item"
            :class="{ 'active': current_page === item }"
            @click="changePage(item)"
        >
          <a href="#" :tabindex="1000 + item" class="page-link">{{ item }}</a>
        </li>

        <li class="page-item next" :class="{'disabled': last_page === current_page}">
          <a href="#" @click="nextPage" tabindex="0" class="page-link"><i class="next"></i></a>
        </li>
      </ul>
    </div>
  </div>
</template>
<script>
import {computed} from "vue";

export default {
  name: "Pagination",
  props:['meta'],
  setup(props, { emit }){

    const per_page = computed(() => props.meta ? props.meta.per_page : 25)

    const current_page = computed(() => props.meta ? props.meta.current_page : 1)

    const last_page = computed(() => props.meta ? props.meta.last_page : 1)

    const total = computed(() => props.meta ? props.meta.total : 0)

    const maxItems = 10

    const min_page = computed(() => {
      if (current_page.value >= maxItems) {
        const pagesToAdd = Math.floor(maxItems / 2);
        const newMaxPage = pagesToAdd + current_page.value;
        if (newMaxPage > last_page.value) {
          return last_page.value - maxItems + 1;
        }
        return current_page.value - pagesToAdd;
      }
      return 1
    })

    const max_page = computed(() => {
      if (current_page.value >= maxItems) {
        const pagesToAdd = Math.floor(maxItems / 2);
        const newMaxPage = pagesToAdd + current_page.value;
        if (newMaxPage < last_page.value) {
          return newMaxPage;
        }
        return last_page.value;
      }
      if (last_page.value < maxItems) {
        return last_page.value;
      }
      return maxItems;
    })

    const pages = computed(() => {
      let arr = [];
      for (let i = min_page.value; i <= max_page.value; i++) {
        arr.push(i);
      }
      return arr;
    })

    const changePage = (page) => {
      current_page.value = page
      emit("update:modelValue", page);
    }

    const prevPage = () => {
      if (current_page.value > 1) {
        changePage(current_page.value - 1);
      }
    }

    const nextPage = () => {
      if (current_page.value < last_page.value) {
        changePage(current_page.value + 1);
      }
    }

    return {
      per_page,
      current_page,
      last_page,
      total,
      pages,
      changePage,
      prevPage,
      nextPage,
    }
  },
};
</script>
<style></style>
