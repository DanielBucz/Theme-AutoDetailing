document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector(".site-header");
  const navLinks = document.querySelectorAll('.nav__link[href^="#"]');
  const mobileNavLinks = document.querySelectorAll(
    '.mobile-menu__link[href^="#"]',
  );
  const sections = document.querySelectorAll("section[id]");

  const menuToggle = document.querySelector(".menu-toggle");
  const mobileMenu = document.querySelector(".mobile-menu");
  const mobileMenuClose = document.querySelector(".mobile-menu__close");
  const mobileMenuOverlay = document.querySelector(".mobile-menu__overlay");

  const getHeaderHeight = () => (header ? header.offsetHeight : 0);

  const setActiveLink = (id) => {
    navLinks.forEach((link) => {
      const isMatch = link.getAttribute("href") === `#${id}`;
      link.classList.toggle("is-active", isMatch);
      if (isMatch) {
        link.setAttribute("aria-current", "page");
      } else {
        link.removeAttribute("aria-current");
      }
    });

    mobileNavLinks.forEach((link) => {
      const isMatch = link.getAttribute("href") === `#${id}`;
      link.classList.toggle("is-active", isMatch);
      if (isMatch) {
        link.setAttribute("aria-current", "page");
      } else {
        link.removeAttribute("aria-current");
      }
    });
  };

  const openMenu = () => {
    if (!mobileMenu || !menuToggle) return;
    mobileMenu.classList.add("is-open");
    document.body.classList.add("menu-open");
    mobileMenu.setAttribute("aria-hidden", "false");
    menuToggle.setAttribute("aria-expanded", "true");
  };

  const closeMenu = () => {
    if (!mobileMenu || !menuToggle) return;
    mobileMenu.classList.remove("is-open");
    document.body.classList.remove("menu-open");
    mobileMenu.setAttribute("aria-hidden", "true");
    menuToggle.setAttribute("aria-expanded", "false");
  };

  const scrollToSection = (target) => {
    if (!target) return;

    const targetTop =
      target.getBoundingClientRect().top +
      window.scrollY -
      getHeaderHeight() -
      12;

    window.scrollTo({
      top: targetTop,
      behavior: "smooth",
    });

    setActiveLink(target.id);
    history.pushState(null, "", `#${target.id}`);
  };

  [...navLinks, ...mobileNavLinks].forEach((link) => {
    link.addEventListener("click", (event) => {
      const href = link.getAttribute("href");
      const target = document.querySelector(href);

      if (!target) return;

      event.preventDefault();
      scrollToSection(target);
      closeMenu();
    });
  });

  if (menuToggle) {
    menuToggle.addEventListener("click", () => {
      if (mobileMenu && mobileMenu.classList.contains("is-open")) {
        closeMenu();
      } else {
        openMenu();
      }
    });
  }

  if (mobileMenuClose) {
    mobileMenuClose.addEventListener("click", closeMenu);
  }

  if (mobileMenuOverlay) {
    mobileMenuOverlay.addEventListener("click", closeMenu);
  }

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      closeMenu();
    }
  });

  if (sections.length) {
    const observer = new IntersectionObserver(
      (entries) => {
        const visibleEntries = entries
          .filter((entry) => entry.isIntersecting)
          .sort((a, b) => b.intersectionRatio - a.intersectionRatio);

        if (visibleEntries.length) {
          setActiveLink(visibleEntries[0].target.id);
        }
      },
      {
        root: null,
        rootMargin: `-${getHeaderHeight() + 20}px 0px -45% 0px`,
        threshold: [0.2, 0.35, 0.5, 0.7],
      },
    );

    sections.forEach((section) => observer.observe(section));
  }

  const updateActiveOnLoad = () => {
    const hash = window.location.hash.replace("#", "");
    if (hash) {
      setActiveLink(hash);
      return;
    }

    const currentSection = [...sections].find((section) => {
      const rect = section.getBoundingClientRect();
      const headerHeight = getHeaderHeight();
      return rect.top <= headerHeight + 60 && rect.bottom > headerHeight + 60;
    });

    if (currentSection) {
      setActiveLink(currentSection.id);
    } else {
      setActiveLink("top");
    }
  };

  const beforeAfterSliders = document.querySelectorAll("[data-before-after]");

  beforeAfterSliders.forEach((slider) => {
    const range = slider.querySelector("[data-before-after-range]");
    const overlay = slider.querySelector("[data-before-after-overlay]");
    const divider = slider.querySelector("[data-before-after-divider]");

    if (!range || !overlay || !divider) return;

    const updateSlider = (value) => {
      overlay.style.width = `${value}%`;
      divider.style.left = `${value}%`;
    };

    updateSlider(range.value);

    range.addEventListener("input", (event) => {
      updateSlider(event.target.value);
    });
  });

  updateActiveOnLoad();
  window.addEventListener("resize", updateActiveOnLoad);
});
