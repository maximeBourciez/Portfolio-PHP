document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner toutes les images avec la classe image-item
    const images = document.querySelectorAll('.image-item');
    
    // Obtenir la référence de la modal Bootstrap
    const imageModal = new bootstrap.Modal(document.getElementById('imageCoverModal'));
    
    // Pour chaque image
    images.forEach(image => {
        image.addEventListener('click', function() {
            // Récupérer les informations de l'image
            const imgSrc = this.src;
            const imgTitle = this.title;
            
            // Mettre à jour le contenu de la modal
            document.getElementById('imageCoverModalLabel').textContent = imgTitle;
            document.getElementById('modalImage').src = imgSrc;
            document.getElementById('modalImage').alt = imgTitle;
            
            // Afficher la modal
            imageModal.show();
        });
    });
});