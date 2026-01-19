<?php
include '../includes/db.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'vendor') {
    header("Location: temp_login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$v_res = $conn->query("SELECT id FROM vendors WHERE user_id = $user_id");
$vendor_id = $v_res->fetch_assoc()['id'];

// Get Month/Year from URL or use Current
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// Calculate Calendar Variables
$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDayName = date('l', strtotime("$year-$month-01"));
$dayOffset = date('w', strtotime("$year-$month-01")); // 0 (Sun) - 6 (Sat)

// Fetch Accepted Bookings for this Month
$query = "
    SELECT DAY(o.created_at) as day, s.title, oi.id
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.id
    JOIN services s ON oi.service_id = s.id
    WHERE oi.vendor_id = $vendor_id 
    AND oi.status = 'accepted'
    AND MONTH(o.created_at) = $month 
    AND YEAR(o.created_at) = $year
";
$result = $conn->query($query);

// Group bookings by Day
$bookings = [];
while ($row = $result->fetch_assoc()) {
    $bookings[$row['day']][] = $row;
}

// Navigation Logic
$prevMonth = date('m', mktime(0, 0, 0, $month-1, 1, $year));
$prevYear = date('Y', mktime(0, 0, 0, $month-1, 1, $year));
$nextMonth = date('m', mktime(0, 0, 0, $month+1, 1, $year));
$nextYear = date('Y', mktime(0, 0, 0, $month+1, 1, $year));
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Schedule</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .calendar-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; }
        .day-name { font-weight: bold; text-align: center; background: #eee; padding: 10px; border-radius: 4px; }
        .day-box { 
            background: white; border: 1px solid #ddd; min-height: 100px; padding: 10px; border-radius: 4px; position: relative; 
        }
        .day-box:hover { background: #f9f9f9; }
        .day-number { font-weight: bold; margin-bottom: 5px; color: #333; }
        .event-badge { 
            background: #28a745; color: white; font-size: 11px; padding: 4px; 
            border-radius: 4px; margin-top: 2px; display: block; text-decoration: none; 
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .event-badge:hover { background: #1e7e34; }
        .empty-slot { background: transparent; border: none; }
        .today { border: 2px solid #007bff; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📅 Monthly Schedule</h1>
        <a href="dashboard.php" class="btn">⬅ Dashboard</a>
    </div>

    <div class="calendar-header">
        <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>" class="btn">⬅ Previous</a>
        <h2><?php echo date("F Y", strtotime("$year-$month-01")); ?></h2>
        <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>" class="btn">Next ➡</a>
    </div>

    <div class="calendar-grid">
        <div class="day-name">Sun</div><div class="day-name">Mon</div><div class="day-name">Tue</div>
        <div class="day-name">Wed</div><div class="day-name">Thu</div><div class="day-name">Fri</div>
        <div class="day-name">Sat</div>

        <?php for($i=0; $i < $dayOffset; $i++): ?>
            <div class="empty-slot"></div>
        <?php endfor; ?>

        <?php for($day=1; $day <= $daysInMonth; $day++): ?>
            <?php 
                $isToday = ($day == date('d') && $month == date('m') && $year == date('Y')) ? 'today' : '';
            ?>
            <div class="day-box <?php echo $isToday; ?>">
                <div class="day-number"><?php echo $day; ?></div>
                
                <?php if (isset($bookings[$day])): ?>
                    <?php foreach($bookings[$day] as $b): ?>
                        <a href="order_details.php?id=<?php echo $b['id']; ?>" class="event-badge" title="<?php echo $b['title']; ?>">
                            ✅ <?php echo htmlspecialchars($b['title']); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        <?php endfor; ?>
    </div>
</div>
</body>
</html>