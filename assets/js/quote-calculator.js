document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#quoteCalculator");
  const result = document.querySelector("#quoteResult");
  const quoteValue = document.querySelector("#quoteValue");
  const messageBox = document.querySelector("#quoteMessage");

  if (!form || !result) return;

  const setQuoteValue = () => {
    result.textContent = "od 120 zł";
    if (quoteValue) {
      quoteValue.value = "Prośba o indywidualną wycenę - cena od 120 zł";
    }
  };

  setQuoteValue();

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
      submitButton.textContent = "Zapytaj o wycenę";
    }
  });
});
