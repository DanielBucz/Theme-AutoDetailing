document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#quoteCalculator");
  const result = document.querySelector("#quoteResult");
  const quoteValue = document.querySelector("#quoteValue");
  const messageBox = document.querySelector("#quoteMessage");

  if (!form || !result) return;

  const conditionPrices = {
    light: 120,
    medium: 180,
    heavy: 260,
  };

  const lampCountMultipliers = {
    single: 0.65,
    pair: 1,
  };

  const addonPrices = {
    uv: 50,
    deep: 80,
    inspection: 30,
    travel: 40,
  };

  const formatPrice = (price) =>
    new Intl.NumberFormat("pl-PL", {
      style: "currency",
      currency: "PLN",
      maximumFractionDigits: 0,
    }).format(price);

  const calculate = () => {
    const data = new FormData(form);
    const lampCondition = data.get("lampCondition");
    const lampCount = data.get("lampCount");
    const addons = data.getAll("addons");

    let price =
      conditionPrices[lampCondition] * lampCountMultipliers[lampCount];

    addons.forEach((addon) => {
      price += addonPrices[addon] || 0;
    });

    const min = Math.round(price / 10) * 10;
    const max = min + 80;
    const priceText = `${formatPrice(min)} - ${formatPrice(max)}`;

    result.textContent = priceText;

    if (quoteValue) {
      quoteValue.value = priceText;
    }
  };

  form.addEventListener("change", calculate);
  calculate();

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const submitButton = form.querySelector('button[type="submit"]');
    const formData = new FormData(form);

    formData.append("action", "buczek_quote_form");
    formData.append("security", buczekThemeData.security);

    if (messageBox) {
      messageBox.textContent = "";
      messageBox.classList.remove("is-success", "is-error");
    }

    submitButton.disabled = true;
    submitButton.textContent = "Wysyłanie...";

    try {
      const response = await fetch(buczekThemeData.ajaxUrl, {
        method: "POST",
        body: formData,
      });

      const data = await response.json();
      const message = data?.data?.message || "Formularz został obsłużony.";

      if (messageBox) {
        messageBox.textContent = message;
        messageBox.classList.toggle("is-success", data.success);
        messageBox.classList.toggle("is-error", !data.success);
      }

      if (data.success) {
        form.reset();
        calculate();
      }
    } catch (error) {
      if (messageBox) {
        messageBox.textContent = "Wystąpił błąd. Spróbuj ponownie.";
        messageBox.classList.add("is-error");
      }
    } finally {
      submitButton.disabled = false;
      submitButton.textContent = "Wyślij zapytanie";
    }
  });
});
