<template>
  <!--begin::Inbox App -->
  <div class="d-flex flex-column flex-lg-row">
    <!--begin::Content-->
    <div class="flex-lg-row-fluid me-lg-7 ms-xl-10">
      <div class="d-flex flex-stack flex-wrap flex-grow-1 px-9 pt-4 pb-3 mx-5">
        <div class="me-2">
          <span class="fw-bolder text-white d-block fs-3">{{ date.format("MMMM YYYY") }}</span>
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
                @click="openAside(day)"
                v-if="day > 0">
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
                v-for="(item, index) in selectedDate.items"
                class="d-flex align-items-center mb-8">
                <div v-if="item.formation" class="d-flex align-items-center flex-grow-1">
                  <div class="symbol symbol-45px me-5">
                    <img :src="`/f/image-${item.formation.id}.jpg`" alt="">
                  </div>
                  <div class="d-flex justify-content-start flex-column">
                    <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">{{ item.formation.name }}</a>
                    <span class="text-muted fw-bold text-muted d-block fs-7">{{ $filters.formatTime(item.start) }} à {{ $filters.formatTime(item.end) }}</span>
                  </div>
                </div>
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
  <!--end::Inbox App -->
</template>

<script>
import {nextTick, onMounted, ref, watch} from "vue";

export default {
  name: 'FormationListAgenda',
  setup(){
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
    watch(() => date.value, () => {fillDate()})

    const events = ref(null)
    const loadEvents = () => {
      const params = {params:{date:date.value.toISOString()}}
      axios.get('/api/v1/expert/sale/formations/events', params)
        .then((response) => {
          if(response.data.success){
            events.value = response.data.data
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
          }
        })

    }
    onMounted(loadEvents)
    watch(() => date.value, () => {loadEvents()})

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

    return {
      events,
      dates,
      date,
      selectedDate,
      previous,
      next,
      isAvailable,
      isActive,
      openAside,
      closeAside,
    }

  }
}
</script>
