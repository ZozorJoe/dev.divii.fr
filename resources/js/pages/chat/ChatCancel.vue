<template>
  <!--begin::Content-->
  <div v-if="room" class="content d-flex flex-column flex-column-fluid" id="kt_content">

    <!--begin::Post-->
    <div class="post d-flex flex-column-fluid" id="kt_post">
      <!--begin::Container-->
      <div id="kt_content_container" class="container-fluid">

        <div class="card card-flush h-100" id="kt_contacts_main">
          <!--begin::Card body-->
          <div class="card-body p-0">
            <!--begin::Wrapper-->
            <div class="card-px text-center py-20 my-10">
              <!--begin::Title-->
              <h2 v-if="room.formation" class="fs-2x fw-bolder mb-10">Annulation du cours</h2>
              <h2 v-if="room.consultation" class="fs-2x fw-bolder mb-10">Annulation de consultation</h2>
              <!--end::Title-->
              <!--begin::Description-->
              <p class="text-gray-400 fs-4 fw-bold mb-10">Etes-vous sur d'annuler cette réunion?</p>
              <!--end::Description-->
              <!--begin::Action-->
              <button @click="submit" class="btn btn-primary">Annuler</button>
              <!--end::Action-->
            </div>
            <!--end::Wrapper-->
          </div>
          <!--end::Card body-->
        </div>

      </div>
      <!--end::Container-->
    </div>
    <!--end::Post-->

  </div>
  <!--end::Content-->
</template>

<script>
import {onMounted, ref, watch} from "vue";
import {useRoute} from "vue-router";
import ApiService from "../../services/api.service";
import {SET_ERRORS} from "../../services/store/form.module";

export default {
  name: 'ChatCancel',
  setup() {
    const route = useRoute()
    const room =  ref(null)
    const loadModel = (value) => {
      if(!value){
        return;
      }
      ApiService.get('/account/rooms/' + value)
        .then((response) => {
          if(response.data.success) {
            room.value = response.data.data
          }
        })
        .catch(({response}) => {
          if(response && response.data && response.data.errors){
            store.commit(SET_ERRORS, response.data.errors);
          }
        })
    }

    const id = ref(null)
    watch(() => id.value, (value) => loadModel(value))
    onMounted(() => { id.value = route.params.id })

    const submit = () => {
      const data = {
        status: 'canceled',
        content: null,
      }
      ApiService.put('/account/rooms/' + route.params.id, data)
      .then((response) => {
        if(response.data.success){
          Swal.fire({
            title: "La réunion a été bien annulée",
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "Ok, d'accord!",
            customClass: {
              confirmButton: "btn btn-success"
            }
          }).then(() => {
            location.href = '/'
          })
        }else{
          Swal.fire({
            title: "Une erreur s'est produite.",
            icon: "error",
            buttonsStyling: false,
            confirmButtonText: "Ok, d'accord!",
            customClass: {
              confirmButton: "btn btn-success"
            }
          })
        }
      })
      .catch(() => {
        Swal.fire({
          title: "Une erreur s'est produite. Veuillez réessayer svp!",
          icon: "error",
          buttonsStyling: false,
          confirmButtonText: "Ok!",
          customClass: {
            confirmButton: "btn btn-success"
          }
        })
      })
    }

    return {
      room,
      submit
    }
  },
}
</script>
