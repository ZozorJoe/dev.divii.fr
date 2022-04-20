<template>
  <VoucherForm>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.vouchers.edit') }}</h3>
    </template>
  </VoucherForm>
</template>

<script>
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module"
import {useStore} from "vuex";
import {onMounted} from "vue";
import VoucherForm from "./VoucherForm";

export default {
  name: 'VoucherEdit',
  components: {VoucherForm},
  setup() {
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'vouchers', route: "admin.vouchers"},
        {title: 'messages.vouchers.edit'},
      ])
    })

  }
}
</script>
