<template>
  <!--begin::Menu-->
  <div class="menu menu-column menu-title-gray-800 menu-state-title-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500" id="#kt_aside_menu" data-kt-menu="true">
    <router-link
      :to="{ name: 'expert.dashboard' }"
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
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $t('catalog') }}</span>
      </div>
    </div>
    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
      <span class="menu-link">
          <span class="menu-icon">
              <!--begin::Svg Icon | path: icons/duotone/Communication/Group.svg-->
              <span class="svg-icon svg-icon-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                      <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                      <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"></path>
                  </svg>
              </span>
            <!--end::Svg Icon-->
          </span>
          <span class="menu-title">{{ $t('formations') }}</span>
          <span class="menu-arrow"></span>
      </span>
      <div class="menu-sub menu-sub-accordion" :class="{ 'show': hasActiveChildren('/formations') }">
        <router-link
          :to="{ name: 'expert.formations' }"
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
            <i class="menu-bullet">
              <span class="bullet bullet-dot"></span>
            </i>
            <span class="menu-title">{{ $t('list') }}</span>
          </a>
        </router-link>
        <router-link
          :to="{ name: 'expert.formations.create' }"
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
            <i class="menu-bullet">
              <span class="bullet bullet-dot"></span>
            </i>
            <span class="menu-title">{{ $t('create') }}</span>
          </a>
        </router-link>
      </div>
    </div>

    <div class="menu-item">
      <div class="menu-content pt-8 pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">Mes rendez-vous</span>
      </div>
    </div>
    <router-link
      :to="{ name: 'expert.sale.consultations' }"
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
        <span class="menu-title">{{ $t('consultations') }}</span>
      </a>
    </router-link>
    <router-link
      :to="{ name: 'expert.sale.formations' }"
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
        <span class="menu-title">{{ $t('classes') }}</span>
      </a>
    </router-link>

    <div class="menu-item">
      <div class="menu-content pt-8 pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $t('my_infos') }}</span>
      </div>
    </div>
    <router-link
      :to="{ name: 'expert.account' }"
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
    <router-link
      :to="{ name: 'expert.time-slots' }"
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
        <span class="menu-title">{{ $t('my_time_slots') }}</span>
      </a>
    </router-link>
    <router-link
      :to="{ name: 'expert.disciplines' }"
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
        <span class="menu-title">{{ $t('my_disciplines') }}</span>
      </a>
    </router-link>

    <div class="menu-item">
      <div class="menu-content pt-8 pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $t('facturations') }}</span>
      </div>
    </div>
    <router-link
      :to="{ name: 'expert.invoices' }"
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
        <span class="menu-title">{{ $t('invoices_validated') }}</span>
      </a>
    </router-link>
    <router-link
      :to="{ name: 'expert.invoices.ping' }"
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
        <span class="menu-title">{{ $t('invoices_ping') }}</span>
      </a>
    </router-link>

    <div class="menu-item">
      <div class="menu-content pt-8 pb-2">
        <span class="menu-section text-muted text-uppercase fs-8 ls-1">{{ $t('others') }}</span>
      </div>
    </div>
    <router-link
      :to="{ name: 'expert.contact' }"
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
import {computed, onMounted} from "vue";
import {useStore} from "vuex";
import {VERIFY_AUTH} from "../../../services/store/auth.module";

export default {
  name: "KTAsideMenu",
  setup(){
    const store = useStore()
    const route = useRoute()

    const hasActiveChildren = (match) => {
      return false; //route["path"].indexOf(match) !== -1;
    }

    const currentUser = computed(() => store.getters.currentUser)
    const verifyAuth = () => {
      store.dispatch(VERIFY_AUTH)
      setTimeout(verifyAuth, 10000)
    }
    onMounted(verifyAuth)

    return {
      currentUser,
      hasActiveChildren,
    }
  },
};
</script>
