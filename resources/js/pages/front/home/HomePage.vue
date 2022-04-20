<template>
  <!--begin::Main-->
  <div>
    <div class="bg-grad-1"></div>
    <AppSection0/>
    <AppSection1/>
    <AppSection2/>
    <AppSection3/>
    <AppSection4/>
    <AppSection5/>
    <AppSection6/>
    <AppSection7/>
  </div>
  <!--end::Main-->
</template>

<script>
import {onMounted} from "vue";
import AppSection0 from "./section/AppSection0";
import AppSection1 from "./section/AppSection1";
import AppSection2 from "./section/AppSection2";
import AppSection3 from "./section/AppSection3";
import AppSection4 from "./section/AppSection4";
import AppSection5 from "./section/AppSection5";
import AppSection6 from "./section/AppSection6";
import AppSection7 from "./section/AppSection7";

export default {
  name: "HomePage",
  components: {
    AppSection0, AppSection1, AppSection2, AppSection3, AppSection4, AppSection5, AppSection6, AppSection7,
  },
  setup() {
    onMounted(() => {
      $('body').attr('class', 'position-relative')
    })
  }
};
</script>
