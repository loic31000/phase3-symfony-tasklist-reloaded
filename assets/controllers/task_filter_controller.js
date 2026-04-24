import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['taskCard'];
    static values = {
        currentStatus: String,
        currentFolder: String,
        currentPriority: String
    }

    connect() {
        this.currentStatusValue = 'tous';
        this.currentFolderValue = 'tous';
        this.currentPriorityValue = 'tous';
        console.log('task-filter connected, taskCard targets:', this.taskCardTargets.length);
    }

    filterByStatus(event) {
        const status = event.currentTarget.value;
        this.currentStatusValue = status;
        this.applyFilters();
    }

    filterByFolder(event) {
        const folderId = event.currentTarget.value;
        this.currentFolderValue = folderId;
        this.applyFilters();
    }

    selectFolder(event) {
        const folderId = event.currentTarget.dataset.folderId;
        this.currentFolderValue = folderId;
        
        // Mettre à jour le select
        const folderSelect = this.element.querySelector('select[data-action*="filterByFolder"]');
        if (folderSelect) {
            folderSelect.value = folderId;
        }
        
        this.applyFilters();
    }

    resetFilters(event) {
        event.preventDefault();
        this.currentStatusValue = 'tous';
        this.currentFolderValue = 'tous';
        this.currentPriorityValue = 'tous';
        
        // Réinitialiser tous les selects
        const statusSelect = this.element.querySelector('select[data-action*="filterByStatus"]');
        const folderSelect = this.element.querySelector('select[data-action*="filterByFolder"]');
        const prioritySelect = this.element.querySelector('select[data-action*="filterByPriority"]');
        
        if (statusSelect) statusSelect.value = 'tous';
        if (folderSelect) folderSelect.value = 'tous';
        if (prioritySelect) prioritySelect.value = 'tous';
        
        this.applyFilters();
    }

    filterByPriority(event) {
        const priorityId = event.currentTarget.value;
        this.currentPriorityValue = priorityId;
        this.applyFilters();
    }

    applyFilters() {
        console.log('applyFilters called', {
            status: this.currentStatusValue,
            folder: this.currentFolderValue,
            priority: this.currentPriorityValue,
            totalCards: this.taskCardTargets.length
        });
        
        this.taskCardTargets.forEach(card => {
            const taskStatus = card.dataset.status;
            const taskFolder = card.dataset.folder || '';
            const taskPriority = card.dataset.priority || '';

            const statusMatch = this.currentStatusValue === 'tous' || taskStatus === this.currentStatusValue;
            const folderMatch = this.currentFolderValue === 'tous' || taskFolder === this.currentFolderValue;
            const priorityMatch = this.currentPriorityValue === 'tous' || taskPriority === this.currentPriorityValue;

            console.log('Task:', taskStatus, taskFolder, taskPriority, '| Match:', statusMatch && folderMatch && priorityMatch);

            if (statusMatch && folderMatch && priorityMatch) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }

    reset() {
        this.currentStatusValue = 'tous';
        this.currentFolderValue = 'tous';
        this.currentPriorityValue = 'tous';
        
        // Reset select elements
        const selects = this.element.querySelectorAll('select');
        selects.forEach(select => select.value = 'tous');
        
        this.applyFilters();
    }
}
