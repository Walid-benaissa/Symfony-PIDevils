// sweet-alert.js

import Swal from 'sweetalert2';

Swal.fire({
    title: 'Offre ajoutée avec succès!',
    icon: 'success',
    showCancelButton: false,
    confirmButtonText: 'OK'
}).then((result) => {
    // Rediriger vers la liste des offres si l'utilisateur clique sur OK
    if (result.isConfirmed) {
        window.location.href = "{{ path('app_offre_course_index') }}";
    }
});
