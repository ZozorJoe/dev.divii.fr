<template>
  <FormationListAll :filter="-1"  :cancelable="false"/>
</template>

<script>
import FormationListAll from "./FormationListAll";

export default {
  name: 'FormationListToday',
  components: {FormationListAll},
}
</script>
