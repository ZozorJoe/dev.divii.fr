<template>
  <SpecialityFrom>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.products.create') }}</h3>
    </template>
  </SpecialityFrom>
</template>

<script>
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module"
import {useStore} from "vuex";
import {onMounted} from "vue";
import SpecialityFrom from "./ProductForm";

export default {
  name: 'ProductCreate',
  components: {SpecialityFrom},
  setup() {
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'products', route: "admin.products"},
        {title: 'messages.products.create'},
      ])
    })

  }
}
</script>
