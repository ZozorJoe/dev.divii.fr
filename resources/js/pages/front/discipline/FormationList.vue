<template>
  <!--begin::List Section-->
  <div class="bg-grad-2"></div>
  <div class="">
    <!--begin::Container-->
    <div class="container">

      <div class="d-flex flex-column container pt-lg-20">
        <!--begin::Heading-->
        <div class="page-title text-center">
          <h1 class="h1 fs-2hx fw-bolder text-white mb-5">Discipline: Cours</h1>
        </div>
        <!--end::Heading-->
      </div>

      <div class="d-flex">

        <!--begin::Layout-->
        <div class="w-100">

          <!--begin::Row-->
          <div class="row g-6 g-xl-9">
            <!--begin::Col-->
            <div
              v-for="model in models"
              :key="`formation-item-${model.id}`"
              class="col-md-3">
              <FormationItem :formation="model" />
            </div>
            <!--end::Col-->
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
          <div v-if="isLastPage" class="row">
            <div class="text-center my-10">
              <span class="text-white">Tout est chargé</span>
            </div>
          </div>
          <!--end::Row-->
        </div>
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
import {useRoute} from "vue-router";
import {useStore} from "vuex";

export default {
  name: 'DisciplineFormationList',
  components: {FormationItem},
  setup(){
    const store = useStore()
    const route = useRoute()

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
      ApiService.get('/disciplines/' + route.params.id + '/formations', {params: params.value})
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
      return all;
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
