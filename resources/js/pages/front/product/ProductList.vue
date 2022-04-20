<template>
  <!--begin::List Section-->
  <div class="bg-grad-4"></div>
  <div class="">
    <!--begin::Container-->
    <div class="container">

      <div class="d-flex flex-column container pt-lg-20">
        <!--begin::Heading-->
        <div class="page-title text-center">
          <h1 class="canela-thin-italic mb-5">Crédits</h1>
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
              :key="`product-item-${model.id}`"
              class="col-md-3">

              <div class="d-flex h-100 align-items-center">
                <!--begin::Option-->
                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-light py-15 px-10">
                  <!--begin::Heading-->
                  <div class="mb-7 text-center">
                    <!--begin::Title-->
                    <h1 class="text-dark mb-5 fw-boldest">{{ model.name }}</h1>
                    <!--end::Title-->

                    <!--begin::Price-->
                    <div class="text-center">
                      <span class="fs-3x fw-bolder text-primary">{{ model.price }}</span>
                      <span class="mb-2 text-primary">€</span>
                    </div>
                    <!--end::Price-->
                  </div>
                  <!--end::Heading-->

                  <!--begin::Select-->
                  <button
                    type="button"
                    class="btn btn-sm btn-primary"
                    @click="addToCart(model.id)">
                    Acheter
                  </button>
                  <!--end::Select-->
                </div>
                <!--end::Option-->
              </div>

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
import {useStore} from "vuex";
import {SET_CART} from "../../../services/store/cart.module";

export default {
  name: 'ProductList',
  setup(){
    const store = useStore()

    const products = ref([])
    const page = ref(1)
    const per_page = ref(null)
    const meta = ref(null)
    const search = ref(null)
    const loading = ref(false)

    const params = computed(() => {
      let data = {'page' : page.value}
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
      ApiService.get('/products', {params: params.value})
        .then(({data}) => {
          if(data.success){
            meta.value = data.meta
            const curPage = data.meta.current_page
            products.value[curPage] = data.data
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
      const keys = Object.keys(products.value);
      keys.sort().forEach(key => {
        const data = products.value[key];
        all = [...all, ...data]
      })
      return all;
    })

    const isLastPage = computed(() => {
      return meta.value && products.value.length > meta.value.last_page;
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

    const addToCart = (id) => {
      ApiService.post('/carts', {product_id: id})
        .then((response) => {
          if(response.data.success) {
            store.commit(SET_CART, response.data.data)
          }
        })
    }

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
      addToCart,
    }
  }
}
</script>
