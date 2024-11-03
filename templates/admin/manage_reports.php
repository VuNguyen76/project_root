<?php
session_start();
include '../../config/db.php';

// Tính toán tổng thu nhập theo ngày, tháng, năm và lấy dữ liệu cho biểu đồ
function calculateRevenue($conn)
{
    // Tổng thu nhập theo ngày
    $dailyQuery = "SELECT DATE(payment_date) AS date, SUM(amount) AS total_revenue
                   FROM payments
                   WHERE status = 'paid'
                   GROUP BY DATE(payment_date)";
    $dailyResult = $conn->query($dailyQuery);
    $dailyRevenue = [];
    while ($row = $dailyResult->fetch_assoc()) {
        $dailyRevenue[] = $row;
    }

    // Tổng thu nhập theo tháng
    $monthlyQuery = "SELECT DATE_FORMAT(payment_date, '%Y-%m') AS month, SUM(amount) AS total_revenue
                     FROM payments
                     WHERE status = 'paid'
                     GROUP BY DATE_FORMAT(payment_date, '%Y-%m')";
    $monthlyResult = $conn->query($monthlyQuery);
    $monthlyRevenue = [];
    while ($row = $monthlyResult->fetch_assoc()) {
        $monthlyRevenue[] = $row;
    }

    // Tổng thu nhập theo năm
    $yearlyQuery = "SELECT YEAR(payment_date) AS year, SUM(amount) AS total_revenue
                    FROM payments
                    WHERE status = 'paid'
                    GROUP BY YEAR(payment_date)";
    $yearlyResult = $conn->query($yearlyQuery);
    $yearlyRevenue = [];
    while ($row = $yearlyResult->fetch_assoc()) {
        $yearlyRevenue[] = $row;
    }

    return [
        'daily' => $dailyRevenue,
        'monthly' => $monthlyRevenue,
        'yearly' => $yearlyRevenue,
    ];
}

$revenueData = calculateRevenue($conn);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê Doanh Thu</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <h1>Thống Kê Doanh Thu</h1>

    <!-- Biểu đồ Doanh thu hàng ngày -->
    <h2>Doanh thu hàng ngày</h2>
    <canvas id="dailyRevenueChart"></canvas>

    <!-- Biểu đồ Doanh thu hàng tháng -->
    <h2>Doanh thu hàng tháng</h2>
    <canvas id="monthlyRevenueChart"></canvas>

    <!-- Biểu đồ Doanh thu hàng năm -->
    <h2>Doanh thu hàng năm</h2>
    <canvas id="yearlyRevenueChart"></canvas>

    <script>
        // Biểu đồ Doanh thu hàng ngày
        const dailyLabels = <?= json_encode(array_column($revenueData['daily'], 'date')) ?>;
        const dailyData = <?= json_encode(array_column($revenueData['daily'], 'total_revenue')) ?>;
        new Chart(document.getElementById('dailyRevenueChart'), {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [{
                    label: 'Doanh thu hàng ngày (VND)',
                    data: dailyData,
                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Doanh thu (VND)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Ngày'
                        }
                    }
                }
            }
        });

        // Biểu đồ Doanh thu hàng tháng
        const monthlyLabels = <?= json_encode(array_column($revenueData['monthly'], 'month')) ?>;
        const monthlyData = <?= json_encode(array_column($revenueData['monthly'], 'total_revenue')) ?>;
        new Chart(document.getElementById('monthlyRevenueChart'), {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Doanh thu hàng tháng (VND)',
                    data: monthlyData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Doanh thu (VND)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tháng'
                        }
                    }
                }
            }
        });

        // Biểu đồ Doanh thu hàng năm
        const yearlyLabels = <?= json_encode(array_column($revenueData['yearly'], 'year')) ?>;
        const yearlyData = <?= json_encode(array_column($revenueData['yearly'], 'total_revenue')) ?>;
        new Chart(document.getElementById('yearlyRevenueChart'), {
            type: 'bar',
            data: {
                labels: yearlyLabels,
                datasets: [{
                    label: 'Doanh thu hàng năm (VND)',
                    data: yearlyData,
                    backgroundColor: 'rgba(255, 99, 132, 0.6)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Doanh thu (VND)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Năm'
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>

<?php $conn->close(); ?>