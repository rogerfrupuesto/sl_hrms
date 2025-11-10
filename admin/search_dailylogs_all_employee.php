<?php
include('../config/db_config.php');
session_start();

$requestData = $_REQUEST;

// Column mapping for ordering
$columns = array(
    0 => 'date_logs',
    1 => 'emp_id',
    2 => 'fullname',
    3 => 'punch_in',
    4 => 'punch_out',
    5 => 'overtime_in',
    6 => 'overtime_out'
);

// -----------------------------------------
// 1️⃣ Count total records (no filtering)
// -----------------------------------------
$sql = "SELECT COUNT(*) as total FROM tbl_employee_timelogs";
$stmt = $con->prepare($sql);
$stmt->execute();
$totalData = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
$totalFiltered = $totalData;

// -----------------------------------------
// 2️⃣ Build base query
// -----------------------------------------
$sql = "SELECT
            t.id, 
            t.date_logs,
            t.schedule_code,
            t.emp_id,
            t.punch_in,
            t.punch_out,
            t.late,
            t.work_hours,
            t.overtime_in,
            t.overtime_out,
            r.fullname
        FROM tbl_employee_timelogs t
        LEFT JOIN tbl_employee_info r ON r.emp_id = t.emp_id
        WHERE 1=1";

// -----------------------------------------
// 3️⃣ Filtering
// -----------------------------------------
if (!empty($requestData['search']['value'])) {
    $search = "%" . $requestData['search']['value'] . "%";
    $sql .= " AND (t.emp_id LIKE :search OR t.date_logs LIKE :search OR r.fullname LIKE :search)";
}

// -----------------------------------------
// 4️⃣ Ordering — default to t.id DESC
// -----------------------------------------
if (!empty($requestData['order'][0]['column'])) {
    $orderColIndex = intval($requestData['order'][0]['column']);
    $orderDir = strtoupper($requestData['order'][0]['dir']) === 'ASC' ? 'ASC' : 'DESC';
    $orderCol = isset($columns[$orderColIndex]) ? $columns[$orderColIndex] : 't.id';
    $sql .= " ORDER BY $orderCol $orderDir";
} else {
    // Default order when no sorting is sent by DataTables
    $sql .= " ORDER BY t.id DESC";
}

// -----------------------------------------
// 5️⃣ Pagination (LIMIT & OFFSET)
// -----------------------------------------
$start = intval($requestData['start']);
$length = intval($requestData['length']);
$sql .= " LIMIT :start, :length";

// -----------------------------------------
// 6️⃣ Prepare and bind parameters
// -----------------------------------------
$stmt = $con->prepare($sql);

if (!empty($requestData['search']['value'])) {
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
}
$stmt->bindParam(':start', $start, PDO::PARAM_INT);
$stmt->bindParam(':length', $length, PDO::PARAM_INT);
$stmt->execute();

$data = [];

// -----------------------------------------
// 7️⃣ Count filtered data
// -----------------------------------------
if (!empty($requestData['search']['value'])) {
    $countSql = "SELECT COUNT(*) as total 
                 FROM tbl_employee_timelogs t
                 LEFT JOIN tbl_employee_info r ON r.emp_id = t.emp_id
                 WHERE (t.emp_id LIKE :search OR t.date_logs LIKE :search OR r.fullname LIKE :search)";
    $countStmt = $con->prepare($countSql);
    $countStmt->bindParam(':search', $search, PDO::PARAM_STR);
    $countStmt->execute();
    $totalFiltered = $countStmt->fetch(PDO::FETCH_ASSOC)['total'];
}

// -----------------------------------------
// 8️⃣ Build response rows
// -----------------------------------------
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $nestedData = [];
    $nestedData[] = '<div style="text-align:center;">' . htmlspecialchars($row["emp_id"]) . '</div>';
    $nestedData[] = '<div style="text-align:center;">' . strtoupper(htmlspecialchars($row["fullname"])) . '</div>';
    $nestedData[] = '<div style="text-align:center;">' . strtoupper(htmlspecialchars($row["schedule_code"])) . '</div>';
    $nestedData[] = '<div style="text-align:center;">' . htmlspecialchars($row["date_logs"]) . '</div>';
    $nestedData[] = '<div style="text-align:center;">' . htmlspecialchars($row["punch_in"]) . '</div>';
    $nestedData[] = '<div style="text-align:center;">' . htmlspecialchars($row["punch_out"]) . '</div>';
    $nestedData[] = '<div style="text-align:center; color:red;">' . htmlspecialchars($row["late"]) . '</div>';
    $nestedData[] = '<div style="text-align:center;">' . htmlspecialchars($row["overtime_in"]) . '</div>';
    $nestedData[] = '<div style="text-align:center;">' . htmlspecialchars($row["overtime_out"]) . '</div>';

    $data[] = $nestedData;
}

// -----------------------------------------
// 9️⃣ Return JSON to DataTables
// -----------------------------------------
$json_data = array(
    "draw"            => intval($requestData['draw']),
    "recordsTotal"    => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data"            => $data
);

echo json_encode($json_data);
