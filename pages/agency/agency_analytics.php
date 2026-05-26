<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

redirectIfNotAgency();
$agency_id = getCurrentUserID();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Analytics</title>
    <script>
        const AGENCY_ID = <?= json_encode($agency_id) ?>;
    </script>
    <link rel="stylesheet" href="../../css/analytics.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
</head>

<body>
    <div class="analytics-wrap">

        <a href="agency_dashboard.php" class="back-link">← Back to Dashboard</a>
        <div class="page-title">Analytics</div>
        <div class="page-subtitle">Performance overview for your agency</div>

        <!-- KPI Cards -->
        <div class="kpi-grid" id="kpi-grid">
            <?php for ($i = 0; $i < 5; $i++): ?>
                <div class="kpi-card">
                    <div class="kpi-label">Loading...</div>
                    <div class="skeleton"></div>
                </div>
            <?php endfor; ?>
        </div>

        <!-- Charts -->
        <div class="charts-grid">
            <div class="chart-card full" id="card-bookings">
                <div class="chart-title">Bookings Per Package</div>
                <div class="chart-wrap"><canvas id="chart-bookings"></canvas></div>
            </div>
            <div class="chart-card" id="card-ratings">
                <div class="chart-title">Rating Breakdown</div>
                <div class="chart-wrap"><canvas id="chart-ratings"></canvas></div>
            </div>
            <div class="chart-card" id="card-split">
                <div class="chart-title">Solo vs Group Bookings</div>
                <div class="chart-wrap"><canvas id="chart-split"></canvas></div>
            </div>
        </div>

        <!-- Recent Reviews -->
        <div class="reviews-card" id="reviews-card">
            <div class="reviews-title">Recent Reviews</div>
            <div id="reviews-list">
                <div class="no-data">Loading reviews...</div>
            </div>
        </div>

    </div>

    <script>
        // ── Match site colors ─────────────────────────────────────────
        const BLUE = '#1e73ff';
        const BLUE2 = '#0d47a1';
        const GREEN = '#28a745';
        const RED = '#dc3545';
        const GOLD = '#f0c040';
        const GREY = '#666';
        const BORDER = '#e8edf4';

        Chart.defaults.font.family = 'Arial, Helvetica, sans-serif';
        Chart.defaults.font.size = 13;
        Chart.defaults.color = GREY;

        const gridColor = BORDER;

        // ── API helper ────────────────────────────────────────────────
        function api(type) {
            return fetch('../../includes/agency_stats_queries.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    type,
                    agency_id: AGENCY_ID
                })
            }).then(r => r.json());
        }

        function stars(n) {
            return '★'.repeat(n) + '☆'.repeat(5 - n);
        }

        function fmt(num) {
            return 'R ' + Number(num).toLocaleString('en-ZA', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        // ── KPI Cards ─────────────────────────────────────────────────
        api('getStats').then(data => {
            document.getElementById('kpi-grid').innerHTML = `
            <div class="kpi-card blue loaded">
                <div class="kpi-label">Total Packages</div>
                <div class="kpi-value">${data.total_packages}</div>
                <div class="kpi-sub">${data.upcoming} upcoming departure${data.upcoming !== 1 ? 's' : ''}</div>
            </div>
            <div class="kpi-card blue loaded">
                <div class="kpi-label">Total Bookings</div>
                <div class="kpi-value">${data.total_bookings}</div>
                <div class="kpi-sub">Across all packages</div>
            </div>
            <div class="kpi-card green loaded">
                <div class="kpi-label">Total Revenue</div>
                <div class="kpi-value" style="font-size:1.5rem">${fmt(data.total_revenue)}</div>
                <div class="kpi-sub">Avg ${fmt(data.avg_price)} per package</div>
            </div>
            <div class="kpi-card gold loaded">
                <div class="kpi-label">Avg Rating</div>
                <div class="kpi-value">${data.avg_rating > 0 ? data.avg_rating : '—'}</div>
                <div class="kpi-sub">${data.total_reviews} review${data.total_reviews !== 1 ? 's' : ''}</div>
            </div>
            <div class="kpi-card red loaded">
                <div class="kpi-label">Top Package</div>
                <div class="kpi-value" style="font-size:1rem; padding-top:4px">${data.top_package}</div>
                <div class="kpi-sub">Most booked</div>
            </div>
        `;

            // Stagger animation
            document.querySelectorAll('.kpi-card').forEach((el, i) => {
                el.style.opacity = 0;
                el.style.transform = 'translateY(8px)';
                setTimeout(() => {
                    el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                    el.style.opacity = 1;
                    el.style.transform = 'translateY(0)';
                }, i * 80);
            });
        });

        // ── Bookings per Package (bar) ────────────────────────────────
        api('getBookingsPerPackage').then(data => {
            document.getElementById('card-bookings').classList.add('loaded');
            new Chart(document.getElementById('chart-bookings'), {
                type: 'bar',
                data: {
                    labels: data.map(d => d.Name),
                    datasets: [{
                        label: 'Bookings',
                        data: data.map(d => d.bookings),
                        backgroundColor: BLUE + 'cc',
                        borderColor: BLUE,
                        borderWidth: 2,
                        borderRadius: 6,
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
                        x: {
                            grid: {
                                color: gridColor
                            },
                            ticks: {
                                maxRotation: 30
                            }
                        },
                        y: {
                            grid: {
                                color: gridColor
                            },
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });

        // ── Ratings Breakdown (bar) ───────────────────────────────────
        api('getRatingsBreakdown').then(data => {
            document.getElementById('card-ratings').classList.add('loaded');
            new Chart(document.getElementById('chart-ratings'), {
                type: 'bar',
                data: {
                    labels: ['1 ★', '2 ★', '3 ★', '4 ★', '5 ★'],
                    datasets: [{
                        label: 'Reviews',
                        data: [data[1], data[2], data[3], data[4], data[5]],
                        backgroundColor: [
                            RED + 'cc',
                            '#fd7c3acc',
                            GOLD + 'cc',
                            '#90d060cc',
                            GREEN + 'cc',
                        ],
                        borderColor: [RED, '#fd7c3a', GOLD, '#90d060', GREEN],
                        borderWidth: 2,
                        borderRadius: 6,
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
                        x: {
                            grid: {
                                color: gridColor
                            }
                        },
                        y: {
                            grid: {
                                color: gridColor
                            },
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        });

        // ── Solo vs Group (doughnut) ──────────────────────────────────
        api('getSoloVsGroup').then(data => {
            document.getElementById('card-split').classList.add('loaded');
            const total = data.solo + data.group;
            if (total === 0) {
                document.getElementById('chart-split').closest('.chart-wrap').innerHTML =
                    '<div class="no-data">No booking data yet.</div>';
                return;
            }
            new Chart(document.getElementById('chart-split'), {
                type: 'doughnut',
                data: {
                    labels: ['Solo', 'Group'],
                    datasets: [{
                        data: [data.solo, data.group],
                        backgroundColor: [BLUE + 'cc', GOLD + 'cc'],
                        borderColor: [BLUE, GOLD],
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: GREY,
                                padding: 16
                            }
                        }
                    }
                }
            });
        });

        // ── Recent Reviews ────────────────────────────────────────────
        api('getRecentReviews').then(data => {
            document.getElementById('reviews-card').classList.add('loaded');
            const list = document.getElementById('reviews-list');
            if (!data.length) {
                list.innerHTML = '<div class="no-data">No reviews yet.</div>';
                return;
            }
            list.innerHTML = data.map(r => `
            <div class="review-row">
                <div style="min-width:90px">
                    <div class="stars">${stars(r.Rating)}</div>
                    <div class="review-meta">${r.Rating}/5</div>
                </div>
                <div>
                    <div class="review-comment">${r.Comment || '<em>No comment left.</em>'}</div>
                    <div class="review-meta" style="margin-top:6px">
                        ${r.reviewer} &nbsp;·&nbsp; ${r.package_name} &nbsp;·&nbsp; ${r.Date}
                    </div>
                </div>
            </div>
        `).join('');
        });
    </script>
</body>

</html>