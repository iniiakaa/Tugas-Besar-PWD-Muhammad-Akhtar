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


document.addEventListener('DOMContentLoaded', function () {
    const container = document.querySelector('header > div:last-child > span');
    const dropdown = container.querySelector('div');

    if(container && dropdown){
        container.querySelector('a').addEventListener('click', function(e) {
            e.preventDefault();
            dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function(e) {
            if(!container.contains(e.target)){
                dropdown.style.display = 'none';
            }
        });
    }
});





