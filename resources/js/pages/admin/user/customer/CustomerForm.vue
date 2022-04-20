<template>
  <!--begin::Content-->
  <div v-if="model" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
      <router-link :to="{name: 'admin.customers'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('avatar') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8">
                  <InputImage v-model="avatar" />

                  <!--begin::Hint-->
                  <div class="form-text">{{ $t('allowed_image_types') }}</div>
                  <!--end::Hint-->
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('tester') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <label class="form-check form-switch form-check-custom form-check-solid">
                    <input class="form-check-input" name="is_tester" type="checkbox" v-model="model.is_tester">
                    <span class="form-check-label fw-bold text-muted">{{ $t('tester') }}</span>
                  </label>
                  <BaseError name="is_tester" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('full_name') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8">
                  <!--begin::Row-->
                  <div class="row">
                    <div class="mb-0 col-lg-6">
                      <BaseInput name="first_name" :placeholder="$t('messages.enter.first_name')" v-model="model.first_name" :rules="{}" />
                      <BaseError name="first_name" />
                    </div>
                    <div class="mb-0 col-lg-6">
                      <BaseInput name="last_name" :placeholder="$t('messages.enter.last_name')" v-model="model.last_name" :rules="{}" />
                      <BaseError name="last_name" />
                    </div>
                  </div>
                  <!--end::Row-->
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('birthday') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputDate
                    v-model="model.birthday"
                    :placeholder="$t('messages.select.date')"
                    class="w-100"
                    name="birthday"/>
                  <BaseError name="birthday"/>
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('email') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputText name="email" class="mb-0" v-model="model.email" :rules="{}" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('password') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputPassword name="password" class="mb-0" v-model="model.password" :rules="{}" :meter="true" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-2 col-lg-4 col-form-label fw-bold fs-6">{{ $t('password_confirmation') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-10 col-lg-8 fv-row">
                  <InputPassword name="password_confirmation" class="mb-0" v-model="model.password_confirmation" :rules="{}" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
              <router-link :to="{name: 'admin.customers'}" class="btn btn-sm btn-light btn-active-light-primary me-2">{{ $t('back') }}</router-link>
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
import {useI18n} from "vue-i18n";

export default {
  name: 'CustomerForm',
  setup(){
    const route = useRoute()
    const store = useStore()
    const v$ = useVuelidate()
    const { t } = useI18n()

    const avatar = ref(null)

    const getData = () => {
      const data = model.value;
      if(avatar.value){
        data.avatar_id = avatar.value.id
      }else{
        data.avatar_id = null
      }

      return data;
    }

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      id && id.value ? update() : create();
    }

    const create = () => {
      const data = getData()
      ApiService.store('/admin/customers', data, t('customer'), initModel, store, t)
    }

    const update = () => {
      const data = getData()
      ApiService.update('/admin/customers/' + id.value, data, t('customer'), initModel, store, t)
    }

    const loadModel = (value) => {
      if(!value){ return; }
      const params = {params:{with:'avatar'}}
      ApiService.show('/admin/customers/' + value, params, t('customer'), initModel, store, t)
    }

    const initModel = (value) => {
      if(!value){
        model.value = Object.assign({}, initialModel);
        return;
      }

      let newValue = {}
      newValue.first_name = value.first_name
      newValue.last_name = value.last_name
      newValue.birthday = value.birthday
      newValue.email = value.email
      newValue.is_tester = value.is_tester

      avatar.value = value.avatar ? value.avatar : null

      model.value = Object.assign({}, newValue);
    }

    const id = ref(route.params.id)
    const initialModel = {
      first_name: '',
      last_name: '',
      email: '',
      birthday: '',
      is_tester: false,
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
      avatar,
      model,
      submit,
    }
  }
}
</script>
