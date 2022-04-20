<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
      <router-link :to="{name: 'admin.horoscopes'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
      <button v-if="!model.status" @click="draft" form="form" type="button" class="btn btn-sm btn-primary me-2">{{ $t('draft') }}</button>
      <button v-if="!model.status || model.status !== 'published'" @click="publish" form="form" type="button" class="btn btn-sm btn-success me-2">{{ $t('publish') }}</button>
      <button v-if="model.status" form="form" type="submit" class="btn btn-sm btn-primary">{{ model.status === 'published' ? $t('send') : $t('save') }}</button>
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
                <div v-for="zodiac in zodiacs" class="row mb-6">
                  <!--begin::Label-->
                  <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-5">{{ $t(zodiac) }}</label>
                  <!--end::Label-->
                  <!--begin::Col-->
                  <div class="col-xl-10 col-lg-8 fv-row">
                    <ckeditor v-model="model[zodiac]" v-if="editor.editor" :editor="editor.editor" :config="editor.editorConfig" />
                    <BaseError :name="zodiac"/>
                  </div>
                  <!--end::Col-->
                </div>
                <!--end::Input group-->

            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <router-link :to="{name: 'admin.horoscopes'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
              <button v-if="!model.status" @click="draft" form="form" type="button" class="btn btn-sm btn-primary me-2">{{ $t('draft') }}</button>
              <button v-if="!model.status || model.status !== 'published'" @click="publish" form="form" type="button" class="btn btn-sm btn-success me-2">{{ $t('publish') }}</button>
              <button v-if="model.status" form="form" type="submit" class="btn btn-sm btn-primary">{{ model.status === 'published' ? $t('send') : $t('save') }}</button>
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
import {useI18n} from "vue-i18n";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

export default {
  name: 'HoroscopeForm',
  setup(){
    const route = useRoute()
    const store = useStore()
    const v$ = useVuelidate()
    const { t } = useI18n()

    const zodiacs = ref([
      'belier', 'taureau', 'gemeaux',
      'cancer', 'lion', 'vierge',
      'balance', 'scorpion', 'sagittaire',
      'capricorne', 'verseau', 'poissons',
    ])

    const getData = () => {
      return model.value;
    }

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      id && id.value ? update() : create();
    }

    const draft = () => {
      model.value.status = 'draft'
      submit()
    }

    const publish = () => {
      model.value.status = 'published'
      submit()
    }

    const create = () => {
      const data = getData()
      ApiService.store('/admin/horoscopes', data, t('horoscope'), initModel, store, t)
    }

    const update = () => {
      const data = getData()
      ApiService.update('/admin/horoscopes/' + id.value, data, t('horoscope'), initModel, store, t)
    }

    const loadModel = (value) => {
      if(!value){ return; }
      const params = null
      ApiService.show('/admin/horoscopes/' + value, params, t('horoscope'), initModel, store, t)
    }

    const initModel = (value) => {
      if(!value){
        model.value = Object.assign({}, initialModel);
        return;
      }

      model.value = value;
    }

    const id = ref(route.params.id)

    const initialModel = {
      status: null,
    }
    zodiacs.value.forEach((zodiac) => {
      initialModel[zodiac] = zodiac
    })

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
      zodiacs,
      model,
      submit,
      draft,
      publish,
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
