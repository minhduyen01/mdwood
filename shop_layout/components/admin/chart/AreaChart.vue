<script>
import { Bar } from "chart.js";

export default {
  extends: Bar,
  props: {
    revenueOfMonth: {
      type: Array,
      default: () => ([0, 0, 0, 0, 0, 0, 0])
    }
  },
  mounted() {
    // console.log(this.revenueOfMonth)
    this.renderChart(
      {
        labels: [
          "Tháng 1",
          "Tháng 2",
          "Tháng 3",
          "Tháng 4",
          "Tháng 5",
          "Tháng 6",
          "Tháng 7",
          "Tháng 8",
          "Tháng 9",
          "Tháng 10",
          "Tháng 11",
          "Tháng 12"
        ],
        datasets: [
          {
            label: "Doanh thu theo tháng",
            backgroundColor: "#f87979",
            data: [0, 0, 0, 0, 5, 10, 0]
          }
        ]
      },
      {
        responsive: true,
        maintainAspectRatio: false,
        title: {
          display: true,
          text: "Doanh thu hàng tháng"
        }
      }
    );
  }
};
</script>
