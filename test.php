<?php
require_once 'include/Session.php';
require_once 'include/Controller.php';
$Controller = new Controller;
$reportsData = $Controller->getReports();
$getStreams = $Controller->getStreams();
var_dump($getStreams);
die();
?>
<!-- Correct way -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Church Kids Registration Analytics</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Fredoka+One&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
        :root {
            --primary: #6C63FF;
            --secondary: #4F46E5;
            --accent: #FF6584;
            --light: #F8F9FA;
            --dark: #212529;
            --success: #28A745;
            --info: #17A2B8;
            --warning: #FFC107;
            --danger: #DC3545;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #F5F7FF;
            color: var(--dark);
            margin: 0;
            padding: 0;
        }

        .dashboard {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            padding: 2rem 1rem;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .sidebar-header h2 {
            font-family: 'Fredoka One', cursive;
            margin: 0;
            font-size: 1.5rem;
            color: white;
        }

        .sidebar-header p {
            opacity: 0.8;
            font-size: 0.9rem;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            font-family: 'Fredoka One', cursive;
            color: var(--secondary);
            margin: 0;
        }

        .date-filter {
            background: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h3 {
            margin-top: 0;
            color: var(--dark);
            font-size: 1rem;
            opacity: 0.7;
        }

        .stat-card .value {
            font-size: 2.5rem;
            font-weight: 700;
            margin: 0.5rem 0;
            color: var(--primary);
        }

        .stat-card .change {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .change.up {
            color: var(--success);
        }

        .change.down {
            color: var(--danger);
        }

        .change i {
            margin-right: 5px;
        }

        .chart-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .chart-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .chart-card h2 {
            margin-top: 0;
            font-size: 1.25rem;
            color: var(--dark);
        }

        .chart {
            height: 300px;
            width: 100%;
        }

        .table-container {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: var(--secondary);
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-primary {
            background-color: rgba(108, 99, 255, 0.1);
            color: var(--primary);
        }

        .badge-success {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--success);
        }

        .badge-warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: var(--warning);
        }

        @media (max-width: 992px) {
            .dashboard {
                grid-template-columns: 1fr;
            }

            .sidebar {
                display: none;
            }

            .chart-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Kids Ministry</h2>
                <p>Registration Analytics</p>
            </div>
            <ul class="sidebar-menu">
                <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <!-- <li><a href="#"><i class="fas fa-globe-americas"></i> By Zones</a></li>
                <li><a href="#"><i class="fas fa-flag"></i> By Countries</a></li>
                <li><a href="#"><i class="fas fa-city"></i> By States/Cities</a></li>
                <li><a href="#"><i class="fas fa-calendar-alt"></i> Time Analysis</a></li>
                <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li> -->
            </ul>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Registration Analytics Dashboard</h1>
                <div class="date-filter">
                    <i class="fas fa-calendar-alt"></i>
                    <select id="time-period">
                        <option>Last 7 Days</option>
                        <option selected>Last 30 Days</option>
                        <option>Last 90 Days</option>
                        <option>This Year</option>
                        <option>All Time</option>
                    </select>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total Registrations</h3>
                    <div class="value"><?= number_format($reportsData['total_registrations']) ?></div>
                    <div class="change <?= $reportsData['registration_growth'] >= 0 ? 'up' : 'down' ?>">
                        <i class="fas fa-arrow-<?= $reportsData['registration_growth'] >= 0 ? 'up' : 'down' ?>"></i>
                        <?= abs($reportsData['registration_growth']) ?>% from last period
                    </div>
                </div>

                <div class="stat-card">
                    <h3>Countries</h3>
                    <div class="value"><?= number_format($reportsData['total_countries']) ?></div>
                    <div class="change up">
                        <i class="fas fa-arrow-up"></i> <?= $reportsData['new_countries'] ?> new countries
                    </div>
                </div>

                <div class="stat-card">
                    <h3>States/Provinces</h3>
                    <div class="value"><?= number_format($reportsData['total_states']) ?></div>
                    <div class="change up">
                        <i class="fas fa-arrow-up"></i> <?= $reportsData['state_growth'] ?>% growth
                    </div>
                </div>

                <div class="stat-card">
                    <h3>Cities</h3>
                    <div class="value"><?= number_format($reportsData['total_cities']) ?></div>
                    <div class="change up">
                        <i class="fas fa-arrow-up"></i> <?= $reportsData['city_growth'] ?>% growth
                    </div>
                </div>
            </div>

            <div class="chart-container">
                <div class="chart-card">
                    <h2>Registrations by Zone</h2>
                    <div id="zoneChart" class="chart"></div>
                </div>

                <div class="chart-card">
                    <h2>Top Countries</h2>
                    <div id="countryChart" class="chart"></div>
                </div>
            </div>

           <div class="table-container">
    <h2>Detailed Breakdown by Zone</h2>
    
    <!-- Zone Summary Table -->
    <div class="mb-4">
        <h3>Zone Summary</h3>
        <table id="zonesTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Zone</th>
                    <th>Registrations</th>
                    <th>Countries</th>
                    <th>States</th>
                    <th>Cities</th>
                    <th>Growth</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reportsData['zones'] as $zone): ?>
                <tr>
                    <td><?= htmlspecialchars($zone['zone_name']) ?></td>
                    <td><?= number_format($zone['registrations']) ?></td>
                    <td><?= number_format($zone['countries']) ?></td>
                    <td><?= number_format($zone['states']) ?></td>
                    <td><?= number_format($zone['cities']) ?></td>
                    <td>
                        <span class="badge badge-<?= 
                            $zone['growth'] > 15 ? 'success' : 
                            ($zone['growth'] > 5 ? 'primary' : 'warning')
                        ?>">
                            <?= $zone['growth'] >= 0 ? '+' : '' ?><?= $zone['growth'] ?>%
                        </span>
                    </td>
                    <td>
                        <button class="btn-view-countries" data-zone="<?= $zone['zone_id'] ?>">
                            <i class="fas fa-eye"></i> View Countries
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Countries by Zone Table (initially hidden) -->
    <div id="countriesByZoneSection" class="mt-5" style="display:none">
        <h3>Countries in <span id="currentZoneName"></span></h3>
        <div class="mb-3">
            <div class="input-group">
                <input type="text" id="countrySearch" class="form-control" placeholder="Search countries...">
                <button class="btn btn-primary" id="clearSearch">Clear</button>
            </div>
        </div>
        <table id="countriesByZoneTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Country</th>
                    <th>Registrations</th>
                    <th>States</th>
                    <th>Cities</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <!-- Will be populated by JavaScript -->
            </tbody>
        </table>
    </div>
</div>

<!-- Include DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize zones table
    var zonesTable = $('#zonesTable').DataTable({
        dom: 'lfrtip',
        pageLength: 10,
        responsive: true
    });
    
    // Store zone country data for JavaScript access
    var zoneCountryData = <?= json_encode($reportsData['zone_countries']) ?>;
    var zoneLookup = <?= json_encode(array_column($reportsData['zones'], 'zone_name', 'zone_id')) ?>;
    
    // Initialize countries table (will be configured when zone is selected)
    var countriesTable;
    
    // Handle view countries button click
    $(document).on('click', '.btn-view-countries', function() {
        var zoneId = $(this).data('zone');
        var zoneName = zoneLookup[zoneId];
        
        // Show the section
        $('#countriesByZoneSection').show();
        $('#currentZoneName').text(zoneName);
        
        // Get the country data for this zone
        var countryData = zoneCountryData[zoneId] || [];
        
        // Calculate total registrations for percentage calculation
        var totalReg = countryData.reduce((sum, country) => sum + country.registrations, 0);
        
        // Prepare table data
        var tableData = countryData.map(country => {
            return [
                country.country_name,
                country.registrations.toLocaleString(),
                country.states.toLocaleString(),
                country.cities.toLocaleString(),
                totalReg > 0 ? ((country.registrations / totalReg) * 100).toFixed(1) + '%' : '0%'
            ];
        });
        
        // Destroy previous table if it exists
        if ($.fn.DataTable.isDataTable('#countriesByZoneTable')) {
            $('#countriesByZoneTable').DataTable().destroy();
        }
        
        // Clear the table body
        $('#countriesByZoneTable tbody').empty();
        
        // Initialize new DataTable
        countriesTable = $('#countriesByZoneTable').DataTable({
            data: tableData,
            dom: 'lfrtip',
            pageLength: 10,
            responsive: true,
            columns: [
                { title: "Country" },
                { title: "Registrations" },
                { title: "States" },
                { title: "Cities" },
                { title: "Percentage" }
            ],
            initComplete: function() {
                // Apply the search
                $('#countrySearch').on('keyup', function() {
                    countriesTable.search(this.value).draw();
                });
                
                $('#clearSearch').on('click', function() {
                    $('#countrySearch').val('');
                    countriesTable.search('').draw();
                });
            }
        });
        
        // Scroll to the countries section
        $('html, body').animate({
            scrollTop: $('#countriesByZoneSection').offset().top - 20
        }, 500);
    });
});
</script>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script>
        // Zone Chart (Doughnut)
        const zoneCtx = document.getElementById('zoneChart');
        const zoneChart = new Chart(zoneCtx, {
            type: 'doughnut',
            data: {
                labels: <?= json_encode(array_column($reportsData['zones'], 'zone_name')) ?>,
                datasets: [{
                    data: <?= json_encode(array_column($reportsData['zones'], 'registrations')) ?>,
                    backgroundColor: [
                        '#6C63FF',
                        '#4F46E5',
                        '#FF6584',
                        '#28A745',
                        '#FFC107',
                        '#17A2B8'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            boxWidth: 12,
                            padding: 20
                        }
                    }
                }
            }
        });

        // Country Chart (Bar)
        const countryChart = echarts.init(document.getElementById('countryChart'));
        const countryOption = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'value',
                axisLine: {
                    show: false
                },
                axisTick: {
                    show: false
                },
                splitLine: {
                    lineStyle: {
                        color: '#eee'
                    }
                }
            },
            yAxis: {
                type: 'category',
                data: <?= json_encode(array_column($reportsData['top_countries'], 'country_name')) ?>,
                axisLine: {
                    show: false
                },
                axisTick: {
                    show: false
                }
            },
            series: [{
                name: 'Registrations',
                type: 'bar',
                data: <?= json_encode(array_column($reportsData['top_countries'], 'registrations')) ?>,
                itemStyle: {
                    color: new echarts.graphic.LinearGradient(0, 0, 1, 0, [{
                            offset: 0,
                            color: '#6C63FF'
                        },
                        {
                            offset: 1,
                            color: '#4F46E5'
                        }
                    ]),
                    borderRadius: [0, 4, 4, 0]
                },
                barWidth: '60%'
            }]
        };
        countryChart.setOption(countryOption);

        // Handle window resize
        window.addEventListener('resize', function() {
            countryChart.resize();
        });
    </script>
</body>

</html>