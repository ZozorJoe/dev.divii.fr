<template>
  <!--begin::Content-->
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar></KtToolbar>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">

      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import {SET_BREADCRUMB} from "../../../services/store/breadcrumbs.module";
import {onMounted} from "vue";
import {useStore} from "vuex";

export default {
  name: 'AdminDashboard',
  setup(){
    const store = useStore()
    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard'},
      ])
    })
  }
}
</script>
