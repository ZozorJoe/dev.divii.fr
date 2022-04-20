<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
      <router-link :to="{name: 'expert.dashboard'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
      <button form="form" type="submit" class="btn btn-sm btn-primary">{{ $t('send') }}</button>
      <!--end::Buttons-->
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
              <h3 class="fw-bolder m-0">{{ $t('contact') }}</h3>
            </div>
            <!--end::Card title-->
          </div>
          <!--begin::Card header-->

          <!--begin::Form-->
          <form @submit.prevent="submit" id="form" method="post" class="form fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('content') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <textarea name="content" v-model="model.content" class="form-control" rows="10" />
                  <BaseError name="content"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <router-link :to="{name: 'expert.dashboard'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
              <button form="form" type="submit" class="btn btn-sm btn-primary">{{ $t('send') }}</button>
            </div>
            <!--end::Actions-->

          </form>
          <!--end::Form-->
        </div>

      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import {useStore} from "vuex";
import {computed, onMounted, ref, watch} from "vue";
import useVuelidate from "@vuelidate/core";
import {useRoute} from "vue-router";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import {useI18n} from "vue-i18n";
import ApiService from "../../../services/api.service";
import {SET_BREADCRUMB} from "../../../services/store/breadcrumbs.module";

export default {
  name: 'ContactFrom',
  setup(){
    const route = useRoute()
    const store = useStore()
    const v$ = useVuelidate()
    const { t } = useI18n()

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      create();
    }

    const create = () => {
      ApiService.store('/expert/contact', model.value, t('contact'), initModel, store, t)
    }

    const initModel = (value) => {
      if(!value){
        model.value = Object.assign({}, initialModel);
        return;
      }

      let newValue = {}
      newValue.content = value.content
      model.value = Object.assign({}, newValue);
    }

    const id = ref(route.params.id)
    const initialModel = {
      content: '',
    }
    const model = ref(null)
    const init = () => {
      initModel()
    }
    watch(() => id.value, () => { init() })
    onMounted(init)

    onMounted(() => {
      store.dispatch(SET_BREADCRUMB, [
        {title: 'dashboard', route: "expert.dashboard"},
        {title: 'contact'},
      ])
    })

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { init() })

    return {
      v$,
      model,
      submit,
      editor:{
        editor: ClassicEditor,
        editorConfig: {
          // The configuration of the editor.
        }
      }
    }
  }
}
</script>
