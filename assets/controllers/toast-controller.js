import { Controller } from '@hotwired/stimulus';
import { Toast } from 'bootstrap';

export default class extends Controller {
    connect() {
        // allows toast elements to be rendered anywhere on the page
        const toastContainer = document.getElementById('toast-container');
        if (this.element.parentNode !== toastContainer) {
            toastContainer.appendChild(this.element);
            return;
        }

        const toast = new Toast(this.element);
        toast.show();
    }
}
