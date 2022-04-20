<template>
  <ConsultationListAll :filter="1" :cancelable="true"/>
</template>

<script>
import ConsultationListAll from "./ConsultationListAll";

export default {
  name: 'ConsultationListFuture',
  components: {ConsultationListAll},
}
</script>
