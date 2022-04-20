<template>
  <!--begin::Chat drawer-->
  <div id="kt_drawer_cart"
       class="bg-body drawer drawer-end"
       data-kt-drawer="true"
       data-kt-drawer-name="cart"
       data-kt-drawer-activate="true"
       data-kt-drawer-overlay="true"
       data-kt-drawer-width="{default:'300px', 'md': '500px'}"
       data-kt-drawer-direction="end"
       data-kt-drawer-toggle="#kt_drawer_cart_toggle"
       data-kt-drawer-close="#kt_drawer_cart_close"
       style="width: 500px !important;">
    <!--begin::Messenger-->
    <div class="card w-100 rounded-0" id="kt_drawer_cart_messenger">
      <!--begin::Card header-->
      <div class="card-header pe-5" id="kt_drawer_cart_messenger_header" style="min-height: auto;">

        <!--begin::Title-->
        <div class="card-title">
          <!--begin::User-->
          <div class="d-flex justify-content-center flex-column me-3">
            <a href="#" class="fs-4 fw-bolder text-gray-900 text-hover-primary me-1 mb-2 lh-1">
              {{ $t('shopping_cart') }}
            </a>
          </div>
          <!--end::User-->
        </div>
        <!--end::Title-->

        <!--begin::Card toolbar-->
        <div class="card-toolbar">
          <!--begin::Close-->
          <div class="btn btn-sm btn-icon btn-active-light-primary" id="kt_drawer_cart_close">
            <!--begin::Svg Icon | path: icons/duotone/Navigation/Close.svg-->
            <span class="svg-icon svg-icon-2">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
									<g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)" fill="#000000">
										<rect fill="#000000" x="0" y="7" width="16" height="2" rx="1"></rect>
										<rect fill="#000000" opacity="0.5" transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)" x="0" y="7" width="16" height="2" rx="1"></rect>
									</g>
								</svg>
							</span>
            <!--end::Svg Icon-->
          </div>
          <!--end::Close-->
        </div>
        <!--end::Card toolbar-->
      </div>
      <!--end::Card header-->

      <!--begin::Card body-->
      <div class="card-body" id="kt_drawer_cart_messenger_body">
        <!--begin::Messages-->
        <div class="scroll-y me-n5 pe-5"
             data-kt-element="messages"
             data-kt-scroll="true"
             data-kt-scroll-activate="true"
             data-kt-scroll-height="auto"
             data-kt-scroll-dependencies="#kt_drawer_cart_messenger_header, #kt_drawer_cart_messenger_footer"
             data-kt-scroll-wrappers="#kt_drawer_cart_messenger_body"
             data-kt-scroll-offset="0px">

          <div v-if="model">

            <!--begin::Item-->
            <div
              v-for="item in model.items"
              :key="`cart-item-${item.id}`"
              class="d-flex align-items-sm-center mb-7">
              <!--begin::Symbol-->
              <div v-if="item.product" class="symbol symbol-45px symbol-2by3 me-4">
                <div class="symbol-label" :style="`background-image:url('/p/image-${item.product.id}.jpg')`"></div>
              </div>
              <div v-else-if="item.formation" class="symbol symbol-45px symbol-2by3 me-4">
                <div class="symbol-label" :style="`background-image:url('/f/image-${item.formation.id}.jpg')`"></div>
              </div>
              <div v-else-if="item.consultation && item.consultation.expert" class="symbol symbol-45px symbol-2by3 me-4">
                <div class="symbol-label" :style="`background-image:url('/u/image-${item.consultation.expert.id}.jpg')`"></div>
              </div>
              <div v-else class="symbol symbol-45px symbol-2by3 me-4">
                <div class="symbol-label"></div>
              </div>
              <!--end::Symbol-->
              <!--begin::Title-->
              <div class="d-flex flex-row-fluid flex-wrap align-items-center">
                <div class="flex-grow-1 me-2">
                  <a v-if="item.product" href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">{{ item.product.name }}</a>
                  <a v-else-if="item.formation" href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Formation "{{ item.formation.name }}"</a>
                  <a v-else-if="item.consultation" href="#" class="text-gray-800 fw-bolder text-hover-primary fs-6">Consultation {{ item.consultation.name }}</a>
                  <span class="text-muted fw-bold d-block pt-1">
                    {{ $t('quantity') }}: {{ item.quantity }} / {{ $t('row_total') }}: {{ item.row_total }}{{ item.currency }}</span>
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

        </div>
        <!--end::Messages-->
      </div>
      <!--end::Card body-->
      <div v-if="model" class="card-footer pt-4" id="kt_drawer_cart_messenger_footer">
        <div class="d-flex align-items-center justify-content-between mb-7">
          <span class="font-weight-bold text-muted font-size-sm mr-2">Montant HT</span>
          <span class="font-weight-bolder text-primary text-right">{{ model.sub_total }} {{ model.currency }}</span>
        </div>
        <div class="d-flex align-items-center justify-content-between mb-7">
          <span class="font-weight-bold text-muted font-size-sm mr-2">TVA</span>
          <span class="font-weight-bolder text-primary text-right">{{ model.vat_total }} {{ model.currency }}</span>
        </div>
        <div v-if="model.discount_total > 0" class="d-flex align-items-center justify-content-between mb-7">
          <span class="font-weight-bold text-muted font-size-sm mr-2">Reduction</span>
          <span class="font-weight-bolder text-primary text-right">{{ model.discount_total }} {{ model.currency }}</span>
        </div>

        <div class="d-flex align-items-center justify-content-between mb-4">
          <span class="font-weight-bold text-muted font-size-sm mr-2">Total TTC</span>
          <span class="font-weight-bolder text-dark-50 text-right">{{ model.total }} {{ model.currency }}</span>
        </div>

        <!--begin:Toolbar-->
        <div class="d-flex align-items-right">
          <!--begin::Checkout-->
          <router-link
            id="kt_drawer_cart_toggle"
            :to="{name: 'front.checkout'}"
            class="btn fiche-btn bg-red-4">
            {{ $t('checkout') }}
          </router-link>
          <!--end::Checkout-->
        </div>
        <!--end::Toolbar-->
      </div>

    </div>
    <!--end::Messenger-->
  </div>
  <!--end::Chat drawer-->
</template>

<script>
import {useStore} from "vuex";
import {onMounted, computed} from "vue";
import {GET_CART, SET_CART} from "../../../services/store/cart.module";
import ApiService from "../../../services/api.service";
import {SET_ERRORS} from "../../../services/store/form.module";

export default {
  name: "KTCartDrawer",
  setup() {
    const store = useStore()

    const model = computed(() => store.getters.currentCart)

    const loadModel = () => {
      store.dispatch(GET_CART)
    }
    onMounted(loadModel)

    const handleDelete = (item) => {
      ApiService.delete('/carts/' + model.value.id, {data: {id: item.id}})
        .then((response) => {
          if(response.data.success){
            loadModel()
          }
        })
    }

    return {
      model,
      handleDelete,
    }
  }
};
</script>
