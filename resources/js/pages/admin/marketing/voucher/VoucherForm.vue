<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
      <router-link :to="{name: 'admin.vouchers'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
              <div class="row">
                <div class="col-4">
                  <!--begin::Input group-->
                  <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-12 col-form-label fw-bold fs-6">{{ $t('image') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-12">
                      <InputImage v-model="image" />

                      <!--begin::Hint-->
                      <div class="form-text">{{ $t('allowed_image_types') }}</div>
                      <!--end::Hint-->
                    </div>
                    <!--end::Col-->
                  </div>
                  <!--end::Input group-->
                </div>
                <div class="col-4">
                  <!--begin::Input group-->
                  <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-12 col-form-label fw-bold fs-6">{{ $t('picto') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-12">
                      <InputImage v-model="picto" />

                      <!--begin::Hint-->
                      <div class="form-text">{{ $t('allowed_image_types') }}</div>
                      <!--end::Hint-->
                    </div>
                    <!--end::Col-->
                  </div>
                  <!--end::Input group-->
                </div>
                <div class="col-4">
                  <!--begin::Input group-->
                  <div class="row mb-6">
                    <!--begin::Label-->
                    <label class="col-12 col-form-label required fw-bold fs-6">{{ $t('background_color') }}</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-12 fv-row">
                      <BaseInput type="color" name="background_color" :placeholder="$t('messages.enter.background_color')" v-model="model.background_color" :rules="{}" />
                      <BaseError name="background_color"/>
                    </div>
                    <!--end::Col-->
                  </div>
                  <!--end::Input group-->
                </div>
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('name') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <BaseInput name="name" :placeholder="$t('messages.enter.name')" v-model="model.name" :rules="{}" />
                  <BaseError name="name"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('description') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <ckeditor v-if="editor.editor" :editor="editor.editor" v-model="model.description" :config="editor.editorConfig" />
                  <BaseError name="description"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('active') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input" name="is_active" type="checkbox" v-model="model.is_active">
                    <span class="form-check-label fw-bold text-muted">{{ $t('active') }}</span>
                  </label>
                  <BaseError name="is_active" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <router-link :to="{name: 'admin.vouchers'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
  name: 'VoucherFrom',
  setup(){
    const route = useRoute()
    const store = useStore()
    const v$ = useVuelidate()
    const { t } = useI18n()

    const image = ref(null)
    const picto = ref(null)

    const getData = () => {
      const data = model.value;
      if(image.value){
        data.image_id = image.value.id
      }else{
        data.image_id = null
      }
      if(picto.value){
        data.picto_id = picto.value.id
      }else{
        data.picto_id = null
      }

      return data;
    }

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      id && id.value ? update() : create();
    }

    const create = () => {
      const data = getData()
      ApiService.store('/admin/vouchers', data, t('voucher'), initModel, store, t)
    }

    const update = () => {
      const data = getData()
      ApiService.update('/admin/vouchers/' + id.value, data, t('voucher'), initModel, store, t)
    }

    const loadModel = (value) => {
      if(!value){ return; }
      ApiService.show('/admin/vouchers/' + value, {params:{with:'image,picto'}}, t('voucher'), initModel, store, t)
    }

    const initModel = (value) => {
      if(!value){
        model.value = Object.assign({}, initialModel);
        return;
      }

      let newValue = {}
      newValue.name = value.name
      newValue.description = value.description
      newValue.is_active = value.is_active
      newValue.background_color = value.background_color
      image.value = value.image ? value.image : null
      picto.value = value.picto ? value.picto : null
      model.value = Object.assign({}, newValue);
    }

    const id = ref(route.params.id)
    const initialModel = {
      name: '',
      description: '',
      background_color: '',
      is_active: true,
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
      image,
      picto,
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
