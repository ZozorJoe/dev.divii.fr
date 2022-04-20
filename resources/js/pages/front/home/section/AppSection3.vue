<template>
  <!--begin::Section 3-->
  <div class="py-20 section-3 my-20">
    <!--begin::Wrapper-->
    <div class="mt-20">
      <!--begin::Container-->
      <div class="container">

        <!--begin::Row-->
        <div class="row w-100 gy-10">
          <!--begin::Col-->
          <div class="col-md-6">
            <!--<video class="w-100" poster="/img/homepage/le-concept.png" />-->
            <img class="w-100 concept-img"  alt="Le concept" src="/img/homepage/le-concept.png" />
          </div>
          <!--end::Col-->
          <!--begin::Col-->
          <div class="col-md-6 px-lg-10">
            <!--begin::Heading-->
            <div class="section-heading text-left">
              <!--begin::Title-->
              <div class="concept-top">
                <h3 class="h3 h3-concept mb-10 canela-thin"><span class="canela-thin-italic">Le</span> concept</h3>
                <!--end::Title-->
                <!--begin::Description-->
                <div class="concept-description canela-thin-italic">
                  <p>La première plateforme qui met en lumière l'ésotérisme
                  grâce à une offre complète et qualitative de cours en
                  consultations en ligne et en direct avec des consultants
                  professionnels reconnus.<br>
                  Notre intention: réunir etrendre plus accessible ces arts
                  ancestraux pour en faire de puissants outils de
                  connaissance de soi et d'évolution personnelle.</p>
                </div>
              </div>
              <!--end::Description-->
              <!--begin::Select-->
              <router-link :to="{name: 'front.experts.list'}" class="fiche-btn btn rounded-pill bg-red-4 btn-icon-dark mb-20 text-uppercase">Découvrir
                <span class="svg-icon svg-icon-1 mx-2">
                 <img src="/img/icon/arrow-dark.svg" alt="right">
                </span></router-link>
              <!--end::Select-->
            </div>
            <!--end::Heading-->
          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->

      </div>
      <!--end::Container-->
    </div>
    <!--end::Wrapper-->
  </div>
  <!--end::Section 3-->
</template>

<script>
export default {
  name: "AppSection3",
};
</script>
