<template>
    <div class="d-flex flex-column container pt-lg-20 sub-header-cours">
        <!--begin::Heading-->
        <div class="page-title text-center">
            <h1 class="canela-thin mb-20"><span class="canela-thin-italic">les</span> cours <span class="canela-thin-italic">et les</span> conférences</h1>
        </div>
        <!--end::Heading-->

        <!--begin::Actions-->
        <div class="text-center">
            <!--begin::Nav group-->
            <div class="nav-group nav-group-header d-md-inline-flex mb-20 bg-transparent moche14 text-uppercase">
                <router-link :to="{name: 'front.calendar'}"
                             class="active-purple-btn btn border me-2">Calendrier
                </router-link>
                <!--<router-link :to="{name: 'front.formations.list'}" class="btn border rounded-pill text-dark bg-purple px-20 py-3 me-2" >Liste</router-link>-->
                <router-link :to="{name: 'front.cours.disciplines.list'}" class="active-green-btn btn border  me-2 d-none">par discipline</router-link>

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
