<template>
  <!--begin::List Section-->
  <div>
    <!--begin::Container-->
    <div class="bg-grad-2"></div>
    <div class="container-fluid">
      <SubHeaderConsultations/>
      <!--begin::Layout-->
      <div class="container">

        <div class="row">
            <div class="col-md-3 m-auto">
              <InputSearch v-model="search" />
            </div>
        </div>

        <!--begin::Row-->
        <div class="rg-5 g-xl-8" id="expert_list">
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
            <!--begin::Col-->
            <div class="carousel-inner">
              <div v-for="(items, index) in models" :key="items" :class="{ 'active': index === 0 }" class="row rows-block carousel-item ">
                <div
                        v-for="model in items"
                        :key="`expert-item-${model.id}`"
                        class="discipline-item-slide col-sm-6 col-lg-4 col-xl-3">
                  <ExpertItem :expert="model" class="h-100" />
                </div>
              </div>
            </div>
            <div class="carousel-indicators">
              <button v-for="(items, index) in models" :key="index" type="button" data-bs-target="#disciplineCarousel" :data-bs-slide-to="index" class="active" aria-current="true" aria-label="Slide"></button>
            </div>
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->

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
import ExpertItem from "./ExpertItem";
import SubHeaderConsultations from "./../base/SubHeaderConsultations";
import InputSearch from "../../../components/form/InputSearch";
export default {
  name: 'ExpertList',
  components: {InputSearch, ExpertItem, SubHeaderConsultations},
  setup(){
    const experts = ref([])
    const page = ref(1)
    const per_swipe = ref(8)
    const per_page = ref(5 * per_swipe.value)
    const meta = ref(null)
    const search = ref(null)
    const loading = ref(false)

    const params = computed(() => {
      let data = {'page' : page.value, 'with': 'disciplines'}
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
      ApiService.get('/experts', {params: params.value})
        .then(({data}) => {
          if(data.success){
            meta.value = data.meta
            const curPage = data.meta.current_page
            experts.value[curPage] = data.data
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
      const keys = Object.keys(experts.value);
      keys.sort().forEach(key => {
        const data = experts.value[key];
        all = [...all, ...data]
      })
      return chunk(all, per_swipe.value)
    })

    const isLastPage = computed(() => {
      return meta.value && experts.value.length > meta.value.last_page;
    })

    watch(() => page.value, () => {loadModels()} )

    const randomIcon = () => {
      const values = [1, 2, 3, 4, 5, 6, 7, 8]
      return values[Math.floor(Math.random()*values.length)];
    }

    return {
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
