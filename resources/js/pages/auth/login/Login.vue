<template>
  <!--begin::Wrapper-->
  <div class="bg-grad-4"></div>
  <div class="w-lg-500px bg-body shadow-sm p-10 p-lg-15 mx-auto">
    <!--begin::Form-->
    <form @submit.prevent="submit" method="post" class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework">

      <!--begin::Heading-->
      <div class="text-center mb-10">
        <!--begin::Title-->
        <h1 class="canela-thin-italic tarifs-title fw-normal">{{ $t('messages.sign.in') }}</h1>
        <!--end::Title-->
        <!--begin::Link-->
        <div class="text-gray-400 fw-bold fs-4">{{ $t('messages.new.here') }}
          <router-link :to="{name: 'register'}" tabindex="5" class="link-primary fw-bolder">{{ $t('messages.create.an.account') }}</router-link>
        </div>
        <!--end::Link-->
      </div>
      <!--begin::Heading-->

      <InputText
        v-model="state.email"
        :placeholder="$t('messages.enter.email')"
        :rules="{required, email}"
        class="mb-10"
        name="email"
        tabindex="1">
        <!--begin::Label-->
        <label class="form-label fs-6 fw-bolder text-dark">{{ $t('email') }}</label>
        <!--end::Label-->
        <!--begin::Input-->
      </InputText>

      <InputPassword
        v-model="state.password"
        :placeholder="$t('messages.enter.password')"
        :meter="false"
        :rules="{required}"
        class="mb-10"
        name="password"
        tabindex="2">
        <!--begin::Wrapper-->
        <div class="d-flex flex-stack mb-2">
          <!--begin::Label-->
          <label class="form-label fw-bolder text-dark fs-6 mb-0">{{ $t('password') }}</label>
          <!--end::Label-->
          <!--begin::Link-->
          <router-link :to="{name: 'password.reset'}" class="link-primary fs-6 fw-bolder">{{ $t('messages.forgot.password') }}</router-link>
          <!--end::Link-->
        </div>
        <!--end::Wrapper-->
      </InputPassword>

      <!--begin::Action-->
      <div class="text-center">
        <BtnSubmit tabindex="3" />
      </div>
      <!--end::Action-->

      <div></div>
    </form>
    <!--end::Form-->
  </div>
  <!--end::Wrapper-->
</template>

<script>
import useVuelidate from "@vuelidate/core";
import {email, required} from "@vuelidate/validators";
import {reactive} from "vue";
import { useStore } from 'vuex'
import BtnSubmit from '../../../components/form/BtnSubmit'
import InputPassword from "../../../components/form/InputPassword";
import InputText from "../../../components/form/InputText";
import {LOGIN} from "../../../services/store/auth.module";

export default {
  name: "KTLogin",
  components: {InputText, InputPassword, BtnSubmit},
  setup() {
    const v$ = useVuelidate()

    const store = useStore()

    const state = reactive({
      email: '',
      password: '',
    })

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      store.dispatch(LOGIN, state)
    }

    return {
      v$,
      email,
      required,
      state,
      submit,
    }
  },
};
</script>
