document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.auth-form');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        if (!checkForm()) {
            e.preventDefault(); // Empêche la soumission si invalide
        }
    });

    // Optionnel : Retirer l'erreur quand l'utilisateur tape
    const inputs = form.querySelectorAll('.form-input');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            clearError(this.id);
        });
    });
});

function checkForm() {
    let isValid = true;
    
    // Champs
    const nom = document.getElementById('nom');
    const prenom = document.getElementById('prenom');
    const email = document.getElementById('email');
    const genre = document.getElementById('genre_id');
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirm');

    // 1. Validation Nom
    if (nom.value.trim().length < 2) {
        showError('nom', 'Le nom doit contenir au moins 2 caractères.');
        isValid = false;
    }

    // 2. Validation Prénom
    if (prenom.value.trim().length < 2) {
        showError('prenom', 'Le prénom doit contenir au moins 2 caractères.');
        isValid = false;
    }

    // 3. Validation Email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email.value.trim())) {
        showError('email', 'Veuillez entrer une adresse email valide.');
        isValid = false;
    }

    // 4. Validation Genre
    if (genre.value === "") {
        showError('genre_id', 'Veuillez sélectionner un genre.');
        isValid = false;
    }

    // 5. Validation Mot de passe
    if (password.value.length < 8) {
        showError('password', 'Le mot de passe doit contenir au moins 8 caractères.');
        isValid = false;
    }

    // 6. Validation Confirmation Mot de passe
    if (passwordConfirm.value !== password.value) {
        showError('password_confirm', 'Les mots de passe ne correspondent pas.');
        isValid = false;
    }

    return isValid;
}

function showError(fieldId, message) {
    const field = document.getElementById(fieldId);
    let errorSpan = document.getElementById('js-err-' + fieldId);
    
    // Créer le span s'il n'existe pas encore
    if (!errorSpan) {
        errorSpan = document.createElement('span');
        errorSpan.id = 'js-err-' + fieldId;
        errorSpan.className = 'form-error js-error';
        // L'insérer juste après l'input
        field.parentNode.appendChild(errorSpan);
    }
    
    errorSpan.textContent = message;
    errorSpan.style.display = 'block';
    field.style.borderColor = 'var(--red, #ef4444)';
}

function clearError(fieldId) {
    const field = document.getElementById(fieldId);
    const errorSpan = document.getElementById('js-err-' + fieldId);
    
    if (errorSpan) {
        errorSpan.style.display = 'none';
        errorSpan.textContent = '';
    }
    
    // Réinitialiser la bordure classique (pourra reprendre sa couleur via les CSS)
    if (field) {
        field.style.borderColor = 'var(--border)';
    }
}
