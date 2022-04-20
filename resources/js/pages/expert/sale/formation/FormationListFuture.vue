<template>
  <FormationListAll :filter="1" :cancelable="true" />
</template>

<script>
import FormationListAll from "./FormationListAll";

export default {
  name: 'FormationListToday',
  components: {FormationListAll},
}
</script>
