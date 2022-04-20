<template>
  <!--begin::Section 2-->
  <div class="py-20 section-2">
    <!--begin::Wrapper-->
    <div>
      <!--begin::Container-->
      <div class="container">

        <!--begin::Row-->
        <div class="row gy-10">
          <!--begin::Col-->
          <div class="col-sm-6  ms-auto pe-lg-15 h-100 mb-10">
            <!--begin::Story-->
            <div class="d-flex flex-column h-100 section2-bloc left-block">
              <!--begin::Option-->
              <div class="w-100 d-flex flex-column bg-yellow-7 p-10">
                <!--begin::Heading-->
                <div class="section-heading mb-5">
                  <!--begin::Title-->
                  <h3 class="text-center text-dark mb-5 canela-thin fw-normal">Consultations<br><span class="and canela-thin-italic">par</span> discipline</h3>
                  <!--end::Title-->
                </div>
                <!--end::Heading-->

                <!--begin::Features-->
                <div class="mb-0 canela-thin-italic section2-description text-dark">
                  <!--begin::Item-->
                  <div class="d-flex flex-stack border-bottom border-dark pb-4 mb-5">
                    <span class="text-gray-800 text-start pe-3">Faire un point sur sa vie</span>
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex flex-stack border-bottom border-dark pb-4 mb-5">
                    <span class="text-gray-800 text-start pe-3">Orienter ses choix</span>
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex flex-stack border-bottom border-dark pb-4 mb-5">
                    <span class="text-gray-800 text-start pe-3">Décider en conscience</span>
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex flex-stack pb-2 mb-5">
                    <span class="text-gray-800 text-start pe-3">Consultation privée en ligne</span>
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex mb-n3 scale-block">
                    <img src="/img/homepage/les-consultations.png" />
                  </div>
                  <!--end::Item-->
                </div>
                <!--end::Features-->

              </div>
              <!--end::Option-->

              <div class="section-2-btn">
                <!--begin::Select-->
                <router-link
                  :to="{name:'front.disciplines.list'}"
                  class="me-n15 fiche-btn btn with-zindex rounded-pill bg-yellow btn-icon-dark">
                  Disciplines
                </router-link>
                <!--end::Select-->
              </div>
            </div>
            <!--end::Story-->
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-sm-6 me-auto ps-lg-15 h-100">
            <!--begin::Story-->
            <div class="d-flex flex-column h-100 section2-bloc right-block">
              <!--begin::Option-->
              <div class="d-flex flex-column bg-green-7 p-10 ">
                <!--begin::Heading-->
                <div class="section-heading mb-5">
                  <!--begin::Title-->
                  <h3 class="text-center text-dark mb-5 canela-thin fw-normal">Conférences<br><span class="and canela-thin-italic">et</span> Cours</h3>
                  <!--end::Title-->
                </div>
                <!--end::Heading-->

                <!--begin::Features-->
                <div class=" mb-0 canela-thin-italic section2-description text-dark">
                  <!--begin::Item-->
                  <div class="d-flex flex-stack border-bottom border-dark pb-4 mb-5">
                    <span class="text-start pe-3">Des initiations accessibles</span>
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex flex-stack border-bottom border-dark pb-4 mb-5">
                    <span class="text-start pe-3">Formations en ligne et en direct</span>
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex flex-stack border-bottom border-dark pb-4 mb-5">
                    <span class="text-start pe-3">Avec nos experts reconnus</span>
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex flex-stack pb-3 mb-5">
                    <span class="text-start pe-3">En petits groupes</span>
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="d-flex mb-n3 scale-block">
                    <img src="/img/homepage/les-cours.png" />
                  </div>
                  <!--end::Item-->
                </div>
                <!--end::Features-->
              </div>
              <!--end::Option-->

              <div class="section-2-btn">
                <!--begin::Select-->
                <router-link
                  :to="{name:'front.calendar'}"
                  class="me-n15 fiche-btn btn with-zindex rounded-pill bg-green">
                  Calendrier
                </router-link>
                <!--end::Select-->
              </div>
            </div>
            <!--end::Story-->
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->

      </div>
      <!--end::Container-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Section 2-->
</template>

<script>
export default {
  name: "AppSection2",
};
</script>
