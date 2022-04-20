<template>
  <CustomerForm>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.customers.create') }}</h3>
    </template>
  </CustomerForm>
</template>

<script>
import CustomerForm from "./CustomerForm";
import {onMounted} from "vue";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";

export default {
  name: 'CustomerCreate',
  components: {CustomerForm},
  setup(){
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'customers', route: "admin.customers"},
        {title: 'messages.customers.create'},
      ])
    })
  }
}
</script>
