<template>
  <FormationListAll :filter="0" :cancelable="true" />
</template>

<script>
import FormationListAll from "./FormationListAll";

export default {
  name: 'FormationListToday',
  components: {FormationListAll},
}
</script>
