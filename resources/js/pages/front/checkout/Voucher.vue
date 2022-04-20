<template>
  <!--begin::Checkout Section-->
  <div class="bg-grad-4"></div>
  <div class="my-10">
    <!--begin::Container-->
    <div class="container">
      <div class="page-title text-center">
        <h1 class="canela-thin mb-20">Code cadeau</h1>
      </div>
      <div class="card card-flush py-4">
        <form @submit.prevent="submit" method="post">
          <div class="card-body">
            <div class="mb-10 row fv-row fv-plugins-icon-container">
              <div class="col-md-9">
                <!--begin::Label-->
                <label class="required form-label text-white">Code cadeau</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" v-model="model" name="code" class="form-control mb-2" placeholder="Entrer le code cadeau">
                <!--end::Input-->
                <!--begin::Description-->
                <div class="text-muted fs-7">Taper ici le code cadeau que vous avez reçus.</div>
                <!--end::Description-->
                <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
              <div class="col-md-3 mt-8 voucher-btn-wrapper">
                <BtnSubmit tabindex="3" />
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!--end::Container-->
  </div>
  <!--end::Checkout Section-->
</template>

<script>
import ApiService from "../../../services/api.service";
import {GET_CART} from "../../../services/store/cart.module";
import {ref} from "vue";

export default {
  name: 'Voucher',
  setup(){
    const model = ref(null)

    const submit = () => {
      const data = {
        voucher: model.value
      }
      ApiService.post('/voucher', data)
        .then((response) => {
          if(response.data.success){
            model.value = null
            Swal.fire({
              title: "Le code cadeau a été bien activé.",
              icon: "success",
              buttonsStyling: false,
              confirmButtonText: "Ok, d'accord!",
              customClass: {
                confirmButton: "btn btn-success"
              }
            });
          }else{
            Swal.fire({
              title: response.data.message,
              icon: "error",
              buttonsStyling: false,
              confirmButtonText: "Ok, d'accord!",
              customClass: {
                confirmButton: "btn btn-danger"
              }
            });
          }
        })
        .catch(() => {

        })
    }

    return {
      model,
      submit,
    }
  }
}
</script>
