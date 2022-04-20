<template>
  <!--begin::Menu-->
  <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">

    <router-link
      :to="{ name: 'customer.dashboard' }"
      tag="div"
      class="menu-item"
      v-slot="{ href, route, navigate, isActive, isExactActive }"
    >
      <a
        :href="href"
        @click="navigate"
        class="menu-link"
        :class="{'active': isExactActive }"
      >
        <span class="menu-icon">
          <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
          <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
              <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
              <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
            </svg>
          </span>
          <!--end::Svg Icon-->
        </span>
        <span class="menu-title">{{ $t('dashboard') }}</span>
      </a>
    </router-link>

    <div class="menu-item">
      <div class="menu-content pt-8 pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $t('shop') }}</span>
      </div>
    </div>
    <router-link
      :to="{ name: 'customer.orders' }"
      tag="div"
      class="menu-item"
      v-slot="{ href, route, navigate, isActive, isExactActive }"
    >
      <a
        :href="href"
        @click="navigate"
        class="menu-link"
        :class="{'active': isExactActive }"
      >
        <span class="menu-icon">
          <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
          <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
              <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
              <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
            </svg>
          </span>
          <!--end::Svg Icon-->
        </span>
        <span class="menu-title">{{ $t('orders') }}</span>
      </a>
    </router-link>

    <div class="menu-item">
      <div class="menu-content pt-8 pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Mes Rendez-vous</span>
      </div>
    </div>
    <router-link
      :to="{ name: 'customer.sale.consultations' }"
      tag="div"
      class="menu-item"
      v-slot="{ href, route, navigate, isActive, isExactActive }"
    >
      <a
        :href="href"
        @click="navigate"
        class="menu-link"
        :class="{'active': isExactActive }"
      >
        <span class="menu-icon">
          <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
          <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
              <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
              <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
            </svg>
          </span>
          <!--end::Svg Icon-->
        </span>
        <span class="menu-title">Mes consultations</span>
      </a>
    </router-link>
    <router-link
      :to="{ name: 'customer.sale.formations' }"
      tag="div"
      class="menu-item"
      v-slot="{ href, route, navigate, isActive, isExactActive }"
    >
      <a
        :href="href"
        @click="navigate"
        class="menu-link"
        :class="{'active': isExactActive }"
      >
        <span class="menu-icon">
          <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
          <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
              <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
              <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
            </svg>
          </span>
          <!--end::Svg Icon-->
        </span>
        <span class="menu-title">Mes cours</span>
      </a>
    </router-link>

    <div class="menu-item">
      <div class="menu-content pt-8 pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $t('facturation') }}</span>
      </div>
    </div>
    <router-link
      :to="{ name: 'customer.invoices' }"
      tag="div"
      class="menu-item"
      v-slot="{ href, route, navigate, isActive, isExactActive }"
    >
      <a
        :href="href"
        @click="navigate"
        class="menu-link"
        :class="{'active': isExactActive }"
      >
        <span class="menu-icon">
          <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
          <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
              <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
              <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
            </svg>
          </span>
          <!--end::Svg Icon-->
        </span>
        <span class="menu-title">{{ $t('invoices') }}</span>
      </a>
    </router-link>

    <div class="menu-item">
      <div class="menu-content pt-8 pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $t('my_infos') }}</span>
      </div>
    </div>
    <router-link
      :to="{ name: 'customer.account' }"
      tag="div"
      class="menu-item"
      v-slot="{ href, route, navigate, isActive, isExactActive }"
    >
      <a
        :href="href"
        @click="navigate"
        class="menu-link"
        :class="{'active': isExactActive }"
      >
        <span class="menu-icon">
          <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
          <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
              <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
              <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
            </svg>
          </span>
          <!--end::Svg Icon-->
        </span>
        <span class="menu-title">{{ $t('my_infos') }}</span>
      </a>
    </router-link>

    <div class="menu-item">
      <div class="menu-content pt-8 pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $t('others') }}</span>
      </div>
    </div>
    <router-link
      :to="{ name: 'customer.contact' }"
      tag="div"
      class="menu-item"
      v-slot="{ href, route, navigate, isActive, isExactActive }"
    >
      <a
        :href="href"
        @click="navigate"
        class="menu-link"
        :class="{'active': isExactActive }"
      >
        <span class="menu-icon">
          <!--begin::Svg Icon | path: icons/duotone/Design/PenAndRuller.svg-->
          <span class="svg-icon svg-icon-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
              <path d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z" fill="#000000" opacity="0.3" />
              <path d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z" fill="#000000" />
            </svg>
          </span>
          <!--end::Svg Icon-->
        </span>
        <span class="menu-title">{{ $t('contact') }}</span>
      </a>
    </router-link>


  </div>
  <!--end::Menu-->
</template>

<script>
import {useRoute} from "vue-router";

export default {
  name: "KTAsideMenu",
  setup(){
    const route = useRoute()

    const hasActiveChildren = (match) => {
      return false; //route["path"].indexOf(match) !== -1;
    }

    return {
      hasActiveChildren,
    }
  },
};
</script>
