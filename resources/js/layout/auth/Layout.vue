<template>
  <div class="d-flex flex-column flex-root canela-regular">

    <!--begin::Authentication -->
    <div class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">

      <!--begin::Content-->
      <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">

        <!--begin::Logo-->
        <a href="/" class="mb-12">
          <img alt="Logo" src="/img/logo-dark.svg" class="h-40px">
        </a>
        <!--end::Logo-->

        <router-view/>

      </div>
      <!--end::Content-->

    </div>
    <!--end::Authentication-->
  </div>
</template>

<script>
import {onMounted} from "vue";
export default {
  name: "KtLayout",
  setup(){
    onMounted(() => {
      $('body').attr('class', 'bg-front')
    })
  }
};
</script>
