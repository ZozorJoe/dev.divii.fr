<template>
  <ConsultationListAll :filter="-1" :cancelable="false" />
</template>

<script>
import ConsultationListAll from "./ConsultationListAll";

export default {
  name: 'ConsultationListPast',
  components: {ConsultationListAll},
}
</script>
