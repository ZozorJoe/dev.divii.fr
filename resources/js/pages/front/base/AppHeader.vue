<template>
  <!--begin::Header Section-->
  <div class="section-header">
    <!--begin::Wrapper-->
    <div>
      <!--begin::Header-->
      <div class="landing-header border-bottom border-bottom-1 border-light">
        <!--begin::Container-->
        <div class="container-fluid">
          <!--begin::Wrapper-->
          <div class="d-flex align-items-center justify-content-between">

            <!--begin::Logo-->
            <div class="d-flex align-items-center">
              <!--begin::Logo image-->
              <router-link :to="{name: 'home'}">
                <img alt="Logo" src="/img/logo-dark.svg" class="logo-default">
              </router-link>
              <!--end::Logo image-->
            </div>
            <!--end::Logo-->

            <!--begin::Menu wrapper-->
            <div class="d-flex align-items-end justify-content-between">
              <!--begin::Trigger button-->
              <a id="kt_landing_menu_toggle" class="toggle-mobile-menu d-flex align-items-end justify-content-between d-lg-none"><img alt="Menu" src="/img/icon/burger-icon.svg" class=" h-25px"></a>
              <!--end::Trigger button-->
              <div class="d-lg-block p-5 p-lg-0" data-kt-drawer="true" data-kt-drawer-name="landing-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="300px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_landing_menu_toggle" data-kt-place="true" data-kt-place-mode="prepend" data-kt-place-parent="{default: '#kt_body', lg: '#kt_header_nav_wrapper'}">
                <!--begin::Menu-->
                <div class="menu menu-column flex-nowrap menu-rounded font-moche-regular menu-lg-row menu-title-light menu-state-title-primary nav nav-flush fs-5 fw-bold header-menu" id="kt_landing_menu">
                  <!--begin::Menu item-->
                  <div class="menu-item">
                    <!--begin::Menu link-->
                    <router-link :to="{name: 'front.experts.list'}" class="menu-link nav-link py-3 px-4 px-xxl-6">Consultations</router-link>
                    <!--end::Menu link-->
                  </div>
                  <!--end::Menu item-->
                  <!--begin::Menu item-->
                  <div class="menu-item">
                    <!--begin::Menu link-->
                    <router-link :to="{name: 'front.calendar'}" class="menu-link nav-link py-3 px-4 px-xxl-6">Cours</router-link>
                    <!--end::Menu link-->
                  </div>
                  <!--end::Menu item-->
                  <!--begin::Menu item-->
                  <div class="menu-item">
                    <!--begin::Menu link-->
                    <router-link :to="{name: 'front.tarifs'}" class="menu-link nav-link py-3 px-4 px-xxl-6">Tarifs</router-link>
                    <!--end::Menu link-->
                  </div>
                  <div class="menu-item">
                    <span class="menu-link nav-link py-3 px-4 px-xxl-6" data-bs-toggle="modal" data-bs-target="#commentCaMarcheModal">Comment ça marche?</span>
                  </div>
                  <!--end::Menu item-->

                  <!--begin::Menu item-->
                  <div v-if="!isAuthenticated" class="menu-item">
                    <!--begin::Menu link-->
                    <router-link :to="{name: 'login'}" class="d-flex align-items-center ms-1 ms-lg-3 login-link">
                      <!--begin::Menu wrapper-->
                      <div class="symbol-30px symbol-md-40px">
                        <img alt="se connecter" width="40" src="/img/avatar.svg" />
                      </div>
                      <!--end::Menu wrapper-->
                    </router-link>
                    <!--end::Menu link-->
                  </div>
                  <!--end::Menu item-->

                  <!--begin::Dismiss button-->
                  <a class="close-btn" data-kt-drawer-dismiss="true">
                    <img alt="Fermer le menu" src="/img/icon/close-icon.svg" class="h-25px" />
                  </a>
                  <!--end::Dismiss button-->
                  <UserMenu />

                  <!--begin::Menu item-->
                  <div v-if="cart" class="menu-item">
                    <!--begin::Menu link-->
                    <div class="d-flex align-items-center ms-1 ms-lg-3">
                      <!--begin::Menu wrapper-->
                      <div class="btn btn-icon btn-active-light-primary position-relative w-30px h-30px w-md-40px h-md-40px" id="kt_drawer_cart_toggle">
                        <!--begin::Svg Icon | path: icons/duotune/communication/com012.svg-->
                        <span class="svg-icon svg-icon-1">
													<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                              <rect x="0" y="0" width="24" height="24"></rect>
                              <path d="M12,4.56204994 L7.76822128,9.6401844 C7.4146572,10.0644613 6.7840925,10.1217854 6.3598156,9.76822128 C5.9355387,9.4146572 5.87821464,8.7840925 6.23177872,8.3598156 L11.2317787,2.3598156 C11.6315738,1.88006147 12.3684262,1.88006147 12.7682213,2.3598156 L17.7682213,8.3598156 C18.1217854,8.7840925 18.0644613,9.4146572 17.6401844,9.76822128 C17.2159075,10.1217854 16.5853428,10.0644613 16.2317787,9.6401844 L12,4.56204994 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                              <path d="M3.5,9 L20.5,9 C21.0522847,9 21.5,9.44771525 21.5,10 C21.5,10.132026 21.4738562,10.2627452 21.4230769,10.3846154 L17.7692308,19.1538462 C17.3034221,20.271787 16.2111026,21 15,21 L9,21 C7.78889745,21 6.6965779,20.271787 6.23076923,19.1538462 L2.57692308,10.3846154 C2.36450587,9.87481408 2.60558331,9.28934029 3.11538462,9.07692308 C3.23725479,9.02614384 3.36797398,9 3.5,9 Z M12,17 C13.1045695,17 14,16.1045695 14,15 C14,13.8954305 13.1045695,13 12,13 C10.8954305,13 10,13.8954305 10,15 C10,16.1045695 10.8954305,17 12,17 Z" fill="#000000"></path>
                            </g>
                          </svg>
												</span>
                        <!--end::Svg Icon-->
                      </div>
                      <!--end::Menu wrapper-->
                    </div>
                    <!--end::Menu link-->
                  </div>
                  <!--end::Menu item-->

                </div>
                <!--end::Menu-->
              </div>
            </div>
            <!--end::Menu wrapper-->

          </div>
          <!--end::Wrapper-->
        </div>
        <!--end::Container-->
      </div>
      <!--end::Header-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Header Section-->
</template>

<script>
import {useStore} from "vuex";
import {computed, nextTick, onMounted} from "vue";

export default {
  name: "AppHeader",
  setup(){
    const store = useStore()
    const isAuthenticated = computed(() => store.getters.isAuthenticated)
    const cart = computed(() => store.getters.currentCart)

    onMounted(() => {
      nextTick(function(){ KTMenu.createInstances(); });
    })

    return {
      isAuthenticated,
      cart,
    }
  }
};
</script>
