<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
      <router-link :to="{name: 'expert.formations'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('date') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputDateTime
                    v-model="model.start_at"
                    :placeholder="$t('messages.select.date')"
                    class="w-100"
                    name="start_at"/>
                  <BaseError name="start_at"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('duration') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <BaseInput name="duration" type="number" min="0" max="100" :placeholder="$t('messages.enter.duration')" v-model="model.duration" :rules="{}" />
                  <BaseError name="duration"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('disciplines') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <div class="checkbox-list">
                    <label
                      v-for="discipline in disciplines"
                      :key="discipline.id"
                      class="form-check form-check-custom form-check-solid form-check-inline mb-2">
                      <input class="form-check-input" v-model="model.disciplines[0]" type="radio" name="disciplines[0]" :value="discipline.id">
                      <span class="form-check-label fw-bold text-gray-700 fs-6">{{  discipline.name }}</span>
                    </label>
                  </div>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

            </div>
            <!--end::Card body-->

            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <router-link :to="{name: 'expert.formations'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
  name: 'FormationFrom',
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
      ApiService.store('/expert/formations', data, t('discipline'), initModel, store, t)
    }

    const update = () => {
      const data = getData()
      ApiService.update('/expert/formations/' + id.value, data, t('formation'), initModel, store, t)
    }

    const loadModel = (value) => {
      if(!value){ return; }
      const params = {params:{with:'disciplines,image,picto'}}
      ApiService.show('/expert/formations/' + value, params, t('formation'), initModel, store, t)
    }

    const initModel = (value) => {
      if(!value){
        model.value = Object.assign({}, initialModel);
        return;
      }

      let newValue = {}
      newValue.name = value.name
      newValue.description = value.description
      newValue.price = value.price
      newValue.currency = value.currency
      newValue.vat = value.vat
      newValue.start_at = value.start_at
      newValue.duration = value.duration
      newValue.user_id = value.user_id
      newValue.background_color = value.background_color

      image.value = value.image ? value.image : null
      picto.value = value.picto ? value.picto : null

      newValue.disciplines = []
      if(value.disciplines){
        value.disciplines.forEach(item => {
          newValue.disciplines.push(item.id)
        })
      }

      model.value = Object.assign({}, newValue);
    }

    const id = ref(route.params.id)
    const initialModel = {
      name: '',
      description: '',
      price: 0,
      currency: 'EUR',
      vat: 0,
      start_at: null,
      duration: null,
      user_id: null,
      background_color: null,
      disciplines: [],
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

    const disciplines = ref([])
    const loadDisciplines = () => {
      ApiService.list('/expert/disciplines', {params:{'per-page':-1}}, t('discipline'), setDisciplines, store, t)
    }
    const setDisciplines = (value) => {
      disciplines.value = value
    }
    onMounted(loadDisciplines)

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { init() })

    return {
      v$,
      image,
      picto,
      model,
      disciplines,
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
