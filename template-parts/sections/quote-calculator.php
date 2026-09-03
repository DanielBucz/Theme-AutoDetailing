<section class="quote-calculator" id="wycena">
    <div class="container">
        <div class="quote-calculator__content">
            <p class="section-kicker">Szybka wycena</p>
            <h2>Ile może kosztować renowacja lamp?</h2>
            <p>Wybierz stan reflektorów i zakres pracy. Kalkulator poda orientacyjny zakres ceny.</p>
        </div>

        <form class="quote-calculator__form" id="quoteCalculator">
            <label>
                Stan lamp
                <select name="lampCondition" required>
                    <option value="light">Lekko zmatowiałe</option>
                    <option value="medium">Widocznie żółte lub mleczne</option>
                    <option value="heavy">Mocno zniszczone / głębokie zmatowienie</option>
                </select>
            </label>

            <label>
                Liczba lamp
                <select name="lampCount" required>
                    <option value="pair">Komplet przednich lamp</option>
                    <option value="single">Jedna lampa</option>
                </select>
            </label>

            <div class="quote-calculator__addons">
                <span>Dodatki</span>

                <label><input type="checkbox" name="addons" value="uv"> Zabezpieczenie UV</label>
                <label><input type="checkbox" name="addons" value="deep"> Dodatkowe szlifowanie głębokich zmatowień</label>
                <label><input type="checkbox" name="addons" value="inspection"> Kontrola efektu świecenia</label>
                <label><input type="checkbox" name="addons" value="travel"> Dojazd na terenie Lublina</label>
            </div>

            <div class="quote-calculator__result">
                <span>Szacunkowa cena:</span>
                <strong id="quoteResult">od 120 zł</strong>
                <small>Dokładna wycena po obejrzeniu lamp lub zdjęć.</small>
            </div>

            <div class="quote-calculator__lead">
                <label>
                    Imię
                    <input type="text" name="clientName" placeholder="Jak mamy się zwracać?">
                </label>

                <label>
                    Telefon
                    <input type="tel" name="clientPhone" placeholder="Np. 500 600 700">
                </label>

                <input type="hidden" name="quoteValue" id="quoteValue">

                <button class="btn btn--primary quote-calculator__button" type="submit">
                    Wyślij zapytanie
                </button>
                <p class="quote-calculator__message" id="quoteMessage" aria-live="polite"></p>
            </div>
        </form>
    </div>
</section>
