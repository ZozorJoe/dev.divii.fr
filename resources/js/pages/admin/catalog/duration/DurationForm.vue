<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
      <router-link :to="{name: 'admin.durations'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
      <button form="form" type="submit" class="btn btn-sm btn-primary">{{ $t('save') }}</button>
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
              <slot name="title"></slot>
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
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('label') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <BaseInput name="label" :placeholder="$t('messages.enter.label')" v-model="model.label" :rules="{}" />
                  <BaseError name="label"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('credit') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <BaseInput type="number" name="credit" :placeholder="$t('messages.enter.credit')" v-model="model.credit" :rules="{}" />
                  <BaseError name="credit"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('price') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <BaseInput name="price" type="number" min="0" :placeholder="$t('messages.enter.price')" v-model="model.price" :rules="{}" />
                  <BaseError name="price"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('currency') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <BaseInput name="currency" type="text" :placeholder="$t('messages.enter.currency')" v-model="model.currency" :rules="{}" />
                  <BaseError name="currency"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('vat') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <BaseInput name="vat" type="number" min="0" max="100" :placeholder="$t('messages.enter.vat')" v-model="model.vat" :rules="{}" />
                  <BaseError name="vat"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('delay') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row" v-if="delays.length">
                  <InputSelect name="delay" field="id" :placeholder="$t('messages.select.delay')" class="mb-0" v-model="model.delay" :options="delays" :rules="{}" />
                  <BaseError name="delay"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <router-link :to="{name: 'admin.durations'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
              <button form="form" type="submit" class="btn btn-sm btn-primary">{{ $t('save') }}</button>
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
import ApiService from "../../../../services/api.service";
import {useStore} from "vuex";
import {computed, onMounted, ref, watch} from "vue";
import useVuelidate from "@vuelidate/core";
import {useRoute} from "vue-router";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import {useI18n} from "vue-i18n";

export default {
  name: 'DurationFrom',
  setup(){
    const route = useRoute()
    const store = useStore()
    const v$ = useVuelidate()
    const { t } = useI18n()

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      id && id.value ? update() : create();
    }

    const create = () => {
      ApiService.store('/admin/durations', model.value, t('duration'), initModel, store, t)
    }

    const update = () => {
      ApiService.update('/admin/durations/' + id.value, model.value, t('duration'), initModel, store, t)
    }

    const loadModel = (value) => {
      if(!value){ return; }
      const params = null
      ApiService.show('/admin/durations/' + value, params, t('duration'), initModel, store, t)
    }

    const initModel = (value) => {
      if(!value){
        model.value = Object.assign({}, initialModel);
        return;
      }

      let newValue = {}
      newValue.label = value.label
      newValue.credit = value.credit
      newValue.price = value.price
      newValue.currency = value.currency
      newValue.vat = value.vat
      newValue.delay = value.delay
      model.value = Object.assign({}, newValue);
    }

    const id = ref(route.params.id)
    const initialModel = {
      label: '',
      credit: 0,
      price: 0,
      currency: 'EUR',
      vat: 0,
      delay: '',
    }
    const model = ref(null)
    const init = () => {
      if(id.value){
        loadModel(id.value)
      }else{
        initModel()
      }
    }
    watch(() => id.value, () => { init() })
    onMounted(init)

    const delays = ref([
      {id: '+15 minutes'},
      {id: '+30 minutes'},
      {id: '+45 minutes'},
      {id: '+60 minutes'},
    ])

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { init() })

    return {
      v$,
      model,
      delays,
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
