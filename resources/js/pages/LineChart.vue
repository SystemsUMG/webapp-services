<template>
    <Line :chart-options="chartOptions" :chart-data="chartData"/>
</template>
<script>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, LineElement, LinearScale, PointElement, CategoryScale, Filler } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, LineElement, LinearScale, PointElement, CategoryScale, Filler)

export default {
    components: { Line },
    props: ['labels', 'values'],
    data() {
        return {
            chartData: {
                labels: this.labels,
                datasets: [{
                    label: "Usuarios",
                    tension: 0.4,
                    borderWidth: 0,
                    pointRadius: 0,
                    borderColor: "#5e72e4",
                    backgroundColor: (ctx) => {
                        const canvas = ctx.chart.ctx;
                        const gradient = canvas.createLinearGradient(0, 230, 0, 50);

                        gradient.addColorStop(1, 'rgba(94, 114, 228, 0.2)');
                        gradient.addColorStop(0.2, 'rgba(94, 114, 228, 0.0)');
                        gradient.addColorStop(0, 'rgba(94, 114, 228, 0)');

                        return gradient;
                    },
                    borderWidth: 3,
                    fill: true,
                    data: this.values,
                    maxBarThickness: 6
                }]
            },
            chartOptions: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#fbfbfb',
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#67748E',
                            padding: 20,
                            font: {
                                size: 11,
                                family: "Open Sans",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                }
            }
        }
    }
}
</script>
