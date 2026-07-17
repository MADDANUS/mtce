<?php
$pdo = new PDO('mysql:host=localhost;dbname=mtce_db', 'root', '');
$stmt = $pdo->query("SELECT id_parameter, bagian_check FROM master_parameter_check WHERE bagian_check LIKE '% RPM'");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

$updated = 0;
foreach($rows as $r) {
    $text = $r['bagian_check'];
    // Look for space followed by digits then " RPM"
    if (preg_match('/^(.*?)\s+([0-9]+ RPM)$/', $text, $matches)) {
        // Only update if it doesn't already have '|'
        if (strpos($text, '|') === false) {
            $newText = $matches[1] . ' | ' . $matches[2];
            $upd = $pdo->prepare("UPDATE master_parameter_check SET bagian_check = ? WHERE id_parameter = ?");
            $upd->execute([$newText, $r['id_parameter']]);
            $updated++;
        }
    }
}
echo "Updated $updated records.\n";
