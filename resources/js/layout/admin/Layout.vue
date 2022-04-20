<template>
  <div class="admin">
    <!--begin::loader-->
    <div class="page-loader">
        <span class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Chargement...</span>
        </span>
    </div>
    <!--end::Loader-->

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root">
      <!--begin::Page-->
      <div class="page d-flex flex-row flex-column-fluid">

        <KtAside />

        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

          <KtHeader />

          <router-view />
        </div>
        <!--end::Wrapper-->

      </div>
      <!--end::Page-->
    </div>
    <!--end::Root-->

    <KTChatDrawer />

    <KTScrollTop />

  </div>
</template>

<script>
import KtAside from "./aside/Aside";
import KtHeader from "./header/Header";
import KTScrollTop from "../base/extras/ScrollTop";
import {onMounted, ref, watch} from "vue";
import KTChatDrawer from "../../pages/chat/ChatDrawer";

export default {
  name: "KtLayout",
  components: {KTChatDrawer, KTScrollTop, KtHeader, KtAside},
  setup(){
    const isLoading = ref(false)

    let axiosInterceptor = null

    const enableInterceptor = () => {
      axiosInterceptor = window.axios.interceptors.request.use((config) => {
        isLoading.value = true
        return config
      }, (error) => {
        isLoading.value = false
        return Promise.reject(error)
      })

      axios.interceptors.response
        .use(
          (response) => {
            isLoading.value = false
            return response
          },
          function(error) {
            isLoading.value = false
            return Promise.reject(error)
          })
    }

    const disableInterceptor = () => {
      axios.interceptors.request.eject(axiosInterceptor)
    }

    onMounted(() => {
      const body = $('body')
      body.attr('class', 'page-loading-enabled header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed')
      body.attr('style', '--kt-toolbar-height:55px;--kt-toolbar-height-tablet-and-mobile:55px')
    })

    /*
    onMounted(() => {
      enableInterceptor()
    })
     */

    watch(() => isLoading.value, (value) => {
      const body = $('body')
      if(value){
        body.addClass('page-loading')
      }else{
        body.removeClass('page-loading')
      }
    })
  }
};
</script>
