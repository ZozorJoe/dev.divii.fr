<template>
    <!--begin::Wrapper-->
    <div class="bg-grad-4"></div>
    <div class="w-lg-600px bg-body shadow-sm p-10 p-lg-15 mx-auto">
        <!--begin::Form-->
        <form @submit.prevent="submit" method="post" class="form w-100 fv-plugins-bootstrap5 fv-plugins-framework" novalidate="novalidate" id="kt_sign_up_form">
            <!--begin::Heading-->
            <div class="mb-10 text-center">
                <!--begin::Title-->
                <h1 class="canela-thin-italic tarifs-title fw-normal">{{ $t('messages.create.an.account') }}</h1>
                <!--end::Title-->
                <!--begin::Link-->
                <div class="text-gray-400 fw-bold fs-4">{{ $t('messages.already.have.an.account') }}
                    <router-link :to="{name: 'login'}" class="link-primary fw-bolder">{{ $t('messages.sign.in') }}</router-link></div>
                <!--end::Link-->
            </div>
            <!--end::Heading-->

            <!--begin::Input group-->
            <div class="row fv-row">
                <!--begin::Col-->
                <div class="col-xl-6">
                  <InputText
                    v-model="state.first_name"
                    :placeholder="$t('messages.enter.first_name')"
                    :rules="{required}"
                    class="mb-10"
                    name="first_name"
                    tabindex="1">
                    <!--begin::Label-->
                    <label class="form-label fs-6 fw-bolder text-dark">{{ $t('first_name') }}</label>
                    <!--end::Label-->
                  </InputText>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-xl-6">
                  <InputText
                    v-model="state.last_name"
                    :placeholder="$t('messages.enter.last_name')"
                    :rules="{required}"
                    class="mb-10"
                    name="last_name"
                    tabindex="2">
                    <!--begin::Label-->
                    <label class="form-label fs-6 fw-bolder text-dark">{{ $t('last_name') }}</label>
                    <!--end::Label-->
                  </InputText>
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->

            <InputText
              v-model="state.email"
              :placeholder="$t('messages.enter.email')"
              :rules="{required, email}"
              class="mb-10"
              name="email"
              tabindex="3">
              <!--begin::Label-->
              <label class="form-label fs-6 fw-bolder text-dark">{{ $t('email') }}</label>
              <!--end::Label-->
              <!--begin::Input-->
            </InputText>

            <InputBirthday
              v-model="state.birthday"
              :placeholder="$t('messages.enter.birthday')"
              :rules="{required}"
              class="mb-10"
              name="birthday"
              tabindex="4">
              <!--begin::Label-->
              <label class="form-label fs-6 fw-bolder text-dark">{{ $t('birthday') }}</label>
              <!--end::Label-->
            </InputBirthday>

            <InputText
              v-model="state.birth_place"
              :placeholder="$t('messages.enter.birth_place')"
              :rules="{required}"
              class="mb-10"
              name="birth_place"
              tabindex="5">
              <!--begin::Label-->
              <label class="form-label fs-6 fw-bolder text-dark">{{ $t('birth_place') }}</label>
              <!--end::Label-->
              <template v-slot:checkbox>
                <div class="my-2">
                  <input v-model="checkbox.birth_place" type="checkbox" id="checkbox_birth_place">
                  <label class="form-label fs-6 fw-bolder text-dark ms-2" for="checkbox_birth_place">Je ne sais pas</label>
                </div>
              </template>
              <template v-slot:help>
                <div class="form-label mb-2 fs-6">
                  Cette information est nécessaire dans le cadre d’une consultation
                </div>
              </template>
            </InputText>

            <InputText
              v-model="state.birth_hour"
              :placeholder="$t('messages.enter.birth_hour')"
              :rules="{required}"
              class="mb-10"
              name="birth_hour"
              tabindex="6">
              <!--begin::Label-->
              <label class="form-label fs-6 fw-bolder text-dark">{{ $t('birth_hour') }}</label>
              <!--end::Label-->
              <template v-slot:checkbox>
                <div class="my-2">
                  <input v-model="checkbox.birth_hour" type="checkbox" id="checkbox_birth_hour">
                  <label class="form-label fs-6 fw-bolder text-dark ms-2" for="checkbox_birth_hour">Je ne sais pas</label>
                </div>
              </template>
              <template v-slot:help>
                <div class="form-label mb-2 fs-6">
                  Cette information est nécessaire dans le cadre d’une consultation
                </div>
              </template>
            </InputText>

            <InputText
              v-model="state.phone"
              :placeholder="$t('messages.enter.phone')"
              :rules="{}"
              class="mb-10"
              name="phone"
              tabindex="7">
              <!--begin::Label-->
              <label class="form-label fs-6 fw-bolder text-dark">{{ $t('phone') }}</label>
              <!--end::Label-->
              <!--begin::Input-->
            </InputText>

            <InputPassword
              v-model="state.password"
              :meter="true"
              :placeholder="$t('messages.enter.password')"
              class="mb-10"
              name="password"
              tabindex="8">
              <!--begin::Label-->
              <label class="form-label fs-6 fw-bolder text-dark">{{ $t('password') }}</label>
              <!--end::Label-->
            </InputPassword>

            <InputPassword
              v-model="state.password_confirmation"
              :meter="false"
              :placeholder="$t('messages.enter.password_confirmation')"
              class="mb-10"
              name="password_confirmation"
              tabindex="9">
              <!--begin::Label-->
              <label class="form-label fs-6 fw-bolder text-dark">{{ $t('password_confirmation') }}</label>
              <!--end::Label-->
            </InputPassword>

            <!--begin::Input group-->
            <div class="fv-row mb-10">
              <label class="form-check form-check-custom form-check-solid form-check-inline">
                  <input class="form-check-input" type="checkbox" name="agree" v-model="state.agree">
                  <span class="form-check-label fw-bold text-gray-700 fs-6">
                    <span class="me-1">{{ $t('i_agree') }}</span>
                    <a href="/cgu" class="link-primary">{{ $t('terms_of_use') }}</a>.
                  </span>
              </label>
              <BaseError name="agree" />
            </div>
            <!--end::Input group-->

            <!--begin::Actions-->
            <div class="text-center">
              <BtnSubmit tabindex="10" />
            </div>
            <!--end::Actions-->
            <div></div>
        </form>
        <!--end::Form-->
    </div>
    <!--end::Wrapper-->
</template>

<script>
import useVuelidate from "@vuelidate/core";
import {email, required} from "@vuelidate/validators";
import {reactive, ref, watch} from "vue";
import {useStore} from "vuex";
import InputText from "../../../components/form/InputText";
import InputPassword from "../../../components/form/InputPassword";
import BtnSubmit from "../../../components/form/BtnSubmit";
import {REGISTER, VERIFY_AUTH} from "../../../services/store/auth.module";
import BaseError from "../../../components/form/BaseError";
import {SET_ERRORS, SET_LOADING} from "../../../services/store/form.module";
import ApiService from "../../../services/api.service";
import {useRouter} from "vue-router";
import InputBirthday from "../../../components/form/InputBirthday";
export default {
  name: "KTRegister",
  components: {InputBirthday, BaseError, InputText, InputPassword, BtnSubmit},
  setup() {
    const v$ = useVuelidate()
    const store = useStore()
    const router = useRouter()

    const state = reactive({
      first_name: '',
      last_name: '',
      email: '',
      birthday: '',
      birth_hour: '',
      birth_place: '',
      phone: '',
      password: '',
      password_confirmation: '',
      agree: false,
    })

    const submit = () => {
      if(v$.$touch && v$.$error) return;
      store.commit(SET_LOADING, true);
      ApiService.post("/register", state)
        .then((response) => {
          store.commit(SET_LOADING, false);
          if(response.data.success){
            Swal.fire({
              title: "Votre compte a été bien créé. Veuillez vérifier votre boite email pour valider votre inscription !",
              icon: "success",
              showCancelButton: false,
              confirmButtonText: "D'accord",
            }).then(() => {
              router.push({name:'home'})
            })
          }else{
            Swal.fire({
              title: "Une erreur s'est produite. Veuillez réessayer!",
              icon: "error",
              showCancelButton: false,
              confirmButtonText: "D'accord",
            })
          }
        })
        .catch(({response}) => {
          store.commit(SET_LOADING, false);
          if(response && response.data && response.data.errors){
            store.commit(SET_ERRORS, response.data.errors);
            Swal.fire({
              title: "Une erreur s'est produite. Veuillez vérifier les champs!",
              icon: "error",
              showCancelButton: false,
              confirmButtonText: "D'accord",
            })
          }
        });
    }

    const checkbox = ref({
      birth_hour: false,
      birth_place: false,
    })

    watch(() => checkbox.value.birth_hour, (value) => {
      if(value){
        state.birth_hour = "Je ne sais pas"
      }else{
        state.birth_hour = ''
      }
    })

    watch(() => checkbox.value.birth_place, (value) => {
      if(value){
        state.birth_place = "Je ne sais pas"
      }else{
        state.birth_place = ''
      }
    })

    return {
      state,
      checkbox,
      submit,
      email,
      required,
    }
  }
};
</script>
