<script>
import { Line } from "chart.js";

export default {
  extends: Line,
  props: {
    revenueOfWeek: {
      type: Array,
      default: () => ([0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0])
    }
  },
  mounted() {
    this.renderChart(
      {
        labels: [
          "Thứ 2",
          "Thứ 3",
          "Thứ 4",
          "Thứ 5",
          "Thứ 6",
          "Thứ 7",
          "Chủ nhật"
        ],
        datasets: [
          {
            label: "Doanh thu",
            data: [0, 0, 0, 0, 0, 0, 10, 3, 5, 0, 0, 0],
            backgroundColor: "transparent",
            borderColor: "rgba(1, 116, 188, 0.50)",
            pointBackgroundColor: "rgba(171, 71, 188, 1)"
          }
        ]
      },
      {
        responsive: true,
        maintainAspectRatio: false,
        title: {
          display: true,
          text: "Doanh thu tuần này"
        }
      }
    );
  }
}
</script>
