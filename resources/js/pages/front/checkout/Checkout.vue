<template>
  <!--begin::Checkout Section-->
  <div class="bg-grad-4"></div>
  <div class="my-10">
    <!--begin::Container-->

      <div class="page-title text-center">
        <h1 class="canela-thin mb-20">Paiement</h1>
      </div>
    <div class="container">
      <OrderPlaced v-if="status === 'success'" />
      <div v-else-if="cart" class="d-flex flex-column flex-lg-row">
        <!--begin::Layout-->
        <form @submit.prevent="submit" method="post" class="form w-100">
          <div class="card card-xl-stretch mb-5 mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0">
              <h3 class="card-title fw-bolder text-dark">{{ $t('payment_methods') }}</h3>
              <div class="card-toolbar">
              </div>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-2">
              <!--begin::Item-->
              <div v-if="cart.total > 0" class="d-flex align-items-center mb-8">
                <!--begin::Checkbox-->
                <div class="form-check form-check-custom form-check-solid mx-5">
                  <input class="form-check-input" type="radio" v-model="method" value="bank-card">
                </div>
                <!--end::Checkbox-->
                <!--begin::Description-->
                <div class="flex-grow-1">
                  <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">{{ $t('bank-card') }}</a>
                </div>
                <!--end::Description-->
              </div>
              <!--end:Item-->

              <div v-if="cart.total > 0" class="mb-5 ms-15">
                <form ref="form" method="POST" action="https://sogecommerce.societegenerale.eu/vads-payment/">
                </form>
              </div>

              <!--begin::Item-->
              <div v-if="false" class="d-flex align-items-center mb-8">
                <!--begin::Checkbox-->
                <div class="form-check form-check-custom form-check-solid mx-5">
                  <input class="form-check-input" type="radio" v-model="method" value="bank-transfer">
                </div>
                <!--end::Checkbox-->
                <!--begin::Description-->
                <div class="flex-grow-1">
                  <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">{{ $t('bank-transfer') }}</a>
                </div>
                <!--end::Description-->
              </div>
              <!--end:Item-->

              <!--begin::Item-->
              <div v-if="cart.total === 0" class="d-flex align-items-center mb-8">
                <!--begin::Checkbox-->
                <div class="form-check form-check-custom form-check-solid mx-5">
                  <input class="form-check-input" type="radio" v-model="method" value="free">
                </div>
                <!--end::Checkbox-->
                <!--begin::Description-->
                <div class="flex-grow-1">
                  <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">{{ $t('free') }}</a>
                </div>
                <!--end::Description-->
              </div>
              <!--end:Item-->

              <!--begin::Item-->
              <div v-if="false" class="d-flex align-items-center mb-8">
                <!--begin::Checkbox-->
                <div class="form-check form-check-custom form-check-solid mx-5">
                  <input class="form-check-input" type="radio" v-model="method" value="cash">
                </div>
                <!--end::Checkbox-->
                <!--begin::Description-->
                <div class="flex-grow-1">
                  <a href="#" class="text-gray-800 text-hover-primary fw-bolder fs-6">{{ $t('cash') }}</a>
                </div>
                <!--end::Description-->
              </div>
              <!--end:Item-->

              <!--begin::Actions-->
              <div class="d-flex justify-content-end align-items-center mt-12">
                <!--begin::Button-->
                <button type="button" class="btn btn-light fiche-btn me-5">
                  {{ $t('cancel')}}
                </button>
                <!--end::Button-->

                <!--begin::Button-->
                <button type="submit" class="btn fiche-btn bg-green">
                  <span class="indicator-label">{{ $t('checkout') }}</span>
                </button>
                <!--end::Button-->
              </div>
              <!--end:Actions-->

            </div>
            <!--end::Body-->
          </div>
        </form>
        <!--end::Layout-->

        <!--begin::Aside-->
        <div class="flex-column flex-lg-row-auto w-100 w-lg-350px w-xxl-450px mb-8 mb-lg-0 ms-lg-9 ms-5">
          <div class="card card-flush pt-3 mb-5">
            <!--begin::Card header-->
            <div class="card-header">
              <!--begin::Card title-->
              <div class="card-title">
                <h2>Coupon</h2>
              </div>
              <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0 fs-6">
              <div class="mb-10 fv-row fv-plugins-icon-container">
                <!--begin::Input-->
                <div class="d-flex gap-3">
                  <input v-model="coupon" placeholder="Entrer votre code" type="text" name="coupon" class="form-control mb-2">
                  <button @click="applyCoupon()" type="button" name="warehouse" class="form-control fiche-btn bg-yellow mb-2">Appliquer</button>
                </div>
                <!--end::Input-->
                <div class="fv-plugins-message-container invalid-feedback"></div>
              </div>
            </div>
            <!--end::Card body-->
          </div>

          <div class="card card-flush pt-3 mb-0">
            <!--begin::Card header-->
            <div class="card-header">
              <!--begin::Card title-->
              <div class="card-title">
                <h2>Résumé</h2>
              </div>
              <!--end::Card title-->
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0 fs-6">
              <!--begin::Section-->
              <div class="mb-7">
                <!--begin::Title-->
                <h5 class="mb-3">Détails</h5>
                <!--end::Title-->
                <!--begin::Details-->
                <div class="mb-0">

                  <!--begin::Item-->
                  <div
                    v-for="item in cart.items"
                    :key="`cart-item-${item.id}`"
                    class="d-flex align-items-sm-center mb-7">
                    <!--begin::Symbol-->
                    <div v-if="item.product" class="symbol symbol-30px symbol-2by3 me-4">
                      <div class="symbol-label" :style="`background-image:url('/p/image-${item.product.id}.jpg')`"></div>
                    </div>
                    <div v-else-if="item.formation" class="symbol symbol-30px symbol-2by3 me-4">
                      <div class="symbol-label" :style="`background-image:url('/f/image-${item.formation.id}.jpg')`"></div>
                    </div>
                    <div v-else-if="item.consultation && item.consultation.expert" class="symbol symbol-30px symbol-2by3 me-4">
                      <div class="symbol-label" :style="`background-image:url('/u/image-${item.consultation.expert.id}.jpg')`"></div>
                    </div>
                    <div v-else class="symbol symbol-30px symbol-2by3 me-4">
                      <div class="symbol-label"></div>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Title-->
                    <div class="d-flex flex-row-fluid flex-wrap align-items-center">
                      <div class="flex-grow-1 me-2">
                        <a v-if="item.product" href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">{{ item.product.name }}</a>
                        <a v-else-if="item.formation" href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Formation "{{ item.formation.name }}"</a>
                        <a v-else-if="item.consultation" href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Consultation {{ item.consultation.name }}</a>
                        <span class="text-muted fw-bold d-block pt-1">{{ $t('quantity') }}: {{ item.quantity }} / {{ $t('row_total') }}: {{ item.row_total }}{{ item.currency }}</span>
                      </div>
                      <div class="d-flex align-items-center">
                        <button @click="handleDelete(item)" class="btn btn-icon btn-light btn-sm border-0">
                          <!--begin::Svg Icon | path: icons/duotune/arrows/arr064.svg-->
                          <span class="svg-icon svg-icon-2 svg-icon-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"></rect>
                                <path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
                                <path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
                              </g>
                            </svg>
                          </span>
                          <!--end::Svg Icon-->
                        </button>
                      </div>
                    </div>
                    <!--end::Title-->
                  </div>
                  <!--end::Item-->

                </div>
                <!--end::Details-->
              </div>
              <!--end::Section-->

              <table class="table align-middle table-row-dashed fs-6 gy-5 mb-0">
                <!--begin::Table body-->
                <tbody class="fw-bold text-gray-600">
                <!--begin::Subtotal-->
                <tr>
                  <td class="text-end">Montant HT</td>
                  <td class="text-end">{{ cart.sub_total }} {{ cart.currency }}</td>
                </tr>
                <!--end::Subtotal-->
                <!--begin::VAT-->
                <tr>
                  <td class="text-end">TVA</td>
                  <td class="text-end">{{ cart.vat_total }} {{ cart.currency }}</td>
                </tr>
                <!--end::VAT-->
                <!--begin::Discount-->
                <tr v-if="cart.discount_total > 0">
                  <td class="text-end">Reduction</td>
                  <td class="text-end">{{ cart.discount_total }} {{ cart.currency }}</td>
                </tr>
                <!--end::Discount-->
                <!--begin::Grand total-->
                <tr>
                  <td class="fs-3 text-dark text-end">Total TTC</td>
                  <td class="text-dark fs-3 fw-boldest text-end">{{ cart.total }} {{ cart.currency }}</td>
                </tr>
                <!--end::Grand total-->
                </tbody>
                <!--end::Table head-->
              </table>
            </div>
            <!--end::Card body-->
          </div>
        </div>
        <!--end::Aside-->
      </div>
      <EmptyCart v-else />
    </div>
    <!--end::Container-->
  </div>
  <!--end::Checkout Section-->
</template>

<script>
import {computed, onMounted, ref} from "vue";
import ApiService from "../../../services/api.service";
import {GET_CART} from "../../../services/store/cart.module";
import {useStore} from "vuex";
import EmptyCart from "./EmptyCart";
import OrderPlaced from "./OrderPlaced";

export default {
  name: 'Checkout',
  components: {OrderPlaced, EmptyCart},
  setup(){
    const store = useStore()

    const form = ref(null)

    const cart = computed(() => store.getters.currentCart)

    const status = ref(null)

    const method = ref('bank-card')

    const submit = () => {
      status.value = null
      const data = {
        method: method.value
      }
      ApiService.post('/checkout', data)
        .then((response) => {
          if(response.data.success){
            if(response.data.form){
              form.value.innerHTML = response.data.form
              form.value.submit()
            }else{
              status.value = 'success'
              store.dispatch(GET_CART)
            }
          }else{
            status.value = 'error'
            if(response.data.message){
              Swal.fire({
                title: response.data.message,
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "Ok, d'accord!",
                customClass: {
                  confirmButton: "btn btn-success"
                }
              });
            }
          }
        })
        .catch(() => {
          status.value = 'error'
        })
    }

    const loadModel = () => {
      store.dispatch(GET_CART)
    }

    const handleDelete = (item) => {
      ApiService.delete('/carts/' + cart.value.id, {data: {id: item.id}})
        .then((response) => {
          if(response.data.success){
            loadModel()
          }
        })
    }

    const coupon = ref(null)
    const applyCoupon = () => {
      const data = {
        coupon: coupon.value
      }
      ApiService.post('/coupon', data)
        .then((response) => {
          Swal.fire({
            title: response.data.message,
            icon: response.data.success ? "success" : "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, d'accord!",
            customClass: {
              confirmButton: "btn btn-success"
            }
          });
        })
        .finally(() => {
          store.dispatch(GET_CART)
        })
    }

    return {
      form,
      cart,
      method,
      status,
      coupon,
      submit,
      handleDelete,
      applyCoupon,
    }
  }
}
</script>
