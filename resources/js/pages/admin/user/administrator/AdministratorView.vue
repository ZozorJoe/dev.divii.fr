<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Button-->
      <router-link :to="{name: 'admin.administrators'}" class="btn btn-sm btn-active-primary me-2">{{  $t('list') }}</router-link>
      <router-link :to="{name: 'admin.administrators.edit'}" class="btn btn-sm btn-primary">{{  $t('edit') }}</router-link>
      <!--end::Button-->
    </KtToolbar>

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">

        <div class="card mb-5 mb-xl-10">
          <!--begin::Card header-->
          <div class="card-header border-0 cursor-pointer">
            <!--begin::Card title-->
            <div class="card-title m-0">
              <h3 class="fw-bolder m-0">{{ $t('messages.administrators.view') }}</h3>
            </div>
            <!--end::Card title-->
          </div>
          <!--begin::Card header-->

          <!--begin::Card body-->
          <div class="card-body border-top p-9">

            <!--begin::Input group-->
            <div class="row mb-6">
              <!--begin::Label-->
              <label class="col-xl-2 col-lg-4 fw-bold fs-6">{{ $t('image') }}</label>
              <!--end::Label-->
              <!--begin::Col-->
              <div class="col-xl-10 col-lg-8">
                <div class="symbol symbol-100px">
                  <img :src="`/u/image-${model.id}.jpg`" alt="image">
                </div>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-6">
              <!--begin::Label-->
              <label class="col-xl-2 col-lg-4 fw-bold fs-6">{{ $t('name') }}</label>
              <!--end::Label-->
              <!--begin::Col-->
              <div class="col-xl-10 col-lg-8 fv-row">
                <span>{{ model.name }}</span>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row mb-6">
              <!--begin::Label-->
              <label class="col-xl-2 col-lg-4 fw-bold fs-6">{{ $t('email') }}</label>
              <!--end::Label-->
              <!--begin::Col-->
              <div class="col-xl-10 col-lg-8 fv-row">
                <div v-html="model.email"></div>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Input group-->

          </div>
          <!--end::Card body-->
        </div>

      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import ApiService from "../../../../services/api.service";
import {useStore} from "vuex";
import {computed, onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router";
import {useI18n} from "vue-i18n";
import {SET_BREADCRUMB} from "../../../../services/store/breadcrumbs.module";

export default {
  name: 'AdministratorView',
  setup(){
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "admin.dashboard"},
        {title: 'administrators', route: "admin.administrators"},
        {title: 'messages.administrators.view'},
      ])
    })

    const model = ref(null)
    const id = ref(route.params.id)
    const init = () => {
      model.value = null
      loadModel(id.value)
    }
    const loadModel = (value) => {
      if(!value){ return; }
      const params = {params:{with:''}}
      ApiService.show('/admin/administrators/' + value, params, t('administrator'), initModel, store, t)
    }
    watch(() => id.value, () => { init() })
    onMounted(init)

    const initModel = (value) => {
      model.value = value
    }

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { init() })

    return {
      model,
    }
  }
}
</script>
