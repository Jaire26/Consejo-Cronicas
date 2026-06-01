const navbar = document.getElementById('navbar');

window.addEventListener('scroll', () => {

  navbar.classList.toggle('active', window.scrollY > 50);

});

const sections = document.querySelectorAll('section');

const reveal = () => {

  sections.forEach(section => {

    const top = section.getBoundingClientRect().top;

    if(top < window.innerHeight - 100){

      section.style.opacity = 1;
      section.style.transform = 'translateY(0px)';

    }

  });

}

sections.forEach(section => {

  section.style.opacity = 0;
  section.style.transform = 'translateY(50px)';
  section.style.transition = 'all 1s ease';

});

window.addEventListener('scroll', reveal);

reveal();