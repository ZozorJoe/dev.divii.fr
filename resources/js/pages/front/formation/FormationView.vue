<template>
  <!--begin::List Section-->
  <div class="bg-grad-4"></div>
  <div class="h-100">
    <!--begin::Container-->
    <div class="container">
      <div class="row g-10 g-xl-10">
        <div class="col-12">
          <div class="card mt-5 h-100 fiche-expert">
            <div v-if="model" class="card-body">
              <!--begin::Details-->
              <div class="d-md-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="fiche-left-block position-relative">
                  <div class="image-block  scale-block ">
                    <img :src="`/f/image-${model.id}.jpg`" alt="image" class="fiche-profil">
                  </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                  <!--begin::Title-->
                  <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                      <!--begin::Name-->
                      <div class="fiche-titre canela-thin-italic">
                        <div class="position-absolute fiche-icon">
                          <img alt="" :src="`/f/picto-${model.id}.jpg`" width="100">
                        </div>
                        {{ model.name }}
                      </div>
                      <!--end::Name-->
                    </div>
                    <!--end::User-->
                  </div>
                  <!--end::Title-->

                  <!--begin::Dates-->
                  <div class="row my-5 eina3-regular formation-sub-title text-uppercase">
                    <div v-if="model.disciplines && model.disciplines.length" class="col-3 border-end border-dark text-center">
                      <router-link :to="{name: 'front.disciplines.view', params:{id:model.disciplines[0].id}}">{{ model.disciplines[0].name }}</router-link>
                    </div>
                    <div class="col-3 border-end border-dark text-center">
                      <span>{{ $filters.formatDayMonth(model.start_at)}}</span>
                    </div>
                    <div class="col-3 border-end border-dark text-center">
                      <span class="text-uppercase">De {{ $filters.formatHour(model.start_at) }}</span>
                      <span class="text-uppercase ms-2" v-if="model.end_at">à {{ $filters.formatHour(model.end_at) }}</span>
                    </div>
                    <div class="col-3 text-uppercase text-center">
                      {{ model.price }}€ le cours
                    </div>
                  </div>
                  <!--end::Dates-->

                  <!--begin::Description-->
                   <div v-html="model.description" class="d-flex flex-wrap font-eina01-regular fiche-detail">
                  </div>
                  <!--end::Description-->

                  <!--begin::Stats-->
                  <div class="row my-10">
                    <div v-if="model.user" class="col-md-6 d-flex flex-column">
                      <div class="formation-description-footer font-eina03-R text-uppercase">Avec le consultant :</div>
                      <!--begin::Name-->
                      <div class="d-flex justify-content-start flex-column mt-2">
                        <div class="text-dark italic-noe26">
                          {{ model.user.first_name }}
                        </div>
                        <span v-if="model.user.disciplines && model.user.disciplines.length" class=" d-block formation-liste-them font-eina01-regular">
                          <span v-for="(discipline, index) in model.user.disciplines">
                            {{ discipline.name }}
                            <span v-if="index < model.user.disciplines.length - 1">, </span>
                          </span>
                        </span>
                      </div>
                      <!--end::Name-->
                    </div>
                    <div class="col-md-6">
                      <button v-if="!isTest() || isTester" @click="addToCart" type="button" class="fiche-btn formation-btn btn rounded-pill text-dark bg-green text-uppercase px-20 py-4" >Réserver</button>
                      <router-link v-else :to="{name: 'front.welcome'}" class="fiche-btn formation-btn btn rounded-pill text-dark bg-green text-uppercase px-20 py-4" >Réserver</router-link>
                    </div>
                  </div>
                  <!--end::Stats-->
                </div>
                <!--end::Info-->
              </div>
              <!--end::Details-->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--end::Container-->
  </div>
  <!--end::List Section-->
</template>

<script>
import ApiService from "../../../services/api.service";
import {useRoute, useRouter} from "vue-router";
import {computed, onMounted, ref} from "vue";
import {useI18n} from "vue-i18n";
import {useStore} from "vuex";
import {SET_CART} from "../../../services/store/cart.module";

export default {
  name: 'FormationView',
  setup() {
    const router = useRouter()
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    const model = ref(null)
    const initModel = (value) => {
      model.value = Object.assign({}, value);
    }
    const loadModel = () => {
      const params = null
      ApiService.show('/formations/' + route.params.id, params, t('formation'), initModel, store, t)
    }

    onMounted(loadModel)

    const addToCart = () => {
      ApiService.post('/carts', {formation_id: route.params.id})
        .then((response) => {
          if(response.data.success) {
            store.commit(SET_CART, response.data.data)
            router.push({name:'front.checkout'})
          }else{
            Swal.fire({
              title: response.data.message,
              icon: "error",
              showCancelButton: false,
              confirmButtonText: t('yes'),
            })
          }
        })
    }

    const isTest = () => {
      console.log('isTest', process.env.MIX_APP_TEST)
      return process.env.MIX_APP_TEST
    }

    const isTester = computed(() => {
      console.log('isTester', store.getters.currentUser && store.getters.currentUser.is_tester)
      return store.getters.currentUser && store.getters.currentUser.is_tester
    })

    return {
      model,
      isTester,
      addToCart,
      isTest,
    }

  }
}
</script>
