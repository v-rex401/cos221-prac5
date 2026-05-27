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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Group Bookings</title>
    <script>
        const AGENCY_ID = <?= json_encode($agency_id) ?>;
    </script>
    <link rel="stylesheet" href="../../css/dashboard.css">
</head>

<body>
    <div id="mainBoard">
        <a href="agency_dashboard.php">Go Back</a>
        <div style="width: 100%;">
            <h2>Group Bookings</h2>
        </div>

        <?php if (empty($bookings)): ?>
            <p>No group bookings on your packages yet.</p>
        <?php else: ?>
            <?php foreach ($bookings as $b): ?>
                <div class="dashboardCard">
                    <h3><?= htmlspecialchars($b['Name']) ?></h3>
                    <p><strong>Sharing Code:</strong> <?= htmlspecialchars($b['Sharing_Code']) ?></p>
                    <p><strong>Dates:</strong>
                        <span id="dates-<?= $b['Booking_ID'] ?>">
                            <?= $b['Start_Date'] ?> → <?= $b['End_Date'] ?>
                        </span>
                    </p>
                    <p><strong>Guests:</strong>
                        <span id="guests-<?= $b['Booking_ID'] ?>">
                            <?= $b['Guest_Count'] ?> / <?= $b['Guest_Limit'] ?>
                        </span>
                    </p>
                    <p><strong>Price:</strong> R<?= htmlspecialchars($b['Price']) ?></p>

                    <!-- Edit Form (hidden by default) -->
                    <div id="edit-<?= $b['Booking_ID'] ?>" style="display:none; background:#f9f9f9; padding:12px; border-radius:6px; margin:8px 0;">
                        <label>Start Date</label><br>
                        <input type="date" id="edit-start-<?= $b['Booking_ID'] ?>" value="<?= $b['Start_Date'] ?>"><br><br>

                        <label>End Date</label><br>
                        <input type="date" id="edit-end-<?= $b['Booking_ID'] ?>" value="<?= $b['End_Date'] ?>"><br><br>

                        <label>Max Guests</label><br>
                        <input type="number" id="edit-limit-<?= $b['Booking_ID'] ?>" value="<?= $b['Guest_Limit'] ?>" min="<?= $b['Guest_Count'] ?>"><br><br>

                        <button onclick="saveBooking(<?= $b['Booking_ID'] ?>)">Save</button>
                        <button onclick="toggleEdit(<?= $b['Booking_ID'] ?>)">Cancel</button>
                    </div>

                    <button id="edit-btn-<?= $b['Booking_ID'] ?>" onclick="toggleEdit(<?= $b['Booking_ID'] ?>)">Edit</button>
                    <button onclick="deleteBooking(<?= $b['Booking_ID'] ?>)">Delete</button>
                    <button onclick="toggleMembers(<?= $b['Booking_ID'] ?>, this)">Show Members</button>

                    <!-- Members List (hidden by default) -->
                    <div id="members-<?= $b['Booking_ID'] ?>" style="display:none; margin-top:8px;"></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <script>
        function toggleEdit(booking_id) {
            const form = document.getElementById('edit-' + booking_id);
            const btn = document.getElementById('edit-btn-' + booking_id);
            const isOpen = form.style.display === 'block';
            form.style.display = isOpen ? 'none' : 'block';
            btn.textContent = isOpen ? 'Edit' : 'Cancel';
        }

        function saveBooking(booking_id) {
            const start_date = document.getElementById('edit-start-' + booking_id).value;
            const end_date = document.getElementById('edit-end-' + booking_id).value;
            const guest_limit = parseInt(document.getElementById('edit-limit-' + booking_id).value);

            if (!start_date || !end_date) {
                alert('Please fill in both dates.');
                return;
            }
            if (end_date <= start_date) {
                alert('End date must be after start date.');
                return;
            }

            fetch('../../includes/manage_group_bookings_queries.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        type: 'updateGroupBooking',
                        booking_id,
                        agency_id: AGENCY_ID,
                        start_date,
                        end_date,
                        guest_limit
                    })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        // Update display without full reload
                        document.getElementById('dates-' + booking_id).textContent = start_date + ' → ' + end_date;
                        const guestSpan = document.getElementById('guests-' + booking_id);
                        const currentCount = guestSpan.textContent.split('/')[0].trim();
                        guestSpan.textContent = currentCount + ' / ' + guest_limit;
                        toggleEdit(booking_id);
                        alert('Booking updated!');
                    } else {
                        alert('Error: ' + res.message);
                    }
                });
        }

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


        function deleteBooking(booking_id) {
            if (!confirm('Are you sure you want to delete this group booking? This cannot be undone.')) return;

            fetch('../../includes/manage_group_bookings_queries.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        type: 'deleteGroupBooking',
                        booking_id,
                        agency_id: AGENCY_ID
                    })
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        // Remove the card from the page without reloading
                        document.getElementById('edit-' + booking_id).closest('.dashboardCard').remove();
                    } else {
                        alert('Error: ' + res.message);
                    }
                });
        }
    </script>
</body>

</html>