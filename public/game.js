const map = L.map('map').setView([54, 15], 4);

// Voeg een kaartlaag toe zonder labels (grijs zonder namen)
L.tileLayer('https://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}{r}.png', {
  attribution: '&copy; OpenStreetMap contributors',
}).addTo(map);

let score = 0;
let wrongScore = 0;
let remainingCountries = [];
let currentCountry = null;

document.getElementById('score').innerText = `Score: ${score} goed | ${wrongScore} fout`;

// Laad GeoJSON met landen in Europa
fetch('https://raw.githubusercontent.com/leakyMirror/map-of-europe/master/GeoJSON/europe.geojson')
  .then(res => res.json())
  .then(data => {
    const countriesLayer = L.geoJSON(data, {
      style: {
        color: "#000",
        weight: 1,
        fillColor: "#3b729f",
        fillOpacity: 0.6
      },
      onEachFeature: function (feature, layer) {
        const name = feature.properties.NAME;

        // Alleen landen in Europa (exclusief deze uitzonderingen)
        const excluded = ["San Marino", "Israel", "Andorra", "Holy See (Vatican City)", "Faroe Islands", "Monaco", "Azerbaijan", "Armenia", "Georgia"];
        if (excluded.includes(name)) return;

        layer.on('click', function () {
          if (!currentCountry) return;

          if (name === currentCountry) {
            layer.setStyle({ fillColor: "#28a745" }); // groen
            score++;
          } else {
            layer.setStyle({ fillColor: "#dc3545" }); // rood
            wrongScore++;
          }

          // Verwijder land uit de lijst zodat het niet opnieuw gevraagd wordt
          remainingCountries = remainingCountries.filter(c => c !== name);

          // Update score
          document.getElementById('score').innerText = `Score: ${score} goed | ${wrongScore} fout`;

          // Volgende vraag
          setTimeout(() => {
            askQuestion();
          }, 800);
        });

        // Voeg toe aan lijst
        remainingCountries.push(name);
      }
    });

    countriesLayer.addTo(map);
    askQuestion();
  });

function askQuestion() {
  if (remainingCountries.length === 0) {
    document.getElementById('question').innerText = 'Het spel is afgelopen!';
    return;
  }

  const randomIndex = Math.floor(Math.random() * remainingCountries.length);
  currentCountry = remainingCountries[randomIndex];
  document.getElementById('question').innerText = `Klik op: ${currentCountry}`;
}