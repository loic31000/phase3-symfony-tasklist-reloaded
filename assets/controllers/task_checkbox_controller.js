import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['checkbox', 'title', 'status'];
    static values = {
        taskId: Number,
        updateUrl: String
    }

    async toggle(event) {
        const checkbox = event.currentTarget;
        const isChecked = checkbox.checked;
        
        try {
            const response = await fetch(this.updateUrlValue, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    completed: isChecked
                })
            });

            if (response.ok) {
                const data = await response.json();
                
                // Mettre à jour l'interface
                if (isChecked) {
                    this.titleTarget.classList.add('line-through', 'text-gray-500');
                    this.titleTarget.classList.remove('text-gray-900');
                    this.statusTarget.textContent = 'Terminée';
                } else {
                    this.titleTarget.classList.remove('line-through', 'text-gray-500');
                    this.titleTarget.classList.add('text-gray-900');
                    this.statusTarget.textContent = 'En cours';
                }

                // Mettre à jour l'attribut data-status pour les filtres
                this.element.dataset.status = data.status;
            } else {
                // Annuler le changement en cas d'erreur
                checkbox.checked = !isChecked;
                alert('Erreur lors de la mise à jour de la tâche');
            }
        } catch (error) {
            console.error('Erreur:', error);
            checkbox.checked = !isChecked;
            alert('Erreur de connexion');
        }
    }
}
