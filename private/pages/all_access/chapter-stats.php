<?php

require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../private/scripts/features/functions.php");
$stats = get_chapter_stats();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapter Stats</title>
</head>

<body>
    <title>NHS Chapter Stats</title>

<style>

    .grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    .card {
        background: #1e293b;
        border-radius: 12px;
        padding: 16px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .stat {
        font-size: 14px;
        margin: 4px 0;
    }

    .bar-container {
        background: #334155;
        border-radius: 8px;
        height: 10px;
        margin-top: 10px;
        overflow: hidden;
    }

    .bar {
        height: 100%;
        background: yellow;
        width: 0%;
    }

    .total {
        margin-top: 8px;
        font-weight: bold;
        color: #f8fafc;
    }
</style>

<body>

<h1>NHS Chapter Hours Dashboard</h1>

<div class="grid" id="dashboard"></div>

<script>
// ===== YOUR DATA GOES HERE =====
const data = {
    officer_hours_gsp: <?php echo $stats['officer']['gsp'] ?? 0; ?>,
    officer_hours_isp: <?php echo $stats['officer']['isp'] ?? 0; ?>,

    polis_hours_gsp: <?php echo $stats['polis']['gsp'] ?? 0; ?>,
    polis_hours_isp: <?php echo $stats['polis']['isp'] ?? 0; ?>,

    fundraiser_hours_gsp: <?php echo $stats['fundraiser']['gsp'] ?? 0; ?>,
    fundraiser_hours_isp: <?php echo $stats['fundraiser']['isp'] ?? 0; ?>,

    elders_hours_gsp: <?php echo $stats['elders']['gsp'] ?? 0; ?>,
    elders_hours_isp: <?php echo $stats['elders']['isp'] ?? 0; ?>,

    assembly_hours_gsp: <?php echo $stats['assembly']['gsp'] ?? 0; ?>,
    assembly_hours_isp: <?php echo $stats['assembly']['isp'] ?? 0; ?>
};

// ===== PROCESS DATA =====
const committees = ["officer", "polis", "fundraiser", "elders", "assembly"];

const totals = committees.map(name => {
    const gsp = data[`${name}_hours_gsp`] || 0;
    const isp = data[`${name}_hours_isp`] || 0;
    const total = gsp + isp;

    return { name, gsp, isp, total };
});

// max for scaling bars
const maxTotal = Math.max(...totals.map(c => c.total));

// ===== RENDER =====
const container = document.getElementById("dashboard");

totals.forEach(c => {
    const percent = (c.total / maxTotal) * 100;

    const card = document.createElement("div");
    card.className = "card";

    card.innerHTML = `
        <div class="title">${c.name}</div>
        <div class="stat">GSP Hours: ${c.gsp}</div>
        <div class="stat">ISP Hours: ${c.isp}</div>
        <div class="total">Total: ${c.total}</div>

        <div class="bar-container">
            <div class="bar" style="width:${percent}%"></div>
        </div>
    `;

    container.appendChild(card);
});
</script>

</body>
</html>
