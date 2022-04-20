<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
      <router-link :to="{name: 'admin.coupons'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('active') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input" name="active" type="checkbox" v-model="model.active">
                    <span class="form-check-label fw-bold text-muted">{{ $t('active') }}</span>
                  </label>
                  <BaseError name="active" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('coupon') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <BaseInput name="name" :placeholder="$t('messages.enter.coupon')" v-model="model.name" :rules="{}" />
                  <BaseError name="name"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('reduction') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <BaseInput type="number" min="0" max="100" name="value" :placeholder="$t('messages.enter.value')" v-model="model.value" :rules="{}" />
                  <BaseError name="value"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('start_at') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputDate
                    v-model="model.start_date"
                    :placeholder="$t('messages.select.date')"
                    class="w-100"
                    name="start_date"
                    :rules="{}"/>
                  <BaseError name="start_date"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('end_at') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputDate
                    v-model="model.end_date"
                    :placeholder="$t('messages.select.date')"
                    class="w-100"
                    name="end_date"
                    :rules="{}"/>
                  <BaseError name="end_date"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <router-link :to="{name: 'admin.coupons'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
import {SET_ERROR, SET_SUCCESS} from "../../../../services/store/form.module";

export default {
  name: 'CouponFrom',
  setup(){
    const route = useRoute()
    const store = useStore()
    const v$ = useVuelidate()
    const { t } = useI18n()

    const getData = () => {
      return model.value;
    }

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      id && id.value ? update() : create();
    }

    const create = () => {
      const data = getData()
      ApiService.store('/admin/coupons', data, t('coupon'), initModel, store, t)
        .then((response) => {
          if(response.data.success) {
            toastr.success("Le code coupon a été bien créé avec succès.")
          }else{
            toastr.error("Une erreur s'est produite. Veuillez réessayer svp!")
          }
        })
    }

    const update = () => {
      const data = getData()
      ApiService.update('/admin/coupons/' + id.value, data, t('coupon'), initModel, store, t)
        .then((response) => {
          if(response.data.success) {
            toastr.success("Le code coupon a été bien mis à jour avec succès.")
          }else{
            toastr.error("Une erreur s'est produite. Veuillez réessayer svp!")
          }
        })
    }

    const loadModel = (value) => {
      if(!value){ return; }
      ApiService.show('/admin/coupons/' + value, {params:{with:'image,picto'}}, t('coupon'), initModel, store, t)
    }

    const initModel = (value) => {
      if(!value){
        model.value = Object.assign({}, initialModel);
        return;
      }

      let newValue = {}
      newValue.type = value.type
      newValue.name = value.name
      newValue.value = value.value
      newValue.active = value.active
      newValue.start_date = value.start_date
      newValue.end_date = value.end_date
      model.value = Object.assign({}, newValue);
    }

    const id = ref(route.params.id)
    const initialModel = {
      type: 'percent',
      name: '',
      value: 20,
      active: true,
      start_date: null,
      end_date: null,
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
