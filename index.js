function initModal() {
  const openBtn = document.querySelector('.open-modal');
  const overlay = document.querySelector('.modal-overlay');
  const closeBtn = document.querySelector('.sulgemine');

  if (!overlay) return; 


  if (overlay.__modalInit) return;
  overlay.__modalInit = true;


  if (openBtn) {
    openBtn.addEventListener('click', (e) => {
      e.preventDefault();
      overlay.classList.add('active');
    });
  }


  if (closeBtn) {
    closeBtn.addEventListener('click', () => overlay.classList.remove('active'));
  }

  overlay.addEventListener('click', (e) => {
    if (e.target === overlay) overlay.classList.remove('active');
  });

}
  document.addEventListener("DOMContentLoaded", initModal);



const wrappers = document.querySelectorAll('.wrapper');

const galleryImages = {
  küttekolded: [
    'ahienne.png',
    'ahipärast.png',
    'pliitenne.png',
    'pliitpärast.png'
  ],
  viimistlus: [
    'uks.png',
    'siset.png',
    'nurk.png',
    'elutuba.png',
    'sein.png'
  ]
};

wrappers.forEach(wrapper => {
  const img = wrapper.querySelector('.frameGallery');
  const btnLeft = wrapper.querySelector('.arrow.left');
  const btnRight = wrapper.querySelector('.arrow.right');
   const text = wrapper.querySelector('.pilt');


  let category = wrapper.getAttribute('data-category');
  const images = galleryImages[category];
  let currentIndex = 0;

  function updateImage() {
    img.src = 'pildid/' + images[currentIndex];
    if (text) text.style.display = currentIndex === 0 ? 'inline' : 'none';
  }

  btnRight.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % images.length;
    updateImage();
  });

  btnLeft.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    updateImage();
  });
});


  