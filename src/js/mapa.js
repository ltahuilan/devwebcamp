(function(){

    document.addEventListener('DOMContentLoaded', function(){
        const lat = 19.3706484;
        const lng = -99.1386718;
        const zoom = 16;
        const map = L.map('map').setView([lat, lng], zoom);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        L.marker([lat, lng]).addTo(map)
            .bindPopup(`
                <h2 class="mapa__heading">DevWebCamp</h2>
                <p class="mapa__texto">Aquí se tiró el codigo para DevWebCamp</p>
            `)
            .openPopup();
    });
})();