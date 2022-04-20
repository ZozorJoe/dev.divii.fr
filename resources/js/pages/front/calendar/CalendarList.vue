<template>
  <!--begin::List Section-->
  <div class="bg-grad-2"></div>
  <div class="">
    <!--begin::Container-->
    <div class="container-fluid">
      <SubHeaderCours/>


      <div class="d-flex flex-column calendar-container">
        <CalendarItem
          class="mb-20"
          v-for="date in dates"
          :title="date.title"
          :start="date.start"
          :end="date.end"
        />
      </div>

      <div class="d-flex flex-column btn-wrapper">
        <button type="button" @click="addDates(2)" class="fiche-btn load-more-btn btn rounded-pill text-dark bg-blue px-20 py-3 me-2" >Afficher plus</button>
      </div>

    </div>
    <!--end::Container-->
  </div>
  <!--end::List Section-->
</template>

<script>
import {onMounted, ref} from "vue";
import CalendarItem from "./CalendarItem";
import SubHeaderCours from "./../base/SubHeaderCours";
export default {
  name: 'CalendarList',
  components: {CalendarItem, SubHeaderCours},
  setup(){
    const dates = ref([])
    const lastDate = ref(null)

    onMounted(() => {
      const now = moment('2022-04-02')
      lastDate.value = moment().add(-1, 'month')
      if(now.isAfter(lastDate.value)){
        lastDate.value = now
      }
      addDate()
      addDate()
    })

    const addDate = () => {
      lastDate.value.add(1, 'month')
      const start = moment(lastDate.value).startOf('month').startOf('week').add(1, 'day')
      const end = moment(lastDate.value).endOf('month').endOf('week').add(1, 'day')
      dates.value.push({start: start, end: end, title: moment(lastDate.value).locale('fr').format('MMMM Y')})
    }

    const addDates = (count) => {
      while (count > 0){
        addDate()
        count--
      }
    }

    return {
      dates,
      addDates,
    }
  }
}
</script>
