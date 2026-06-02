<section class="quote-calculator" id="wycena">
    <div class="container">
        <div class="quote-calculator__content">
            <p class="section-kicker">Szybka wycena</p>
            <h2>Ile może kosztować detailing Twojego auta?</h2>
            <p>Wybierz typ pojazdu, usługę i dodatki. Kalkulator poda orientacyjny zakres ceny.</p>
        </div>

        <form class="quote-calculator__form" id="quoteCalculator">
            <label>
                Typ pojazdu
                <select name="carType" required>
                    <option value="hatchback">Hatchback</option>
                    <option value="sedan">Sedan</option>
                    <option value="kombi">Kombi</option>
                    <option value="suv">SUV</option>
                    <option value="van">VAN</option>
                </select>
            </label>

            <label>
                Usługa
                <select name="service" required>
                    <option value="wash">Mycie detailingowe</option>
                    <option value="oneStep">Korekta lakieru 1-etapowa</option>
                    <option value="twoStep">Korekta lakieru 2-etapowa</option>
                    <option value="ceramic">Powłoka ceramiczna</option>
                    <option value="interior">Detailing wnętrza</option>
                </select>
            </label>

            <div class="quote-calculator__addons">
                <span>Dodatki</span>

                <label><input type="checkbox" name="addons" value="upholstery"> Pranie tapicerki</label>
                <label><input type="checkbox" name="addons" value="leather"> Czyszczenie skóry</label>
                <label><input type="checkbox" name="addons" value="glass"> Zabezpieczenie szyb</label>
                <label><input type="checkbox" name="addons" value="wheels"> Powłoka na felgi</label>
            </div>

            <div class="quote-calculator__result">
                <span>Szacunkowa cena:</span>
                <strong id="quoteResult">od 250 zł</strong>
                <small>Dokładna wycena po oględzinach pojazdu.</small>
            </div>

            <a class="btn btn--primary quote-calculator__button" href="#kontakt">
                Umów bezpłatną konsultację
            </a>
        </form>
    </div>
</section>