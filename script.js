  let lastScroll = 0;
  const header = document.querySelector("header");

  window.addEventListener("scroll", () => {
    const currentScroll = window.scrollY;

    if (currentScroll > lastScroll) {
      
      header.style.top = "-100px";
    } else {
      
      header.style.top = "0";
    }

    lastScroll = currentScroll;
  });

