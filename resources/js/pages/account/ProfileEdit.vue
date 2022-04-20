<template>
  <!--begin::Content-->
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <KtToolbar>
      <!--begin::Buttons-->
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
              <h3 class="fw-bolder m-0">{{ $t('messages.profile.edit') }}</h3>
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
                <label class="col-xl-3 col-lg-4 col-form-label fw-bold fs-6">Avatar</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-9 col-lg-8">
                  <InputImage v-model="model.avatar" />

                  <!--begin::Hint-->
                  <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                  <!--end::Hint-->
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-3 col-lg-4 col-form-label required fw-bold fs-6">{{ $t('full_name') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-9 col-lg-8">
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
                <label class="col-xl-3 col-lg-4 col-form-label fw-bold fs-6">{{ $t('birthday') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-9 col-lg-8 fv-row">
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
                <label class="col-xl-3 col-lg-4 col-form-label fw-bold fs-6">{{ $t('email') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-9 col-lg-8 fv-row">
                  <BaseInput name="email" :placeholder="$t('messages.enter.email')" v-model="model.email" :rules="{}" />
                  <BaseError name="email" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-3 col-lg-4 col-form-label fw-bold fs-6">{{ $t('current_password') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-9 col-lg-8 fv-row">
                  <InputPassword name="old_password" class="mb-0" v-model="model.old_password" :rules="{minLength, required}" />

                  <!--begin::Link-->
                  <a href="#" @click="passwordReset" class="link-primary fs-6 fw-bolder mt-n10">{{ $t('forgot_password') }}</a>
                  <!--end::Link-->

                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-3 col-lg-4 col-form-label fw-bold fs-6">{{ $t('new_password') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-9 col-lg-8 fv-row">
                  <InputPassword name="password" class="mb-0" v-model="model.password" :rules="{minLength, required}" :meter="true" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->
              <!--begin::Input group-->
              <div class="row mb-6">
                <!--begin::Label-->
                <label class="col-xl-3 col-lg-4 col-form-label fw-bold fs-6">{{ $t('password_confirmation') }}</label>
                <!--end::Label-->
                <!--begin::Col-->
                <div class="col-xl-9 col-lg-8 fv-row">
                  <InputText name="password_confirmation" class="mb-0" v-model="model.password_confirmation" :rules="{minLength, required}" />
                </div>
                <!--end::Col-->
              </div>
              <!--end::Input group-->

            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
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
import {onMounted, watch, reactive, watchEffect} from "vue";
import ApiService from "../../services/api.service";
import {LOGOUT, VERIFY_AUTH} from "../../services/store/auth.module";
import {SET_ERRORS} from "../../services/store/form.module";
import {useStore} from "vuex";
import useVuelidate from "@vuelidate/core";
import {email, minLength, required} from "@vuelidate/validators";
import {useRouter} from "vue-router";

export default {
  name: 'ProfileEdit',
  setup(){
    const store = useStore()
    const router = useRouter()
    const v$ = useVuelidate()

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      let data = Object.assign({}, model)
      data.avatar = null
      ApiService.put('/account', data)
        .then((response) => {
          v$.$reset()
          store.commit(SET_ERRORS, {})
          if(response.data.success) {
            initModel(response.data.data)
          }
        })
        .catch(({response}) => {
          if(response && response.data && response.data.errors){
            store.commit(SET_ERRORS, response.data.errors);
          }
        })
    }

    const loadModel = () => {
      ApiService.get('/account')
        .then((response) => {
          if(response.data.success) {
            initModel(response.data.data)
            store.dispatch(VERIFY_AUTH);
          }
        })
        .catch(({response}) => {
          if(response && response.data && response.data.errors){
            store.commit(SET_ERRORS, response.data.errors);
          }
        })
    }

    const initModel = (value) => {
      Object.assign(model, value ? value : initialModel);
    }

    const passwordReset = () => {
      store.dispatch(LOGOUT)
        .then(() => {
          location.href = router.resolve({name: 'password.reset'}).fullPath
        })
        .catch(() => {
          location.href = router.resolve({name: 'password.reset'}).fullPath
        });
    }

    const initialModel = {
      id: null,
      avatar_id: 0,
      first_name: '',
      last_name: '',
      birthday: '',
      email: '',
      old_password: '',
      password: '',
      password_confirmation: '',
      avatar: null,
    }
    const model = reactive({ ...initialModel})
    watchEffect(() => loadModel())
    onMounted(loadModel)

    watch(() => model.avatar, (value) => {
      model.avatar_id = value ? value.id : null
    })

    return {
      v$,
      required,
      email,
      minLength: minLength(4),
      model,
      submit,
      passwordReset,
    }
  }
}
</script>
