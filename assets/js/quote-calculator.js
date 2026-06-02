document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("#quoteCalculator");
  const result = document.querySelector("#quoteResult");

  if (!form || !result) return;

  const servicePrices = {
    wash: 50, // było 250
    oneStep: 180, // było 900
    twoStep: 300, // było 1500
    ceramic: 440, // było 2200
    interior: 120, // było 600
  };

  const carMultipliers = {
    hatchback: 1,
    sedan: 1.1,
    kombi: 1.15,
    suv: 1.25,
    van: 1.4,
  };

  const addonPrices = {
    upholstery: 70, // było 350
    leather: 50, // było 250
    glass: 36, // było 180
    wheels: 60, // było 300
  };
  const formatPrice = (price) =>
    new Intl.NumberFormat("pl-PL", {
      style: "currency",
      currency: "PLN",
      maximumFractionDigits: 0,
    }).format(price);

  const calculate = () => {
    const data = new FormData(form);
    const service = data.get("service");
    const carType = data.get("carType");
    const addons = data.getAll("addons");

    let price = servicePrices[service] * carMultipliers[carType];

    addons.forEach((addon) => {
      price += addonPrices[addon] || 0;
    });

    const min = Math.round(price / 50) * 50;
    const max = min + 300;

    result.textContent = `${formatPrice(min)} - ${formatPrice(max)}`;
  };

  form.addEventListener("change", calculate);
  calculate();
});
