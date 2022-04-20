<template>
  <!--begin::List Section-->
  <div class="">
    <!--begin::Container-->
    <div class="container-fluid">

      <div class="d-flex flex-column container pt-lg-20">
        <!--begin::Heading-->
        <div class="page-title text-center">
          <h1 class="titre-noe54  text-white mb-20"><span>Les</span> Cours <span>et les</span> conférences</h1>
        </div>
        <!--end::Heading-->

        <!--begin::Actions-->
        <div class="text-center">
          <!--begin::Nav group-->
          <div class="nav-group d-inline-flex mb-15 bg-transparent text-uppercase">
            <router-link :to="{name: 'front.calendar'}" class="btn border rounded-pill text-white px-20 py-3 me-2" >Calendrier</router-link>
            <router-link :to="{name: 'front.disciplines.list'}" class="btn border rounded-pill text-white px-20 py-3 me-2">Par discipline</router-link>
          </div>
          <!--end::Nav group-->
        </div>
        <!--end::Actions-->
      </div>

      <div class="row">

          <!--begin::Row-->
        <div class="g-5 g-xl-8 col-md-12">
            <!--begin::Col-->
          <div id="disciplineCarousel" class="carousel carousel-custom slide" data-bs-interval="4000" >
            <div class="me-20 arrow-block arrow-block-carousel-page">
              <button class="carousel-control-prev" type="button" data-bs-target="#disciplineCarousel" data-bs-slide="prev">
                <span aria-hidden="true"><img class="rotate-180" src="/img/icon/arrow-light.svg" alt="prev"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#disciplineCarousel" data-bs-slide="next">
                <span aria-hidden="true"><img src="/img/icon/arrow-light.svg" alt="next"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>

            <div class="carousel-inner">
              <div
                v-for="(model, index) in models"  :class="{ 'active': index === 0 }"
                :key="`formation-item-${model.id}`"
                class="formation-item-slide carousel-item">
                <FormationItem :formation="model" class="h-100" />
              </div>
            </div>
            <div class="carousel-indicators">
              <button
                v-for="(items, index) in models"
                :key="index"
                type="button"
                data-bs-target="#disciplineCarousel"
                :data-bs-slide-to="index"
                class="active"
                aria-current="true"
                aria-label="Slide"></button>
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
          <!--end::Row-->

        <!--end::Layout-->
      </div>

    </div>
    <!--end::Container-->

  </div>
  <!--end::List Section-->
</template>

<script>
import {ref, onMounted, computed, watch} from "vue";
import ApiService from "../../../services/api.service";
import FormationItem from "./FormationItem";
import {useStore} from "vuex";


export default {
  name: 'FormationList',
  components: {
    FormationItem,
  },
  setup(){
    const store = useStore()
    const formations = ref([])
    const page = ref(1)
    const per_page = ref(null)
    const meta = ref(null)
    const search = ref(null)
    const loading = ref(false)

    const params = computed(() => {
      let data = {'page' : page.value}
      data['with'] = 'user'
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

    const loadModels = () => {
      loading.value = true
      ApiService.get('/formations', {params: params.value})
        .then(({data}) => {
          if(data.success){
            meta.value = data.meta
            const curPage = data.meta.current_page

            formations.value[curPage] = data.data
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

    const models = computed(() => {
      let all = [];
      const keys = Object.keys(formations.value);
      keys.sort().forEach(key => {
        const data = formations.value[key];
        all = [...all, ...data]
      })
      return all
    })

    const isLastPage = computed(() => {
      return meta.value && formations.value.length > meta.value.last_page;
    })

    watch(() => page.value, () => {loadModels()} )

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { loadModels() })

    return {
      models,
      page,
      meta,
      search,
      loading,
      isLastPage,
      loadModels,
      changePerPage,
    }
  }
}
</script>
