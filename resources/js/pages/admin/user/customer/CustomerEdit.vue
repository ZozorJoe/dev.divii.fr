<template>
  <CustomerForm>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.customers.edit') }}</h3>
    </template>
  </CustomerForm>
</template>

<script>
import CustomerForm from "./CustomerForm";
import {onMounted} from "vue";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";
import {useRoute} from "vue-router";

export default {
  name: 'CustomerEdit',
  components: {CustomerForm},
  setup(){
    const store = useStore()
    const route = useRoute()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'customers', route: "admin.customers"},
        {title: 'messages.customers.view', route: {name: "admin.customers.view", params: {id: route.params.id }}},
        {title: 'messages.customers.edit'},
      ])
    })
  }
}
</script>
