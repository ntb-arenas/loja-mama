const btn = document
    .querySelectorAll('.read-more-btn');

const text = document
    .querySelectorAll('.content-wrapper');

const contentWrapper = document
    .querySelectorAll('.content-wrapper');

for (var i = 0; i < contentWrapper.length; i++) {
    contentWrapper[i]
        .addEventListener('click', e => {
            const current = e.target;

            const isReadMoreBtn = current.className.includes('read-more-btn');

            if (!isReadMoreBtn)
                return;

            const currentText = e.target.parentNode.querySelector('.desc__read-more');

            currentText.classList.toggle('desc__read-more--open');

            current.textContent = current.textContent.includes('Ler mais') ? 'Ler menos' : 'Ler mais';
        });
}
