// Mapa livre de Rio Grande da Serra - SP: o usuário pode arrastar, dar zoom
// e transitar entre as ruas, assim como no Google Maps.
const mapaCidade = L.map('mapaCidade', {
  center: [-23.7450938, -46.3954697], // Centro de Rio Grande da Serra
  zoom: 15,
  dragging: true,
  scrollWheelZoom: true,
  doubleClickZoom: true,
  touchZoom: true
});
 
// OBS: sem o prefixo {s}. — os subdomínios a/b/c.tile.openstreetmap.org
// foram descontinuados e podem não resolver, deixando o mapa em branco.
L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxZoom: 19,
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contribuidores'
}).addTo(mapaCidade);
 
L.marker([-23.7450938, -46.3954697])
  .addTo(mapaCidade)
  .bindPopup("<strong>Rio Grande da Serra</strong><br>Centro da cidade")
  .openPopup();
 
// Força o Leaflet a recalcular o tamanho do mapa depois que tudo carregou
// (corrige o problema comum de "mapa cinza" quando a div estava com
// tamanho 0 no momento da inicialização, ex: dentro de container flex/grid)
setTimeout(() => mapaCidade.invalidateSize(), 200);