<template>
  <CouponForm>
    <template v-slot:title>
      <h3 class="fw-bolder m-0">{{ $t('messages.coupons.edit') }}</h3>
    </template>
  </CouponForm>
</template>

<script>
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module"
import {useStore} from "vuex";
import {onMounted} from "vue";
import CouponForm from "./CouponForm";

export default {
  name: 'CouponEdit',
  components: {CouponForm},
  setup() {
    const store = useStore()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'coupons', route: "admin.coupons"},
        {title: 'messages.coupons.edit'},
      ])
    })

  }
}
</script>
