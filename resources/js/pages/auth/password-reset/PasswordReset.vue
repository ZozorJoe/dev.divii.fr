<template>
    <!--begin::Wrapper-->
    <div class="bg-grad-4"></div>
    <div class="w-lg-600px bg-body shadow-sm p-10 p-lg-15 mx-auto">
        <!--begin::Form-->
        <form @submit.prevent="submit" method="post" class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_password_reset_form">
            <!--begin::Heading-->
            <div class="text-center mb-10">
              <!--begin::Title-->
              <h1 class="canela-thin-italic tarifs-title fw-normal">{{ $t('messages.forgot.password') }}</h1>
              <!--end::Title-->

              <!--begin::Link-->
              <div class="text-gray-400 fw-bold fs-4">{{ $t('messages.forgot.password_subtitle') }}</div>
              <!--end::Link-->

              <div v-if="result" class="alert fs-5 mt-2" :class="classObject">{{ $t(result.status) }}</div>

            </div>
            <!--begin::Heading-->
            <!--begin::Input group-->
            <InputText
              v-model="state.email"
              :placeholder="$t('messages.enter.email')"
              :rules="rules"
              class="mb-10"
              name="email"
              tabindex="1">
              <!--begin::Label-->
              <label class="form-label fs-6 fw-bolder text-dark">{{ $t('email') }}</label>
              <!--end::Label-->
            </InputText>
            <!--end::Input group-->
            <!--begin::Actions-->
            <div class="d-flex flex-wrap justify-content-end pb-lg-0">
              <BtnSubmit />
              <router-link :to="{name: 'login'}" class="fiche-btn btn with-zindex rounded-pill bg-green btn-icon-dark mb-n10 text-uppercase">{{ $t('cancel') }}</router-link>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
    </div>
    <!--end::Wrapper-->
</template>

<script>
import useVuelidate from "@vuelidate/core";
import BtnSubmit from "../../../components/form/BtnSubmit";
import InputText from "../../../components/form/InputText";
import {email, required} from "@vuelidate/validators";
import {computed, reactive, ref} from "vue";
import ApiService from "../../../services/api.service";
import {SET_ERRORS, SET_LOADING} from "../../../services/store/form.module";
import { useStore } from 'vuex'

export default {
  name: "KTPasswordReset",
  components: {InputText, BtnSubmit},
  setup() {
    const v$ = useVuelidate()

    const store = useStore()

    const result = ref(null)

    const classObject = computed(() => {
      return {
        'alert-danger': result.value && result.value.status !== 'passwords.sent',
        'alert-success': result.value && result.value.status === 'passwords.sent',
      }
    })

    const state = reactive({
      email: '',
    })

    const rules = {
      required,
      email
    }

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      store.commit(SET_LOADING, true);
      result.value = null
      ApiService.post('/password-reset', state)
        .then((response) => {
          result.value = response.data.data
          store.commit(SET_LOADING, false);
          v$.$reset()
          store.commit(SET_ERRORS, {})
        })
        .catch(({response}) => {
          store.commit(SET_LOADING, false);
          if(response && response.data){
            result.value = response.data.data
            if(response.data.errors){
              store.commit(SET_ERRORS, response.data.errors);
            }
          }
        })
    }

    return {
      state,
      rules,
      result,
      classObject,
      submit
    }
  }
};
</script>
