@ -0,0 +1,364 @@
<style>
    .chart-container {
        background: white;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12);
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e9ecef;
        flex-wrap: wrap;
        gap: 10px;
    }

    .chart-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        display: flex;
        align-items: center;
    }

    .chart-title i {
        margin-right: 8px;
        color: #3498db;
    }

    .date-range {
        background: #f8f9fa;
        padding: 6px 12px;
        border-radius: 5px;
        font-size: 12px;
        color: #6c757d;
    }

    .chart-wrapper {
        position: relative;
        height: 350px;
        margin-top: 15px;
    }

    .chart-wrapper.small {
        height: 250px;
    }

    .filter-buttons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: 6px 12px;
        border: 1px solid #dee2e6;
        background: white;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.3s;
        font-size: 13px;
    }

    .filter-btn:hover {
        background: #f8f9fa;
    }

    .filter-btn.active {
        background: #3498db;
        color: white;
        border-color: #3498db;
    }

    @media (max-width: 768px) {
        .chart-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .filter-buttons {
            width: 100%;
        }
    }
</style>

<div class="row">
    <div class="box col-md-12">
        <div class="box-header">
            <h2><i class="glyphicon glyphicon-stats"></i><span class="break"></span>Violation Analytics</h2>
            <div class="box-icon">
                <a href="<?= base_url('manager/dashboard/show/all') ?>" title="Back to Table">
                    <i class="glyphicon glyphicon-list"></i>
                </a>
            </div>
        </div>

        <div class="box-content">
            <!-- Navigation Tabs -->
            <div class="col-md-12" style="margin-bottom: 15px;">
                <div class="btn-group" role="group">
                    <a href="<?= base_url('manager/dashboard/show/all') ?>" class="btn btn-sm btn-default">
                        <i class="glyphicon glyphicon-list"></i> Table View
                    </a>
                    <a href="<?= base_url('manager/dashboard/charts') ?>" class="btn btn-sm btn-primary">
                        <i class="glyphicon glyphicon-stats"></i> Analytics
                    </a>
                </div>
            </div>

            <!-- Charts in Grid -->
            <div class="row">
                <!-- Main Chart - Full Width -->
                <div class="col-md-12">
                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">
                                <i class="glyphicon glyphicon-user"></i>
                                Top 10 Publishers with Most Violations
                            </div>
                            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                                <div class="filter-buttons">
                                    <button class="filter-btn active" onclick="updateChart('all')">All</button>
                                    <button class="filter-btn" onclick="updateChart('stacked')">By Type</button>
                                    <button class="filter-btn" onclick="updateChart('status')">By Status</button>
                                </div>
                                <div class="date-range">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                    <?= date('M d', strtotime($date_from)) ?> - <?= date('M d, Y', strtotime($date_to)) ?>
                                </div>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="topPublishersChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Pie Chart - Half Width -->
                <div class="col-md-6">
                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">
                                <i class="glyphicon glyphicon-exclamation-sign"></i>
                                Violation Type Distribution
                            </div>
                        </div>
                        <div class="chart-wrapper small">
                            <canvas id="errorTypeChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="chart-container">
                        <div class="chart-header">
                            <div class="chart-title">
                                <i class="glyphicon glyphicon-time"></i>
                                Trend Analysis
                            </div>
                        </div>
                        <div class="chart-wrapper small">
                            <canvas id="trendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const publisherData = <?= json_encode($top_publishers) ?>;
    const errorTypeData = <?= json_encode($pub_error_types) ?>;

    const colors = {
        primary: 'rgba(54, 162, 235, 0.8)',
        warning: 'rgba(255, 206, 86, 0.8)',
        danger: 'rgba(255, 99, 132, 0.8)',
        success: 'rgba(75, 192, 192, 0.8)',
        purple: 'rgba(153, 102, 255, 0.8)',
        orange: 'rgba(255, 159, 64, 0.8)'
    };

    let mainChart;
    const ctx = document.getElementById('topPublishersChart').getContext('2d');

    function initMainChart(type = 'all') {
        if (mainChart) {
            mainChart.destroy();
        }

        const labels = publisherData.map(p => p.userid);
        let datasets = [];

        if (type === 'all') {
            datasets = [{
                label: 'Total Violations',
                data: publisherData.map(p => p.violation_count),
                backgroundColor: colors.primary,
                borderColor: colors.primary.replace('0.8', '1'),
                borderWidth: 2
            }];
        } else if (type === 'status') {
            datasets = [{
                    label: 'Warnings',
                    data: publisherData.map(p => p.warning_count),
                    backgroundColor: colors.warning,
                    borderColor: colors.warning.replace('0.8', '1'),
                    borderWidth: 1
                },
                {
                    label: 'Paused',
                    data: publisherData.map(p => p.paused_count),
                    backgroundColor: colors.danger,
                    borderColor: colors.danger.replace('0.8', '1'),
                    borderWidth: 1
                }
            ];
        } else if (type === 'stacked') {
            const errorTypes = ['Duplicate Device', 'CR Require', 'Duplicate IP'];
            const typeColors = [colors.purple, colors.orange, colors.success];

            datasets = errorTypes.map((errorType, index) => ({
                label: errorType,
                data: labels.map(pubId => {
                    return errorTypeData[pubId] && errorTypeData[pubId][errorType] ?
                        errorTypeData[pubId][errorType] : 0;
                }),
                backgroundColor: typeColors[index],
                borderColor: typeColors[index].replace('0.8', '1'),
                borderWidth: 1
            }));
        }

        mainChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: type !== 'all',
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += context.parsed.y + ' violations';
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        stacked: type === 'stacked',
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    const errorCtx = document.getElementById('errorTypeChart').getContext('2d');
    const allErrorTypes = {};

    Object.values(errorTypeData).forEach(pubData => {
        Object.entries(pubData).forEach(([errorType, count]) => {
            allErrorTypes[errorType] = (allErrorTypes[errorType] || 0) + count;
        });
    });

    new Chart(errorCtx, {
        type: 'doughnut',
        data: {
            labels: Object.keys(allErrorTypes),
            datasets: [{
                data: Object.values(allErrorTypes),
                backgroundColor: [colors.purple, colors.orange, colors.success],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });


    const trendCtx = document.getElementById('trendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($trend_labels) ?>,
            datasets: [{
                label: 'Violations Trend',
                data: <?= json_encode($trend_counts) ?>,
                borderColor: colors.primary,
                backgroundColor: colors.primary.replace('0.8', '0.2'),
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    function updateChart(type) {
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.classList.add('active');
        initMainChart(type);
    }

    initMainChart('all');
</script>