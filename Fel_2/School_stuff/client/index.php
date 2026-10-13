<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztráció</title>
    <link rel="stylesheet" href="./src/css/style.css">
</head>
<body class="app-background">
    <main class="page-wrapper">
        <section class="brand-panel">
            <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse4.mm.bing.net%2Fth%2Fid%2FOIP.LYPNRLagI8mWwEzypsUhYgHaHa%3Fr%3D0%26pid%3DApi&f=1&ipt=1870d6e36c19ff8f0a6cb3c09445fa55728f6ea8332e26bb98750ca70215ffcd&ipo=images" class="logo-placeholder">
            <h1>Regisztrációs űrlap</h1>
            <p>A jelentkezések adatai.</p>
            <a href="./admin.php" class="admin-link">Admin felület megnyitása</a>
        </section>

        <div class="content-stack">
            <section class="card">
                <form id="registrationForm" class="form-grid">
                    <label>
                        Teljes név
                        <input type="text" id="fullName" required>
                    </label>

                    <label>
                        Iskola, ahonnan jöttél
                        <input type="text" id="schoolName" required>
                    </label>

                    <div class="interest-section">
                        <label for="interestInput">Érdeklődési szak(ok)</label>
                        <div class="interest-actions">
                            <select id="interestInput">
                                <option value="">Válassz szakot</option>
                                <option value="Szoftverfejlesztő és -tesztelő">Szoftverfejlesztő és -tesztelő</option>
                                <option value="Szakács">Szakács</option>
                                <option value="Pénzügyi-számviteli ügyintéző">Pénzügyi-számviteli ügyintéző</option>
                                <option value="Mechatronikus karbantartó">Mechatronikus karbantartó</option>
                                <option value="CNC-programozó">CNC-programozó</option>
                            </select>
                            <button type="button" id="addInterestButton">Szak hozzáadása</button>
                        </div>
                        <ul id="interestList" class="chips"></ul>
                    </div>

                    <div class="radio-block">
                        <p>Lakhatás</p>
                        <label class="inline-option">
                            <input type="radio" name="housing" value="dormitory" checked>
                            Koleszos
                        </label>
                        <label class="inline-option">
                            <input type="radio" name="housing" value="commuter">
                            Bejárós
                        </label>
                    </div>

                    <div class="radio-block">
                        <p>Végzős vagy?</p>
                        <label class="inline-option">
                            <input type="radio" name="finalYear" value="yes" checked>
                            Igen
                        </label>
                        <label class="inline-option">
                            <input type="radio" name="finalYear" value="no">
                            Nem
                        </label>
                    </div>

                    <button type="submit" class="primary-button">Jelentkezés elküldése</button>
                    <p id="formMessage" class="form-message"></p>
                </form>
            </section>
        </div>
    </main>
    <script src="./src/js/register.js" type="module"></script>
</body>
</html>