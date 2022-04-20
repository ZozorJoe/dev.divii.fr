<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Button-->
      <a href="/calendar" class="btn btn-sm btn-primary me-2">Commander une formation</a>
      <!--end::Button-->
      <!--begin::Button-->
      <a href="/experts" class="btn btn-sm btn-primary">Commander une consultation</a>
      <!--end::Button-->
    </KtToolbar>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">
          <!--begin::Row-->
          <div class="row g-5 g-xl-10 mb-xl-10">
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-md-5 mb-xl-10">
              <div class="card card-flush mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                  <!--begin::Title-->
                  <div class="card-title d-flex flex-column">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center">
                      <!--begin::Amount-->
                      <span class="fs-2hx fw-bolder text-dark me-2 lh-1 ls-n2">{{ model.count.consultations }}</span>
                      <!--end::Amount-->
                    </div>
                    <!--end::Info-->
                    <!--begin::Subtitle-->
                    <span class="text-gray-400 pt-1 fw-bold fs-3">Nombre des consultations</span>
                    <!--end::Subtitle-->
                  </div>
                  <!--end::Title-->
                </div>
                <!--end::Header-->
              </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 col-xxl-4 mb-md-5 mb-xl-10">
              <div class="card card-flush mb-xl-10">
                <!--begin::Header-->
                <div class="card-header pt-5">
                  <!--begin::Title-->
                  <div class="card-title d-flex flex-column">
                    <!--begin::Info-->
                    <div class="d-flex align-items-center">
                      <!--begin::Amount-->
                      <span class="fs-2hx fw-bolder text-dark me-2 lh-1 ls-n2">{{ model.count.formations }}</span>
                      <!--end::Amount-->
                    </div>
                    <!--end::Info-->
                    <!--begin::Subtitle-->
                    <span class="text-gray-400 pt-1 fw-bold fs-3">Nombre des formations</span>
                    <!--end::Subtitle-->
                  </div>
                  <!--end::Title-->
                </div>
                <!--end::Header-->
              </div>
            </div>
          </div>
          <!--end::Row-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import {computed, onMounted, ref, watch} from "vue";
import {SET_BREADCRUMB} from "../../../services/store/breadcrumbs.module";
import {useStore} from "vuex";
import ApiService from "../../../services/api.service";

export default {
  name: 'Dashboard',
  setup(){
    const store = useStore()
    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard'},
      ])
    })

    const loading = ref(false)
    const model = ref(null)
    const loadModel = () => {
      loading.value = true
      ApiService.get('/customer/account/dashboard')
        .then(({data}) => {
          if(data.success){
            model.value = data.data
          }
        })
        .finally(() => {
          loading.value = false
        })
    }
    onMounted(loadModel)

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { loadModel() })

    return {
      model,
      loading,
    }
  }
}
</script>
