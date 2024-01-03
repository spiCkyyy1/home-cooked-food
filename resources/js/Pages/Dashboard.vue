<template>
<!--    <Head title="Dashboard" />-->

<!--    <AuthenticatedLayout>-->
<!--        <template #header>-->
<!--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>-->
<!--        </template>-->

    <div class="flex flex-row">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Chart
                        :size="{ width: 500, height: 400 }"
                        :data="data"
                        :margin="margin"
                        :direction="direction">

                        <!--                    <template #layers>-->
                        <!--                      <Grid strokeDasharray="2,2" />-->
                        <!--                      <Line :dataKeys="['name', 'pl']" />-->
                        <!--                    </template>-->

                        <template #layers>
                            <Grid strokeDasharray="2,2" />
                            <Line :dataKeys="['name', 'pl']" />
                            <Line :dataKeys="['name', 'avg']" :lineStyle="{ stroke: 'red' }" type="step" />
                        </template>

                        <template #widgets>
                            <Tooltip
                                borderColor="#48CAE4"
                                :config="{
                              name: { hide: true },
                              pl: { color: '#0077b6' },
                              avg: { label: 'averange', color: 'red' },
                              inc: { hide: true }
                          }"
                            />
                        </template>

                    </Chart>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Chart
                        direction="circular"
                        :size="{ width: 500, height: 400 }"
                        :data="data"
                        :margin="{
                        left: Math.round((500 - 360)/2),
                        top: 20,
                        right: 0,
                        bottom: 20
                      }"
                        :axis="{
  primary: {
    domain: ['dataMin', 'dataMax'],
    type: 'band'
  },
  secondary: {
    domain: ['dataMin', 'dataMax'],
    type: 'linear'
  }
}"
                        :config="{ controlHover: false }">
                        <template #layers>
                            <Pie
                                :dataKeys="['name', 'pl']"
                                :pie-style="{ innerRadius: 100, padAngle: 0.05 }" />
                        </template>
                        <template #widgets>
                            <Tooltip
                                :config="{
                        name: { },
                        avg: { hide: true},
                        pl: { label: 'value' },
                        inc: { hide: true }
                      }"
                                hideLine
                            />
                        </template>
                    </Chart>
                </div>
            </div>
        </div>
    </div>

<!--    </AuthenticatedLayout>-->
</template>
<script>
import {Chart, Responsive, Pie, Tooltip, Line, Grid} from 'vue3-charts'
import {ref} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
  components: {AuthenticatedLayout, Chart, Grid, Line, Responsive, Pie, Tooltip },
  props: {data: Object},
  mounted() {
    console.log(this.data);

    // console.log(this.result);
    // this.data = this.result;
  },
  data(){
    return {
      direction: ref('horizontal'),
      margin: ref({
        left: 0,
        top: 20,
        right: 20,
        bottom: 0
      }),
      data : [
        { name: 'Jan', pl: 1000, avg: 500, inc: 300 },
        { name: 'Feb', pl: 2000, avg: 900, inc: 400 },
        { name: 'Apr', pl: 400, avg: 400, inc: 500 },
        { name: 'Mar', pl: 3100, avg: 1300, inc: 700 },
        { name: 'May', pl: 200, avg: 100, inc: 200 },
        { name: 'Jun', pl: 600, avg: 400, inc: 300 },
        { name: 'Jul', pl: 500, avg: 90, inc: 100 }
      ],
    }
  }
}
</script>
