const viewer = document.getElementById('viewer');

const viewerImg = document.getElementById('viewer-img');

const viewerTitle = document.getElementById('viewer-title');

const viewerDescription = document.getElementById('viewer-description');

const closeViewer = document.getElementById('close-viewer');

document.querySelectorAll('.gallery img').forEach(img => {

    img.addEventListener('click', () => {

        viewer.style.display = 'flex';

        viewerImg.src = img.src;

        viewerTitle.textContent = img.dataset.title;

        viewerDescription.textContent = img.dataset.description;

    });

});

closeViewer.addEventListener('click', () => {

    viewer.style.display = 'none';

});

viewer.addEventListener('click', (e) => {

    if(e.target === viewer){

        viewer.style.display = 'none';

    }

});