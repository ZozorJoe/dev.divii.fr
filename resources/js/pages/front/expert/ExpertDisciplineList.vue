<template>
  <!--begin::List Section-->
  <div>
    <div class="bg-grad-2"></div>
    <!--begin::Container-->
    <div class="container">
      <div class="row g-10 g-xl-10">
        <div class="col-12">
          <div class="card mt-5 h-100 fiche-expert bg-transparent">
            <div v-if="model" class="card-body">
              <!--begin::Details-->
              <div class="d-md-flex flex-wrap flex-sm-nowrap">
                <!--begin: Pic-->
                <div class="fiche-left-block position-relative">
                  <div class="image-block  scale-block ">
                    <img :src="`/u/image-${model.id}.jpg`" alt="image" class="fiche-profil">
                  </div>
                  <div class="avis-btn-wrapper">
                    <span class="avis-btn fiche-btn btn bg-green" data-bs-toggle="modal" data-bs-target="#avisModal">Lire les avis</span>
                  </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                  <!--begin::Title-->
                  <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <!--begin::User-->
                    <div class="fiche-titre-wrapper">
                      <!--begin::Name-->
                      <div class="fiche-titre canela-thin-italic">
                        <div class="position-absolute fiche-icon">
                          <img alt="" :src="`/u/picto-${model.id}.jpg`" width="100">
                        </div>
                        {{ model.first_name }}
                        <div class="notation notation-fiche">
                          <span class="black-star">&nbsp;</span>
                          <span class="black-star">&nbsp;</span>
                          <span class="black-star">&nbsp;</span>
                          <span class="empty-star">&nbsp;</span>
                          <span class="empty-star">&nbsp;</span>
                        </div>
                      </div>
                      <!--end::Name-->
                    </div>
                    <!--end::User-->
                  </div>
                  <!--end::Title-->

                  <!--begin::Description-->
                  <div
                    class="d-flex flex-wrap font-eina01-regular fiche-detail"
                    v-html="model.description"
                  >
                  </div>
                  <!--end::Description-->
                </div>
                <!--end::Info-->
              </div>
              <!--end::Details-->
            </div>
          </div>
        </div>
      </div>

      <div class="d-flex flex-column container pt-lg-20 sub-header-consultations">
        <!--begin::Heading-->
        <div class="page-title text-center">
          <h1 class="canela-thin mb-20"><span class="canela-thin-italic">Mes</span> disciplines</h1>
        </div>
        <!--end::Heading-->
      </div>

      <!--begin::Layout-->
      <div class="container">

        <div class="row">
          <div class="col-md-3 m-auto">
            <InputSearch v-model="search" />
          </div>
        </div>

        <div class="g-5 g-xl-8">

            <div id="disciplineCarousel" class="carousel carousel-custom slide" data-bs-interval="4000" >
              <div class="me-20 arrow-block arrow-block-carousel-page">
                <button class="carousel-control-prev" type="button" data-bs-target="#disciplineCarousel" data-bs-slide="prev">
                  <span aria-hidden="true"><img src="/img/icon/arrow-slide-left.svg" alt="prev"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#disciplineCarousel" data-bs-slide="next">
                  <span aria-hidden="true"><img src="/img/icon/arrow-slide-right.svg" alt="next"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
              <div class="carousel-inner">
                  <div v-for="(items, index) in models" :key="items" :class="{ 'active': index === 0 }" class="row rows-block carousel-item ">
                    <div
                      v-for="model in items"
                      :key="`discipline-item-${model.id}`"
                      class="discipline-item-slide col-sm-6 col-lg-4 col-xl-3">
                      <ExpertDisciplineItem :discipline="model" class="h-100" />
                    </div>
                </div>
              </div>
              <div class="carousel-indicators">
                <button v-for="(items, index) in models" :key="index" type="button" data-bs-target="#disciplineCarousel" :data-bs-slide-to="index" class="active" aria-current="true" aria-label="Slide"></button>
              </div>
            </div>
        </div>
        <!--end::Row-->

        <!--begin::Row-->
        <div v-if="loading" class="row">
          <div class="text-center my-10">
            <span class="spinner-border text-white"></span>
          </div>
        </div>

      </div>
      <div class="avis-modal">
        <div class="modal fade gradient-2" id="avisModal" tabindex="-1" aria-labelledby="les avis" aria-hidden="true">
          <div class="modal-dialog  modal-xl modal-dialog-centered">
            <div class="modal-content modal-bg ">
              <div class="modal-header ">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <!--liste avis-->
                <div class="avis-item">
                  <p class="avis-user canela-thin-italic"><span class="avis-name">Sarah</span><span class="avis-date">Le 12/04/22</span></p>
                  <div class="notation notation-liste">
                      <span class="black-star">&nbsp;</span>
                      <span class="black-star">&nbsp;</span>
                      <span class="black-star">&nbsp;</span>
                      <span class="empty-star">&nbsp;</span>
                      <span class="empty-star">&nbsp;</span>
                  </div>
                  <p class="avis-description font-eina03-regular">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                </div>
                <div class="avis-item">
                  <p class="avis-user canela-thin-italic"><span class="avis-name">Sarah</span><span class="avis-date">Le 12/04/22</span></p>
                  <div class="notation notation-liste">
                    <span class="black-star">&nbsp;</span>
                    <span class="black-star">&nbsp;</span>
                    <span class="black-star">&nbsp;</span>
                    <span class="empty-star">&nbsp;</span>
                    <span class="empty-star">&nbsp;</span>
                  </div>
                  <p class="avis-description font-eina03-regular">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                </div>
                <div class="avis-item">
                  <p class="avis-user canela-thin-italic"><span class="avis-name">Sarah</span><span class="avis-date">Le 12/04/22</span></p>
                  <div class="notation notation-liste">
                    <span class="black-star">&nbsp;</span>
                    <span class="black-star">&nbsp;</span>
                    <span class="black-star">&nbsp;</span>
                    <span class="empty-star">&nbsp;</span>
                    <span class="empty-star">&nbsp;</span>
                  </div>
                  <p class="avis-description font-eina03-regular">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </p>
                </div>

                <!--liste avis-->


              </div>
            </div>
          </div>
        </div>
      </div>
      <!--end::Layout-->

    </div>
    <!--end::Container-->
  </div>
  <!--end::List Section-->
</template>

<script>
import {ref, onMounted, computed, watch} from "vue";
import ApiService from "../../../services/api.service";
import {useRoute} from "vue-router";
import ExpertDisciplineItem from "./ExpertDisciplineItem";
import {useI18n} from "vue-i18n";
import {useStore} from "vuex";
export default {
  name: 'ExpertDisciplineList',
  components: {ExpertDisciplineItem},
  setup(){
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    const disciplines = ref([])
    const page = ref(1)
    const per_swipe = ref(8)
    const per_page = ref(5 * per_swipe.value)
    const meta = ref(null)
    const search = ref(null)
    const loading = ref(false)

    const params = computed(() => {
      let data = {'page' : page.value, count: 'users'}
      if(per_page.value){
        data['per-page'] = per_page.value
      }
      if(search.value){
        data['s'] = search.value
      }
      return data
    })

    const changePerPage = (value) => {
      per_page.value = value
    }

    const chunk = (array, size) =>
        array.reduce((acc, _, i) => {
      if (i % size === 0) acc.push(array.slice(i, i + size))
        return acc
    }, [])

    const loadModels = () => {
      loading.value = true
      ApiService.get('/experts/' + route.params.id + '/disciplines', {params: params.value})
        .then(({data}) => {
          if(data.success){
            meta.value = data.meta
            const curPage = data.meta.current_page
            disciplines.value[curPage] = data.data
            if(curPage === 1){
              //nextTick(scrollBottom)
            }else{
              const lastPage = data.meta.last_page
              if(lastPage <= curPage){
                page.value = lastPage
              }
            }
          }
        })
        .finally(() => {
          loading.value = false
        })
    }
    onMounted(loadModels)
    watch(() => search.value, () => {loadModels()})

    const models = computed(() => {
      let all = [];
      const keys = Object.keys(disciplines.value);
      keys.sort().forEach(key => {
        const data = disciplines.value[key];
        all = [...all, ...data]
      })
      return chunk(all, per_swipe.value)
     // return all;
    })

    const isLastPage = computed(() => {
      return meta.value && disciplines.value.length > meta.value.last_page;
    })

    watch(() => page.value, () => {loadModels()} )

    const randomIcon = () => {
      const values = [1, 2, 3, 4, 5, 6, 7, 8]
      return values[Math.floor(Math.random()*values.length)];
    }

    const model = ref(null)
    const initModel = (value) => {
      model.value = Object.assign({}, value);
    }
    const loadModel = () => {
      const params = {params:{with:'disciplines'}}
      ApiService.show('/experts/' + route.params.id, params, t('expert'), initModel, store, t)
    }
    onMounted(loadModel)

    return {
      model,
      models,
      page,
      meta,
      search,
      loading,
      isLastPage,
      loadModels,
      changePerPage,
      randomIcon,
    }
  }
}
</script>
