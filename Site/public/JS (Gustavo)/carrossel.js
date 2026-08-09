const trilhoCarrossel = document.getElementById('carrosselTrack');
const imagensCarrossel = document.querySelectorAll('.carrossel-img');
const totalImagens = imagensCarrossel.length;
const TEMPO_TROCA_MS = 2000; // mesmo valor usado na transição CSS (transform 800ms)
let indiceAtual = 0;

function proximaImagemCarrossel() {
  if (!trilhoCarrossel || totalImagens === 0) return;

  // avança o índice e volta pro 0 depois da última imagem
  indiceAtual = (indiceAtual + 1) % totalImagens;

  // desloca o trilho: cada "passo" é 100% dividido pelo número de imagens
  const deslocamento = indiceAtual * (100 / totalImagens);
  trilhoCarrossel.style.transform = `translateX(-${deslocamento}%)`;
}

if (trilhoCarrossel && totalImagens > 1) {
  setInterval(proximaImagemCarrossel, TEMPO_TROCA_MS);
}