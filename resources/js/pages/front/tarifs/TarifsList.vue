<template>
  <!--begin::List Section-->
    <!--begin::Container-->

    <div class="container-fluid">
      <div class="bg-grad-3"></div>
      <div class="row g-10 g-xl-10 tarifs-page">

        <div class="col-xl-4 col-lg-4  offset-xl-1 offset-lg-1 tarifs-text-wrapper">
          <!--begin::Heading-->
          <div class="section-heading text-left">
            <!--begin::Title-->
            <h1 class="canela-title fw-normal"><span class="canela-thin-italic">Offres et tarifs "à la carte"</span></h1>
            <!--end::Title-->
            <!--begin::Description-->
            <div class="canela-texte fw-normal">
              Chez divii, pas de paiement "à la minute" ,chaque prestation est associée à un tarif. Les tarifs de base sont donnés à titre indicatif, le paiement de chaque prestation se fait au moment de la sélection de la consultation ou du cours de votre choix.
            </div>
            <!--end::Description-->

          </div>
          <!--end::Heading-->
        </div>
        <div class="col-xl-3 col-lg-3 col-sm-6 ">
          <!--begin::Option-->
          <div class="tarifs-table table-left d-flex flex-column p-7">
            <!--begin::Heading-->
            <div class="section-heading mb-5">
              <!--begin::Title-->
              <h3 class="canela-thin-italic tarifs-title fw-normal">Consultations</h3>
              <p class="canela-regular tarifs-sub-title">en ligne et en direct</p>
              <!--end::Title-->
            </div>
            <!--end::Heading-->

            <!--begin::Features-->
            <div class="tarifs-all">
              <!--begin::Item-->
              <div class="d-flex flex-stack pb-2 mb-2">
                <span class="tarifs-mn">15 minutes</span>
                <span class="tarifs-separation"></span>
                <span class="tarifs-value">35€</span>
              </div>
              <!--end::Item-->

              <!--begin::Item-->
              <div class="d-flex flex-stack pb-2 mb-2">
                <span class="tarifs-mn">30 minutes</span>
                <span class="tarifs-separation"></span>
                <span class="tarifs-value">65€</span>
              </div>
              <!--end::Item-->

              <!--begin::Item-->
              <div class="d-flex flex-stack pb-2 mb-2">
                <span class="tarifs-mn">45 minutes</span>
                <span class="tarifs-separation"></span>
                <span class="tarifs-value">95€</span>
              </div>
              <!--end::Item-->

                <!--begin::Item-->
                <div class="d-flex flex-stack pb-2 mb-2">
                    <span class="tarifs-mn">60 minutes</span>
                    <span class="tarifs-separation"></span>
                    <span class="tarifs-value">120€</span>
                </div>
                <!--end::Item-->

            </div>
            <!--end::Features-->

          </div>
          <div class="tarifs-btn-block">
            <!--begin::Select-->
            <router-link
                    :to="{name:'front.experts.list'}"
                    class="me-n15 fiche-btn btn with-zindex rounded-pill bg-red-4 btn-icon-dark mb-n10">
              Découvrir
            </router-link>
            <!--end::Select-->
          </div>
          <!--end::Option-->
        </div>
        <div class="col-xl-3 col-lg-3 col-sm-6">
          <!--begin::Option-->
          <div class="tarifs-table table-right d-flex flex-column p-7">
            <!--begin::Heading-->
            <div class="section-heading mb-5">
              <!--begin::Title-->
              <h3 class="canela-thin-italic tarifs-title fw-normal">Cours</h3>
              <p class="canela-regular tarifs-sub-title">en ligne et en direct</p>
              <!--end::Title-->
            </div>
            <!--end::Heading-->

            <!--begin::Features-->
            <div class="tarifs-all">
              <!--begin::Item-->
              <div class="d-flex flex-stack pb-2 mb-2">
                <span class="tarifs-mn">Cours de 2h</span>
                <span class="tarifs-separation"></span>
                <span class="tarifs-value">98€</span>
              </div>
              <!--end::Item-->

              <!--begin::Item-->
              <div class="d-flex flex-stack pb-2 mb-2">
                <span class="tarifs-mn">tarif earlybird</span>
                <span class="tarifs-separation"></span>
                <span class="tarifs-value">76€</span>
              </div>
              <!--end::Item-->


            </div>
            <!--end::Features-->

          </div>
          <!--end::Option-->
          <div class="tarifs-btn-block">
            <!--begin::Select-->
            <router-link
                    :to="{name:'front.disciplines.list'}"
                    class="me-n15 fiche-btn btn with-zindex rounded-pill bg-yellow btn-icon-dark mb-n10">
              Découvrir
              <span class="svg-icon svg-icon-1 mx-2">
                   <img src="/img/icon/arrow-dark.svg" alt="right">
                  </span>
            </router-link>
            <!--end::Select-->
          </div>
        </div>


      </div>

    </div>
    <!--end::Container-->
</template>

<script>

    export default {
        name: 'TarifsList'
    }
</script>
