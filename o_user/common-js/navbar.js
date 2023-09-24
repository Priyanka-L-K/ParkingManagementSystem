function toggleMenu() {
    var subMenu = document.getElementById("subMenu");
    if (subMenu.style.display === "block") {
      subMenu.style.display = "none";
    } else {
      subMenu.style.display = "block";
    }
  }
  
  window.addEventListener("resize", function() {
    if (window.innerWidth > 768) {
      var subMenu = document.getElementById("subMenu");
      subMenu.style.display = "none";
    }
  });