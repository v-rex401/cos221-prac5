<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/auth.php';

$agency_id = getCurrentUserID();
?>

<?php if (!$agency_id): ?>
    <script>
        alert("Please login to view analytics.");
        window.location.href = "../login.php";
    </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Analytics</title>
    <link rel="stylesheet" href="../../css/analytics.css">
    <script>
        const AGENCY_ID = <?= json_encode($agency_id) ?>;
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
</head>

<body>

    <header>
        <a href="agency_dashboard.php" class="back-link">← Dashboard</a>
    </header>

    <main>
        <div class="page-title">Analytics</div>
        <div class="page-subtitle">Performance overview for your agency</div>

        <!-- KPI Cards -->
        <div class="kpi-grid" id="kpi-grid">
            <div class="kpi-card">
                <div class="kpi-label">Loading...</div>
                <div class="skeleton"></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Loading...</div>
                <div class="skeleton"></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Loading...</div>
                <div class="skeleton"></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Loading...</div>
                <div class="skeleton"></div>
            </div>
            <div class="kpi-card">
                <div class="kpi-label">Loading...</div>
                <div class="skeleton"></div>
            </div>
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
    </main>

    <script>
        // ── Helpers ──────────────────────────────────────────────────────
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

        const chartDefaults = {
            font: {
                family: "'DM Sans', sans-serif"
            },
            color: '#7a7f96'
        };
        Chart.defaults.font = chartDefaults.font;
        Chart.defaults.color = chartDefaults.color;

        // ── KPI Cards ─────────────────────────────────────────────────────
        api('getStats').then(data => {
            const grid = document.getElementById('kpi-grid');
            grid.innerHTML = `
        <div class="kpi-card">
            <div class="kpi-label">Total Packages</div>
            <div class="kpi-value">${data.total_packages}</div>
            <div class="kpi-sub">${data.upcoming} upcoming departure${data.upcoming !== 1 ? 's' : ''}</div>
        </div>
        <div class="kpi-card blue">
            <div class="kpi-label">Total Bookings</div>
            <div class="kpi-value">${data.total_bookings}</div>
            <div class="kpi-sub">Across all packages</div>
        </div>
        <div class="kpi-card green">
            <div class="kpi-label">Total Revenue</div>
            <div class="kpi-value" style="font-size:1.6rem">${fmt(data.total_revenue)}</div>
            <div class="kpi-sub">Avg ${fmt(data.avg_price)} / package</div>
        </div>
        <div class="kpi-card">
            <div class="kpi-label">Avg Rating</div>
            <div class="kpi-value">${data.avg_rating > 0 ? data.avg_rating : '—'}</div>
            <div class="kpi-sub">${data.total_reviews} review${data.total_reviews !== 1 ? 's' : ''}</div>
        </div>
        <div class="kpi-card red">
            <div class="kpi-label">Top Package</div>
            <div class="kpi-value" style="font-size:1.1rem; padding-top:6px">${data.top_package}</div>
            <div class="kpi-sub">Most booked</div>
        </div>
    `;
            // Stagger animation
            document.querySelectorAll('.kpi-card').forEach((el, i) => {
                setTimeout(() => el.classList.add('loaded'), i * 80);
            });
        });

        // ── Bookings per Package (bar) ────────────────────────────────────
        api('getBookingsPerPackage').then(data => {
            const card = document.getElementById('card-bookings');
            card.classList.add('loaded');

            new Chart(document.getElementById('chart-bookings'), {
                type: 'bar',
                data: {
                    labels: data.map(d => d.Name),
                    datasets: [{
                        label: 'Bookings',
                        data: data.map(d => d.bookings),
                        backgroundColor: '#f0c040cc',
                        borderColor: '#f0c040',
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
                                color: '#252836'
                            },
                            ticks: {
                                color: '#7a7f96',
                                maxRotation: 30
                            }
                        },
                        y: {
                            grid: {
                                color: '#252836'
                            },
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#7a7f96'
                            }
                        }
                    }
                }
            });
        });

        // ── Ratings Breakdown (bar) ───────────────────────────────────────
        api('getRatingsBreakdown').then(data => {
            const card = document.getElementById('card-ratings');
            card.classList.add('loaded');

            const labels = ['1 ★', '2 ★', '3 ★', '4 ★', '5 ★'];
            const counts = [data[1], data[2], data[3], data[4], data[5]];
            const colors = ['#f06060cc', '#f09060cc', '#f0c040cc', '#a0d060cc', '#60d0a0cc'];

            new Chart(document.getElementById('chart-ratings'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Reviews',
                        data: counts,
                        backgroundColor: colors,
                        borderColor: colors.map(c => c.replace('cc', '')),
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
                                color: '#252836'
                            },
                            ticks: {
                                color: '#7a7f96'
                            }
                        },
                        y: {
                            grid: {
                                color: '#252836'
                            },
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                color: '#7a7f96'
                            }
                        }
                    }
                }
            });
        });

        // ── Solo vs Group (doughnut) ──────────────────────────────────────
        api('getSoloVsGroup').then(data => {
            const card = document.getElementById('card-split');
            card.classList.add('loaded');

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
                        backgroundColor: ['#4fc3f7cc', '#f0c040cc'],
                        borderColor: ['#4fc3f7', '#f0c040'],
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
                                color: '#7a7f96',
                                padding: 16
                            }
                        }
                    }
                }
            });
        });

        // ── Recent Reviews ────────────────────────────────────────────────
        api('getRecentReviews').then(data => {
            const card = document.getElementById('reviews-card');
            card.classList.add('loaded');
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