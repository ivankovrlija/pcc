<template>
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

        <!-- begin:: Subheader -->
        <Subheader :title="`Dashboard`"></Subheader>

        <!-- end:: Subheader -->

        <!-- begin:: Content -->
        <div id="kt_content" class="kt-content kt-grid__item kt-grid__item--fluid">
            <template v-if="data">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="row row-full-height">
                            <div class="col-sm-12 col-md-12 col-lg-6">
                                <div class="kt-portlet kt-portlet--height-fluid-half kt-portlet--border-bottom-brand">
                                    <div class="kt-portlet__body kt-portlet__body--fluid">
                                        <div class="kt-widget26">
                                            <div class="kt-widget26__content">
                                                <span class="kt-widget26__number">{{ data.total_courses }}</span>
                                                <span class="kt-widget26__desc">Total Courses</span>
                                            </div>
                                            <div class="kt-widget26__chart" style="height:100px; width: 230px;"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
            <template v-else>
                <div class="kt-spinner kt-spinner--sm kt-spinner--brand"></div>
            </template>
        </div>

        <!-- end:: Content -->
    </div>
</template>

<script>
import Subheader from '../../includes/Subheader'
import { debounce } from 'lodash'
import PerfectScrollbar from 'perfect-scrollbar';
import defaultAvatar from '../../../images/users/default.jpg'

export default {
    name: 'Dashboard',
    components: {
        Subheader
    },
    data() {
        return {
            data: null,
            ps: null,
            defaultAvatar: defaultAvatar,
            loading: true
        }
    },
    mounted() {
        this.fetchDashboardData().then(() => {


            $(window).on('resize', e => debounce(() => this.initMap(), 500))

            this.ps = new PerfectScrollbar('.kt-scroll')
        })
    },
    beforeDestroy() {
        $('#kt_jqvmap_world').remove()
        this.ps.destroy()
    },
    methods: {
        fetchDashboardData() {
            return this.$http.get('dashboard')
                .then(response => {
                    this.data = response.data
                    this.loading = false
                })
                .catch(error => console.log(error))
        },
        initSparklineChart(src, data, color, border, labels) {
            if (!src.length) { return }

            const config = {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: "",
                        borderColor: color,
                        borderWidth: border,

                        pointHoverRadius: 4,
                        pointHoverBorderWidth: 12,
                        pointBackgroundColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                        pointBorderColor: Chart.helpers.color('#000000').alpha(0).rgbString(),
                        pointHoverBackgroundColor: KTAppOptions.colors.state.danger,
                        pointHoverBorderColor: Chart.helpers.color('#000000').alpha(0.1).rgbString(),
                        fill: false,
                        data: data,
                    }]
                },
                options: {
                    title: { display: false },
                    legend: {
                        display: false,
                        labels: {
                            usePointStyle: false
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: true,
                    hover: { mode: 'index' },
                    scales: {
                        xAxes: [{
                            display: false,
                            gridLines: false,
                            scaleLabel: {
                                display: true,
                                labelString: 'Month'
                            }
                        }],
                        yAxes: [{
                            display: false,
                            gridLines: false,
                            scaleLabel: {
                                display: true,
                                labelString: 'Value'
                            },
                            ticks: { beginAtZero: true }
                        }]
                    },
                    elements: {
                        point: {
                            radius: 4,
                            borderWidth: 12
                        },
                    },
                    layout: {
                        padding: {
                            left: 0,
                            right: 10,
                            top: 5,
                            bottom: 0
                        }
                    }
                }
            };

            return new Chart(src, config);
        }
    }
}
</script>
