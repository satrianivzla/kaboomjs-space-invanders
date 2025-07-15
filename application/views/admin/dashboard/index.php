<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h1>
    </div>

    <div class="row">
        <!-- Daily Visits Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Unique Daily Visits (Last 30 Days)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="dailyVisitsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Pages -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Top 10 Visited Pages</h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <?php foreach($top_pages as $page): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?php echo html_escape($page['page_visited']); ?>
                                <span class="badge bg-primary rounded-pill"><?php echo $page['total_visits']; ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Page level plugins -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Page level custom scripts -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Area Chart Example
    var ctx = document.getElementById("dailyVisitsChart");
    var myLineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo $chart_labels; ?>,
            datasets: [{
                label: "Unique Visits",
                lineTension: 0.3,
                backgroundColor: "rgba(78, 115, 223, 0.05)",
                borderColor: "rgba(78, 115, 223, 1)",
                pointRadius: 3,
                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                pointBorderColor: "rgba(78, 115, 223, 1)",
                pointHoverRadius: 3,
                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                pointHitRadius: 10,
                pointBorderWidth: 2,
                data: <?php echo $chart_data; ?>,
            }],
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                x: {
                    time: {
                        unit: 'date'
                    },
                    grid: {
                        display: false
                    }
                },
                y: {
                    ticks: {
                        beginAtZero: true
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
