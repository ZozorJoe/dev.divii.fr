<template>
  <!--begin::List Section-->
  <div class="bg-grad-2"></div>
  <div class="">
    <!--begin::Container-->
    <div class="container-fluid">

      <div class="d-flex flex-column container pt-lg-20">
        <!--begin::Heading-->
        <div class="page-title text-center">
          <h1 class="canela-thin mb-20"><span class="canela-thin-italic">les</span> consultants</h1>
        </div>
        <!--end::Heading-->
      </div>


      <div class="container">

      <!--  <div class="row">
          <div class="col-3 m-auto">
            <InputSearch v-model="search" />
          </div>
        </div>-->

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
              <!--end::Col-->
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

          <!--begin::Row-->
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
import FormationItem from "../formation/FormationItem";
import ExpertItem from "./ExpertItem";
import {useRoute} from "vue-router";

export default {
  name: 'DisciplineExpertList',
  components: {FormationItem, ExpertItem},
  setup(){
    const route = useRoute()

    const formations = ref([])
    const page = ref(1)
    const per_swipe = ref(8)
    const per_page = ref(5 * per_swipe.value)
    const meta = ref(null)
    const search = ref(null)
    const loading = ref(false)

    const params = computed(() => {
      let data = {'page' : page.value}
      data['with'] = 'disciplines'
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
      ApiService.get('/disciplines/' + route.params.id + '/experts', {params: params.value})
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
      return chunk(all, per_swipe.value);
    })

    const isLastPage = computed(() => {
      return meta.value && formations.value.length > meta.value.last_page;
    })

    watch(() => page.value, () => {loadModels()} )

    onMounted(() => {
      $(window).scroll(function() {
        if(loading.value){
          return;
        }

        if(isLastPage.value){
          return;
        }

        if($(window).scrollTop() + $(window).height() >= $(document).height()){
          page.value++
        }
      });
    })

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
