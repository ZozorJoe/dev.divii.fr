<template>
  <!--begin::Section-->
  <div class="bg-grad-2"></div>
  <div class="mt-10 mb-20 cc" id="cc-calendar">
    <!--begin::Container-->
    <div class="container text-white">
        <!--begin::Inbox App - Messages -->
        <div class="d-flex flex-column flex-lg-row">
          <!--begin::Content-->
          <div class="flex-lg-row-fluid me-lg-7 ms-xl-10">
            <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-4 pb-3 mx-5">
              <div class="me-2">
                <span class="fw-bolder text-white text-capitalize d-block fs-3">{{ $filters.format(date, "MMMM YYYY") }}</span>
              </div>

              <div v-if="expert && expert.available" class="me-2">
                <button @click="openModal()" class="btn with-zindex rounded-pill bg-red btn-icon-dark text-uppercase">
                  Réserver maintenant
                </button>
              </div>

              <div class="d-flex align-items-center">
                <a @click="previous" class="btn btn-icon btn-sm btn-active-light-primary rounded fw-bolder p-8 me-2">
                  <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr074.svg-->
                  <span class="svg-icon svg-icon-muted svg-icon-2hx me-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M11.2657 11.4343L15.45 7.25C15.8642 6.83579 15.8642 6.16421 15.45 5.75C15.0358 5.33579 14.3642 5.33579 13.95 5.75L8.40712 11.2929C8.01659 11.6834 8.01659 12.3166 8.40712 12.7071L13.95 18.25C14.3642 18.6642 15.0358 18.6642 15.45 18.25C15.8642 17.8358 15.8642 17.1642 15.45 16.75L11.2657 12.5657C10.9533 12.2533 10.9533 11.7467 11.2657 11.4343Z" fill="black"/>
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                </a>
                <a @click="next" class="btn btn-icon btn-sm btn-active-light-primary rounded fw-bolder p-8 me-2">
                  <!--begin::Svg Icon | path: assets/media/icons/duotune/arrows/arr071.svg-->
                  <span class="svg-icon svg-icon-muted svg-icon-2hx ms-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <path d="M12.6343 12.5657L8.45001 16.75C8.0358 17.1642 8.0358 17.8358 8.45001 18.25C8.86423 18.6642 9.5358 18.6642 9.95001 18.25L15.4929 12.7071C15.8834 12.3166 15.8834 11.6834 15.4929 11.2929L9.95001 5.75C9.5358 5.33579 8.86423 5.33579 8.45001 5.75C8.0358 6.16421 8.0358 6.83579 8.45001 7.25L12.6343 11.4343C12.9467 11.7467 12.9467 12.2533 12.6343 12.5657Z" fill="black"/>
                    </svg>
                  </span>
                  <!--end::Svg Icon-->
                </a>
              </div>
            </div>

            <!--begin::Calendar wrapper-->
            <div v-if="events" class="cc-wrapper">
              <table class="cc-table">
                <thead>
                  <th>Lun.</th>
                  <th>Mar.</th>
                  <th>Mer.</th>
                  <th>Jeu.</th>
                  <th>Ven.</th>
                  <th>Sam.</th>
                  <th>Dim.</th>
                </thead>
                <tbody>
                  <!--begin::Row-->
                  <tr
                    v-for="(days, index) in dates"
                    :key="`cc-row-${index}`"
                    class="cc-row">
                    <td
                      v-for="(day, index2) in days"
                      :key="`cc-date-${index}-${index2}`"
                      class="cc-date"
                      :class="{'cc-past': $filters.isPast(day), 'cc-available': isAvailable(day), 'cc-active': isActive(day)}">
                      <span
                        v-if="day > 0 && $filters.isPast(day)">
                        {{ day.format('D') }}
                      </span>
                      <span
                        @click="openAside(day)"
                        v-else-if="day > 0">
                        {{ day.format('D') }}
                      </span>
                    </td>
                  </tr>
                  <!--begin::Row-->
                </tbody>
              </table>

            </div>
            <!--end::Calendar wrapper-->

            <!--begin::Calendar wrapper-->
            <div v-if="!events" class="cc-wrapper">
              <table class="cc-table">
                <thead>
                  <th>Lun.</th>
                  <th>Mar.</th>
                  <th>Mer.</th>
                  <th>Jeu.</th>
                  <th>Ven.</th>
                  <th>Sam.</th>
                  <th>Dim.</th>
                </thead>
                <tbody>
                  <!--begin::Row-->
                  <tr
                    v-for="(days, index) in dates"
                    :key="`cc-row-${index}`"
                    class="cc-row">
                    <td
                      v-for="(day, index2) in days"
                      :key="`cc-date-${index}-${index2}`"
                      class="cc-date">
                      <span>
                        {{ $filters.format(day, 'D') }}
                      </span>
                    </td>
                  </tr>
                  <!--begin::Row-->
                </tbody>
              </table>

            </div>
            <!--end::Calendar wrapper-->

            <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-4 pb-3 mx-5">
              <div class="me-2">
                <TimezoneSelect class="min-w-200px" />
              </div>
            </div>
          </div>
          <!--end::Content-->

          <!--begin::Sidebar-->
          <div
            v-if="selectedDate"
            class="flex-column flex-lg-row-auto w-100 w-lg-300px mb-10 mb-lg-0">
            <!--begin::Sticky aside-->
            <div class="card card-flush mb-0 h-100">
              <div class="card-header" id="kt_cc_header">
                <div class="card-title">
                  <h2>{{ $filters.format(selectedDate.date, 'LL') }}</h2>
                </div>
              </div>
              <!--begin::Aside content-->
              <div class="card-body pt-0 scroll h-400px">
                <div>
                  <div id="kt_cc_content">
                    <!--begin::Item-->
                    <div
                      v-for="(slot, index) in selectedDate.slots"
                      :key="`cc-slot-${index}`"
                      class="p-4  mb-2 cc-slot"
                    >
                      <!--begin::Section-->
                      <div class="cc-time text-center">
                        <!--begin::Title-->
                        <div class="m-2">
                          <span class="fs-6 fw-bolder">{{ $filters.formatTime(slot.start) }}</span>
                        </div>
                        <!--end::Title-->
                      </div>
                      <!--end::Section-->

                      <!--begin::Label-->
                      <button type="button" @click="openModal(slot)" class="cc-btn btn btn-sm rounded-pill text-uppercase">Confirmer</button>
                      <!--end::Label-->
                    </div>
                    <!--end::Item-->
                  </div>
                </div>
              </div>
              <!--end::Aside content-->
              <div class="card-footer" id="kt_cc_footer"></div>
            </div>
            <!--end::Sticky aside-->
          </div>
          <!--end::Sidebar-->
        </div>
        <!--end::Inbox App - Messages -->

      <div class="modal fade" :class="{'show d-block': model.date && durations.length}">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-xl">
          <!--begin::Modal content-->
          <div class="modal-content rounded">
            <!--begin::Modal header-->
            <div class="modal-header justify-content-end border-0 pb-0">
              <!--begin::Close-->
              <div @click="closeModal" class="btn btn-sm btn-icon btn-active-color-primary">
                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                <span class="svg-icon svg-icon-1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="black"></rect>
                    <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black"></rect>
                  </svg>
                </span>
                <!--end::Svg Icon-->
              </div>
              <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body pt-0 pb-15 px-5 px-xl-20">
              <!--begin::Heading-->
              <div class="mb-13 text-center">
                <h1 class="mb-3">Réservation</h1>
                <div class="text-muted fw-bold fs-5">Réservation de la date
                  <a href="#" class="link-primary fw-bolder">{{ $filters.formatDateTime(model.date) }}</a>.</div>
              </div>
              <!--end::Heading-->
              <!--begin::Plans-->
              <div class="d-flex flex-column">

                <!--begin::Row-->
                <div class="row mt-10">
                  <!--begin::Col-->
                  <div
                    v-for="duration in durations"
                    class="col-lg-6 mb-10 mb-lg-0">
                    <!--begin::Tab link-->
                    <div
                      class="btn btn-outline btn-outline-dashed btn-color-dark btn-active btn-active-primary d-flex flex-stack text-start p-6 mb-6">
                      <!--end::Description-->
                      <div class="d-flex align-items-center me-2">
                        <!--begin::Radio-->
                        <div class="form-check form-check-custom form-check-solid form-check-success me-6">
                          <input v-model="model.duration" class="form-check-input" type="radio" name="plan" :value="duration">
                        </div>
                        <!--end::Radio-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                          <h2 class="d-flex align-items-center fs-2 fw-bolder flex-wrap">{{ duration.label }}</h2>
                        </div>
                        <!--end::Info-->
                      </div>
                      <!--end::Description-->
                      <!--begin::Price-->
                      <div class="ms-5">
                        <span class="fs-3x fw-bolder">{{ duration.price }}</span>
                        <span class="mb-2 ms-2">€</span>
                      </div>
                      <!--end::Price-->
                    </div>
                    <!--end::Tab link-->
                  </div>
                  <!--end::Col-->
                </div>
                <!--end::Row-->
              </div>
              <!--end::Plans-->
              <!--begin::Actions-->
              <div class="d-flex flex-center flex-row-fluid pt-12">
                <button @click="closeModal" type="reset" class="btn btn-light me-3">Annuler</button>
                <button :disabled="!durations.length" @click="create" type="submit" class="btn btn-primary">Réserver</button>
              </div>
              <!--end::Actions-->
            </div>
            <!--end::Modal body-->
          </div>
          <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
      </div>

    </div>
    <!--end::Container-->
  </div>
  <!--end::Section-->
</template>

<script>

import {computed, nextTick, onMounted, ref, watch} from "vue";
import ApiService from "../../../services/api.service";
import {useStore} from "vuex";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {SET_ERRORS} from "../../../services/store/form.module";
import {SET_CART} from "../../../services/store/cart.module";
import TimezoneSelect from "../../../components/utils/TimezoneSelect";
import {VERIFY_AUTH} from "../../../services/store/auth.module";

export default {
  name: 'CalendarView',
  components: {TimezoneSelect},
  setup() {
    const route = useRoute()
    const router = useRouter()
    const store = useStore()
    const { t } = useI18n()
    const model = ref({
      duration: null,
      date: null,
      durations: [],
    })

    const getData = () => {
      const data = {}
      data.date = model.value.date
      if(model.value.duration){
        data.duration_id = model.value.duration.id
      }else{
        data.duration_id = null
      }
      return data
    }

    const create = () => {
      const data = getData()
      axios.post('/api/v1/experts/' + route.params.id  + '/disciplines/' + route.params.discipline + '/consultations', data)
        .then((response) => {
          store.commit(SET_ERRORS, {})
          if(response.data.success) {
            if(response.data.order){
              console.warn('OK', response.data.order)
              model.value.date = null
              store.dispatch(VERIFY_AUTH)
              Swal.fire({
                title: "Votre demande à bien été prise en question.",
                showCancelButton: false,
                confirmButtonText: `D'accord`,
              })
            }else{
              console.error('KO', response.data.message)
              model.value.date = null
            }
            loadEvents()
          }else{
            model.value.date = null
            if(response.data.consultation){
              Swal.fire({
                title: response.data.message,
                showCancelButton: true,
                confirmButtonText: 'Payer autrement',
                cancelButtonText: `Annuler`,
              }).then((result) => {
                if (result.isConfirmed) {
                  addToCart(response.data.consultation.id);
                }
              })
            }else{
              Swal.fire(
                'Oups!',
                response.data.message,
                'warning'
              )
            }
          }
        })
    }

    const params = computed(() => {
      let data = {'per-page' : -1}
      if(model.value && model.value.date){
        data['date'] = model.value.date
      }
      return data
    })
    const durations = ref([])
    const loadDurations = () => {
      if(!model.value.date){
        return;
      }
      durations.value = []
      if(!blockUI.value){
        const target = document.querySelector("#cc-calendar");
        blockUI.value = new KTBlockUI(target);
      }
      if (!blockUI.value.isBlocked()) {
        blockUI.value.block()
      }
      ApiService.get('/experts/' + route.params.id  + '/disciplines/' + route.params.discipline + '/durations', {params: params.value})
        .then(({data}) => {
          if(data.success) {
            durations.value = data.data
            if(!data.data.length){
              model.value.date = null
              toastr.error("Votre consultant n’est pas disponible pour pour cette durée. Veuillez essayer un autre créneau.")
            }
          }
        })
        .finally(() => {
          if (blockUI.value.isBlocked()) {
            blockUI.value.release();
          }
        })
    }
    watch(() => params.value, () => { loadDurations() })

    const addToCart = (id) => {
      ApiService.post('/carts', {consultation_id: id})
        .then((response) => {
          if(response.data.success) {
            store.commit(SET_CART, response.data.data)
            router.push({name:'front.checkout'})
          }
        })
    }
    const openModal = (item) => {
      if(item){
        model.value.date = item.start
      }else{
        // Réserver maintenant
        const date = (new Date())
        date.setMinutes(date.getMinutes() + 15)
        const minute = date.getMinutes()

        const now = new Date(date)
        if(minute <= 15){
          now.setMinutes(15)
        }else if(minute <= 30){
          now.setMinutes(30)
        }else if(minute <= 45){
          now.setMinutes(45)
        }else{
          now.setHours(date.getHours() + 1)
          now.setMinutes(0)
        }
        model.value.date = now.toISOString()
      }
    }
    const closeModal = () => {
      model.value.date = null
    }

    const selectedDate = ref(null)
    const openAside = (day) => {
      const format = moment(day).format("YYYY-MM-DD")
      selectedDate.value = events.value[format]
      nextTick(() => {
        KTScroll.createInstances()
      })
    }
    const closeAside = () => {
      selectedDate.value = null
    }

    const date = ref(moment())
    const previous = () => {
      date.value = date.value.clone().add(-1, 'month')
    }
    const next = () => {
      date.value = date.value.clone().add(1, 'month')
    }

    const dates = ref([])
    const fillDate = () => {
      dates.value = []
      const start = date.value.clone().startOf('month')
      const end = date.value.clone().endOf('month')

      // init items
      let items = new Array(7)
      items.fill(0)

      let $date = start.clone()
      while ($date.isBefore(end)){
        let day = parseInt($date.format('E'))
        items[day-1] = $date.clone()
        if(day % 7 === 0){
          dates.value.push(items)

          // reset items
          items = new Array(7)
          items.fill(0)
        }
        $date.add(1, 'day')

        // While broken
        if(!$date.isBefore(end)){
          dates.value.push(items)
        }
      }
    }
    onMounted(fillDate)
    watch(() => date.value, () => {
      fillDate();
      loadEvents();
    })

    const $timezone = computed(() => store.getters.timezone)
    watch(() => $timezone.value, () => { loadEvents() })

    const blockUI = ref(null)

    const events = ref(null)
    const loadEvents = () => {
      if(!blockUI.value){
        const target = document.querySelector("#cc-calendar");
        blockUI.value = new KTBlockUI(target);
      }
      if (!blockUI.value.isBlocked()) {
        blockUI.value.block()
      }
      const params = {params:{date:date.value.toISOString(), 'timezone': $timezone.value}}
      axios.get('/api/v1/experts/' + route.params.id  + '/disciplines/' + route.params.discipline + '/events', params)
        .then((response) => {
          setEvents(response.data.data)
          if(events.value){
            // Refresh selected
            if(selectedDate.value){
              const format = moment(selectedDate.value.date).format("YYYY-MM-DD")
              selectedDate.value = events.value[format]
            }

            if(!selectedDate.value){
              selectedDate.value = events.value[Object.keys(events.value)[0]]
            }
          }
        })
        .finally(() => {
          if (blockUI.value.isBlocked()) {
            blockUI.value.release();
          }
        })
    }
    onMounted(loadEvents)
    const setEvents = (value) => {
      events.value = value
    }
    const isAvailable = (day) => {
      const format = moment(day).format("YYYY-MM-DD")
      return events.value && events.value[format]
    }
    const isActive = (day) => {
      if(selectedDate.value && day){
        return moment(day).format("YYYY-MM-DD") === moment(selectedDate.value.date).format("YYYY-MM-DD")
      }
      return false
    }

    const slots = ref([])

    const expert = ref(null)
    const initExpert = (value) => {
      expert.value = value;
    }
    const loadExpert = () => {
      const params = {params:{with:'disciplines'}}
      ApiService.show('/experts/' + route.params.id, params, t('expert'), initExpert, store, t)
    }
    onMounted(loadExpert)

    return {
      expert,
      slots,
      events,
      dates,
      date,
      durations,
      model,
      selectedDate,
      isAvailable,
      isActive,
      previous,
      next,
      openAside,
      closeAside,
      create,
      openModal,
      closeModal,
    }
  }
}
</script>
