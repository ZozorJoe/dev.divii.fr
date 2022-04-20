<template>
  <!--begin::Wrapper-->
  <div class="bg-grad-4"></div>
  <div class="w-lg-550px bg-body shadow-sm p-10 p-lg-15 mx-auto">
    <!--begin::Form-->
    <form @submit.prevent="submit" method="post" class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_new_password_form">
      <!--begin::Heading-->
      <div class="text-center mb-10">
        <!--begin::Title-->
        <h1 class="canela-thin-italic tarifs-title fw-normal">{{ $t('messages.new.password') }}</h1>
        <!--end::Title-->
        <!--begin::Link-->
        <div class="text-gray-400 fw-bold fs-4">{{ $t('messages.already.have.reset.your.password') }}
          <router-link :to="{name: 'login'}" class="link-primary fw-bolder">{{ $t('messages.sign.in') }}</router-link>
        </div>
        <!--end::Link-->
      </div>
      <!--begin::Heading-->

      <!--begin::Input group=-->
      <InputPassword
        v-model="state.password"
        :meter="true"
        :placeholder="$t('messages.enter.password')"
        class="mb-10"
        name="password"
        tabindex="1">
        <!--begin::Label-->
        <label class="form-label fs-6 fw-bolder text-dark">{{ $t('password') }}</label>
        <!--end::Label-->
      </InputPassword>
      <!--end::Input group=-->
      <!--begin::Input group=-->
      <InputPassword
        v-model="state.password_confirmation"
        :placeholder="$t('messages.enter.password_confirmation')"
        class="mb-10"
        name="password_confirmation"
        tabindex="2">
        <!--begin::Label-->
        <label class="form-label fs-6 fw-bolder text-dark">{{ $t('password_confirmation') }}</label>
        <!--end::Label-->
      </InputPassword>
      <!--end::Input group=-->
      <!--begin::Action-->
      <div class="text-center">
        <BtnSubmit />
      </div>
      <!--end::Action-->
    </form>
    <!--end::Form-->
  </div>
  <!--end::Wrapper-->
</template>

<script>
import {useRoute, useRouter} from "vue-router";
import {reactive} from "vue";
import BtnSubmit from "../../../components/form/BtnSubmit";
import InputPassword from "../../../components/form/InputPassword";
import {SET_ERRORS, SET_LOADING} from "../../../services/store/form.module";
import ApiService from "../../../services/api.service";
import { useStore } from 'vuex'

export default {
  name: "KTNewPassword",
  components: {InputPassword, BtnSubmit},
  setup() {
    const store = useStore()
    const route = useRoute()
    const router = useRouter()

    const state = reactive({
      email: route.params.email,
      token: route.params.token,
      password: '',
      password_confirmation: '',
    })

    const submit = () => {
      store.commit(SET_LOADING, true);
      ApiService.post('/new-password', state)
        .then((response) => {
          store.commit(SET_ERRORS, {})
          if(response.data.success){
            router.push({name:'login'})
          }else{
            toastr.error(response.data.message)
          }
        })
        .catch(({response}) => {
          if(response && response.data){
            if(response.data.errors){
              store.commit(SET_ERRORS, response.data.errors);
            }
          }
        })
        .finally(() => {
          store.commit(SET_LOADING, false);
        })
    }

    return {
      state,
      submit
    }
  }
};
</script>
