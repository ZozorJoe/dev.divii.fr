<template>
    <div class="d-flex flex-column container pt-lg-20 sub-header-consultations">
        <!--begin::Heading-->
        <div class="page-title text-center">
            <h1 class="canela-thin mb-20"><span class="canela-thin-italic">les</span> consultations</h1>
        </div>
        <!--end::Heading-->

        <!--begin::Actions-->
        <div class="text-center">
            <!--begin::Nav group-->
            <div class="nav-group nav-group-header d-md-inline-flex mb-20 bg-transparent moche14 text-uppercase">
                <router-link :to="{name: 'front.experts.list'}"
                             class="active-purple-btn btn border rounded-pill text-white  me-2">par consultant
                </router-link>
                <router-link :to="{name: 'front.disciplines.list'}"
                             class="active-green-btn btn border rounded-pill text-white ">par discipline
                </router-link>
            </div>
            <!--end::Nav group-->
        </div>
        <!--end::Actions-->
    </div>
</template>

<script>
    import {useStore} from "vuex";
    import {computed} from "vue";

    export default {
        name: "SubHeaderConsultations",
    };
</script>
