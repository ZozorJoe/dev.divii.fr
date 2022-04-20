<template>

    <!--begin::Container-->
    <div class="container-fluid cours-discipline-list">
      <SubHeaderCours/>
      <DisciplineList/>
    </div>
    <!--end::Container-->


</template>

<script>
    import {ref, onMounted, computed, watch} from "vue";
    import ApiService from "../../../services/api.service";
    import SubHeaderCours from "./../base/SubHeaderCours";
    import DisciplineList from "./DisciplineList";
    export default {
        name: 'CoursDisciplineList',
        components: {DisciplineList,SubHeaderCours},
        setup(){
            const disciplines = ref([])
            const page = ref(1)
            const per_page = ref(null)
            const per_swipe = ref(8)
            const meta = ref(null)
            const search = ref(null)
            const loading = ref(false)

            const params = computed(() => {
                let data = {'page' : page.value, count: 'users'}
                if(per_page.value){
                data['per-page'] = per_page.value
            }
            if(search.value){
                data['s'] = search.value
            }
            return data
        })

            const changePerPage = (value) => {
                per_page.value = value
            }

            const chunk = (array, size) =>
            array.reduce((acc, _, i) => {
                if (i % size === 0) acc.push(array.slice(i, i + size))
            return acc
        }, [])

            const loadModels = () => {
                loading.value = true
                ApiService.get('/disciplines', {params: params.value})
                    .then(({data}) => {
                    if(data.success){
                    meta.value = data.meta
                    const curPage = data.meta.current_page
                    disciplines.value[curPage] = data.data
                    if(curPage === 1){
                        //nextTick(scrollBottom)
                    }else{
                        const lastPage = data.meta.last_page
                        if(lastPage <= curPage){
                            page.value = lastPage
                        }
                    }
                }
            })
            .finally(() => {
                    loading.value = false
            })
            }
            onMounted(loadModels)

            const models = computed(() => {
                let all = [];
            const keys = Object.keys(disciplines.value);
            keys.sort().forEach(key => {
                const data = disciplines.value[key];
            all = [...all, ...data]
        })
            return chunk(all, per_swipe.value)
            // return all;
        })

            const isLastPage = computed(() => {
                return meta.value && disciplines.value.length > meta.value.last_page;
        })

            watch(() => page.value, () => {loadModels()} )

            return {
                models,
                page,
                meta,
                search,
                loading,
                isLastPage,
                loadModels,
                changePerPage,
            }
        }
    }
</script>
