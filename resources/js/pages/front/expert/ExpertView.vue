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
                    <img :src="`/u/image-${model.id}.jpg`" alt="image" class="fiche-profil">
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
                          <img alt="" :src="`/u/picto-${model.id}.jpg`" width="100">
                        </div>{{ model.first_name }}</div>
                      <!--end::Name-->
                      <!--begin::Info-->
                      <div v-if="model.disciplines.length" class="d-flex flex-wrap fiche-sous-titre canela-regular-italic">
                        <router-link
                          v-for="discipline in model.disciplines"
                          :key="discipline.id"
                          :to="{name: 'front.disciplines.view', params:{id: discipline.id}}"
                          class="d-flex ">
                          {{ discipline.name }}
                        </router-link>
                      </div>
                      <!--end::Info-->
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

                  <!--begin::Stats-->

                  <!--begin::Wrapper-->
                  <div class="d-md-flex flex-row btn-fiche-wrapper">
                    <!--<router-link :to="{name: 'front.experts.formations.list'}" class="btn border border-dark rounded-pill text-dark text-uppercase fiche-btn left-btn " >Voir ses cours</router-link>-->
                    <router-link :to="{name: 'front.experts.disciplines.list'}" class="btn rounded-pill text-dark bg-green text-uppercase px-20 fiche-btn" >Sélectionner</router-link>
                    <!--<router-link :to="{name: 'front.experts.consultation'}" class="d-none btn border border-dark rounded-pill text-dark text-uppercase fiche-btn " >Consultation</router-link>-->
                  </div>
                  <!--end::Wrapper-->

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
import CalendarView from "./CalendarView";

export default {
  name: 'ExpertView',
  components: {CalendarView},
  setup() {
    const route = useRoute()
    const store = useStore()
    const { t } = useI18n()

    const model = ref(null)
    const initModel = (value) => {
      model.value = Object.assign({}, value);
    }
    const loadModel = () => {
      const params = {params:{with:'disciplines'}}
      ApiService.show('/experts/' + route.params.id, params, t('expert'), initModel, store, t)
    }

    onMounted(loadModel)

    const randomIcon = () => {
      const values = [1, 2, 3, 4, 5, 6, 7, 8]
      return values[Math.floor(Math.random()*values.length)];
    }

    return {
      model,
      randomIcon,
    }

  }
}
</script>
