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
                    <img :src="`/d/image-${model.id}.jpg`" alt="image" class="fiche-profil">
		          </div>
                </div>
                <!--end::Pic-->
                <!--begin::Info-->
                <div class="flex-grow-1">
                  <!--begin::Title-->
                  <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <!--begin::User-->
                    <div class="d-flex flex-column">
                      <!--begin::Name-->
                      <div class="fiche-titre canela-thin-italic">
                        <div class="position-absolute fiche-icon">
                          <img alt="" :src="`/d/picto-${model.id}.jpg`">
                        </div>
                        {{ model.name }}
                      </div>
                      <!--end::Name-->
                    </div>
                    <!--end::User-->
                  </div>
                  <!--end::Title-->

                  <!--begin::Description-->
                  <div v-html="model.description" class="d-flex flex-wrap font-eina01-regular fiche-detail">
                  </div>
                  <!--end::Description-->

                  <!--begin::Stats-->
                  <div class="d-flex flex-wrap btn-fiche-wrapper">
                    <!--begin::Wrapper-->
                    <div class="d-md-flex flex-row moche14">
                      <!--<router-link :to="{name: 'front.disciplines.formations.list'}" class="btn border border-dark rounded-pill text-dark text-uppercase  fiche-btn left-btn " >Voir ses cours</router-link>
                      --><router-link :to="{name: 'front.disciplines.experts.list'}" class="btn rounded-pill text-dark bg-yellow text-uppercase px-20  fiche-btn " >Découvrir</router-link>
                    </div>
                    <!--end::Wrapper-->
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
import {useRoute} from "vue-router";
import {onMounted, ref} from "vue";
import {useI18n} from "vue-i18n";
import {useStore} from "vuex";

export default {
  name: 'DisciplineView',
  setup() {
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    const model = ref(null)
    const initModel = (value) => {
      model.value = Object.assign({}, value);
    }
    const loadModel = () => {
      const params = null
      ApiService.show('/disciplines/' + route.params.id, params, t('discipline'), initModel, store, t)
    }

    onMounted(loadModel)

    return {
      model,
    }

  }
}
</script>
