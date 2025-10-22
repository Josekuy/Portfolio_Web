//Funcionalidad para el Botón Hamburguesa Responsivo
//Desclaraciones
const toggle = document.querySelector('.header__toggle');
const nav = document.querySelector('.header__nav');
const header = document.querySelector('.header');

//Sacar el menu al clicar hamburguesa
toggle.addEventListener('click', () => {
  nav.classList.toggle('active');       // Mostrar/ocultar menú
  toggle.classList.toggle('open');      // Cambiar estado de hamburguesa
});

// Cerrar menú al salir el ratón del header
header.addEventListener('mouseleave', () => {
  nav.classList.remove('active');       // Oculta el menú al salir el ratón
  toggle.classList.remove('open');      // Vuelve a mostrar la hamburguesa
});

//Volver al estado anterior
window.addEventListener('resize', () => {
  if (window.innerWidth > 768) {
    nav.classList.remove('active');  // quitar clase active al ampliar
    toggle.classList.remove('open'); // reset botón hamburguesa
  }
});

//Funcionalidad para animar las barras de Skills
const skills = document.querySelectorAll('.about-section__skill-level');

function animateSkills() {
    const triggerBottom = window.innerHeight * 0.85;

    skills.forEach(skill => {
        const rect = skill.getBoundingClientRect();

        // Solo animar si está dentro del viewport y no tiene la clase 'animated'
        if(rect.top < triggerBottom && rect.bottom > 0 && !skill.classList.contains('animated')) {
            const width = skill.getAttribute('data-width');
            skill.style.width = width;
            skill.classList.add('animated'); // marcar como animada
        }
    });
}

window.addEventListener('scroll', animateSkills);
window.addEventListener('load', animateSkills);


// SLIDER Y MODAL DE BRANDING

document.addEventListener('DOMContentLoaded', () => {

  // --- Slider tipo catálogo Branding
  const brandingSwiper = new Swiper('.branding-slider', {
    slidesPerView: 3,
    spaceBetween: 20,
    grabCursor: true,
    navigation: {
      nextEl: '.portfolio-section__item--brand .swiper-button-next',
      prevEl: '.portfolio-section__item--brand .swiper-button-prev',
    },
    breakpoints: {
      1024: { slidesPerView: 3 },
      768:  { slidesPerView: 2 },
      480:  { slidesPerView: 1 }
    }
  });

  // --- Modal dinámico para Branding
  const items = document.querySelectorAll('.branding-item');
  const modal = document.querySelector('#branding-modal');
  const modalImg = document.querySelector('#modal-logo-img');
  const modalTitle = document.querySelector('#modal-title');
  const modalDesc = document.querySelector('#modal-description');
  const appsContainer = document.querySelector('.branding-applications');
  const closeBtn = document.querySelector('.close-modal');

  items.forEach(item => {
    item.addEventListener('click', () => {
      const imgSrc = item.querySelector('img').src;
      const title = item.dataset.title;
      const description = item.dataset.description;

      // Obtener el JSON desde el <script> embebido
      const jsonScript = item.querySelector('.apps-data');
      let apps = [];
      try {
        apps = jsonScript ? JSON.parse(jsonScript.textContent) : [];
      } catch (e) {
        console.error("Error al parsear JSON de aplicaciones:", e);
      }

      // Cargar datos en el modal
      modalImg.src = imgSrc;
      modalTitle.textContent = title;
      modalDesc.textContent = description;

      // Limpiar y cargar imágenes de aplicaciones
      appsContainer.innerHTML = '';
      apps.forEach(app => {
        const img = document.createElement('img');
        img.src = app;
        img.alt = title + " aplicación";
        appsContainer.appendChild(img);
      });

      modal.classList.add('active');
    });
  });

  // --- Cerrar modal
  closeBtn?.addEventListener('click', () => modal.classList.remove('active'));
  modal?.addEventListener('click', e => {
    if (e.target === modal) modal.classList.remove('active');
  });;

  // --- Slider de seccion 'Fotografía' (fade uno a uno)
  new Swiper('.portfolio-section__item--foto .swiper', {
    loop: true,
    effect: 'fade',
    fadeEffect: { crossFade: true },
    speed: 600,
    slidesPerView: 1,
    navigation: {
      nextEl: '.portfolio-section__item--foto .swiper-button-next',
      prevEl: '.portfolio-section__item--foto .swiper-button-prev',
    },
    pagination: {
      el: '.portfolio-section__item--foto .swiper-pagination',
      clickable: true,
    },
  });
});

  // --- Funcionalidad del formulario de contacto
document.querySelector("#contact-form").addEventListener("submit", async (e) => {
  e.preventDefault();
  const form = e.target;
  const status = document.querySelector("#form-status");

  const data = new FormData(form);
  status.textContent = "Enviando...";

  const response = await fetch(form.action, {
    method: "POST",
    body: data,
  });

  const result = await response.text();

  if (result === "success") {
    status.textContent = "✅ Mensaje enviado correctamente. ¡Gracias!";
    form.reset();
  } else if (result === "invalid") {
    status.textContent = "⚠️ Por favor, rellena todos los campos correctamente.";
  } else {
    status.textContent = "❌ Error al enviar el mensaje. Intenta de nuevo.";
  }
});



