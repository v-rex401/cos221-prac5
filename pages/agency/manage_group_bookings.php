<?php
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/manage_group_bookings_queries.php';

redirectIfNotAgency();
$agency_id = getCurrentUserID();
$bookings  = getGroupBookings($conn, $agency_id);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Group Bookings</title>
    <script>
        const AGENCY_ID = <?= json_encode($agency_id) ?>;
    </script>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<body>
    <div id="mainBoard">
        <a href="agency_dashboard.php">Go Back</a>
        <h2>Group Bookings</h2>

        <?php if (empty($bookings)): ?>
            <p>No group bookings on your packages yet.</p>
        <?php else: ?>
            <?php foreach ($bookings as $b): ?>
                <div class="dashboardCard">
                    <h3><?= htmlspecialchars($b['Name']) ?></h3>
                    <p><strong>Sharing Code:</strong> <?= htmlspecialchars($b['Sharing_Code']) ?></p>
                    <p><strong>Dates:</strong> <?= $b['Start_Date'] ?> → <?= $b['End_Date'] ?></p>
                    <p><strong>Guests:</strong> <?= $b['Guest_Count'] ?> / <?= $b['Guest_Limit'] ?></p>
                    <p><strong>Price:</strong> R<?= htmlspecialchars($b['Price']) ?></p>
                    <button onclick="toggleMembers(<?= $b['Booking_ID'] ?>, this)">Show Members</button>
                    <div id="members-<?= $b['Booking_ID'] ?>" style="display:none; margin-top:8px;"></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        function toggleMembers(booking_id, btn) {
            const container = document.getElementById('members-' + booking_id);

            if (container.style.display === 'block') {
                container.style.display = 'none';
                btn.textContent = 'Show Members';
                return;
            }

            fetch('../../includes/manage_group_bookings_queries.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        type: 'getGroupBookingMembers',
                        booking_id,
                        agency_id: AGENCY_ID
                    })
                })
                .then(r => r.json())
                .then(res => {
                    if (!res.success) {
                        alert(res.message);
                        return;
                    }

                    container.innerHTML = res.members.length === 0 ?
                        '<p>No members yet.</p>' :
                        `<table style="width:100%; border-collapse:collapse;">
                <tr>
                    <th style="text-align:left; padding:4px; border-bottom:1px solid #ccc;">Name</th>
                    <th style="text-align:left; padding:4px; border-bottom:1px solid #ccc;">Email</th>
                    <th style="text-align:left; padding:4px; border-bottom:1px solid #ccc;">Cell</th>
                    <th style="text-align:left; padding:4px; border-bottom:1px solid #ccc;">Joined</th>
                </tr>
                ${res.members.map(m => `
                    <tr>
                        <td style="padding:4px;">${m.Name}</td>
                        <td style="padding:4px;">${m.Email}</td>
                        <td style="padding:4px;">${m.Cell}</td>
                        <td style="padding:4px;">${m.Joined_Date}</td>
                    </tr>
                `).join('')}
               </table>`;

                    container.style.display = 'block';
                    btn.textContent = 'Hide Members';
                });
        }
    </script>
</body>

</html>