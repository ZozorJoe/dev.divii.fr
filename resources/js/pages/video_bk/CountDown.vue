<template>
  <div class="fs-4 fw-bolder countdown">
    <span v-if="day" class="countdown-day mr-1">{{ day }}d </span><span class="countdown-hour">{{ hour>9?hour:'0'+hour }}</span>:<span class="countdown-min">{{ min>9?min:'0'+min }}</span>:<span class="countdown-sec">{{ sec>9?sec:'0'+sec }}</span>
  </div>
</template>

<script>
import {computed, onMounted, ref, watch} from "vue";

export default {
  name: 'CountDown',
  props: {
    duration: {
      type: Number,
      default: 0,
    },
  },
  setup(props, {emit}) {
    const duration = ref(props.duration);

    const day = computed(() => Math.floor((duration.value / (3600 * 24))))
    const hour = computed(() => Math.floor((duration.value % (3600 * 24)) / 3600))
    const min = computed(() => Math.floor((duration.value % 3600) / 60))
    const sec = computed(() => Math.floor(duration.value % 60))

    console.log(duration.value, day.value, hour.value, min.value, sec.value)

    watch(() => duration.value, (value) => {
      emit("update:modelValue", value)
      setTimeout(() => { if(duration.value > 0){duration.value--;} }, 1000);
    })

    onMounted(() => { if(duration.value > 0){duration.value--;} })

    return {
      day,
      hour,
      min,
      sec,
    }
  }
}
</script>
