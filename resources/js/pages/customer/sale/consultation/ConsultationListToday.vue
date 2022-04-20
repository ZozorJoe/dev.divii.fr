<template>
  <ConsultationListAll :filter="0"  :cancelable="true"/>
</template>

<script>
import ConsultationListAll from "./ConsultationListAll";

export default {
  name: 'ConsultationListToday',
  components: {ConsultationListAll},
}
</script>
