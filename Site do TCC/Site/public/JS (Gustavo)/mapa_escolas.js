// Escolas parceiras da RG Eats, com coordenadas reais em Rio Grande da Serra - SP
const escolasParceiras = [
  {
    nome: "ETEC de Rio Grande da Serra (Sede)",
    descricao: "Unidade central: gestão administrativa e articulação com a prefeitura.",
    lat: -23.751622,
    lng: -46.391074
  },
  {
    nome: "Escola Antonio Lucas",
    descricao: "Apoio tecnológico: soluções para controle de estoque dos alimentos doados.",
    lat: -23.7530655,
    lng: -46.3945228
  },
  {
    nome: "EMEF Cassiano Ricardo",
    descricao: "Comunicação e mobilização comunitária: divulgação das campanhas de arrecadação.",
    lat: -23.7476768,
    lng: -46.3977115
  },
  {
    nome: "E.E Edmundo Luiz de Nobrega Teixeira",
    descricao: "Operação e infraestrutura: triagem e armazenamento temporário das doações.",
    lat: -23.7515509,
    lng: -46.4021474
  }
];
 
// Centraliza o mapa no meio das 4 escolas
const mapaParceiros = L.map('mapaParceiros').setView([-23.7510, -46.3966], 15);
 
// OBS: sem o prefixo {s}. — os subdomínios a/b/c.tile.openstreetmap.org
// foram descontinuados e podem não resolver, deixando o mapa em branco.
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contribuidores'
}).addTo(mapaParceiros);
 
// Força o Leaflet a recalcular o tamanho do mapa depois que tudo carregou
// (corrige o problema comum de "mapa cinza" quando a div estava com
// tamanho 0 no momento da inicialização, ex: dentro de container flex/grid)
setTimeout(() => mapaParceiros.invalidateSize(), 200);
 
escolasParceiras.forEach(escola => {
  L.marker([escola.lat, escola.lng])
    .addTo(mapaParceiros)
    .bindPopup(`<strong>${escola.nome}</strong><br>${escola.descricao}`);
});