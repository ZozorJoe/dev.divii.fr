<template>
  <!--begin::Checkout Section-->
  <div class="bg-grad-4"></div>
  <div v-if="model" class="my-10">
    <!--begin::Container-->
    <div class="container">

      <div class="d-flex flex-column container pt-lg-20 pb-15">
        <!--begin::Heading-->
        <div class="page-title text-center">
          <div class="col-12 mx-auto text-center canela-thin-italic" style="font-size: 2.5rem;">
            Merci pour votre intérêt !
            <br>Renseignez votre email et recevez un code promo promotionnel,
            <br>à utiliser lors de votre première réservation divii. :)
          </div>
        </div>
        <!--end::Heading-->
      </div>

      <div class="w-lg-600px bg-white p-10 mx-auto">
        <form @submit.prevent="submit" method="post">
          <!--begin::Input group-->
          <div class="row fv-row">
            <!--begin::Col-->
            <div class="col-xl-6">
              <InputText
                v-model="model.first_name"
                :placeholder="$t('messages.enter.first_name')"
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
                v-model="model.last_name"
                :placeholder="$t('messages.enter.last_name')"
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

          <!--begin::Input group-->
          <div class="row fv-row">
            <!--begin::Col-->
            <div class="col-xl-6">
              <InputText
                v-model="model.email"
                :placeholder="$t('messages.enter.email')"
                name="email"
                tabindex="3">
                <!--begin::Label-->
                <label class="form-label fs-6 fw-bolder text-dark">{{ $t('email') }}</label>
                <!--end::Label-->
                <!--begin::Input-->
              </InputText>
            </div>
            <!--end::Col-->
            <!--begin::Col-->
            <div class="col-xl-6 pt-9">
              <button
                type="submit"
                class="w-100 btn rounded-pill bg-red-4 btn-icon-dark text-uppercase">
                Valider
              </button>
            </div>
            <!--end::Col-->
          </div>
          <!--end::Input group-->
        </form>
      </div>
    </div>
    <!--end::Container-->
  </div>
  <!--end::Checkout Section-->
</template>

<script>
import ApiService from "../../../services/api.service";
import {ref} from "vue";
import {useRouter} from "vue-router";

export default {
  name: 'Welcome',
  setup(){
    const router = useRouter()

    const model = ref({
      first_name: '',
      last_name: '',
      email: '',
    })

    const submit = () => {
      const data = model.value
      ApiService.post('/welcome', data)
        .then((response) => {
          if(response.data.success){
            Swal.fire({
              title: "Votre demande a été bien reçue. Merci pour votre intérêt !",
              icon: "success",
              showCancelButton: false,
              confirmButtonText: "D'accord",
            }).then(() => {
              router.push({name:'home'})
            })
          }else{
            Swal.fire({
              title: message,
              icon: "error",
              showCancelButton: false,
              confirmButtonText: "D'accord",
            }).then(() => {
              router.push({name:'home'})
            })
          }
        })
        .catch(() => {
          toastr.error("Une erreur s'est produite! Veuillez réessayer svp!")
        })
    }

    return {
      model,
      submit,
    }
  }
}
</script>
