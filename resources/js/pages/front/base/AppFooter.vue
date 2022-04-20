<template>
  <!--begin::Footer Section-->
  <div class="py-20 section-footer">
    <!--begin::Wrapper-->
    <div>

      <!--begin::Container-->
      <div class="container py-20">
        <!--begin::Separator-->
        <div class="separator my-15"></div>
        <!--end::Separator-->
        <!--begin::Row-->
        <div class="row">
          <!--begin::Col-->
          <div class="col-lg-4 footer-logo">
            <!--begin::Logo-->
            <a href="">
              <img alt="Logo" src="/img/logo-dark.svg" class="h-30px h-md-50px">
            </a>
            <!--end::Logo image-->
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-lg-8">
            <!--begin::Navs-->
            <div class="d-md-flex align-items-stretch justify-content-between w-100">
              <!--begin::Links-->
              <div class="d-flex fw-bold flex-column w-30 footer-col">
                <!--begin::Subtitle-->
                <h4 class="fw-bolder text-white mb-6 canela-regular">Découvrir</h4>
                <!--end::Subtitle-->
                <!--begin::Link-->
                <router-link :to="{name:'front.formations.list'}" class="text-white  text-hover-primary fs-5 mb-6 font-moche-regular">Cours</router-link>
                <!--end::Link-->
                <!--begin::Link-->
                <router-link :to="{name:'front.formations.list'}" class="text-white  text-hover-primary fs-5 mb-6 font-moche-regular">Consultations</router-link>
                <!--end::Link-->
                <!--begin::Link-->
                <router-link :to="{name:'front.calendar'}" class="text-white  text-hover-primary fs-5 mb-6 font-moche-regular">Calendrier</router-link>
                <!--end::Link-->
                <!--begin::Link-->
                <router-link :to="{name:'front.disciplines.list'}" class="text-white  text-hover-primary fs-5 mb-6 font-moche-regular">Discipline</router-link>
                <!--end::Link-->
              </div>
              <!--end::Links-->
              <!--begin::Links-->
              <div class="d-flex fw-bold flex-column w-30 footer-col">
                <!--begin::Subtitle-->
                <h4 class="fw-bolder text-white mb-6 canela-regular">Suivez-nous</h4>
                <!--end::Subtitle-->
                <!--begin::Link-->
                <a href="https://www.instagram.com/divii_fr/" target="_blank" class="mb-6">
                  <span class="text-white text-hover-primary fs-5 mb-6 font-moche-regular">Instagram</span>
                </a>
                <!--end::Link-->
                <!--begin::Link-->
                <a href="https://www.facebook.com/divii.co" class="mb-6" target="_blank">
                  <span class="text-white text-hover-primary fs-5 mb-6 font-moche-regular">Facebook</span>
                </a>
                <!--end::Link-->
                <!--begin::Link-->
                <a href="https://www.linkedin.com/company/divii/" target="_blank" class="mb-6">
                  <span class="text-white text-hover-primary fs-5 mb-6 font-moche-regular">Linkedin</span>
                </a>
                <!--end::Link-->
              </div>
              <!--end::Links-->
              <!--begin::Links-->
              <div v-if="model" class="d-flex fw-bold flex-column w-40 footer-col">
                <!--begin::Subtitle-->
                <h4 class="fw-bolder text-white mb-6 canela-regular">Inscrivez-vous à notre newsletter</h4>
                <!--end::Subtitle-->

                <form method="post" @submit.prevent="submit" class=" w-100 mb-5 mb-lg-0 position-relative canela-regular" autocomplete="off">

                  <!--begin::Input-->
                  <input
                    type="email"
                    class="input-newsletter border-0 border-bottom border-bottom-1 w-100 h-40px pe-13 text-white eina3-regular"
                    name="email"
                    v-model="model.email"
                    placeholder="Entrez l'adresse email">
                  <!--end::Input-->

                  <!--begin::Icon-->
                  <span @click="submit" v-if="!loading" class="svg-icon svg-icon-2 svg-icon-gray-700 position-absolute top-50 end-0 translate-middle-y me-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <rect opacity="0.5" x="18" y="13" width="13" height="2" rx="1" transform="rotate(-180 18 13)" fill="black"/>
                      <path d="M15.4343 12.5657L11.25 16.75C10.8358 17.1642 10.8358 17.8358 11.25 18.25C11.6642 18.6642 12.3358 18.6642 12.75 18.25L18.2929 12.7071C18.6834 12.3166 18.6834 11.6834 18.2929 11.2929L12.75 5.75C12.3358 5.33579 11.6642 5.33579 11.25 5.75C10.8358 6.16421 10.8358 6.83579 11.25 7.25L15.4343 11.4343C15.7467 11.7467 15.7467 12.2533 15.4343 12.5657Z" fill="black"/>
                    </svg>
                  </span>
                  <!--end::Icon-->

                  <!--begin::Spinner-->
                  <span v-if="loading" class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5">
                    <span class="spinner-border h-15px w-15px align-middle text-gray-400"></span>
                  </span>
                  <!--end::Spinner-->

                  <!--begin::Reset-->
                  <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4">
                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                    <span class="svg-icon svg-icon-2 me-0">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                      </svg>
                    </span>
                    <!--end::Svg Icon-->
                    </span>
                  <!--end::Reset-->
                </form>

              </div>
              <!--end::Links-->
            </div>
            <!--end::Navs-->
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->
      </div>
      <!--end::Container-->

      <!--begin::Container-->
      <div class="container canela-regular text-center">

        <!--begin::Row-->
        <div class="row">

          <!--begin::Col-->
          <div class="col-lg-12">
            <!--begin::Menu-->
            <ul class=" menu-hover-primary align-items-stretch justify-content-between fw-bold fs-6 fs-md-5 order-1 mb-5 mb-md-0 d-md-inline-flex">
              <li class="menu-item">
                <span class="menu-link px-5">© 2022 All right reserved.</span>
              </li>
              <li class="menu-item">
                <a href="/cgv" target="_blank" class="menu-link px-2">Conditions générales de vente</a>
              </li>
              <li class="menu-item mx-5">
                <a href="/cgu" target="_blank" class="menu-link px-2">Conditions générales d'utilisation</a>
              </li>
              <li class="menu-item">
                <a href="/politique-de-confidentialite" target="_blank" class="menu-link px-2">Politique de confidentialité</a>
              </li>
              <li class="menu-item">
                <a href="/mentions-legales" target="_blank" class="menu-link px-2">Mentions légales</a>
              </li>
            </ul>
            <!--end::Menu-->
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->
      </div>
      <!--end::Container-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Footer Section-->
</template>

<script>
import {onMounted, ref, watch} from "vue";
import ApiService from "../../../services/api.service";

export default {
  name: "AppFooter",
  setup(){
    const loading = ref(false)
    const model = ref(null)
    const initialModel = {
      email: null,
    }
    const init = () => {
      model.value = Object.assign({}, initialModel);
    }
    onMounted(init)

    const submit = () => {
      loading.value = true
      const data = model.value
      ApiService.post('/newsletter', data)
        .then((response) => {
          if(response.data.success){
            toastr.success("Vous avez souscrit a notre newsletter")
            init()
          }else{
            toastr.error(response.data.message)
          }
        })
        .finally(() => {
          loading.value = false
        })
    }

    return {
      model,
      loading,
      submit,
    }
  }
};
</script>
