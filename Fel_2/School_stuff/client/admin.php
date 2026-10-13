<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin felület</title>
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body class="app-background">
    <main class="page-wrapper">
        <section class="brand-panel">
            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse4.mm.bing.net%2Fth%2Fid%2FOIP.LYPNRLagI8mWwEzypsUhYgHaHa%3Fr%3D0%26pid%3DApi&f=1&ipt=1870d6e36c19ff8f0a6cb3c09445fa55728f6ea8332e26bb98750ca70215ffcd&ipo=images" class="logo-placeholder">
            <h1>Admin felület</h1>
            <p>Jelentkezések kezelése.</p>
            <a href="./index.php" class="admin-link">Vissza a regisztrációhoz</a>
        </section>

        <div class="content-stack">
            <section class="card">
                <h2>Regisztrációk</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Név</th>
                                <th>Iskola</th>
                                <th>Szakok</th>
                                <th>Koleszos</th>
                                <th>Végzős</th>
                                <th>Dátum</th>
                                <th>Művelet</th>
                            </tr>
                        </thead>
                        <tbody id="registrationsTableBody"></tbody>
                    </table>
                </div>
            </section>

            <section class="card">
                <h2>Statisztikák szakok szerint</h2>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th>Szak</th>
                                <th>Összes jelentkező</th>
                                <th>Végzős jelentkező</th>
                                <th>Koleszos jelentkező</th>
                                <th>Koleszos végzős</th>
                            </tr>
                        </thead>
                        <tbody id="statsTableBody"></tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>

    <script src="./src/js/admin.js" type="module"></script>
</body>
</html>
