<template>
  <!--begin::Section 4-->
  <div class="py-20 section-4">
    <!--Wrapper-->
    <div>
      <!--begin::Container-->
      <div class="container-fluid">

        <!--begin::Row-->
        <div class="row">

          <!--begin::Col-->
          <div class="col-lg-3 offset-lg-1">
            <!--begin::Heading-->
            <div class="section4-title  d-flex flex-center h-100 mb-17">
              <!--begin::Title-->
              <h3 class="h3 mb-5 canela-thin">
                <span class="divii-span ">Pourquoi</span>
                <span class="canela-thin-italic divii-span">choisir</span><span>divii ?</span>
              </h3>
              <!--end::Title-->
            </div>
            <!--end::Heading-->
          </div>
          <!--end::Col-->

          <!--begin::Col-->
          <div class="col-lg-8">
            <div>
              <!--begin::Slider-->
              <div class="tns tns-default">
                <!--begin::Wrapper-->
                <div class="raisons-slider eina3-regular">
                  <!--begin::Item-->
                  <div class="raison-item w-300px h-350px pe-15">
                    <!--begin::Highlight-->
                    <div class="d-flex flex-column flex-center h-100 py-10 bg-yellow-6">
                      <span class="fs-3 fw-bold text-dark text-center p-5 mb-0">vivre en accord avec soi-même avec une meilleure connaissance de soi</span>
                      <img alt="icon" src="/img/icon/picto-1.png" />
                    </div>
                    <!--end::Highlight-->
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="raison-item w-300px h-350px pe-15">
                    <!--begin::Highlight-->
                    <div class="d-flex flex-column flex-center h-100 py-10 bg-yellow-6">
                      <span class="fs-3 fw-bold text-dark text-center p-5 mb-0">redonner au monde sa part de mystère et de spiritualité</span>
                      <img alt="icon" src="/img/icon/picto-2.png" />
                    </div>
                    <!--end::Highlight-->
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="raison-item w-300px h-350px">
                    <!--begin::Highlight-->
                    <div class="d-flex flex-column flex-center h-100 py-10 bg-yellow-6">
                      <span class="fs-3 fw-bold  text-dark text-center p-5 mb-0">exploiter nos forces et comprendre nos fragilités</span>
                      <img alt="icon" src="/img/icon/picto-3.png" />
                    </div>
                    <!--end::Highlight-->
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="raison-item w-300px h-350px">
                    <!--begin::Highlight-->
                    <div class="d-flex flex-column flex-center h-100 py-10 bg-yellow-6">
                      <span class="fs-3 fw-bold  text-dark text-center p-5 mb-0">identifier qui nous sommes et apprendre à se connaitre</span>
                      <img alt="icon" src="/img/icon/picto-4.png" />
                    </div>
                    <!--end::Highlight-->
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="raison-item w-300px h-350px">
                    <!--begin::Highlight-->
                    <div class="d-flex flex-column flex-center h-100 py-10 bg-yellow-6">
                      <span class="fs-3 fw-bold  text-dark text-center p-5 mb-0">prendre du recul pour prendre les bonnes décisions</span>
                      <img alt="icon" src="/img/icon/picto-5.png" />
                    </div>
                    <!--end::Highlight-->
                  </div>
                  <!--end::Item-->
                  <!--begin::Item-->
                  <div class="raison-item w-300px h-350px">
                    <!--begin::Highlight-->
                    <div class="d-flex flex-column flex-center h-100 py-10 bg-yellow-6">
                      <span class="fs-3 fw-bold  text-dark text-center p-5 mb-0">devenir une personne plus intuitive et connectée au monde qui l'entoure</span>
                      <img alt="icon" src="/img/icon/picto-6.png" />
                    </div>
                    <!--end::Highlight-->
                  </div>
                  <!--end::Item-->
                </div>
                <!--end::Wrapper-->
              </div>
              <!--end::Slider-->
            </div>
            <div class="d-flex flex-column align-items-end">
              <div class="me-20 arrow-block">
                <!--begin::Button-->
                <button class="btn arrow-left-btn  btn-active-color-primary rotate-180" id="kt_raison_slider_prev">
                  <img src="/img/icon/arrow-dark.svg" alt="left">
                </button>
                <!--end::Button-->
                <!--begin::Button-->
                <button class="btn  btn-active-color-primary" id="kt_raison_slider_next">
                  <img src="/img/icon/arrow-dark.svg" alt="right">
                </button>
                <!--end::Button-->
              </div>
            </div>

          </div>
          <!--end::Col-->
        </div>
        <!--end::Row-->

      </div>
      <!--end::Container-->
    </div>
    <!--Wrapper-->
  </div>
  <!--end::Section 4-->
</template>

<script>
import {nextTick, onMounted} from "vue";

export default {
  name: "AppSection4",
  setup() {
    const initTinySliders = () => {
      const e = $('.raisons-slider')
      const options = {
        container: '.raisons-slider',
        items: 6,
        slideBy: 'page',
        gutter: 30,
        loop: false,
        swipeAngle: true,
        speed: 2000,
        autoplay: false,
        controls: true,
        nav: false,
        dots: false,
        prevButton: "#kt_raison_slider_prev",
        nextButton: "#kt_raison_slider_next",
        responsive: {1200: {items: 3}, 992: {items: 3}},
        autoplayButtonOutput: !1
      }
      e.closest(".tns").addClass("tns-initiazlied")
      tns(options)
    }

    onMounted(initTinySliders)
  }
};
</script>
