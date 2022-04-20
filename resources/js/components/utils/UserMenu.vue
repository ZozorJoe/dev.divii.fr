<template>
  <!--begin::User-->
  <div
    v-if="user"
    class="d-flex align-items-center ms-1 ms-lg-3"
    id="kt_header_user_menu_toggle">
    <!--begin::Menu wrapper-->
    <div class="cursor-pointer symbol symbol-30px symbol-md-40px"
         data-kt-menu-trigger="click"
         data-kt-menu-attach="parent"
         data-kt-menu-placement="bottom-end"
         data-kt-menu-flip="bottom">
      <img src="/img/avatar.svg" alt="avatar">
    </div>
    <!--begin::Menu-->
    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-primary fw-bold py-4 fs-6 w-275px" data-kt-menu="true" style="">
      <!--begin::Menu item-->
      <div class="menu-item px-3">
        <div class="menu-content d-flex align-items-center px-3">
          <!--begin::Avatar-->
          <div class="symbol symbol-50px me-5">
            <img alt="avatar" :src="`/u/image-${user.id}.jpg`">
          </div>
          <!--end::Avatar-->
          <!--begin::Username-->
          <div class="d-flex flex-column">
            <div class="fw-bolder d-flex align-items-center fs-5">
              {{ user.name ? user.name : $t('messages.my.account') }}
              <span v-if="user.role === 'customer'" class="badge fw-bolder fs-8 px-2 py-1 ms-2" :class="{'badge-light-success': user.credit > 0, 'badge-light-danger': user.credit === 0, }">{{ $tc('count.credits2', user.credit) }}</span>
            </div>
            <span class="fw-bold text-muted text-hover-primary fs-7">{{ user.email }}</span>
          </div>
          <!--end::Username-->
        </div>
      </div>
      <!--end::Menu item-->
      <!--begin::Menu separator-->
      <div class="separator my-2"></div>
      <!--end::Menu separator-->
      <!--begin::Menu item-->
      <div class="menu-item px-5">
        <router-link
          v-if="user.role === 'administrator'"
          :to="{name: 'admin.profile.edit'}"
          class="menu-link px-5">
          {{ $t('messages.my.profile') }}
        </router-link>
        <router-link
          v-else-if="user.role === 'expert'"
          :to="{name: 'expert.profile.edit'}"
          class="menu-link px-5">
          {{ $t('messages.my.profile') }}
        </router-link>
        <router-link
          v-else
          :to="{name: 'customer.profile.edit'}"
          class="menu-link px-5">
          {{ $t('messages.my.profile') }}
        </router-link>
      </div>
      <!--end::Menu item-->
      <!--begin::Menu separator-->
      <div class="separator my-2"></div>
      <!--end::Menu separator-->
      <!--begin::Menu item-->
      <div class="menu-item px-5">
        <a
          href="/auth/logout"
          class="menu-link px-5">
          {{ $t('messages.sign.out') }}
        </a>
      </div>
      <!--end::Menu item-->
    </div>
    <!--end::Menu-->
    <!--end::Menu wrapper-->
  </div>
  <!--end::User -->
</template>

<script>
import {computed, nextTick, watch} from "vue";
import {useStore} from "vuex";

export default {
  name: "UserMenu",
  setup(){
    const store = useStore()
    const user = computed(() => store.getters.currentUser)
    watch(() => user.value, () => {
      nextTick(function(){ KTMenu.createInstances(); });
    })
    return {
      user
    }
  }
};
</script>
