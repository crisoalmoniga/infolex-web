// Espera a que se cargue todo el documento
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.querySelector('.menu-toggle');
    const nav = document.querySelector('.nav');

    toggle.addEventListener('click', () => {
        nav.classList.toggle('active');
    });
});

document.addEventListener("DOMContentLoaded", () => {
  const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });

  document.querySelectorAll('.animate-left, .animate-right, .animate-service-left, .animate-service-right')
    .forEach(el => observer.observe(el));
});
